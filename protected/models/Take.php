<?php

/**
 * This is the model class for table "take".
 *
 * The followings are the available columns in table 'take':
 * @property integer $take_id
 * @property integer $student_id
 * @property integer $exam_id
 * @property string $date
 * @property integer $total_time
 *
 * The followings are the available model relations:
 * @property PaperQuestion[] $paperQuestions
 * @property Student $student
 * @property Exam $exam
 */
class Take extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Take the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'take';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id, exam_id, date', 'required'),
            array('student_id, exam_id, total_time', 'numerical', 'integerOnly' => true),
            array('date', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('take_id, student_id, exam_id, date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paperQuestions' => array(self::HAS_MANY, 'PaperQuestion', 'take_id'),
            'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
            'exam' => array(self::BELONGS_TO, 'Exam', 'exam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'take_id' => 'Take',
            'student_id' => 'Student',
            'exam_id' => 'Exam',
            'date' => 'Date',
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

        $criteria->compare('take_id', $this->take_id);
        $criteria->compare('student_id', $this->student_id);
        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getExamIdOfTake($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        return $question_results[0]['exam_id'];
    }

    public function getTake($take_id) {
        $take = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        return $take[0];
    }
    public function getExamID($take_id) {
        $data = Yii::app()->db->createCommand()
                ->select('exam_id')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryRow();

        return $data['exam_id'];
    }
    public function getResultOfTheTake($take_id){
        $data = Yii::app()->db->createCommand()
                ->select('question_id')
                ->from('essay_answer')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
        if(count($data) > 0){
            $count = count($data);
            $marks = 0;
            foreach($data as $question){
                $marks = $marks + EssayAnswer::model()->getMarkForTheQuestion($take_id, $question['question_id']);
            }
            return (double)$marks/$count;
        }else{
            return 0;
        }
    }
    public function getTimeTakenOfTake($take_id) {
        $final_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        $total_time_taken = 0;

        foreach ($final_results as $final_result) {
            $total_time_taken+=$final_result['time_taken'];
        }

        return $total_time_taken;
    }
    public function getResultOfTheTakeByStatus($take_id, $status){
        $data = Yii::app()->db->createCommand()
                ->select('question_id')
                ->from('essay_answer')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
        if($status == 1){
            if(count($data) > 0){
                $count = count($data);
                $marks = 0;
                $allocated_marks = 0;
                foreach($data as $question){
                    $marks = $marks + EssayAnswer::model()->getFeedbackMarkForTheQuestion($take_id, $question['question_id']);
                    $allocated_marks = $allocated_marks + EssayAnswer::model()->getAllocatedMarkForTheQuestion($question['question_id']);
                }
                $final_marks = (double)($marks/$allocated_marks)*100;
                return round($final_marks, 2).'%';
            }else{
                return '0%';
            }
        }else{
            return "Pending";
        }
    }
}
