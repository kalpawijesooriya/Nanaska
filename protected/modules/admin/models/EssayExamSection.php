<?php

/**
 * This is the model class for table "essay_exam_section".
 *
 * The followings are the available columns in table 'essay_exam_section':
 * @property integer $essay_exam_section_id
 * @property integer $exam_id
 * @property integer $section_number
 * @property integer $section_time
 * @property integer $number_of_questions
 *
 * The followings are the available model relations:
 * @property Exam $exam
 */
class EssayExamSection extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'essay_exam_section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_id, section_number, section_time, number_of_questions', 'required'),
			array('exam_id, section_number, section_time, number_of_questions', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('essay_exam_section_id, exam_id, section_number, section_time, number_of_questions', 'safe', 'on'=>'search'),
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
			'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'essay_exam_section_id' => 'Essay Exam Section',
			'exam_id' => 'Exam',
			'section_number' => 'Section Number',
			'section_time' => 'Section Time',
			'number_of_questions' => 'Number Of Questions',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('essay_exam_section_id',$this->essay_exam_section_id);
		$criteria->compare('exam_id',$this->exam_id);
		$criteria->compare('section_number',$this->section_number);
		$criteria->compare('section_time',$this->section_time);
		$criteria->compare('number_of_questions',$this->number_of_questions);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EssayExamSection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
