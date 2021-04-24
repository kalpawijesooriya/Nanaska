<?php

/**
 * This is the model class for table "question_preseen_material_tabs".
 *
 * The followings are the available columns in table 'question_preseen_material_tabs':
 * @property integer $question_preseen_material_tab_id
 * @property integer $question_preseen_material_id
 * @property string $tab_title
 *
 * The followings are the available model relations:
 * @property QuestionPreseenMaterials $questionPreseenMaterial
 */
class QuestionPreseenMaterialTabs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuestionPreseenMaterialTabs the static model class
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
		return 'question_preseen_material_tabs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_preseen_material_id, tab_title', 'required'),
			array('question_preseen_material_id', 'numerical', 'integerOnly'=>true),
			array('tab_title', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('question_preseen_material_tab_id, question_preseen_material_id, tab_title', 'safe', 'on'=>'search'),
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
			'questionPreseenMaterial' => array(self::BELONGS_TO, 'QuestionPreseenMaterials', 'question_preseen_material_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'question_preseen_material_tab_id' => 'Question Preseen Material Tab',
			'question_preseen_material_id' => 'Question Preseen Material',
			'tab_title' => 'Tab Title',
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

		$criteria->compare('question_preseen_material_tab_id',$this->question_preseen_material_tab_id);
		$criteria->compare('question_preseen_material_id',$this->question_preseen_material_id);
		$criteria->compare('tab_title',$this->tab_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}