<?php

/**
 * This is the model class for table "paper_question".
 *
 * The followings are the available columns in table 'paper_question':
 * @property integer $paper_question_id
 * @property integer $take_id
 * @property integer $question_id
 * @property integer $question_part_id
 * @property string $answer_id
 * @property integer $time_taken
 * @property integer $question_marked
 * @property integer $question_number
 *
 * The followings are the available model relations:
 * @property Question $question
 * @property QuestionPart $questionPart
 * @property Take $take
 */
class PaperQuestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaperQuestion the static model class
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
		return 'paper_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('take_id, question_id, time_taken, question_number', 'required'),
			array('take_id, question_id, question_part_id, time_taken, question_marked, question_number', 'numerical', 'integerOnly'=>true),
			//array('answer_id', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('paper_question_id, take_id, question_id, question_part_id, answer_id, time_taken, question_marked, question_number', 'safe', 'on'=>'search'),
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
			'questionPart' => array(self::BELONGS_TO, 'QuestionPart', 'question_part_id'),
			'take' => array(self::BELONGS_TO, 'Take', 'take_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paper_question_id' => 'Paper Question',
			'take_id' => 'Take',
			'question_id' => 'Question',
			'question_part_id' => 'Question Part',
			'answer_id' => 'Answer',
			'time_taken' => 'Time Taken',
			'question_marked' => 'Question Marked',
			'question_number' => 'Question Number',
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

		$criteria->compare('paper_question_id',$this->paper_question_id);
		$criteria->compare('take_id',$this->take_id);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('question_part_id',$this->question_part_id);
		$criteria->compare('answer_id',$this->answer_id,true);
		$criteria->compare('time_taken',$this->time_taken);
		$criteria->compare('question_marked',$this->question_marked);
		$criteria->compare('question_number',$this->question_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getTotalTimeTaken($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('total_time')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryRow();

//        $total_time_taken = 0;
//
//        foreach ($question_results as $question_result) {
//            $total_time_taken+=$question_result['time_taken'];
//        }

        return $question_results['total_time'];
    }

    public function getTotalMarksOfExam($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->selectDistinct('question_id')
                ->from('paper_question')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();


        $exam_id = Take::model()->getExamIdOfTake($take_id);

        $total_num_of_marks = 0;

        $exam_details = Exam::model()->getExamDetails($exam_id);

        if ($exam_details['allow_custom_marks'] == 0) {
            $total_num_of_marks = sizeof($question_results) * $exam_details['marks_per_question'];
        } else if ($exam_details['allow_custom_marks'] == 1) {
            foreach ($question_results as $question_result) {
                $question = Question::model()->getQuestion($question_result['question_id']);

                $total_num_of_marks+=$question['number_of_marks'];
            }
        }

        return $total_num_of_marks;
    }
    public function getAnswerForTheQuestion($take_id, $question_id){
        $data = Yii::app()->db->createCommand()
                ->select('answer_id')
                ->from('paper_question')
                ->where('take_id=:take_id AND question_id=:question_id', array(':take_id' => $take_id, ':question_id' => $question_id))
                ->queryRow();
        //var_dump($data);die;
        return $data['answer_id'];
    }
}