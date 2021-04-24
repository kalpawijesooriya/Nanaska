<?php

/**
 * This is the model class for table "essay_answer".
 *
 * The followings are the available columns in table 'essay_answer':
 * @property integer $essay_answer_id
 * @property integer $exam_id
 * @property integer $student_id
 * @property integer $section_no
 * @property integer $status
 * @property integer $take_id
 * @property string $feedback
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property Exam $exam
 * @property Student $student
 * @property Take $take
 * @property Question $question
 * @property EssayExamFeedback[] $essayExamFeedbacks
 */
class EssayAnswer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'essay_answer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_id, student_id, section_no, status, take_id, question_id', 'required'),
			array('exam_id, student_id, section_no, status, take_id, question_id', 'numerical', 'integerOnly'=>true),
			array('feedback', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('essay_answer_id, exam_id, student_id, section_no, status, take_id, feedback, question_id', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
			'take' => array(self::BELONGS_TO, 'Take', 'take_id'),
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
			'essayExamFeedbacks' => array(self::HAS_MANY, 'EssayExamFeedback', 'essay_answer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'essay_answer_id' => 'Essay Answer',
			'exam_id' => 'Exam',
			'student_id' => 'Student',
			'section_no' => 'Section No',
			'status' => 'Status',
			'take_id' => 'Take',
			'feedback' => 'Feedback',
			'question_id' => 'Question',
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

		$criteria->compare('essay_answer_id',$this->essay_answer_id);
		$criteria->compare('exam_id',$this->exam_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('section_no',$this->section_no);
		$criteria->compare('status',$this->status);
		$criteria->compare('take_id',$this->take_id);
		$criteria->compare('feedback',$this->feedback,true);
		$criteria->compare('question_id',$this->question_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EssayAnswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getTotalMarksOfTakeID($take_id){
            
            
            
        }
        public function getSectionsOfExamByTakeId($take_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('section_no')
                ->from('essay_answer')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
            //var_dump($data); die;
            return $data;
        }
        public function getQuestionsOfExamByTakeIdSectionNo($take_id, $sec_no){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('question_id')
                ->from('essay_answer')
                ->where('take_id=:take_id AND section_no=:section_no', array(':take_id' => $take_id, ':section_no' => $sec_no))
                ->queryAll();
            //var_dump($data); die;
            return $data;
        }
        public function getStatus($take_id, $question_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('status')
                ->from('essay_answer')
                ->where('take_id=:take_id AND question_id=:question_id', array(':take_id' => $take_id, ':question_id' => $question_id))
                ->queryAll();
            //var_dump($data); die;
            if($data[0]['status'] == 1){
                return "Marked";
            }else{
                return "Un-marked";
            }
            
        }
        public function getEssayAnswerId($take_id, $question_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('essay_answer_id')
                ->from('essay_answer')
                ->where('take_id=:take_id AND question_id=:question_id', array(':take_id' => $take_id, ':question_id' => $question_id))
                ->queryRow();
            //var_dump($data); die;
            if($data['essay_answer_id'] != null){
                return $data['essay_answer_id'];
            }else{
                return null;
            }
        }
        public function getMarkForTheQuestion($take_id, $question_id){
            $essay_answer_id = EssayAnswer::model()->getEssayAnswerId($take_id, $question_id);
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('essay_exam_feedback')
                ->where('essay_answer_id=:essay_answer_id', array(':essay_answer_id' => $essay_answer_id))
                ->queryRow();
            
            if(count($data) > 0){
                $question = Yii::app()->db->createCommand()
                    ->select('number_of_marks')
                    ->from('question')
                    ->where('question_id=:question_id', array(':question_id' => $question_id))
                    ->queryRow();
                $marks_allocated = (int)$question['number_of_marks'];
                $marks = (int)$data['business_type_mark']+(int)$data['accounting_type_mark']+(int)$data['leadership_type_mark']+(int)$data['people_type_mark'];
                return (double)($marks / $marks_allocated)*100;
            }else{
                return 0;
            }
        }
        public function getEssayAnswerIds($take_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('essay_answer_id')
                ->from('essay_answer')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
            return $data;
        }
        public function getStatusByEssayID($essay_answer_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('status')
                ->from('essay_answer')
                ->where('essay_answer_id=:essay_answer_id', array(':essay_answer_id' => $essay_answer_id))
                ->queryAll();
            //var_dump($data); die;
            
            return $data[0]['status'];
           
            
        }
        public function getQuestionsOfExamByTakeId($take_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('question_id')
                ->from('essay_answer')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
            //var_dump($data); die;
            return $data;
        }
        public function getDetailsOfQuestion($take_id, $question_id){
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('essay_answer')
                ->where('take_id=:take_id AND question_id=:question_id', array(':take_id' => $take_id, 'question_id' => $question_id))
                ->queryRow();
            //var_dump($data); die;
            return $data;
        }
        public function getFeedbackMarkForTheQuestion($take_id, $question_id){
            $essay_answer_id = EssayAnswer::model()->getEssayAnswerId($take_id, $question_id);
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('essay_exam_feedback')
                ->where('essay_answer_id=:essay_answer_id', array(':essay_answer_id' => $essay_answer_id))
                ->queryRow();
            
            if(count($data) > 0){
                
                $marks = (int)$data['business_type_mark']+(int)$data['accounting_type_mark']+(int)$data['leadership_type_mark']+(int)$data['people_type_mark'];
                return $marks;
            }else{
                return 0;
            }
        }
        public function getAllocatedMarkForTheQuestion($question_id){
            
            $question = Yii::app()->db->createCommand()
                ->select('number_of_marks')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryRow();
            $marks_allocated = (int)$question['number_of_marks'];
            return $marks_allocated;
            
        }
}
