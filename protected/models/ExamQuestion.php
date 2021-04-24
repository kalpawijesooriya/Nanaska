<?php

/**
 * This is the model class for table "exam_question".
 *
 * The followings are the available columns in table 'exam_question':
 * @property integer $exam_question_id
 * @property integer $exam_id
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property Question $question
 * @property Exam $exam
 */
class ExamQuestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ExamQuestion the static model class
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
		return 'exam_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_id, question_id', 'required'),
			array('exam_id, question_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('exam_question_id, exam_id, question_id', 'safe', 'on'=>'search'),
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
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
			'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'exam_question_id' => 'Exam Question',
			'exam_id' => 'Exam',
			'question_id' => 'Question',
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

		$criteria->compare('exam_question_id',$this->exam_question_id);
		$criteria->compare('exam_id',$this->exam_id);
		$criteria->compare('question_id',$this->question_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getSectionNo($exam_id, $question_id){
        $data = Yii::app()->db->createCommand()
                ->select('section_number')
                ->from('exam_question')
                ->where('exam_id=:exam_id AND question_id=:question_id', array(':exam_id' => $exam_id, 'question_id'=>$question_id))
                ->queryRow();
        return $data['section_number'];
    }
}