<?php

/**
 * This is the model class for table "exam_tables_and_formulae_tab_title".
 *
 * The followings are the available columns in table 'exam_tables_and_formulae_tab_title':
 * @property integer $exam_tables_and_formulae_tab_title_id
 * @property integer $exam_tables_and_formulae_id
 * @property string $tab_title
 *
 * The followings are the available model relations:
 * @property ExamTablesAndFormulae $examTablesAndFormulae
 */
class ExamTablesAndFormulaeTabTitle extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExamTablesAndFormulaeTabTitle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_tables_and_formulae_tab_title';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('exam_tables_and_formulae_id, tab_title', 'required'),
            array('exam_tables_and_formulae_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_tables_and_formulae_tab_title_id, exam_tables_and_formulae_id, tab_title', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'examTablesAndFormulae' => array(self::BELONGS_TO, 'ExamTablesAndFormulae', 'exam_tables_and_formulae_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'exam_tables_and_formulae_tab_title_id' => 'Exam Tables And Formulae Tab Title',
            'exam_tables_and_formulae_id' => 'Exam Tables And Formulae',
            'tab_title' => 'Tab Title',
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

        $criteria->compare('exam_tables_and_formulae_tab_title_id', $this->exam_tables_and_formulae_tab_title_id);
        $criteria->compare('exam_tables_and_formulae_id', $this->exam_tables_and_formulae_id);
        $criteria->compare('tab_title', $this->tab_title, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getExamTablesAndFormulaeTabTitleByExamTablesAndFormulaeId($exam_tables_and_formulae_id) {
        
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_tables_and_formulae_tab_title')
                ->where('exam_tables_and_formulae_id=:exam_tables_and_formulae_id', array(':exam_tables_and_formulae_id' => $exam_tables_and_formulae_id))
                ->queryAll();
        if (isset($data[0])) {
            return $data[0];
        } 
//        else {
//            return "No Content";
//        }
    }

}
