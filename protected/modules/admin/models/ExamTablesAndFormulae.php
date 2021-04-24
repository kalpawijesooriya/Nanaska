<?php

/**
 * This is the model class for table "exam_tables_and_formulae".
 *
 * The followings are the available columns in table 'exam_tables_and_formulae':
 * @property integer $exam_tables_and_formulae_id
 * @property integer $exam_id
 * @property string $tables_and_formulae_text
 * @property integer $tab_position
 *
 * The followings are the available model relations:
 * @property Exam $exam
 * @property ExamTablesAndFormulaeTabTitle[] $examTablesAndFormulaeTabTitles
 */
class ExamTablesAndFormulae extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExamTablesAndFormulae the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_tables_and_formulae';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exam_id, tab_position', 'required'),
            array('exam_id, tab_position', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_tables_and_formulae_id, exam_id,  tab_position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
            'examTablesAndFormulaeTabTitles' => array(self::HAS_MANY, 'ExamTablesAndFormulaeTabTitle', 'exam_tables_and_formulae_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'exam_tables_and_formulae_id' => 'Exam Tables And Formulae',
            'exam_id' => 'Exam',
            'tables_and_formulae_text' => 'Tables And Formulae Text',
            'tab_position' => 'Tab Position',
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

        $criteria->compare('exam_tables_and_formulae_id', $this->exam_tables_and_formulae_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('tables_and_formulae_text', $this->tables_and_formulae_text, true);
        $criteria->compare('tab_position', $this->tab_position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getExamTablesAndFormulaeByExamId($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_tables_and_formulae')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data;
    }

    public function getExamTablesAndFormulaeByTabPosition($exam_id, $tab_position) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_tables_and_formulae')
                ->where('exam_id=:exam_id AND tab_position=:tab_position', array(':exam_id' => $exam_id, ':tab_position' => $tab_position))
                ->queryAll();

        if ($data == null) {
            return $data;
        } else {
            return $data[0];
        }
    }

}
