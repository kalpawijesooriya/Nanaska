<?php

/**
 * This is the model class for table "email_essay_header".
 *
 * The followings are the available columns in table 'email_essay_header':
 * @property integer $email_essay_header_id
 * @property integer $essay_question_id
 * @property string $from_field
 * @property string $to_field
 * @property string $cc_field
 * @property string $subject_field
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property EssayQuestion $essayQuestion
 * @property Question $question
 */
class EmailEssayHeader extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailEssayHeader the static model class
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
		return 'email_essay_header';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('essay_question_id, from_field, to_field, subject_field, question_id', 'required'),
			array('essay_question_id, question_id', 'numerical', 'integerOnly'=>true),
			array('from_field, to_field', 'length', 'max'=>50),
			array('cc_field', 'length', 'max'=>200),
			array('subject_field', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email_essay_header_id, essay_question_id, from_field, to_field, cc_field, subject_field, question_id', 'safe', 'on'=>'search'),
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
			'essayQuestion' => array(self::BELONGS_TO, 'EssayQuestion', 'essay_question_id'),
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email_essay_header_id' => 'Email Essay Header',
			'essay_question_id' => 'Essay Question',
			'from_field' => 'From Field',
			'to_field' => 'To Field',
			'cc_field' => 'Cc Field',
			'subject_field' => 'Subject Field',
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

		$criteria->compare('email_essay_header_id',$this->email_essay_header_id);
		$criteria->compare('essay_question_id',$this->essay_question_id);
		$criteria->compare('from_field',$this->from_field,true);
		$criteria->compare('to_field',$this->to_field,true);
		$criteria->compare('cc_field',$this->cc_field,true);
		$criteria->compare('subject_field',$this->subject_field,true);
		$criteria->compare('question_id',$this->question_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getEmailEssayHeaderDetailsByQuestionId($question_id) {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('email_essay_header')
                    ->where('question_id=:question_id', array(':question_id' => $question_id))
                    ->queryAll();

            if (isset($data[0])) {
                return $data[0];
            } else {
                return null;
            }
        }
}