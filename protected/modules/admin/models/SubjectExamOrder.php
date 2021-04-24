<?php

/**
 * This is the model class for table "subject_exam_order".
 *
 * The followings are the available columns in table 'subject_exam_order':
 * @property integer $subject_exam_order_id
 * @property integer $subject_id
 * @property integer $exam_id
 * @property integer $position
 */
class SubjectExamOrder extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SubjectExamOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subject_exam_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_id, exam_id, position', 'required'),
            array('subject_id, exam_id, position', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject_exam_order_id, subject_id, exam_id, position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subject_exam_order_id' => 'Subject Exam Order',
            'subject_id' => 'Subject',
            'exam_id' => 'Exam',
            'position' => 'Position',
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

        $criteria->compare('subject_exam_order_id', $this->subject_exam_order_id);
        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getSubjectExamOrderDetails($subject_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_exam_order')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();
        return $data;
    }

}
