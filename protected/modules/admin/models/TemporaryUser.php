<?php

/**
 * This is the model class for table "temporary_user".
 *
 * The followings are the available columns in table 'temporary_user':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $address
 * @property integer $country_id
 * @property string $email
 * @property integer $course_id
 * @property integer $level_id
 * @property integer $sitting_id
 *
 * The followings are the available model relations:
 * @property Sitting $sitting
 * @property Country $country
 * @property Course $course
 * @property Level $level
 */
class TemporaryUser extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TemporaryUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'temporary_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name, last_name, phone_number, address, country_id, email, course_id, level_id, sitting_id', 'required'),
            array('country_id, course_id, level_id, sitting_id', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email', 'length', 'max' => 100),
            array('phone_number', 'length', 'max' => 20),
            array('address', 'length', 'max' => 150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, first_name, last_name, phone_number, address, country_id, email, course_id, level_id, sitting_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sitting' => array(self::BELONGS_TO, 'Sitting', 'sitting_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'country_id' => 'Country',
            'email' => 'Email',
            'course_id' => 'Course',
            'level_id' => 'Level',
            'sitting_id' => 'Sitting',
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
        $criteria->with = array('country');

        if (isset($_GET['TemporaryUser']['country_id'])) {
            $criteria->compare('country_name', $_GET['TemporaryUser']['country_id'], true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('phone_number', $this->phone_number, true);
        $criteria->compare('address', $this->address, true);
        //$criteria->compare('country_id', $this->country_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('sitting_id', $this->sitting_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getCountruByID($country_id) {
        if ($country_id = "") {
            $data = Yii::app()->db->createCommand()
                    ->select('country_name')
                    ->from('country')
                    ->where('country_id=:country_id', array(':country_id' => $country_id))
                    ->queryAll();
            if (isset($data[0]['country_name'])) {
                return $data[0]['country_name'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}