<?php

/**
 * This is the model class for table "exam_preseen_material_tabs".
 *
 * The followings are the available columns in table 'exam_preseen_material_tabs':
 * @property integer $exam_preseen_material_tab_id
 * @property integer $exam_preseen_material_id
 * @property string $tab_title
 */
class ExamPreseenMaterialTabs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exam_preseen_material_tabs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('exam_preseen_material_id', 'numerical', 'integerOnly'=>true),
			array('tab_title', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('exam_preseen_material_tab_id, exam_preseen_material_id, tab_title', 'safe', 'on'=>'search'),
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
			'exam_preseen_material_tab_id' => 'Exam Preseen Material Tab',
			'exam_preseen_material_id' => 'Exam Preseen Material',
			'tab_title' => 'Tab Title',
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

		$criteria->compare('exam_preseen_material_tab_id',$this->exam_preseen_material_tab_id);
		$criteria->compare('exam_preseen_material_id',$this->exam_preseen_material_id);
		$criteria->compare('tab_title',$this->tab_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamPreseenMaterialTabs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
