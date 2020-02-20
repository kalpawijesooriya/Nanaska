<?php

/**
 * This is the model class for table "essay_question".
 *
 * The followings are the available columns in table 'essay_question':
 * @property integer $essay_question_id
 * @property integer $question_id
 * @property string $essay_type
 * @property integer $preseen_material
 * @property integer $reference_material
 *
 * The followings are the available model relations:
 * @property EmailEssayHeader[] $emailEssayHeaders
 * @property Question $question
 */
class EssayQuestion extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EssayQuestion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'essay_question';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_id, essay_type, preseen_material, reference_material', 'required'),
            array('question_id, preseen_material, reference_material', 'numerical', 'integerOnly' => true),
            array('essay_type', 'length', 'max' => 6),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('essay_question_id, question_id, essay_type, preseen_material, reference_material', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'emailEssayHeaders' => array(self::HAS_MANY, 'EmailEssayHeader', 'essay_question_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'essay_question_id' => 'Essay Question',
            'question_id' => 'Question',
            'essay_type' => 'Essay Type',
            'preseen_material' => 'Preseen Material',
            'reference_material' => 'Reference Material',
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

        $criteria->compare('essay_question_id', $this->essay_question_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('essay_type', $this->essay_type, true);
        $criteria->compare('preseen_material', $this->preseen_material);
        $criteria->compare('reference_material', $this->reference_material);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getEmailEssayDetailsByQuestionId($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('essay_type')
                ->from('essay_question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryScalar();

        return $data;
    }
    public function getDetailsByQuestionId($question_id){
        $data = Yii::app()->db->createCommand()
                ->select('reference_material')
                ->from('essay_question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryScalar();
        if(count($data) > 0){
            return $data;
        }else{
            return null;
        }
        
    }
}