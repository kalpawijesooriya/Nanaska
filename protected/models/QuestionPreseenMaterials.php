<?php

/**
 * This is the model class for table "question_preseen_materials".
 *
 * The followings are the available columns in table 'question_preseen_materials':
 * @property integer $question_preseen_material_id
 * @property integer $question_id
 * @property string $preseen_text
 * @property integer $preseen_tab_position
 *
 * The followings are the available model relations:
 * @property QuestionPreseenMaterialTabs[] $questionPreseenMaterialTabs
 * @property Question $question
 */
class QuestionPreseenMaterials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuestionPreseenMaterials the static model class
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
		return 'question_preseen_materials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id, preseen_tab_position', 'required'),
			array('question_id, preseen_tab_position', 'numerical', 'integerOnly'=>true),
			array('preseen_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('question_preseen_material_id, question_id, preseen_text, preseen_tab_position', 'safe', 'on'=>'search'),
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
			'questionPreseenMaterialTabs' => array(self::HAS_MANY, 'QuestionPreseenMaterialTabs', 'question_preseen_material_id'),
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'question_preseen_material_id' => 'Question Preseen Material',
			'question_id' => 'Question',
			'preseen_text' => 'Preseen Text',
			'preseen_tab_position' => 'Preseen Tab Position',
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

		$criteria->compare('question_preseen_material_id',$this->question_preseen_material_id);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('preseen_text',$this->preseen_text,true);
		$criteria->compare('preseen_tab_position',$this->preseen_tab_position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}