<?php

/**
 * This is the model class for table "lecturer".
 *
 * The followings are the available columns in table 'lecturer':
 * @property integer $lecturer_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ExamLecturer[] $examLecturers
 * @property User $user
 */
class Lecturer extends CActiveRecord {

    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $country_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lecturer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lecturer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('lecturer_code', 'required','message'=>'Please enter lecturer code'),
            array('extra_number', 'required','message'=>'Please enter phone number 2'),
            //array('note', 'required','message'=>'Please enter note'),
            array('user_id, status, extra_number', 'numerical', 'integerOnly' => true),
            array('lecturer_code', 'length', 'max' => 25),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('lecturer_id, user_id, status, lecturer_code, extra_number, note', 'safe', 'on' => 'search'),
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
            'subjectLecturers' => array(self::HAS_MANY, 'SubjectLecturer', 'lecturer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'lecturer_id' => 'Lecturer',
            'user_id' => 'User',
            'status' => 'Status',
            'lecturer_code' => 'Lecturer Code',
            'extra_number' => 'Phone Number 2',
            'note' => 'Note',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
//        $criteria = new CDbCriteria;
//        $criteria->with = array('user');
//        
//        if(isset($_GET['Lecturer'])){
//        $criteria->compare('user.first_name', $this->$_GET['Lecturer']['first_name']);
//        }
//        $criteria->compare('lecturer_id', $this->lecturer_id);
//        $criteria->compare('user_id', $this->user_id);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));

        $criteria = new CDbCriteria;
        $criteria->with = array('user');

        $criteria->compare('lecturer_id', $this->lecturer_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('lecturer_code', $this->lecturer_code, true);
        $criteria->compare('extra_number', $this->extra_number);
        $criteria->compare('note', $this->note, true);

        if (isset($_GET['Lecturer'])) {
            $criteria->compare('user.first_name', $_GET['Lecturer']['first_name'], true);
            $criteria->compare('user.last_name', $_GET['Lecturer']['last_name'], true);
            $criteria->compare('user.email', $_GET['Lecturer']['email'], true);
            $criteria->compare('user.phone_number', $_GET['Lecturer']['phone_number'], true);
//            $criteria->compare('user.country_id', $_GET['Lecturer']['country_id'], true);
//            $criteria->compare('user.address', $_GET['Lecturer']['address'], true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function getUserIdByLecturerId($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('lecturer')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        return $data[0]['user_id'];
    }
    
    public static function getLecturerIdByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('lecturer_id')
                ->from('lecturer')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        if(count($data) != 0){
            return $data[0]['lecturer_id'];
        }else{
            return null;
        }
    }

    public static function getLecturerCode($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('lecturer')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        if(count($data) != 0){
            if ($data[0]['lecturer_code'] == NULL) {
                return "Not Set";
            } else {
                return $data[0]['lecturer_code'];
            }
        }else{
            return "Not Set";
        }
    }
    public static function getLecturerCodeByUserId($user_id){
        $data = Yii::app()->db->createCommand()
                ->select('lecturer_code')
                ->from('lecturer')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        if(count($data) != 0){
            if ($data[0]['lecturer_code'] == NULL) {
                return "Not Set";
            } else {
                return $data[0]['lecturer_code'];
            }
        }else{
            return "Not Set";
        }
    }
    public static function getUserIdByLecturerCode($lecturer_code) {
        $data = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('lecturer')
                ->where('lecturer_code=:lecturer_code', array(':lecturer_code' => $lecturer_code))
                ->queryAll();
        return $data[0]['user_id'];
    }

}
