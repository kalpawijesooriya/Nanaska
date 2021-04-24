<?php

/**
 * This is the model class for table "exam_lecturer".
 *
 * The followings are the available columns in table 'exam_lecturer':
 * @property integer $exam_lecturer_id
 * @property integer $lecturer_id
 * @property integer $exam_id
 *
 * The followings are the available model relations:
 * @property Lecturer $lecturer
 * @property Exam $exam
 */
class ExamLecturer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExamLecturer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam_lecturer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lecturer_id, exam_id', 'required'),
            array('lecturer_id, exam_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_lecturer_id, lecturer_id, exam_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lecturer' => array(self::BELONGS_TO, 'Lecturer', 'lecturer_id'),
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'exam_lecturer_id' => 'Exam Lecturer',
            'lecturer_id' => 'Lecturer',
            'exam_id' => 'Exam',
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

        $criteria->compare('exam_lecturer_id', $this->exam_lecturer_id);
        $criteria->compare('lecturer_id', $this->lecturer_id);
        $criteria->compare('exam_id', $this->exam_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getExamsOfLecturerById($lecturer_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_lecturer')
                ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $lecturer_id))
                ->queryAll();
        
        $examData = Array();
            
        foreach ($data as $d){
            $examDetails = Exam::model()->getExamDetails($d['exam_id']);
            
            $levelName = Level::model()->getLevelName($examDetails["level_id"]);

            $examData[] =array("exam_name" => $examDetails['exam_name'],"level_name"=>$levelName); 
                    
        }
        return $examData;
        
    }

}
