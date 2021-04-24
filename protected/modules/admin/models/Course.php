<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $course_id
 * @property string $course_name
 *
 * The followings are the available model relations:
 * @property Level[] $levels
 */
class Course extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Course the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'course';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_name', 'required','message' => "Please enter a course name"),
            array('course_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('course_id, course_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'levels' => array(self::HAS_MANY, 'Level', 'course_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'course_id' => 'Course ID',
            'course_name' => 'Course Name',
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

        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('course_name', $this->course_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getCourseName($course_id) {
        $data = Yii::app()->db->createCommand()
                ->select('course_name')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();
        return $data[0]['course_name'];
    }
    
    
    public function getCourseIdByName($course_name){
        $data = Yii::app()->db->createCommand()
                ->select('course_id')
                ->from('course')
                ->where('course_name=:course_name', array(':course_name' => $course_name))
                ->queryAll();
        return $data[0]['course_id'];
    }

    public function getCourseDetails($course_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();
        return $data[0];
    }
    
     public function getCourseNameForNews($course_id) {
         
         if($course_id==NULL){
             return 'N/A';
         }else{
        $data = Yii::app()->db->createCommand()
                ->select('course_name')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();
      //  print_r($data[0]['course_name']);die();
        return $data[0]['course_name'];
         }
    }
    public static function getCoursesForUser($user_id){
        //$user_id = Yii::app()->user->getId();
        if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN"){
            //$lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            $return_array=array();
            

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('course_id, course_name')
                    ->from('course')
                    ->queryAll();

            if(count($data) != 0){
                foreach ($data as $result){
//                    $return_array[$result['course_id']]=$result['course_name'];
                    $return_array[$result['course_id']]=$result['course_name'];
                }
                return $return_array;
            }else{
                return $return_array;
            }
          
        }else{
            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            $return_array=array();
            if($lecture_id != null){

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('course_id, course_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecture_id))
                        ->queryAll();

                if(count($data) != 0){
                    foreach ($data as $result){
    //                    $return_array[$result['course_id']]=$result['course_name'];
                        $return_array[$result['course_id']]=$result['course_name'];
                    }
                    return $return_array;
                }else{
                    return $return_array;
                }
            }else{
                return $return_array;
            }
        }
        
    }
    
        public static function getCoursesForUserAdvancedSearch(){
        //$user_id = Yii::app()->user->getId();
        if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN"){
            //$lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            $return_array=array();
            

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('course_id, course_name')
                    ->from('course')
                    ->queryAll();

            if(count($data) != 0){
                foreach ($data as $result){
//                    $return_array[$result['course_id']]=$result['course_name'];
                    $return_array[$result['course_id']]=$result['course_name'];
                }
                return $return_array;
            }else{
                return $return_array;
            }
          
        }else{
            $user_id = Yii::app()->user->loadUser()->user_id;
            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            $return_array=array();
            if($lecture_id != null){

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('course_id, course_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecture_id))
                        ->queryAll();

                if(count($data) != 0){
                    foreach ($data as $result){
    //                    $return_array[$result['course_id']]=$result['course_name'];
                        $return_array[$result['course_id']]=$result['course_name'];
                    }
                    return $return_array;
                }else{
                    return $return_array;
                }
            }else{
                return $return_array;
            }
        }
        
    }

}
