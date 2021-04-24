<?php

/**
 * This is the model class for table "hotspot".
 *
 * The followings are the available columns in table 'hotspot':
 * @property integer $hotspot_id
 * @property string $image_name
 * @property string $coordinates
 * @property integer $question_id
 *
 * The followings are the available model relations:
 * @property Question $question
 */
class Hotspot extends CActiveRecord
{
    public $subject_area_id;
    public $number_of_marks;
    public $exclude_from_dynamic;
    public $question_text;
    public $id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Hotspot the static model class
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
		return 'hotspot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id', 'required'),
			array('question_id', 'numerical', 'integerOnly'=>true),
			array('image_name, coordinates', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hotspot_id, image_name, coordinates, question_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hotspot_id' => 'Hotspot',
			'image_name' => 'Image Name',
			'coordinates' => 'Coordinates',
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

		$criteria->compare('hotspot_id',$this->hotspot_id);
		$criteria->compare('image_name',$this->image_name,true);
		$criteria->compare('coordinates',$this->coordinates,true);
		$criteria->compare('question_id',$this->question_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        
  // get answers for question view
    public function getImageName($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        return Hotspot::model()->findAll($criteria);
    }
}