<?php

/**
 * This is the model class for table "subject".
 *
 * The followings are the available columns in table 'subject':
 * @property integer $subject_id
 * @property integer $level_id
 * @property string $subject_name
 *
 * The followings are the available model relations:
 * @property Exam[] $exams
 * @property Level $level
 */
class Subject extends CActiveRecord {

    public $course_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Subject the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subject';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('level_id, subject_name', 'required'),
            array('level_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject_id, level_id, subject_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'exams' => array(self::HAS_MANY, 'Exam', 'subject_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subject_id' => 'Subject ID',
            'level_id' => 'Level',
            'subject_name' => 'Subject Name',
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

        $criteria->with = array('level');

        $criteria->with = array('level.course');

        if (isset($_GET['Subject']['course_id'])) {
            $criteria->compare('course_name', $_GET['Subject']['course_id'], true);
        }

        $criteria->compare('subject_id', $this->subject_id);
//		$criteria->compare('level_id',$this->level_id);
        $criteria->compare('level.level_name', $this->level_id, true);
        $criteria->compare('subject_name', $this->subject_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getSubjectName($subject_id) {
        $data = Yii::app()->db->createCommand()
                ->select('subject_name')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();
        return $data[0]['subject_name'];
    }

    public function getSubjectDetails($subject_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();
        return $data[0];
    }

    public static function getSubjectInfoById($subject_id) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "subject_id = " . $subject_id;
        // $Criteria->compare("exam_id",$exam_id);
        $subject = Subject::model()->find($Criteria);

        return $subject;
    }

    public function getCourseOfSubject($subject_id) {
        $subjectdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();

        $leveldata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $subjectdata[0]['level_id']))
                ->queryAll();
        return $leveldata[0]['course_id'];
    }

    public function getLevelOfSubject($subject_id) {
        $subjectdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();


        return $subjectdata[0]['level_id'];
    }
    public function getSubjectsForUser($levelID) {
        $user_id = Yii::app()->user->getId();
        $return_array=array();
        if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN"){
                       

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('subject_id')
                    ->from('subject')
                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                    ->queryAll();

            
            if(count($data) > 0){ 
            foreach ($data as $d) {
                $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                $return_array[$d['subject_id']]=$subjectName;
                
            }
            }
            
            
            
        }else{
            
            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            
                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id, subject_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and level_id=:level_id', array(':lecturer_id' => $lecture_id,':level_id'=>$levelID))
                        ->queryAll();

    //            $data = Yii::app()->db->createCommand()
    //                    ->selectdistinct('subject_id')
    //                    ->from('subject')
    //                    ->where('level_id=:level_id', array(':level_id' => $levelID))
    //                    ->queryAll();

                
                if(count($data) > 0){ 
                foreach ($data as $d) {
                    $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                    $return_array[$d['subject_id']]=$subjectName;
                    
                }

            }
            
        }
        return $return_array;
    }

    public function getSubjectsForLevel($id){
        $criteria = new CDbCriteria;
        $criteria->addCondition('level_id=' . $id);
        $criteria->order = "subject_name ASC";
        return $this->model()->findAll($criteria);
    }
}
