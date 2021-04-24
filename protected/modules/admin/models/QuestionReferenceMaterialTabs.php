<?php

/**
 * This is the model class for table "question_reference_material_tabs".
 *
 * The followings are the available columns in table 'question_reference_material_tabs':
 * @property integer $question_reference_material_tab_id
 * @property integer $question_reference_material_id
 * @property string $reference_tab_title
 *
 * The followings are the available model relations:
 * @property QuestionReferenceMaterials $questionReferenceMaterial
 */
class QuestionReferenceMaterialTabs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuestionReferenceMaterialTabs the static model class
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
		return 'question_reference_material_tabs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_reference_material_id, reference_tab_title', 'required'),
			array('question_reference_material_id', 'numerical', 'integerOnly'=>true),
			array('reference_tab_title', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('question_reference_material_tab_id, question_reference_material_id, reference_tab_title', 'safe', 'on'=>'search'),
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
			'questionReferenceMaterial' => array(self::BELONGS_TO, 'QuestionReferenceMaterials', 'question_reference_material_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'question_reference_material_tab_id' => 'Question Reference Material Tab',
			'question_reference_material_id' => 'Question Reference Material',
			'reference_tab_title' => 'Reference Tab Title',
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

		$criteria->compare('question_reference_material_tab_id',$this->question_reference_material_tab_id);
		$criteria->compare('question_reference_material_id',$this->question_reference_material_id);
		$criteria->compare('reference_tab_title',$this->reference_tab_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getQuestionReferenceMatByQuestionReferenceMatId($exam_reference_material_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_reference_material_tabs')
                ->where('question_reference_material_id=:question_reference_material_id', array(':question_reference_material_id' => $exam_reference_material_id))
                ->queryAll();
        return $data[0];
    }
}