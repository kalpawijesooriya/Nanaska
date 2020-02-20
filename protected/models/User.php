<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $phone_number
 * @property string $address
 * @property integer $country_id
 * @property string $user_type
 * @property string $reset_token
 *
 * The followings are the available model relations:
 * @property Lecturer[] $lecturers
 * @property Student[] $students
 * @property Country $country
 * 
 */
class User extends CActiveRecord {
    
    const TIME_SPLIT = "$$";

    public $repeatpassword;
    public $sitting_id;
    public $level_id;
    public $course_id;
    public $status;
    public $current_password;
    public $new_password;
    public $repeat_new_password;
    public $verifyCode;

    //public $type;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name, email, phone_number,last_name,address,country_id, password', 'required', 'message' => 'Please enter your {attribute}.'),
            array('country_id, user_type', 'required', 'message' => 'Please enter a {attribute}.'),
            array('course_id', 'required', 'message' => 'Please select a course.'),
            array('level_id', 'required', 'message' => 'Please select a level.'),
            array('sitting_id', 'required', 'message' => 'Please select a session.'),
            array('repeatpassword', 'required', 'message' => 'Please confirm your Password.'),
            array('phone_number, country_id', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, address', 'length', 'max' => 100),
            array('password', 'length', 'min' => 6, 'max' => 32),
            array('repeatpassword', 'compare', 'compareAttribute' => 'password', 'message' => "Sorry passwords do not match"),
            array('user_type', 'length', 'max' => 10),
            array('phone_number', 'length', 'max' => 25),
             array('reset_token', 'length', 'max' => 512),
            array('email', 'email'),
            array('email', 'unique', 'message' => 'This email address is already been registered!'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            //array('current_password, new_password, repeat_new_password', 'required', 'on'=>'update'),
            //array('current_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Sorry passwords do not match with current password", 'on'=>'update'),
            //array('repeat_new_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>"Sorry new passwords do not match", 'on'=>'update'),
            array('email', 'unique', 'message' => 'Entered email address has already been registered!'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, first_name, last_name, email, password, phone_number, address, country_id, user_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lecturers' => array(self::HAS_MANY, 'Lecturer', 'user_id'),
            'students' => array(self::HAS_MANY, 'Student', 'user_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'repeatpassword' => 'Repeat Password',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'country_id' => 'Country',
            'user_type' => 'User Type',
            'verifyCode' => 'Verification Code',
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

        $criteria->compare('user_id', Yii::app()->user->getId());
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('phone_number', $this->phone_number);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('user_type', $this->user_type, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /* public function beforeSave()
      {
      $pass = md5($this->password);
      $this->password = $pass;

      return TRUE;


      } */

    public function checkEmailExist($email) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('email="' . $email . '"');
        $result = User::model()->find($criteria);
        if (!empty($result) && $result->email == $email) {
            return "yes";
        } else {
            return "no";
        }
    }

    public function getUserByEmail($email) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('email="' . $email . '"');
        $result = User::model()->find($criteria);
        return $result;
    }

    public function getType() {
        $user_ID = Yii::app()->user->getId();
        $data = Yii::app()->db->createCommand()
                ->select('user_type')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_ID))
                ->queryAll();
        return $data[0]['user_type'];
    }

    public function getLevelByLevelId($levelid) {
        $data = Yii::app()->db->createCommand()
                ->select('level_name')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $levelid))
                ->queryAll();
        return $data;
    }

    public function getUserDetailsByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0];
    }

    public static function generateToken($hash = '') {

        return md5(uniqid($hash, true)) . self::TIME_SPLIT . strtotime("now");
    }
    
    public static function validateToken($token, $life_time = 3600) {
        $token_parts = explode(self::TIME_SPLIT, $token);

        if ((time() - $token_parts[1]) > $life_time) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

}