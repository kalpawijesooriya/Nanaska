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
 */
class User extends CActiveRecord {

    public $level_id;
    public $sitting_id;
    public $subject_id;
    public $course_id;

    public $current_password;
    public $new_password;
    public $repeat_new_password;

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
    const WEAK = 0;
    const STRONG = 1;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('user_type', 'required'),
            array('first_name', 'required', 'message' => 'Please enter first name'),
            array('last_name', 'required', 'message' => 'Please enter last name'),
            array('email', 'required', 'message' => 'Please enter email'),
            array('password', 'required', 'message' => 'Please enter password'),
            array('phone_number', 'required', 'message' => 'Please enter phone number'),
            array('address', 'required', 'message' => 'Please enter address'),
            array('country_id', 'required', 'message' => 'Please enter country'),
            array('user_type', 'required', 'message' => 'Please enter user type'),
            array('reset_token', 'length', 'max' => 512),
            array('phone_number, country_id', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, address', 'length', 'max' => 100),
            array('email', 'checkEmail', 'strength' => self::STRONG, 'on' => 'created'),
            array('password', 'length', 'max' => 32),
            array('user_type', 'length', 'max' => 10),
            array('email', 'unique', 'message' => 'This email address is already been registered!'),
            array('email', 'email'),
            array('course_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, first_name, last_name, email, password, phone_number, address, country_id, user_type', 'safe', 'on' => 'search'),
        );
    }

    public function checkEmail($attribute, $params) {
        $models = User::model()->findAllByAttributes(array('email' => $this->email));
        if (count($models) > 0) {
            $this->addError($attribute, 'This E-mail is already in use');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lecturer' => array(self::HAS_ONE, 'Lecturer', 'user_id'),
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
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'country_id' => 'Country',
            'user_type' => 'User Type',
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

        $criteria->compare('user_id', $this->user_id);
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

    public function searchByCondition($condition) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('phone_number', $this->phone_number);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('user_type', $this->user_type, true);

        $criteria->condition = $condition;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getUserInfoById($user_id) {

        /*  $Criteria = new CDbCriteria();
          $Criteria->condition = "user_id = ".$user_id;
          // $Criteria->compare("user_id",$user_id);
          $user = User::model()->find($Criteria);

          return $user;
         */

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0];
    }

    public static function getLecturerInfoByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('lecturer')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0];
    }

    public static function getLecturerIdByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('lecturer_id')
                ->from('lecturer')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0]['lecturer_id'];
    }

    public static function getUserByType($user_type) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('user')
                ->where('user_type=:user_type', array(':user_type' => $user_type))
                ->queryAll();
        return $data;
    }

    public function getLectures() {
        $user_ID = Yii::app()->user->getId();
        $data = Yii::app()->db->createCommand()
                ->select('email')
                ->from('user')
                //->where('user_id=:user_id', array(':user_id' => $user_ID))
                ->where('user_type="LECTURER" AND user_id=' . $user_ID)
                ->queryAll();
        return $data[0]['email'];
    }

    public static function getName($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('first_name, last_name')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        if (count($data) != 0) {
            if ($data[0]['first_name'] == NULL && $data[0]['last_name'] == NULL) {
                return "Not Set";
            } else {
                return $data[0]['first_name'] . " " . $data[0]['last_name'];
            }
        } else {
            return "Not Set";
        }
    }

    public static function getUserType($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('user_type')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        if (count($data) != 0) {
            return $data[0]['user_type'];
        } else {
            return null;
        }
    }

    public function getUserName($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('first_name,last_name,user_type')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryRow();
        if (count($data) != 0) {
            return $data;
        } else {
            return null;
        }
    }

    public function getFirstName($user_id) {

        $data = Yii::app()->db->createCommand()
                ->select('first_name')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryScalar();
        if (count($data) != 0) {

            if ($data == false) {
                return "-";
            } else {
                return $data;
            }
        } else {
            return null;
        }
    }

    public function getLastName($user_id) {

        $data = Yii::app()->db->createCommand()
                ->select('last_name')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryScalar();
        if (count($data) != 0) {
            if ($data == false) {
                return "-";
            } else {
                return $data;
            }
        } else {
            return null;
        }
    }

}
