<?php

/**
 * This is the model class for table "subject_lecturer".
 *
 * The followings are the available columns in table 'subject_lecturer':
 * @property integer $subject_lecturer_id
 * @property integer $lecturer_id
 * @property integer $subject_id
 *
 * The followings are the available model relations:
 * @property Subject $subject
 * @property Lecturer $lecturer
 */
class SubjectLecturer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SubjectLecturer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subject_lecturer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lecturer_id, subject_id', 'required'),
            array('lecturer_id, subject_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject_lecturer_id, lecturer_id, subject_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
            'lecturer' => array(self::BELONGS_TO, 'Lecturer', 'lecturer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subject_lecturer_id' => 'Subject Lecturer',
            'lecturer_id' => 'Lecturer',
            'subject_id' => 'Subject',
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

        $criteria->compare('subject_lecturer_id', $this->subject_lecturer_id);
        $criteria->compare('lecturer_id', $this->lecturer_id);
        $criteria->compare('subject_id', $this->subject_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getSubjectsOfLecturerById($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_lecturer')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();

        $subjectData = Array();

        foreach ($data as $d) {
            $subjectDetails = Subject::model()->getSubjectDetails($d['subject_id']);

            $levelData = Level::model()->getLevel($subjectDetails["level_id"]);

            $levelName = $levelData['level_name'];

            $courseName = Course::model()->getCourseName($levelData['course_id']);

            $subjectData[] = array("subject_name" => $subjectDetails['subject_name'], "level_name" => $levelName, "course_name" => $courseName);
        }
        return $subjectData;
    }

    public static function loadLecturerSubjectSession($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('subject_id')
                ->from('subject_lecturer')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();

        return $data;
    }

}
