<?php

/**
 * This is the model class for table "exam_audit".
 *
 * The followings are the available columns in table 'exam_audit':
 * @property integer $exam_audit_id
 * @property integer $exam_id
 * @property integer $user_id
 * @property string $action
 * @property string $date
 * @property string $time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Exam $exam
 * @property User $user
 */
class ExamAudit extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExamAudit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_audit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exam_id, user_id, action, date, time, status', 'required'),
            array('exam_id, user_id, status', 'numerical', 'integerOnly' => true),
            array('action', 'length', 'max' => 4),
            array('date', 'length', 'max' => 20),
            array('time', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_audit_id, exam_id, user_id, action, date, time, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'exam_audit_id' => 'Exam Audit ID',
            'exam_id' => 'Exam ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'date' => 'Date',
            'time' => 'Time',
            'status' => 'Status',
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

        $criteria->compare('exam_audit_id', $this->exam_audit_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getNewExamAudits() {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_audit')
                ->where('status=:status', array(':status' => '1'))
                ->queryAll();
        return $data;
    }
    
    public static function getStatus($status) {
        if($status==0){
            return "Not New";
        }else{
            return "New";
        }
    }

}
