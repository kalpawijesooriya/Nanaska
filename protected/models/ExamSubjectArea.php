<?php

/**
 * This is the model class for table "exam_subject_area".
 *
 * The followings are the available columns in table 'exam_subject_area':
 * @property integer $exam_subject_area_id
 * @property integer $exam_id
 * @property integer $subject_area_id
 * @property double $weightage
 * @property double $single_answer_weightage
 * @property double $multiple_answer_weightage
 * @property double $short_written_answer_weightage
 * @property double $drag_drop_typea_answer_weightage
 * @property double $drag_drop_typeb_answer_weightage
 * @property double $drag_drop_typec_answer_weightage
 * @property double $drag_drop_typed_answer_weightage
 * @property double $drag_drop_typee_answer_weightage
 * @property double $multiple_choice_answer_weightage
 * @property double $true_or_false_answer_weightage
 * @property double $hotspot_answer_weightage
 */
class ExamSubjectArea extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExamSubjectArea the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_subject_area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exam_id, subject_area_id, weightage, single_answer_weightage, multiple_answer_weightage, short_written_answer_weightage, drag_drop_typea_answer_weightage, drag_drop_typeb_answer_weightage, drag_drop_typec_answer_weightage, drag_drop_typed_answer_weightage, drag_drop_typee_answer_weightage, multiple_choice_answer_weightage, true_or_false_answer_weightage, hotspot_answer_weightage', 'required'),
            array('exam_id, subject_area_id', 'numerical', 'integerOnly' => true),
            array('weightage, single_answer_weightage, multiple_answer_weightage, short_written_answer_weightage, drag_drop_typea_answer_weightage, drag_drop_typeb_answer_weightage, drag_drop_typec_answer_weightage, drag_drop_typed_answer_weightage, drag_drop_typee_answer_weightage, multiple_choice_answer_weightage, true_or_false_answer_weightage, hotspot_answer_weightage', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_subject_area_id, exam_id, subject_area_id, weightage, single_answer_weightage, multiple_answer_weightage, short_written_answer_weightage, drag_drop_typea_answer_weightage, drag_drop_typeb_answer_weightage, drag_drop_typec_answer_weightage, drag_drop_typed_answer_weightage, drag_drop_typee_answer_weightage, multiple_choice_answer_weightage, true_or_false_answer_weightage, hotspot_answer_weightage', 'safe', 'on' => 'search'),
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
            'exam_subject_area_id' => 'Exam Subject Area',
            'exam_id' => 'Exam',
            'subject_area_id' => 'Subject Area',
            'weightage' => 'Weightage',
            'single_answer_weightage' => 'Single Answer Weightage',
            'multiple_answer_weightage' => 'Multiple Answer Weightage',
            'short_written_answer_weightage' => 'Short Written Answer Weightage',
            'drag_drop_typea_answer_weightage' => 'Drag Drop Typea Answer Weightage',
            'drag_drop_typeb_answer_weightage' => 'Drag Drop Typeb Answer Weightage',
            'drag_drop_typec_answer_weightage' => 'Drag Drop Typec Answer Weightage',
            'drag_drop_typed_answer_weightage' => 'Drag Drop Typed Answer Weightage',
            'drag_drop_typee_answer_weightage' => 'Drag Drop Typee Answer Weightage',
            'multiple_choice_answer_weightage' => 'Multiple Choice Answer Weightage',
            'true_or_false_answer_weightage' => 'True Or False Answer Weightage',
            'hotspot_answer_weightage' => 'Hotspot Answer Weightage',
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

        $criteria->compare('exam_subject_area_id', $this->exam_subject_area_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('subject_area_id', $this->subject_area_id);
        $criteria->compare('weightage', $this->weightage);
        $criteria->compare('single_answer_weightage', $this->single_answer_weightage);
        $criteria->compare('multiple_answer_weightage', $this->multiple_answer_weightage);
        $criteria->compare('short_written_answer_weightage', $this->short_written_answer_weightage);
        $criteria->compare('drag_drop_typea_answer_weightage', $this->drag_drop_typea_answer_weightage);
        $criteria->compare('drag_drop_typeb_answer_weightage', $this->drag_drop_typeb_answer_weightage);
        $criteria->compare('drag_drop_typec_answer_weightage', $this->drag_drop_typec_answer_weightage);
        $criteria->compare('drag_drop_typed_answer_weightage', $this->drag_drop_typed_answer_weightage);
        $criteria->compare('drag_drop_typee_answer_weightage', $this->drag_drop_typee_answer_weightage);
        $criteria->compare('multiple_choice_answer_weightage', $this->multiple_choice_answer_weightage);
        $criteria->compare('true_or_false_answer_weightage', $this->true_or_false_answer_weightage);
        $criteria->compare('hotspot_answer_weightage', $this->hotspot_answer_weightage);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getSubjectAreaWeightagesOfExamById($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_subject_area')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data;
    }

}
