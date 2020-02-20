<?php

/**
 * This is the model class for table "question_part_text".
 *
 * The followings are the available columns in table 'question_part_text':
 * @property integer $question_part_text_id
 * @property integer $question_part_id
 * @property string $question_part_text
 */
class QuestionPartText extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return QuestionPartText the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_part_text';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_part_id, question_part_text', 'required'),
            array('question_part_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_part_text_id, question_part_id, question_part_text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'question_part_text_id' => 'Question Part Text',
            'question_part_id' => 'Question Part',
            'question_part_text' => 'Question Part Text',
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

        $criteria->compare('question_part_text_id', $this->question_part_text_id);
        $criteria->compare('question_part_id', $this->question_part_id);
        $criteria->compare('question_part_text', $this->question_part_text, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getQuestionPartTextsOfQuestion($question_part_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_part_text')
                ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                ->queryAll();

        if (empty($data)) {
            return NULL;
        } else {
            return $data[0];
        }
    }

    public function getOperatorsOfQuestion($question_part_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_part_text')
                ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                ->queryAll();

        if (empty($data)) {
            return NULL;
        } else {
            return $data;
        }
    }

    public function getQuestionPartTextByQuestionPartID($question_part_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_part_id=' . $question_part_id);
        $criteria->order = "question_part_text_id ASC";
        return $this->model()->findAll($criteria);
    }

}
