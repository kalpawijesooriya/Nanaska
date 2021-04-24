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
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_name', 'required'),
			array('course_name', 'length', 'max'=>100),
                        //array('course_id','required','message'=>'Please select a course', 'on' => 'created'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('course_id, course_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'levels' => array(self::HAS_MANY, 'Level', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'course_id' => 'Course',
			'course_name' => 'Course Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_name',$this->course_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        //retreive course names on registration
        public static function getCourse(){
        $return_array=array();
        
        $criteria=new CDbCriteria;
        $criteria->order="course_name";
        $results= Course::model()->findAll($criteria);
        
        foreach ($results as $result){
            $return_array[$result->course_id]=$result->course_name;
        }
        return $return_array;
    }
    
     public static  function getCourseName($course_id) {
        $data = Yii::app()->db->createCommand()
                ->select('course_name')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();
        return $data[0]['course_name'];
    }
}