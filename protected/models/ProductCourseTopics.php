<?php

/**
 * This is the model class for table "product_course_topics".
 *
 * The followings are the available columns in table 'product_course_topics':
 * @property integer $id
 * @property integer $prod_course_id
 * @property double $price
 * @property string $contents
 *
 * The followings are the available model relations:
 * @property ProductCourses $prodCourse
 */
class ProductCourseTopics extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductCourseTopics the static model class
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
		return 'product_course_topics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_course_id, price, contents', 'required'),
			array('prod_course_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prod_course_id, price, contents', 'safe', 'on'=>'search'),
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
			'prodCourse' => array(self::BELONGS_TO, 'ProductCourses', 'prod_course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prod_course_id' => 'Prod Course',
			'price' => 'Price',
			'contents' => 'Contents',
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
		$criteria->compare('prod_course_id',$this->prod_course_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('contents',$this->contents,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}