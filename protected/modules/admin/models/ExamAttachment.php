<?php

/**
 * This is the model class for table "exam_attachment".
 *
 * The followings are the available columns in table 'exam_attachment':
 * @property integer $exam_attachment_id
 * @property integer $exam_id
 * @property string $attachment
 *
 * The followings are the available model relations:
 * @property Exam $exam
 */
class ExamAttachment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exam_attachment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_id, attachment', 'required'),
			array('exam_attachment_id, exam_id', 'numerical', 'integerOnly'=>true),
			array('attachment', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('exam_attachment_id, exam_id, attachment', 'safe', 'on'=>'search'),
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
			'exam_attachment_id' => 'Exam Attachment',
			'exam_id' => 'Exam',
			'attachment' => 'Attachment',
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

		$criteria->compare('exam_attachment_id',$this->exam_attachment_id);
		$criteria->compare('exam_id',$this->exam_id);
		$criteria->compare('attachment',$this->attachment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamAttachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getAttchId($exam_id, $file_name){
            $data = Yii::app()->db->createCommand()
                ->select('exam_attachment_id')
                ->from('exam_attachment')
                ->where('exam_id=:exam_id AND attachment=:attachment', array(':exam_id' => $exam_id, ':attachment' => $file_name))
                ->queryAll();
            return $data[0];
        }
}
