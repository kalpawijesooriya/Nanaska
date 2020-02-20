<?php

/**
 * This is the model class for table "answer_text".
 *
 * The followings are the available columns in table 'answer_text':
 * @property integer $answer_text_id
 * @property string $answer_text
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property Question $question
 */
class AnswerText extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnswerText the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'answer_text';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('answer_text, question_id', 'required'),
            array('question_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('answer_text_id, answer_text, question_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::HAS_MANY, 'Answer', 'answer_text_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'answer_text_id' => 'Answer Text',
            'answer_text' => 'Answer Text',
            'question_id' => 'Question',
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

        $criteria->compare('answer_text_id', $this->answer_text_id);
        $criteria->compare('answer_text', $this->answer_text, true);
        $criteria->compare('question_id', $this->question_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getSingleAnswerTextOnQuestionView($question_id) {

        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        $results = AnswerText::model()->findAll($criteria);
        return $results;
    }

    public function getAnswerTextById($answer_text_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('answer_text')
                ->where('answer_text_id=:answer_text_id', array(':answer_text_id' => $answer_text_id))
                ->queryAll();

        if ($data != null) {
            return $data[0]['answer_text'];
        }
        return null;
    }

    public function getAnswerText($answer_text_id) {
        return AnswerText::model()->findByPk($answer_text_id);
    }

    // get answer text for relevant question id
    public function getAnswerTextForQuestion($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        return AnswerText::model()->findAll($criteria);
    }

    public function deleteAnswerText($answer_text_id) {
        AnswerText::model()->findByPk($answer_text_id)->delete();
    }

    public function getAnswerTextByQId($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('answer_text')
                ->from('answer_text')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        
       // var_dump($data[0]['answer_text']);die;

        if ($data != null) {
            return $data;
        } else {
            return null;
        }
    }
    
    
    public function getAnswerIdtByAnswerTextId($answer_text_id) {
        $data = Yii::app()->db->createCommand()
                ->select('answer_id')
                ->from('answer')
                ->where('answer_text_id=:answer_text_id', array(':answer_text_id' => $answer_text_id))
                ->queryAll();
        
       // var_dump($data[0]['answer_text']);die;

        if ($data != null) {
            return $data;
        } else {
            return null;
        }
    }
    

}
