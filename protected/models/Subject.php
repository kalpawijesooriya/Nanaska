<?php

/**
 * This is the model class for table "subject".
 *
 * The followings are the available columns in table 'subject':
 * @property integer $subject_id
 * @property integer $level_id
 * @property string $subject_name
 *
 * The followings are the available model relations:
 * @property Exam[] $exams
 * @property Level $level
 */
class Subject extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Subject the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'subject';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('level_id, subject_name', 'required'),
            array('level_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject_id, level_id, subject_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'exams' => array(self::HAS_MANY, 'Exam', 'subject_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subject_id' => 'Subject',
            'level_id' => 'Level',
            'subject_name' => 'Subject Name',
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

        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('subject_name', $this->subject_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getSubjectsForLevelID($level_id) {
        $criteria = new CDbCriteria;
        $subject_array = array();
        $criteria->addCondition('level_id = ' . $level_id);
        $subject_array = Subject::model()->findAll($criteria);
        return $subject_array;
    }

    public static function loadLevelSubjects() {
        $levels = Level::model()->findAll();
        $level_subjects = array();
        if ($levels === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        foreach ($levels as $level) {
            $level_subjects[$level->level_id] = Subject::model()->getSubjectsForLevelID($level->level_id);
        }
        return $level_subjects;
    }

    public function getSubjectName($subject_id) {
        $data = Yii::app()->db->createCommand()
                ->select('subject_name')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();
        if ($data != null) {
            return $data[0]['subject_name'];
        } else {
            return null;
        }
    }

    public function getLevelOfSubject($subject_id) {
        $subjectdata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();


        return $subjectdata[0]['level_id'];
    }

}
