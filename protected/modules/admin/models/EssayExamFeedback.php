<?php

/**
 * This is the model class for table "essay_exam_feedback".
 *
 * The followings are the available columns in table 'essay_exam_feedback':
 * @property integer $essay_exam_feedback_id
 * @property integer $essay_answer_id
 * @property string $business_type_comment
 * @property string $accounting_type_comment
 * @property string $leadership_type_comment
 * @property string $people_type_comment
 * @property integer $business_type_mark
 * @property integer $accounting_type_mark
 * @property integer $leadership_type_mark
 * @property integer $people_type_mark
 * @property string $overall_comment
 *
 * The followings are the available model relations:
 * @property EssayAnswer $essayAnswer
 */
class EssayExamFeedback extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'essay_exam_feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('essay_answer_id', 'required'),
			array('essay_answer_id, business_type_mark, accounting_type_mark, leadership_type_mark, people_type_mark', 'numerical', 'integerOnly'=>true),
			array('business_type_comment, accounting_type_comment, leadership_type_comment, people_type_comment, overall_comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('essay_exam_feedback_id, essay_answer_id, business_type_comment, accounting_type_comment, leadership_type_comment, people_type_comment, business_type_mark, accounting_type_mark, leadership_type_mark, people_type_mark, overall_comment', 'safe', 'on'=>'search'),
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
			'essayAnswer' => array(self::BELONGS_TO, 'EssayAnswer', 'essay_answer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'essay_exam_feedback_id' => 'Essay Exam Feedback',
			'essay_answer_id' => 'Essay Answer',
			'business_type_comment' => 'Business Type Comment',
			'accounting_type_comment' => 'Accounting Type Comment',
			'leadership_type_comment' => 'Leadership Type Comment',
			'people_type_comment' => 'People Type Comment',
			'business_type_mark' => 'Business Type Mark',
			'accounting_type_mark' => 'Accounting Type Mark',
			'leadership_type_mark' => 'Leadership Type Mark',
			'people_type_mark' => 'People Type Mark',
			'overall_comment' => 'Overall Comment',
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

		$criteria->compare('essay_exam_feedback_id',$this->essay_exam_feedback_id);
		$criteria->compare('essay_answer_id',$this->essay_answer_id);
		$criteria->compare('business_type_comment',$this->business_type_comment,true);
		$criteria->compare('accounting_type_comment',$this->accounting_type_comment,true);
		$criteria->compare('leadership_type_comment',$this->leadership_type_comment,true);
		$criteria->compare('people_type_comment',$this->people_type_comment,true);
		$criteria->compare('business_type_mark',$this->business_type_mark);
		$criteria->compare('accounting_type_mark',$this->accounting_type_mark);
		$criteria->compare('leadership_type_mark',$this->leadership_type_mark);
		$criteria->compare('people_type_mark',$this->people_type_mark);
		$criteria->compare('overall_comment',$this->overall_comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EssayExamFeedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getEssayExamFeedbackID($essay_answer_id){
            
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('essay_exam_feedback_id')
                ->from('essay_exam_feedback')
                ->where('essay_answer_id=:essay_answer_id', array(':essay_answer_id' => $essay_answer_id))
                ->queryRow();
            //var_dump($data); die;
            if($data['essay_exam_feedback_id'] != null){
                return $data['essay_exam_feedback_id'];
            }else{
                return null;
            }
        
        }
        public function getFeedbackDetails($take_id, $question_id){
            $essay_answer_id = EssayAnswer::model()->getEssayAnswerId($take_id, $question_id);
            $data = array();
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('essay_exam_feedback')
                ->where('essay_answer_id=:essay_answer_id', array(':essay_answer_id' => $essay_answer_id))
                ->queryRow();
            //var_dump($data); die;
            
            return $data;
            
        }
}
