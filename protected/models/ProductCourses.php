<?php

/**
 * This is the model class for table "product_courses".
 *
 * The followings are the available columns in table 'product_courses':
 * @property integer $id
 * @property integer $prod_cat_id
 * @property string $product_course_name
 *
 * The followings are the available model relations:
 * @property ProductCourseTopics[] $productCourseTopics
 * @property ProductCategories $prodCat
 */
class ProductCourses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductCourses the static model class
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
		return 'product_courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prod_cat_id', 'required'),
			array('prod_cat_id', 'numerical', 'integerOnly'=>true),
			array('product_course_name', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prod_cat_id, product_course_name', 'safe', 'on'=>'search'),
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
			'productCourseTopics' => array(self::HAS_MANY, 'ProductCourseTopics', 'prod_course_id'),
			'prodCat' => array(self::BELONGS_TO, 'ProductCategories', 'prod_cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prod_cat_id' => 'Prod Cat',
			'product_course_name' => 'Product Course Name',
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
		$criteria->compare('prod_cat_id',$this->prod_cat_id);
		$criteria->compare('product_course_name',$this->product_course_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}