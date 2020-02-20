<?php

/**
 * This is the model class for table "question_part".
 *
 * The followings are the available columns in table 'question_part':
 * @property integer $question_part_id
 * @property string $question_part_name
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property PaperQuestion[] $paperQuestions
 * @property Question $question
 */
class QuestionPart extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return QuestionPart the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_part';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_part_name, question_id', 'required'),
            array('question_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_part_id, question_part_name, question_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::HAS_MANY, 'Answer', 'question_part_id'),
            'paperQuestions' => array(self::HAS_MANY, 'PaperQuestion', 'question_part_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'question_part_id' => 'Question Part',
            'question_part_name' => 'Question Part Name',
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

        $criteria->compare('question_part_id', $this->question_part_id);
        $criteria->compare('question_part_name', $this->question_part_name, true);
        $criteria->compare('question_id', $this->question_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getQuestionPartsOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_part')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data;
    }

    public function getQuestionPartOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_part')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        if ($data == NULL) {
            return NULL;
        } else {
            return $data[0];
        }
    }

    // get question parts for question view : zah
    public function getQuestionPartsforQuestionView($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        return QuestionPart::model()->findAll($criteria);
    }

    //get question part text : zah
    public function getQuestionPartText($question_part_id) {
        $data = Yii::app()->db->createCommand()
                ->select('question_part_name')
                ->from('question_part')
                ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                ->queryAll();
        if(isset($data[0]['question_part_name']))
        {
            return $data[0]['question_part_name'];
        }
        else
        {
            return null;
        }
        
    }
    
    public function deleteQuestionPart($question_part_id){
        QuestionPart::model()->findByPk($question_part_id)->delete();
    }

}
