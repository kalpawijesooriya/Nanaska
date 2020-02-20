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

 * The followings are the available model relations:
 * @property Sitting $sitting
 * @property User $user
 * @property Level $level
 * @property Take[] $takes
 */
class Student extends CActiveRecord {

    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $country_id;
    public $level;
    public $country;
    public $user_search;
    public $subject_id;

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
//public function tableName()
//{
//    return 'student';
//}

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Student the static model class
     */
//    public static function model($className = __CLASS__) {
//        return parent::model($className);
//    }

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
            array('user_id, level_id, sitting_id', 'required'),
            array('user_id, level_id, sitting_id', 'numerical', 'integerOnly' => true),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('student_id, user_id, level_id, sitting_id, note, user_search', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
            'takes' => array(self::HAS_MANY, 'Take', 'student_id'),
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
        $criteria->with = array('user');

        $criteria->compare('student_id', $this->student_id);
        if (isset($_GET['Student'])) {
            $criteria->compare('user.first_name', $_GET['Student']['first_name'], true);
            $criteria->compare('user.last_name', $_GET['Student']['last_name'], true);
            $criteria->compare('user.email', $_GET['Student']['email'], true);
            $criteria->compare('user.phone_number', $_GET['Student']['phone_number'], true);
            //$criteria->compare('user.address', $_GET['Student']['address'],true);
        }
        //	 $criteria->compare('level_id',$this->level_id);
        //	 $criteria->compare('sitting_id',$this->sitting_id);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }

    public function getDisplayOfExamBreakDown($show_exam_breakdown) {
        if ($show_exam_breakdown == 1) {
            return "Yes";
        } else if ($show_exam_breakdown == 0) {
            return "No";
        }
    }

    public function getStudentTypeLabel($student_type) {
        if ($student_type == "FULL_TIME") {
            return "Full Time";
        } else if ($student_type == "PART_TIME") {
            return "Part Time";
        }
    }

    public function getStatusLabel($status) {
        if ($status == 1) {
            return "Active";
        } else if ($status == 0) {
            return "In-Active";
        }
    }

    public function getStudentIdForUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('student_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryScalar();
        return $data;
    }

    public static function getStudentById($student_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('student')
                ->where('student_id=:student_id', array(':student_id' => $student_id))
                ->queryAll();
        return $data[0];
    }

    public function getStudentsBySittingId($sitting_id) {
        $students = Yii::app()->db->createCommand()
                ->select('*')
                ->from('student')
                ->where('sitting_id=:sitting_id', array(':sitting_id' => $sitting_id))
                ->queryAll();

        return $students;
    }

    public function getCourseOfStudent($student_id) {
        $subjectdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('student')
                ->where('student_id=:student_id', array(':student_id' => $student_id))
                ->queryAll();

        $leveldata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $subjectdata[0]['level_id']))
                ->queryAll();
        return $leveldata[0]['course_id'];
    }

    public function getAllStudentDetails() {
        $data = Yii::app()->db->createCommand()
                ->select('email')
                ->from('user')
                ->where('user_type=:user_type', array(':user_type' => "STUDENT"))
                ->queryAll();
        return $data;
    }

    public function getuserIDFromEmail($email) {
        $data = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('user')
                ->where('email=:email', array(':email' => $email))
                ->queryAll();
        if (isset($data[0])) {
            return $data[0]['user_id'];
        } else {
            return null;
        }
    }

    public function getCoursesFromUserId($userID) {
        $level_id = Student::model()->findByAttributes(array('user_id' => $userID));
        $course_id = Level::model()->findByAttributes(array('level_id' => $level_id['level_id']));
        $course_details = Course::model()->findByAttributes(array('course_id' => $course_id['course_id']));

        return $course_details;
    }

    public function getLevelDetails($userID) {
        $level_id = Student::model()->findByAttributes(array('user_id' => $userID));
        $levelDetails = Level::model()->findByAttributes(array('level_id' => $level_id['level_id']));
        return $levelDetails;
    }

    public function getSubjectDetails($userID) {
        $level_id = Student::model()->findByAttributes(array('user_id' => $userID));
        // $subjectDetails = Subject::model()->findByAttributes(array('level_id' => $level_id['level_id']));
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('level_id=:level_id', array(':level_id' => $level_id['level_id']))
                ->queryAll();
        return $data;

        // return $subjectDetails;
    }
    public function getStudentNameByUserID($id) {
        $data = Yii::app()->db->createCommand()
                ->select('first_name, last_name')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $id))
                ->queryAll();
        //var_dump($data); die;
        return $data[0]['first_name'].' '.$data[0]['last_name'];
    }
    public function getStudentEmailByUserID($id) {
        $data = Yii::app()->db->createCommand()
                ->select('email')
                ->from('user')
                ->where('user_id=:user_id', array(':user_id' => $id))
                ->queryAll();
        //var_dump($data); die;
        return $data[0]['email'];
    }
}
