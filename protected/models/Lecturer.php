<?php

/**
 * This is the model class for table "lecturer".
 *
 * The followings are the available columns in table 'lecturer':
 * @property integer $lecturer_id
 * @property integer $user_id
 * @property integer $status
 * @property string $lecturer_code
 * @property integer $extra_number
 * @property string $note
 */
class Lecturer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lecturer the static model class
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
		return 'lecturer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lecturer_code, extra_number, note', 'required'),
			array('user_id, status, extra_number', 'numerical', 'integerOnly'=>true),
			array('lecturer_code', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lecturer_id, user_id, status, lecturer_code, extra_number, note', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lecturer_id' => 'Lecturer',
			'user_id' => 'User',
			'status' => 'Status',
			'lecturer_code' => 'Lecturer Code',
			'extra_number' => 'Extra Number',
			'note' => 'Note',
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

		$criteria->compare('lecturer_id',$this->lecturer_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('lecturer_code',$this->lecturer_code,true);
		$criteria->compare('extra_number',$this->extra_number);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getLecturerDetailsByUserId($user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('lecturer')
                ->where('user_id=:user_id', array(':user_id' => $user_id))
                ->queryAll();
        return $data[0];
    }
        
}