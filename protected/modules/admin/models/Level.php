<?php

/**
 * This is the model class for table "level".
 *
 * The followings are the available columns in table 'level':
 * @property integer $level_id
 * @property string $level_name
 * @property integer $course_id
 *
 * The followings are the available model relations:
 * @property Exam[] $exams
 * @property Course $course
 * @property News[] $news
 * @property Student[] $students
 * @property SubjectArea[] $subjectAreas
 */
class Level extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Level the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'level';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('level_name', 'required', 'message' =>'Please enter a level'),
            array('course_id', 'required', 'message' => 'Please select a course'),
            array('course_id', 'numerical', 'integerOnly' => true),
            array('level_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('level_id, level_name, course_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'exams' => array(self::HAS_MANY, 'Exam', 'level_id'),
            'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
            'news' => array(self::HAS_MANY, 'News', 'level_id'),
            'students' => array(self::HAS_MANY, 'Student', 'level_id'),
            'subjectAreas' => array(self::HAS_MANY, 'SubjectArea', 'level_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'level_id' => 'Level ID',
            'level_name' => 'Level Name',
            'course_id' => 'Course',
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

        $criteria->with = array('course');

        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('level_name', $this->level_name, true);
//        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('course.course_name', $this->course_id, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function getLevels() {
        $return_array = array();

        $criteria = new CDbCriteria;
        $criteria->order = "level_name";
        $results = Level::model()->findAll($criteria);

        foreach ($results as $result) {
            $return_array[$result->level_id] = $result->level_name;
        }
        return $return_array;
    }

    public static function getLevelsOfCourse($level_id) {
//        echo $le;

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $level_id))
                ->queryAll();

//        print_r($data);


        $course_id = $data[0]['course_id'];

        $return_array = array();

        $criteria = new CDbCriteria;
        $criteria->order = "level_name";
        $criteria->condition = "course_id = " . $course_id;

        $results = Level::model()->findAll($criteria);

        foreach ($results as $result) {
            $return_array[$result->level_id] = $result->level_name;
        }
        return $return_array;
    }

    public function getLevel($level_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $level_id))
                ->queryAll();

        return $data[0];
    }

    public static function getLevelName($level_id) {
        if ($level_id != "") {
            $data = Yii::app()->db->createCommand()
                    ->select('level_name')
                    ->from('level')
                    ->where('level_id=:level_id', array(':level_id' => $level_id))
                    ->queryAll();
            return $data[0]['level_name'];
        }
    }

    public function getCourse($course_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();

        return $data[0];
    }

    public function getLevelForNews($level_id) {

        if ($level_id == null) {
            return 'No';
        } else {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('level') 
                    ->where('level_id=:level_id', array(':level_id' => $level_id))
                    ->queryAll();

            return $data[0];
        }
    }

    public function getLevelNameForNews($level_id) {
        if ($level_id != "") {
            if ($level_id == NULL) {
                return 'No';
            } else {
                $data = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('level')
                        ->where('level_id=:level_id', array(':level_id' => $level_id))
                        ->queryAll();
                return $data[0]['level_name'];
            }
        }
    }
    
    public function getLevelNameForNewsAdmin($level_id) {
       
            if ($level_id == NULL) {
                return 'N/A';
            } else {
                $data = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('level')
                        ->where('level_id=:level_id', array(':level_id' => $level_id))
                        ->queryAll();
                return $data[0]['level_name'];
            }
        
    }
    
    public function getCourseOfLevelID($level_id) {
         $level_data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $level_id))
                ->queryAll();


        return $level_data[0]['course_id'];
    }
    public function getLevelsForUser($courseID) {
        $return_array=array();
        $user_id = Yii::app()->user->getId();
        if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN"){
            
            
            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('level_id')
                    ->from('level')
                    ->where('course_id=:course_id', array(':course_id' => $courseID))
                    ->queryAll();

            if(count($data) > 0) {
                foreach ($data as $d) {
                    $levelData = Level::model()->getLevel($d['level_id']);

                    $levelName = $levelData['level_name'];

                    $return_array[$d['level_id']]=$levelName;
                    
                }
            }
            
        }else{
            
            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id, level_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and course_id=:course_id', array(':lecturer_id' => $lecture_id,':course_id'=>$courseID))
                        ->queryAll();
    //            $data = Yii::app()->db->createCommand()
    //                    ->selectdistinct('level_id')
    //                    ->from('level')
    //                    ->where('course_id=:course_id', array(':course_id' => $courseID))
    //                    ->queryAll();

               
                if(count($data) > 0) {
                foreach ($data as $d) {
                    $levelData = Level::model()->getLevel($d['level_id']);

                    $levelName = $levelData['level_name'];

                    $return_array[$d['level_id']]=$levelName;
                    
                }
                } 
            
        }
        
        return $return_array;
    }
    
    public function getLevelsForCourse($course_id){
        $criteria = new CDbCriteria;
        $criteria->addCondition('course_id=' . $course_id);
        $criteria->order="level_name ASC";
        return $this->model()->findAll($criteria);
    }

}
