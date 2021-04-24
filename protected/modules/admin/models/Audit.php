<?php

/**
 * This is the model class for table "audit".
 *
 * The followings are the available columns in table 'audit':
 * @property integer $audit_id
 * @property integer $user_id
 * @property integer $action_id
 * @property string $action_name
 * @property string $action
 * @property string $date
 * @property string $time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Audit extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Audit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'audit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('action_id, action_name, action, date, time, status', 'required'),
            array('action_id, status', 'numerical', 'integerOnly' => true),
//            array('user_id', 'setOnEmpty' => true),
            array('action_name', 'length', 'max' => 19),
            array('action', 'length', 'max' => 6),
            array('date', 'length', 'max' => 20),
            array('time', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('audit_id, user_id, action_id, action_name, action, date, time, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'audit_id' => 'Audit',
            'user_id' => 'User',
            'action_id' => 'Action ID',
            'action_name' => 'Action Name',
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

        $criteria->with = array('user');

        $criteria->compare('audit_id', $this->audit_id);
//        $criteria->compare('user_id', $this->user_id);

        if (isset($_GET['Audit']['user_id'])) {
            if ($_GET['Audit']['user_id'] != "") {
                $criteria->compare('first_name', $_GET['Audit']['user_id'], true);
            }
        }

        $criteria->compare('action_id', $this->action_id);
        $criteria->compare('action_name', $this->action_name, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getActionNameBylabel($action_name){
        
        if($action_name == "EXAM_MANAGEMENT"){
            return "Exam Management";            
        }else if($action_name == "QUESTION_MANAGEMENT"){
            return "Question Management"; 
        }else if($action_name == "STUDENT_MANAGEMENT"){
            return "Student Management"; 
        }else if($action_name == "LECTURER_MANAGEMENT"){
            return "Lecturer Management"; 
        }else if($action_name == "FRONT_END_PAYMENT"){
            return "Frontend Payment"; 
        }
    }
    
    
    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }

}
