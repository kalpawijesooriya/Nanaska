<?php

/**
 * This is the model class for table "final_result".
 *
 * The followings are the available columns in table 'final_result':
 * @property integer $final_result_id
 * @property integer $take_id
 * @property integer $question_id
 * @property integer $mark
 * @property integer $question_number
 * @property integer $time_taken
 *
 * The followings are the available model relations:
 * @property Take $take
 * @property Question $question
 */
class FinalResult extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FinalResult the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'final_result';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('take_id, question_id, mark, question_number, time_taken', 'required'),
            array('take_id, question_id, mark, question_number, time_taken', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('final_result_id, take_id, question_id, mark, question_number, time_taken', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'take' => array(self::BELONGS_TO, 'Take', 'take_id'),
            'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'final_result_id' => 'Final Result',
            'take_id' => 'Take',
            'question_id' => 'Question',
            'mark' => 'Mark',
            'question_number' => 'Question Number',
            'time_taken' => 'Time Taken',
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

        $criteria->compare('final_result_id', $this->final_result_id);
        $criteria->compare('take_id', $this->take_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('mark', $this->mark);
        $criteria->compare('question_number', $this->question_number);
        $criteria->compare('time_taken', $this->time_taken);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getScoreTake($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        $total_marks = 0;

        foreach ($question_results as $question_result) {
            $total_marks+= $question_result['mark'];
        }

        $total_marks_of_exam = PaperQuestion::model()->getTotalMarksOfExam($take_id);

        if ($total_marks != 0) {
            if ($total_marks_of_exam != 0) {
                $score = ($total_marks / $total_marks_of_exam) * 100;
            } else {
                $score = 0;
            }
        } else {
            $score = 0;
        }

        $score = round($score, 1);

        return $score;
    }

    public function getNumberOfCorrectAnswers($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        $no_of_correct_answers = 0;

        foreach ($question_results as $question_result) {
            if ($question_result['mark'] > 0) {
                $no_of_correct_answers++;
            }
        }

        return $no_of_correct_answers;
    }

    public function getNumberOfInCorrectAnswers($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        $no_of_incorrect_answers = 0;

        foreach ($question_results as $question_result) {
            if ($question_result['mark'] < 1) {
                $no_of_incorrect_answers++;
            }
        }

        return $no_of_incorrect_answers;
    }

    public function getNumberOfQuestions($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();
        return sizeof($question_results);
    }

    public function getFinalResultById($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        return $question_results;
    }

//    public function getExamTypeForSubjectID($subjectid){
//        $question_results = Yii::app()->db->createCommand()
//                ->select('*')
//                ->from('final_result')
//                ->where('take_id=:take_id', array(':take_id' => $take_id))
//                ->queryAll();
//
//        return $question_results;
//    }
}
