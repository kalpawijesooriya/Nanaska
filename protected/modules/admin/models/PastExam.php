<?php

/**
 * This is the model class for table "past_exam".
 *
 * The followings are the available columns in table 'past_exam':
 * @property integer $past_exam_id
 * @property integer $student_id
 * @property integer $exam_id
 * @property integer $take_id
 *
 * The followings are the available model relations:
 * @property Take $take
 * @property Student $student
 * @property Exam $exam
 */
class PastExam extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PastExam the static model class
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
		return 'past_exam';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, exam_id, take_id', 'required'),
			array('student_id, exam_id, take_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('past_exam_id, student_id, exam_id, take_id', 'safe', 'on'=>'search'),
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
			'take' => array(self::BELONGS_TO, 'Take', 'take_id'),
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
			'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'past_exam_id' => 'Past Exam',
			'student_id' => 'Student',
			'exam_id' => 'Exam',
			'take_id' => 'Take',
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

		$criteria->compare('past_exam_id',$this->past_exam_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('exam_id',$this->exam_id);
		$criteria->compare('take_id',$this->take_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}