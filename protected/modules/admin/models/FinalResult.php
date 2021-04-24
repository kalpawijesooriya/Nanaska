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
            $score = ($total_marks / $total_marks_of_exam) * 100;
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

    public function getHighestMarkOfSubject($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
        //11111111111
        $count = 0;
        $highest_mark = 0;

        foreach ($take_ids as $take_id) {
            $score = FinalResult::model()->getScoreTake($take_id);
            if ($count == 0) {
                $highest_mark = $score;
            } else if ($score > $highest_mark) {
                $highest_mark = $score;
            }
            $count++;
        }

        return $highest_mark;
    }

    public function getLowestMarkOfSubject($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
//222222222222
        $count = 0;
        $lowest_mark = 0;

        foreach ($take_ids as $take_id) {
            $score = FinalResult::model()->getScoreTake($take_id);
            if ($count == 0) {
                $lowest_mark = $score;
            } else if ($score < $lowest_mark) {
                $lowest_mark = $score;
            }
            $count++;
        }

        return $lowest_mark;
    }

    public function getAverageOfSubject($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
//3333333
        $total_score = 0;
        $lowest_mark = 0;

        foreach ($take_ids as $take_id) {
            $score = FinalResult::model()->getScoreTake($take_id);
            $total_score+=$score;
        }

        if (sizeof($take_ids) != 0) {
            $average = $total_score / (sizeof($take_ids));
            $average = round($average, 1);
        } else {
            $average = 0;
        }


        return $average;
    }

    public function getLongestTimeTaken($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
//444444
        $max_time_taken = 0;
        $count = 0;

        foreach ($take_ids as $take_id) {
            $time_taken = Take::model()->getTimeTakenOfTake($take_id);
            if ($count == 0) {
                $max_time_taken = $time_taken;
            } else if ($time_taken > $max_time_taken) {
                $max_time_taken = $time_taken;
            }
            $count++;
        }
        return $max_time_taken;
    }

    public function getShortestTimeTaken($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
//555555
        $min_time_taken = 0;
        $count = 0;

        foreach ($take_ids as $take_id) {
            $time_taken = Take::model()->getTimeTakenOfTake($take_id);
            if ($count == 0) {
                $min_time_taken = $time_taken;
            } else if ($time_taken < $min_time_taken) {
                $min_time_taken = $time_taken;
            }
            $count++;
        }
        return $min_time_taken;
    }

    public function getAverageTimeTaken($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
//6666666
        $total_time_taken = 0;

        foreach ($take_ids as $take_id) {
            $time_taken = Take::model()->getTimeTakenOfTake($take_id);
            $total_time_taken+=$time_taken;
        }

        if (sizeof($take_ids) != 0) {
            $average_time_taken = $total_time_taken / (sizeof($take_ids));
            $average_time_taken = round($average_time_taken, 2);
        } else {
            $average_time_taken = 0;
        }
        return $average_time_taken;
    }

    public function getNumberOfPasses($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);
        //777777
        $number_of_passes = 0;

        foreach ($take_ids as $take_id) {
            $score = FinalResult::model()->getScoreTake($take_id);

            $exam_id = Take::model()->getExamIdOfTake($take_id);

            $exam = Exam::model()->getExamDetails($exam_id);

            if ($score >= $exam['pass_mark']) {
                $number_of_passes++;
            }
        }

        return $number_of_passes;
    }

    public function getNumberOfFails($subject_id) {
        $take_ids = Take::model()->getTakeIdsOfSubject($subject_id);

        $number_of_fails = 0;
        //8888888
        foreach ($take_ids as $take_id) {
            $score = FinalResult::model()->getScoreTake($take_id);

            $exam_id = Take::model()->getExamIdOfTake($take_id);

            $exam = Exam::model()->getExamDetails($exam_id);

            if ($score < $exam['pass_mark']) {
                $number_of_fails++;
            }
        }

        return $number_of_fails;
    }

    public function getHighestMarksOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,mark')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $max_mark = 0;

        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                if ($count == 0) {
                    $max_mark = $question_result['mark'];
                } else if ($question_result['mark'] > $max_mark) {
                    $max_mark = $question_result['mark'];
                }
            }
            $count++;
        }

        return $max_mark;
    }

    public function getLowestMarksOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,mark')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $min_mark = 0;


        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                if ($count == 0) {
                    $min_mark = $question_result['mark'];
                } else if ($question_result['mark'] < $min_mark) {
                    $min_mark = $question_result['mark'];
                }
            }
            $count++;
        }

        return $min_mark;
    }

    public function getAverageMarksOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,mark')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $total_marks = 0;
        $average = 0;

        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                $total_marks += $question_result['mark'];
            }
            $count++;
        }

        $average = $total_marks / $count;

        $average = round($average, 2);

        return $average;
    }

    public function getLongestTimeOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,time_taken')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $max_time = 0;

        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                if ($count == 0) {
                    $max_time = $question_result['time_taken'];
                } else if ($question_result['time_taken'] > $max_time) {
                    $max_time = $question_result['time_taken'];
                }
            }
            $count++;
        }

        return $max_time;
    }

    public function getShortestTimeOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,time_taken')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $min_time = 0;


        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                if ($count == 0) {
                    $min_time = $question_result['time_taken'];
                } else if ($question_result['time_taken'] < $min_time) {
                    $min_time = $question_result['time_taken'];
                }
            }
            $count++;
        }

        return $min_time;
    }

    public function getAverageTimeTakenOfSubjectArea($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,time_taken')
                ->from('final_result')
                ->queryAll();

        $count = 0;
        $total_time = 0;
        $average = 0;

        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                $total_time += $question_result['time_taken'];
            }
            $count++;
        }

        $average = $total_time / $count;

        $average = round($average, 2);

        return $average;
    }

    public function getAllDoneInOne($subject_area_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('question_id,mark,time_taken')
                ->from('final_result')
                ->queryAll();

        $details = array();
        $max_mark = 0;
        $min_mark = 0;
        $total_marks = 0;
        $average = 0;
        $count = 0;
        $max_time = 0;
        $min_time = 0;
        $total_time = 0;
        $timeAverage = 0;

        foreach ($question_results as $question_result) {
            $question_subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question_result['question_id']);

            if ($question_subject_area_id == $subject_area_id) {
                $total_marks += $question_result['mark'];
                $total_time += $question_result['time_taken'];
                if ($count == 0) {
                    $max_mark = $question_result['mark'];
                    $min_mark = $question_result['mark'];
                    $max_time = $question_result['time_taken'];
                    $min_time = $question_result['time_taken'];
                } else {
                    if ($question_result['mark'] > $max_mark) {
                        $max_mark = $question_result['mark'];
                    } else if ($question_result['mark'] < $min_mark) {
                        $min_mark = $question_result['mark'];
                    }

                    if ($question_result['time_taken'] > $max_time) {
                        $max_time = $question_result['time_taken'];
                    } else if ($question_result['time_taken'] < $min_time) {
                        $min_time = $question_result['time_taken'];
                    }
                }
            }
            $count++;
        }

        $questions = Yii::app()->db->createCommand()
                ->select('take_id, question_id, status')
                ->from('essay_answer')
                ->queryAll();
        
        foreach ($questions as $question){
            $model_question = new Question;
            $model_question = Question::model()->findByPk($question['question_id']);
            if($model_question->subject_area_id == $subject_area_id){
                
                if($question['status'] == 1){
                    $mark = EssayAnswer::model()->getMarkForTheQuestion($question['take_id'], $question['question_id']);
                    $time = PaperQuestion::model()->getTimeForTheQuestion($question['take_id'], $question['question_id']);
                    $total_marks += $mark;
                    $total_time += $time;
                    
                    
                    if ($mark > $max_mark) {
                        $max_mark = $mark;
                    } else if ($mark < $min_mark) {
                        $min_mark = $mark;
                    }

                    if ($time > $max_time) {
                        $max_time = $time;
                    } else if ($time < $min_time) {
                        $min_time = $time;
                    }
                    
                    $count++;
                }
            }
        }
        
        //var_dump($questions); die;
        
        $details['max_mark'] = $max_mark;
        $details['min_mark'] = $min_mark;

        $average = $total_marks / $count;
        $average = round($average, 2);

        $details['average'] = $average;
        $details['max_time'] = $max_time;
        $details['min_time'] = $min_time;

        $timeAverage = $total_time / $count;
        $timeAverage = round($timeAverage, 2);

        $details['time_average'] = $timeAverage;
        return $details;
    }

    public function getAllDoneForSubject($subjetc_id) {

        $receied_id = $subjetc_id;

        $take_ids = Take::model()->getTakeIdsOfSubject($receied_id);
//        var_dump($take_ids); die;
        $details = array();
        $count = 0;
        $highest_mark = 0;
        $lowest_mark = 0;
        $average = 0;
        $total_score = 0;
        $max_time_taken = 0;
        $min_time_taken = 0;
        $total_time_taken = 0;
        $timeAverage = 0;
        $passCount = 0;
        $failCount = 0;

        foreach ($take_ids as $take_id) {
            $exam_id = Take::model()->getExamIdOfTake($take_id);
            $exam_model = new Exam;
            $exam_model = Exam::model()->findByPk($exam_id);
            if($exam_model->exam_type == "ESSAY"){
                $score = Take::model()->getResultOfTheTake($take_id, 1);
                $time_taken = PaperQuestion::model()->getTotalTimeTaken($take_id);
            }else{
                $calDetails = FinalResult::model()->calculationsForSubject($take_id);
                $score = $calDetails['score'];
                $time_taken = $calDetails['time'];
            }
            
            $total_score+=$score;
            $total_time_taken+=$time_taken;
            //var_dump($time_taken); die;
            
            $passMark = Exam::model()->getPasmark($exam_id);

            if ($score >= $passMark) {
                $passCount++;
            } else {
                $failCount++;
            }

            if ($count == 0) {
                $highest_mark = $score;
                $lowest_mark = $score;
                $max_time_taken = $time_taken;
                $min_time_taken = $time_taken;
            } else {
                if ($score > $highest_mark) {
                    $highest_mark = $score;
                } else if ($score < $lowest_mark) {
                    $lowest_mark = $score;
                }

                if ($time_taken > $max_time_taken) {
                    $max_time_taken = $time_taken;
                } else if ($time_taken < $min_time_taken) {
                    $min_time_taken = $time_taken;
                }
            }
            $count++;
        }

        $details['max_mark'] = $highest_mark;
        $details['min_mark'] = $lowest_mark;

        if ($count != 0) {
            $average = $total_score / $count;
            $average = round($average, 2);

            $timeAverage = $total_time_taken / $count;
            $timeAverage = round($timeAverage, 2);
        }

        $details['average'] = $average;
        $details['max_time'] = $max_time_taken;
        $details['min_time'] = $min_time_taken;
        $details['time_average'] = $timeAverage;
        $details['passCount'] = $passCount;
        $details['failCount'] = $failCount;

        return $details;
    }

    public function calculationsForSubject($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('final_result')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        $calculationDetails = array();
        $total_marks = 0;
        $total_time_taken = 0;

        foreach ($question_results as $question_result) {
            $total_marks+= $question_result['mark'];
            $total_time_taken+=$question_result['time_taken'];
        }

        $total_marks_of_exam = PaperQuestion::model()->getTotalMarksOfExam($take_id);
        $score = 0;
        if($total_marks_of_exam != 0){
            if ($total_marks != 0) {
                $score = ($total_marks / $total_marks_of_exam) * 100;
            } else {
                $score = 0;
            }
        }

        $score = round($score, 1);
        $calculationDetails['score'] = $score;
        $calculationDetails['time'] = $total_time_taken;
        return $calculationDetails;
    }
    
    
    public function noOfCorrectAttempts($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        $criteria->addCondition('mark>0');
        return $this->model()->count($criteria);
    }

    public function noOfInCorrectAttempts($question_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('question_id=' . $question_id);
        $criteria->addCondition('mark<=0');
        return $this->model()->count($criteria);
    }

}
