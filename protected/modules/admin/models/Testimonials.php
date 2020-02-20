<?php

/**
 * This is the model class for table "testimonials".
 *
 * The followings are the available columns in table 'testimonials':
 * @property integer $testimonials_id
 * @property string $testimonials_name
 * @property string $testimonials_description
 * @property string $image_url
 */
class Testimonials extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'testimonials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_url', 'required'),
            array('image_url', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'), // this will allow empty field when page is update (remember here i create scenario update)
			array('testimonials_name, testimonials_description, image_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('testimonials_id, testimonials_name, testimonials_description, image_url', 'safe', 'on'=>'search'),
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
			'testimonials_id' => 'Testimonials',
			'testimonials_name' => 'Testimonials Name',
			'testimonials_description' => 'Testimonials Description',
			'image_url' => 'Image Url',
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

		$criteria->compare('testimonials_id',$this->testimonials_id);
		$criteria->compare('testimonials_name',$this->testimonials_name,true);
		$criteria->compare('testimonials_description',$this->testimonials_description,true);
		$criteria->compare('image_url',$this->image_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Testimonials the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
