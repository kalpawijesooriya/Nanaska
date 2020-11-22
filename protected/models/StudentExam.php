<?php

/**
 * This is the model class for table "student_exam".
 *
 * The followings are the available columns in table 'student_exam':
 * @property integer $student_exam_id
 * @property integer $student_id
 * @property integer $exam_id
 * @property string $transaction_id
 * @property string $start_date
 * @property string $expiry_date
 *
 * The followings are the available model relations:
 * @property Student $student
 * @property Exam $exam
 */
class StudentExam extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StudentExam the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'student_exam';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id, exam_id, start_date, expiry_date', 'required'),
            array('student_id, exam_id', 'numerical', 'integerOnly' => true),
            array('start_date, expiry_date', 'length', 'max' => 15),
            array('transaction_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('student_exam_id, student_id, exam_id, start_date, expiry_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'student_exam_id' => 'Student Exam',
            'student_id' => 'Student',
            'exam_id' => 'Exam',
            'transaction_id' => 'Transaction ID',
            'start_date' => 'Start Date',
            'expiry_date' => 'Expiry Date',
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

        $criteria->compare('student_exam_id', $this->student_exam_id);
        $criteria->compare('student_id', $this->student_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('expiry_date', $this->expiry_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getExamsForStudentId($student_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('student_id=' . $student_id);
        return $this->findAll($criteria);
    }

    public function getExamsOfStudent($student_id) {

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('student_exam')
                ->where('student_id=:student_id', array(':student_id' => $student_id))
                ->queryAll();
        return $data;
    }

}
