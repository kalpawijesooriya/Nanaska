<?php

/**
 * This is the model class for table "sitting".
 *
 * The followings are the available columns in table 'sitting':
 * @property integer $sitting_id
 * @property string $sitting_name
 *
 * The followings are the available model relations:
 * @property Student[] $students
 */
class Sitting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sitting the static model class
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
		return 'sitting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sitting_name', 'required'),
			array('sitting_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sitting_id, sitting_name', 'safe', 'on'=>'search'),
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
			'students' => array(self::HAS_MANY, 'Student', 'sitting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sitting_id' => 'Sitting',
			'sitting_name' => 'Sitting Name',
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

		$criteria->compare('sitting_id',$this->sitting_id);
		$criteria->compare('sitting_name',$this->sitting_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        //retreive sittings on registration
        public static function getSittings(){
        $return_array=array();
        
        $criteria=new CDbCriteria;
        $criteria->order="sitting_name";
        $results= Sitting::model()->findAll($criteria);
        
        foreach ($results as $result){
            $return_array[$result->sitting_id]=$result->sitting_name;
        }
        return $return_array;
    }
}