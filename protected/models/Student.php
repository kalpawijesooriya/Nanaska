<?php

/**
 * This is the model class for table "student".
 *
 * The followings are the available columns in table 'student':
 * @property integer $student_id
 * @property integer $user_id
 * @property integer $level_id
 * @property integer $sitting_id
 * @property string $note
 * @property integer $status
 * @property integer $show_exam_breakdown
 * @property string $student_type
 */
class Student extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Student the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'student';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, level_id, sitting_id, show_exam_breakdown, student_type', 'required'),
            array('user_id, level_id, sitting_id, status, show_exam_breakdown', 'numerical', 'integerOnly' => true),
            array('student_type', 'length', 'max' => 9),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('student_id, user_id, level_id, sitting_id, note, status, show_exam_breakdown, student_type', 'safe', 'on' => 'search'),
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
            'student_id' => 'Student',
            'user_id' => 'User',
            'level_id' => 'Level',
            'sitting_id' => 'Sitting',
            'note' => 'Note',
            'status' => 'Status',
            'show_exam_breakdown' => 'Show Exam Breakdown',
            'student_type' => 'Student Type',
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

        $criteria->compare('student_id', $this->student_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('sitting_id', $this->sitting_id);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('show_exam_breakdown', $this->show_exam_breakdown);
        $criteria->compare('student_type', $this->student_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLevelNameUpdate($user_Id) {

        $data = Yii::app()->db->createCommand()
                ->select('level_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_Id))
                ->queryAll();
        return $data[0]['level_id'];
    }

    public function getSittingIdUpdate($user_Id) {

        $data = Yii::app()->db->createCommand()
                ->select('sitting_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_Id))
                ->queryAll();
        return $data[0]['sitting_id'];
    }

    public function getStatus() {
        $user_ID = Yii::app()->user->getId();
        $data = Yii::app()->db->createCommand()
                ->select('status')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_ID))
                ->queryAll();
        return $data[0]['status'];
    }

    public function getStudentIdForUserId($user_id) {
        if ($user_id != "") {
            $data = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $user_id))
                    ->queryAll();
            return $data[0]['student_id'];
        } else {
            return null;
        }
    }

    public static function getStudentById($student_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('student')
                ->where('student_id=:student_id', array(':student_id' => $student_id))
                ->queryAll();
        return $data[0];
    }

    public static function getStudentTypeByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('student_type')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0]['student_type'];
    }

    public static function getStudentStatusTypeByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('status')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0]['status'];
    }

    public function getStudentByStudentUniqueCode($student_unique_code){
        $criteria = new CDbCriteria;
        $criteria->addCondition('student_unique_code="' . $student_unique_code.'"');
        return $this->model()->find($criteria);
    }
}
