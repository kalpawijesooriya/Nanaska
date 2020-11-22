<?php

/**
 * This is the model class for table "answer".
 *
 * The followings are the available columns in table 'answer':
 * @property integer $answer_id
 * @property integer $question_id
 * @property integer $question_part_id
 * @property string $image_answer
 * @property integer $is_correct
 *
 * The followings are the available model relations:
 * @property Question $question
 * @property QuestionPart $questionPart
 * @property PaperQuestion[] $paperQuestions
 */
class Answer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Answer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'answer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_id, is_correct', 'required'),
            array('question_id, question_part_id, is_correct', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('answer_id, question_id, question_part_id, image_answer, is_correct', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answerText' => array(self::BELONGS_TO, 'AnswerText', 'answer_text_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
            'questionPart' => array(self::BELONGS_TO, 'QuestionPart', 'question_part_id'),
            'paperQuestions' => array(self::HAS_MANY, 'PaperQuestion', 'answer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'answer_id' => 'Answer',
            'question_id' => 'Question',
            'question_part_id' => 'Question Part',
            'is_correct' => 'Is Correct',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('answer_id', $this->answer_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('question_part_id', $this->question_part_id);
        $criteria->compare('is_correct', $this->is_correct);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDistinctAnswersOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->selectDistinct('answer_text_id')
                ->from('answer')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data;
    }

    public function getAnswersOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data;
    }

    public function getAnswersOfQuestionPart($question_part_id) {
        $answers = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                ->queryAll();

        return $answers;
    }

    public function getAnwersForQuestion($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        $results = Answer::model()->findAll($criteria);

        return $results;
    }

    public function getResultText($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_id=:question_id AND question_part_id=:question_part_id', array(':question_id' => $question_id, ':question_part_id' => null))
                ->queryAll();
        return $data;
    }

    public function getCorrectAnswersOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_id=:question_id AND is_correct=:is_correct', array(':question_id' => $question_id, ':is_correct' => 1))
                ->queryAll();
        return $data;
    }

    public function getOtherAnswersOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data;
    }

    public function getAnswerOfQuestionPart($question_part_id, $question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('question_part_id=:question_part_id AND question_id=:question_id', array(':question_part_id' => $question_part_id, ':question_id' => $question_id))
                ->queryAll();
//        print_r($data);
        return $data[0];
    }
    
    public function getAnswerTextAnswerId($answer_text_id) {        
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer')
                ->where('answer_text_id=:answer_text_id', array(':answer_text_id' => $answer_text_id))
                ->queryAll();
        return $data[0]['answer_text_id'];
        
        
    }
    
    public function getIs_correct($answer_id)
    {
        $data = Yii::app()->db->createCommand()
                ->select('is_correct')
                ->from('answer')
                ->where('answer_id=:answer_id', array(':answer_id' =>$answer_id))
                ->queryAll();
        if(isset($data[0]['is_correct']))
        {
            return $data[0]['is_correct'];
        }
        else
        {
            return 0;
        }
        
    }
    
    public function getIs_correctForDragTypeD($answer_id)
    {
        $data = Yii::app()->db->createCommand()
                ->select('is_correct')
                ->from('answer')
                ->where('answer_text_id=:answer_text_id', array(':answer_text_id' =>$answer_id))
                ->queryAll();
        if(isset($data[0]['is_correct']))
        {
            return $data[0]['is_correct'];
        }
        else
        {
            return 0;
        }
        
    }
    
    public function numberOfIs_corrects($question_id)
    {
        $data = Yii::app()->db->createCommand()
                ->select('is_correct')
                ->from('answer')
                ->where('question_id=:question_id', array(':question_id' =>$question_id))                
                ->queryAll();
        return $data;
    }
    
    public function getAnswerTextIdFromQuestionPartId($question_part_id) {
        $data = Yii::app()->db->createCommand()
                ->select('answer_text_id')
                ->from('answer')
                ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                ->queryAll();
        return $data;
    }

}
