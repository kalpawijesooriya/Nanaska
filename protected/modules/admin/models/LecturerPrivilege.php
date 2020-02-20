<?php

/**
 * This is the model class for table "lecturer_privilege".
 *
 * The followings are the available columns in table 'lecturer_privilege':
 * @property integer $lecturer_privilege_id
 * @property integer $lecturer_id
 * @property integer $course_management
 * @property integer $level_management
 * @property integer $subject_management
 * @property integer $subject_area_management
 * @property integer $sitting_management
 * @property integer $news_management
 * @property integer $country_management
 * @property integer $student_management
 * @property integer $lecturer_management
 * @property integer $temporary_users
 * @property integer $exam_management
 * @property integer $question_management
 * @property integer $result_management
 * @property integer $essay_answer_management
 * @property integer $activity_logs
 *
 * The followings are the available model relations:
 * @property Lecturer $lecturer
 */
class LecturerPrivilege extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LecturerPrivilege the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lecturer_privilege';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lecturer_id, course_management, level_management, subject_management, subject_area_management, sitting_management, news_management, country_management, student_management, lecturer_management, temporary_users, exam_management, question_management, result_management,essay_answer_management,activity_logs', 'required'),
            array('lecturer_id, course_management, level_management, subject_management, subject_area_management, sitting_management, news_management, country_management, student_management, lecturer_management, temporary_users, exam_management, question_management, result_management,essay_answer_management,activity_logs', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('lecturer_privilege_id, lecturer_id, course_management, level_management, subject_management, subject_area_management, sitting_management, news_management, country_management, student_management, lecturer_management, temporary_users, exam_management, question_management, result_management,essay_answer_management,activity_logs', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lecturer' => array(self::BELONGS_TO, 'Lecturer', 'lecturer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'lecturer_privilege_id' => 'Lecturer Privilege',
            'lecturer_id' => 'Lecturer',
            'course_management' => 'Course Management',
            'level_management' => 'Level Management',
            'subject_management' => 'Subject Management',
            'subject_area_management' => 'Subject Area Management',
            'sitting_management' => 'Sitting Management',
            'news_management' => 'News Management',
            'country_management' => 'Country Management',
            'student_management' => 'Student Management',
            'lecturer_management' => 'Lecturer Management',
            'temporary_users' => 'Temporary Users',
            'exam_management' => 'Exam Management',
            'question_management' => 'Question Management',
            'result_management' => 'Result Management',
            'essay_answer_management' => 'Essay Answer Management',
            'activity_logs'=>'Activity Logs'
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

        $criteria->compare('lecturer_privilege_id', $this->lecturer_privilege_id);
        $criteria->compare('lecturer_id', $this->lecturer_id);
        $criteria->compare('course_management', $this->course_management);
        $criteria->compare('level_management', $this->level_management);
        $criteria->compare('subject_management', $this->subject_management);
        $criteria->compare('subject_area_management', $this->subject_area_management);
        $criteria->compare('sitting_management', $this->sitting_management);
        $criteria->compare('news_management', $this->news_management);
        $criteria->compare('country_management', $this->country_management);
        $criteria->compare('student_management', $this->student_management);
        $criteria->compare('lecturer_management', $this->lecturer_management);
        $criteria->compare('temporary_users', $this->temporary_users);
        $criteria->compare('exam_management', $this->exam_management);
        $criteria->compare('question_management', $this->question_management);
        $criteria->compare('result_management', $this->result_management);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function isPrivilegeSet($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('lecturer_privilege')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        if ($data == null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function getPrivilegeByLecturerId($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('lecturer_privilege')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        return $data[0];
    }
    
    //get individual priviledges for isAllowed method in EwebUser Class 
    public static function getIndividualPriviledge($priviledge_object,$lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select($priviledge_object)
                ->from('lecturer_privilege')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        if(isset($data[0][$priviledge_object]))
        {
            return $data[0][$priviledge_object];
        }
        else
        {
            return null;
        }
    }

}