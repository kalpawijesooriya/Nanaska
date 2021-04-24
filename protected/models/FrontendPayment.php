<?php

/**
 * This is the model class for table "frontend_payment".
 *
 * The followings are the available columns in table 'frontend_payment':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $cima_id
 * @property string $email
 * @property string $contact_no
 * @property string $course
 * @property double $amount
 * @property string $ref_no
 * @property string $status
 */
class FrontendPayment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FrontendPayment the static model class
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
		return 'frontend_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, address, cima_id, email, contact_no, course, amount, ref_no', 'required'),
			array('amount', 'numerical'),
			array('first_name, last_name, address, cima_id, email, course', 'length', 'max'=>255),
			array('contact_no, ref_no, status', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, address, cima_id, email, contact_no, course, amount, ref_no, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address' => 'Address',
			'cima_id' => 'Cima',
			'email' => 'Email',
			'contact_no' => 'Contact No',
			'course' => 'Course',
			'amount' => 'Amount',
			'ref_no' => 'Ref No',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('cima_id',$this->cima_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_no',$this->contact_no,true);
		$criteria->compare('course',$this->course,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('ref_no',$this->ref_no,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}