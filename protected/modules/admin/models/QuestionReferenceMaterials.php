<?php

/**
 * This is the model class for table "question_reference_materials".
 *
 * The followings are the available columns in table 'question_reference_materials':
 * @property integer $question_reference_material_id
 * @property integer $question_id
 * @property string $reference_material_text
 * @property string $reference_file
 * @property integer $reference_tab_position
 *
 * The followings are the available model relations:
 * @property QuestionReferenceMaterialTabs[] $questionReferenceMaterialTabs
 * @property Question $question
 */
class QuestionReferenceMaterials extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return QuestionReferenceMaterials the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_reference_materials';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_id, reference_tab_position', 'required'),
            array('question_id, reference_tab_position', 'numerical', 'integerOnly' => true),
            array('reference_file', 'length', 'max' => 100),
            array('reference_material_text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_reference_material_id, question_id, reference_material_text, reference_file, reference_tab_position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'questionReferenceMaterialTabs' => array(self::HAS_MANY, 'QuestionReferenceMaterialTabs', 'question_reference_material_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'question_reference_material_id' => 'Question Reference Material',
            'question_id' => 'Question',
            'reference_material_text' => 'Reference Material Text',
            'reference_file' => 'Reference File',
            'reference_tab_position' => 'Reference Tab Position',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('question_reference_material_id', $this->question_reference_material_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('reference_material_text', $this->reference_material_text, true);
        $criteria->compare('reference_file', $this->reference_file, true);
        $criteria->compare('reference_tab_position', $this->reference_tab_position);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getQuestionReferenceMaterials($question_id) {
        
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_reference_materials')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data;
    }
    
    
      public function getQuestionPreseenMatByTabPosition($question_id, $tab_position) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_reference_materials')
                ->where('question_id=:question_id AND reference_tab_position=:reference_tab_position', array(':question_id' => $question_id, ':reference_tab_position' => $tab_position))
                ->queryAll();
        

        if ($data == null) {
            return $data;
        } else {
            return $data[0];
        }
    }

}