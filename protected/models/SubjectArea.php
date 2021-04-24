<?php

/**
 * This is the model class for table "subject_area".
 *
 * The followings are the available columns in table 'subject_area':
 * @property integer $subject_area_id
 * @property integer $subject_id
 * @property string $subject_area_name
 *
 * The followings are the available model relations:
 * @property ExamSubjectArea[] $examSubjectAreas
 * @property Question[] $questions
 * @property Subject $subject
 */
class SubjectArea extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SubjectArea the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subject_area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_id, subject_area_name', 'required'),
            array('subject_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject_area_id, subject_id, subject_area_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'examSubjectAreas' => array(self::HAS_MANY, 'ExamSubjectArea', 'subject_area_id'),
            'questions' => array(self::HAS_MANY, 'Question', 'subject_area_id'),
            'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subject_area_id' => 'Subject Area',
            'subject_id' => 'Subject',
            'subject_area_name' => 'Subject Area Name',
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

        $criteria->compare('subject_area_id', $this->subject_area_id);
        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('subject_area_name', $this->subject_area_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getSubjectAreaName($subject_area_id) {
        $data = Yii::app()->db->createCommand()
                ->select('subject_area_name')
                ->from('subject_area')
                ->where('subject_area_id=:subject_area_id', array(':subject_area_id' => $subject_area_id))
                ->queryAll();
        return $data[0]['subject_area_name'];
    }

}
