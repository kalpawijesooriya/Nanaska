<?php

/**
 * This is the model class for table "login_audit".
 *
 * The followings are the available columns in table 'login_audit':
 * @property integer $login_audit_id
 * @property integer $user_id
 * @property string $action
 * @property string $date
 * @property string $time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class LoginAudit extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LoginAudit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'login_audit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, action, date, time, status', 'required'),
            array('user_id, status', 'numerical', 'integerOnly' => true),
            array('action', 'length', 'max' => 7),
            array('date', 'length', 'max' => 20),
            array('time', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('login_audit_id, user_id, action, date, time, status', 'safe', 'on' => 'search'),
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
            'login_audit_id' => 'Login Activity',
            'user_id' => 'User',
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

        $criteria->compare('login_audit_id', $this->login_audit_id);
//        $criteria->compare('user_id', $this->user_id);

        if (isset($_GET['LoginAudit']['user_id'])) {
            if ($_GET['LoginAudit']['user_id'] != "") {
                $criteria->compare('first_name', $_GET['LoginAudit']['user_id'], true);
            }
        }

        $criteria->compare('action', $this->action, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
//        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLoginAuditActionNameByLabel($action_name) {
        if ($action_name == "LOGIN") {
            return "Login";
        } else {
            return "Log out";
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
