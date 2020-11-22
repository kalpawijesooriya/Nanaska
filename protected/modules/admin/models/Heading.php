<?php

/**
 * This is the model class for table "heading".
 *
 * The followings are the available columns in table 'heading':
 * @property integer $heading_id
 * @property integer $question_id
 * @property string $heading_text
 * @property integer $heading_position
 *
 * The followings are the available model relations:
 * @property Question $question
 */
class Heading extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Heading the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'heading';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_id, heading_text, heading_position', 'required'),
            array('question_id, heading_position', 'numerical', 'integerOnly' => true),
//            array('heading_text', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('heading_id, question_id, heading_text, heading_position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'heading_id' => 'Heading',
            'question_id' => 'Question',
            'heading_text' => 'Heading Text',
            'heading_position' => 'Heading Position',
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

        $criteria->compare('heading_id', $this->heading_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('heading_text', $this->heading_text, true);
        $criteria->compare('heading_position', $this->heading_position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getHeadingsOfQuestion($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('heading')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->order('heading_position')
                ->queryAll();
        return $data;
    }
    
    // get question related headings : zah
    public function getHeadingTextforQuestionView($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        return Heading::model()->findAll($criteria);
    }

}
