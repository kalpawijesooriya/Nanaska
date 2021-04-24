<?php

/**
 * This is the model class for table "exam".
 *
 * The followings are the available columns in table 'exam':
 * @property integer $exam_id
 * @property integer $subject_id
 * @property string $exam_name
 * @property string $exam_description
 * @property integer $number_of_questions
 * @property string $exam_type
 * @property integer $time
 * @property boolean $calculator_allowed
 * @property double $exam_price
 * @property integer $marks_per_question
 * @property integer $allow_custom_marks
 * @property integer $allow_minus_marks
 * @property integer $pass_mark
 * @property integer $expiry_duration
 * @property integer $allow_view_marked_questions
 * @property integer $allow_goto_question
 * @property integer $allow_view_unanswered_questions
 * @property integer $status
 * @property string $exam_image
 * @property string $exam_instruction
 *
 * The followings are the available model relations:
 * @property Subject $subject
 * @property ExamQuestion[] $examQuestions
 * @property ExamSubjectArea[] $examSubjectAreas
 * @property StudentExam[] $studentExams
 * @property SubjectExamOrder[] $subjectExamOrders
 * @property Take[] $takes
 */
class Exam extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Exam the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'exam';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_id, exam_name, exam_description, number_of_questions, exam_type, time, exam_price, marks_per_question, pass_mark, expiry_duration', 'required'),
            array('subject_id, number_of_questions, time, calculator_allowed, marks_per_question, allow_custom_marks, allow_minus_marks, pass_mark, expiry_duration, allow_view_marked_questions, allow_goto_question, allow_view_unanswered_questions, status', 'numerical', 'integerOnly' => true),
            array('exam_price', 'numerical'),
            array('exam_name', 'length', 'max' => 100),
            array('exam_type', 'length', 'max' => 7),
            array('exam_image', 'length', 'max' => 30),
            array('exam_instruction', 'length', 'max' => 512),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('exam_id, subject_id, exam_name, exam_description, number_of_questions, exam_type, time, calculator_allowed, exam_price, marks_per_question, allow_custom_marks, allow_minus_marks, pass_mark, expiry_duration, allow_view_marked_questions, allow_goto_question, allow_view_unanswered_questions, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
            'examQuestions' => array(self::HAS_MANY, 'ExamQuestion', 'exam_id'),
            'examSubjectAreas' => array(self::HAS_MANY, 'ExamSubjectArea', 'exam_id'),
            'studentExams' => array(self::HAS_MANY, 'StudentExam', 'exam_id'),
            'subjectExamOrders' => array(self::HAS_MANY, 'SubjectExamOrder', 'exam_id'),
            'takes' => array(self::HAS_MANY, 'Take', 'exam_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'exam_id' => 'Exam',
            'subject_id' => 'Subject',
            'exam_name' => 'Exam Name',
            'exam_description' => 'Exam Description',
            'number_of_questions' => 'Number Of Questions',
            'exam_type' => 'Exam Type',
            'time' => 'Time',
            'calculator_allowed' => 'Calculator Allowed',
            'exam_price' => 'Exam Price',
            'marks_per_question' => 'Marks Per Question',
            'allow_custom_marks' => 'Allow Custom Marks',
            'allow_minus_marks' => 'Allow Minus Marks',
            'pass_mark' => 'Pass Mark',
            'expiry_duration' => 'Expiry Duration',
            'allow_view_marked_questions' => 'Allow View Marked Questions',
            'allow_goto_question' => 'Allow Goto Question',
            'allow_view_unanswered_questions' => 'Allow View Unanswered Questions',
            'status' => 'Status',
            'exam_image' => 'Exam Image',
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

        $criteria->compare('exam_id', $this->exam_id);
        $criteria->compare('subject_id', $this->subject_id);
        $criteria->compare('exam_name', $this->exam_name, true);
        $criteria->compare('exam_description', $this->exam_description, true);
        $criteria->compare('number_of_questions', $this->number_of_questions);
        $criteria->compare('exam_type', $this->exam_type, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('calculator_allowed', $this->calculator_allowed);
        $criteria->compare('exam_price', $this->exam_price);
        $criteria->compare('marks_per_question', $this->marks_per_question);
        $criteria->compare('allow_custom_marks', $this->allow_custom_marks);
        $criteria->compare('allow_minus_marks', $this->allow_minus_marks);
        $criteria->compare('pass_mark', $this->pass_mark);
        $criteria->compare('expiry_duration', $this->expiry_duration);
        $criteria->compare('allow_view_marked_questions', $this->allow_view_marked_questions);
        $criteria->compare('allow_goto_question', $this->allow_goto_question);
        $criteria->compare('allow_view_unanswered_questions', $this->allow_view_unanswered_questions);
        $criteria->compare('status', $this->status);
        $criteria->compare('exam_image', $this->exam_image, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getSubjectsForLevelId($levelid) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('level_id=:level_id', array(':level_id' => $levelid))
                ->queryAll();
        return $data;
    }

    public function getExamDetailsForSubjectID($subjectid) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('subject_id=:subject_id', array(':subject_id' => $subjectid))
                ->queryAll();
        return $data;
    }

    public function getSubjectExamOrderForExamID($examid) {

        if ($examid == NULL) {
            return 'N/A';
        } else {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('subject_exam_order')
                    ->where('exam_id=:exam_id', array(':exam_id' => $examid))
                    ->queryAll();
            return $data;
        }
    }

    public function getExamDetailsForExamID($examid) {
        if ($examid == NULL) {
            return 'N/A';
        } else {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('exam')
                    ->where('exam_id=:exam_id', array(':exam_id' => $examid))
                    ->queryAll();
            return $data;
        }
    }

    public function getSubjectExamOrderForSubjectId($subjectid) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_exam_order')
                ->where('subject_id=:subject_id', array(':subject_id' => $subjectid))
                ->order('position')
                ->queryAll();
        return $data;
    }

    public function getCourseNameFromLevelID($levelid) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('level_id=:level_id', array(':level_id' => $levelid))
                ->queryAll();


        $course_data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('course')
                ->where('course_id=:course_id', array(':course_id' => $data[0]['course_id']))
                ->queryAll();
        return $course_data[0]['course_name'];
    }

    public function getExamDetails($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0];
    }

    public static function getQuestionsOfExamById($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_question')
                ->order('exam_question_id')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data;
    }

    public static function getExamName($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if ($data != null) {
            return $data[0]['exam_name'];
        } else {
            return null;
        }
    }

    public static function getExam($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if ($data != null) {
            return $data[0];
        } else {
            return null;
        }
    }

    public function getExamPrice($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['exam_price'];
    }

    public function getExamTime($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['time'];
    }

    public static function getExamType($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('exam_type')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if ($data != null) {
            return $data[0]['exam_type'];
        } else {
            return null;
        }
    }

    public function getSubjectForExam($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if ($data != null) {
            return $data[0]['subject_id'];
        } else {
            return null;
        }
    }

    public function getExamCalAllowed($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['calculator_allowed'];
    }

    public function getExamViewMarkedAllowed($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['allow_view_marked_questions'];
    }

    public function getExamViewUnansweredAllowed($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['allow_view_unanswered_questions'];
    }

    public function getExamGotoQuestionAllowed($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['allow_view_marked_questions'];
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

    public function getExamTablesAndFormulaeTabTitleByExamTablesAndFormulaeId($exam_tables_and_formulae_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_tables_and_formulae_tab_title')
                ->where('exam_tables_and_formulae_id=:exam_tables_and_formulae_id', array(':exam_tables_and_formulae_id' => $exam_tables_and_formulae_id))
                ->queryAll();
        return $data[0];
    }

    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }

    public function getQuestionsOfDynamicExamById($exam_id) {
        $exam_details = Exam::model()->getExamDetails($exam_id);
//        print_r($exam_details);

        $exam_subject_area_weightages = ExamSubjectArea::model()->getSubjectAreaWeightagesOfExamById($exam_id);

//        echo '<pre>';
//        print_r($exam_subject_area_weightages);
//        echo '</pre>';
//        $total_number_of_questions = $exam_details['number_of_questions'];
        $total_number_of_questions = $exam_details['number_of_questions'];
        $all_questions = array();

        if (sizeof($exam_subject_area_weightages) == 1) {
            $no_of_single_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['single_answer_weightage'] / 100);
            $no_of_multiple_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['multiple_answer_weightage'] / 100);
            $no_of_short_written_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['short_written_answer_weightage'] / 100);
            $no_of_drag_drop_typea_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['drag_drop_typea_answer_weightage'] / 100);
            $no_of_drag_drop_typeb_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['drag_drop_typeb_answer_weightage'] / 100);
            $no_of_drag_drop_typec_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['drag_drop_typeb_answer_weightage'] / 100);
            $no_of_drag_drop_typed_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['drag_drop_typed_answer_weightage'] / 100);
            $no_of_drag_drop_typee_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['drag_drop_typee_answer_weightage'] / 100);
            $no_of_multiple_choice_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['multiple_choice_answer_weightage'] / 100);
            $no_of_true_false_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['true_or_false_answer_weightage'] / 100);
            $no_of_hotspot_answer = $total_number_of_questions * ($exam_subject_area_weightages[0]['hotspot_answer_weightage'] / 100);

//            echo $no_of_single_answer . '<br/>';
//            echo $no_of_multiple_answer . '<br/>';
//            echo $no_of_short_written_answer . '<br/>';
//            echo $no_of_drag_drop_typea_answer . '<br/>';
//            echo $no_of_drag_drop_typeb_answer . '<br/>';
//            echo $no_of_drag_drop_typec_answer . '<br/>';
//            echo $no_of_drag_drop_typed_answer . '<br/>';
//            echo $no_of_drag_drop_typee_answer . '<br/>';
//            echo $no_of_multiple_choice_answer . '<br/>';
//            echo $no_of_true_false_answer . '<br/>';
//            echo $no_of_hotspot_answer . '<br/>';

            $total_set_questions = 0;

            if ($no_of_single_answer < 1) {
                $no_of_single_answer = ceil($no_of_single_answer);
            } else {
                $no_of_single_answer = round($no_of_single_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_single_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_single_answer;

            if ($no_of_multiple_answer < 1) {
                $no_of_multiple_answer = ceil($no_of_multiple_answer);
            } else {
                $no_of_multiple_answer = round($no_of_multiple_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_multiple_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_multiple_answer;

            if ($no_of_short_written_answer < 1) {
                $no_of_short_written_answer = ceil($no_of_short_written_answer);
            } else {
                $no_of_short_written_answer = round($no_of_short_written_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_short_written_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_short_written_answer;

            if ($no_of_drag_drop_typea_answer < 1) {
                $no_of_drag_drop_typea_answer = ceil($no_of_drag_drop_typea_answer);
            } else {
                $no_of_drag_drop_typea_answer = round($no_of_drag_drop_typea_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_drag_drop_typea_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_drag_drop_typea_answer;

            if ($no_of_drag_drop_typeb_answer < 1) {
                $no_of_drag_drop_typeb_answer = ceil($no_of_drag_drop_typeb_answer);
            } else {
                $no_of_drag_drop_typeb_answer = round($no_of_drag_drop_typeb_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_drag_drop_typeb_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_drag_drop_typeb_answer;

            if ($no_of_drag_drop_typec_answer < 1) {
                $no_of_drag_drop_typec_answer = ceil($no_of_drag_drop_typec_answer);
            } else {
                $no_of_drag_drop_typec_answer = round($no_of_drag_drop_typec_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_drag_drop_typec_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_drag_drop_typec_answer;

            if ($no_of_drag_drop_typed_answer < 1) {
                $no_of_drag_drop_typed_answer = ceil($no_of_drag_drop_typed_answer);
            } else {
                $no_of_drag_drop_typed_answer = round($no_of_drag_drop_typed_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_drag_drop_typed_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_drag_drop_typed_answer;

            if ($no_of_drag_drop_typee_answer < 1) {
                $no_of_drag_drop_typee_answer = ceil($no_of_drag_drop_typee_answer);
            } else {
                $no_of_drag_drop_typee_answer = round($no_of_drag_drop_typee_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_drag_drop_typee_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_drag_drop_typee_answer;

            if ($no_of_multiple_choice_answer < 1) {
                $no_of_multiple_choice_answer = ceil($no_of_multiple_choice_answer);
            } else {
                $no_of_multiple_choice_answer = round($no_of_multiple_choice_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_multiple_choice_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_multiple_choice_answer;

            if ($no_of_true_false_answer < 1) {
                $no_of_true_false_answer = ceil($no_of_true_false_answer);
            } else {
                $no_of_true_false_answer = round($no_of_true_false_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_true_false_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_true_false_answer;

            if ($no_of_hotspot_answer < 1) {
                $no_of_hotspot_answer = ceil($no_of_hotspot_answer);
            } else {
                $no_of_hotspot_answer = round($no_of_hotspot_answer);
            }
            if ($total_set_questions == $total_number_of_questions) {
                $no_of_hotspot_answer = 0;
            }
            $total_set_questions = $total_set_questions + $no_of_hotspot_answer;

//            echo '........................<br>';
//            echo $no_of_single_answer . '<br/>';
//            echo $no_of_multiple_answer . '<br/>';
//            echo $no_of_short_written_answer . '<br/>';
//            echo $no_of_drag_drop_typea_answer . '<br/>';
//            echo $no_of_drag_drop_typeb_answer . '<br/>';
//            echo $no_of_drag_drop_typec_answer . '<br/>';
//            echo $no_of_drag_drop_typed_answer . '<br/>';
//            echo $no_of_drag_drop_typee_answer . '<br/>';
//            echo $no_of_multiple_choice_answer . '<br/>';
//            echo $no_of_true_false_answer . '<br/>';
//            echo $no_of_hotspot_answer . '<br/>';


            $total_qs = $no_of_single_answer + $no_of_multiple_answer + $no_of_short_written_answer +
                    $no_of_drag_drop_typea_answer + $no_of_drag_drop_typeb_answer + $no_of_drag_drop_typec_answer +
                    $no_of_drag_drop_typed_answer + $no_of_drag_drop_typee_answer + $no_of_multiple_choice_answer +
                    $no_of_true_false_answer + $no_of_hotspot_answer;


            if ($total_qs != $total_number_of_questions) {
                if ($total_qs < $total_number_of_questions) {
                    
                }
            }
            

            $single_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "SINGLE_ANSWER", $no_of_single_answer);
            if ($single_answer_question_ids == null && $no_of_single_answer > 0) {
                $no_of_multiple_answer++;
            }

            $multiple_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "MULTIPLE_ANSWER", $no_of_multiple_answer);
            if ($multiple_answer_question_ids == null && $no_of_multiple_answer > 0) {
                $no_of_short_written_answer++;
            }

            $short_written_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "SHORT_WRITTEN", $no_of_short_written_answer);
            if ($short_written_answer_question_ids == null && $no_of_short_written_answer > 0) {
                $no_of_drag_drop_typea_answer++;
            }

            $drag_drop_typea_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "DRAG_DROP_TYPEA_ANSWER", $no_of_drag_drop_typea_answer);
            if ($drag_drop_typea_question_ids == null && $no_of_drag_drop_typea_answer > 0) {
                $no_of_drag_drop_typeb_answer++;
            }

            $drag_drop_typeb_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "DRAG_DROP_TYPEB_ANSWER", $no_of_drag_drop_typeb_answer);
            if ($drag_drop_typeb_question_ids == null && $no_of_drag_drop_typeb_answer > 0) {
                $no_of_drag_drop_typec_answer++;
            }

            $drag_drop_typec_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "DRAG_DROP_TYPEC_ANSWER", $no_of_drag_drop_typec_answer);
            if ($drag_drop_typec_question_ids == null && $no_of_drag_drop_typec_answer > 0) {
                $no_of_drag_drop_typed_answer++;
            }

            $drag_drop_typed_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "DRAG_DROP_TYPED_ANSWER", $no_of_drag_drop_typed_answer);
            if ($drag_drop_typed_question_ids == null && $no_of_drag_drop_typed_answer > 0) {
                $no_of_drag_drop_typee_answer++;
            }

            $drag_drop_typee_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "DRAG_DROP_TYPEE_ANSWER", $no_of_drag_drop_typee_answer);
            if ($drag_drop_typee_question_ids == null && $no_of_drag_drop_typee_answer > 0) {
                $no_of_multiple_choice_answer++;
            }

            $multiple_choice_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "MULTIPLE_CHOICE_ANSWER", $no_of_multiple_choice_answer);
            if ($multiple_choice_answer_question_ids == null && $no_of_multiple_choice_answer > 0) {
                $no_of_true_false_answer++;
            }

            $true_false_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "TRUE_OR_FALSE_ANSWER", $no_of_true_false_answer);
            if ($true_false_question_ids == null && $no_of_true_false_answer > 0) {
                $no_of_hotspot_answer++;
            }

            $hotspot_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightages[0]['subject_area_id'], "HOT_SPOT_ANSWER", $no_of_hotspot_answer);


//            print_r($single_answer_question_ids);
//            echo '<br/>';
//            print_r($multiple_answer_question_ids);
//            echo '<br/>';
//            print_r($short_written_answer_question_ids);
//            echo '<br/>';
//            print_r($drag_drop_typea_question_ids);
//            echo '<br/>';
//            print_r($drag_drop_typeb_question_ids);
//            echo '<br/>';
//            print_r($drag_drop_typec_question_ids);
//            echo '<br/>';
//            print_r($drag_drop_typed_question_ids);
//            echo '<br/>';
//            print_r($drag_drop_typee_question_ids);
//            echo '<br/>';
//            print_r($multiple_choice_answer_question_ids);
//            echo '<br/>';
//            print_r($true_false_question_ids);
//            echo '<br/>';
//            print_r($hotspot_answer_question_ids);
//            echo '<br/>';

            $all_questions = array();

            foreach ($single_answer_question_ids as $single_answer_question_id) {
                $all_questions[]['question_id'] = $single_answer_question_id['question_id'];
            }

            foreach ($multiple_answer_question_ids as $multiple_answer_question_id) {
                $all_questions[]['question_id'] = $multiple_answer_question_id['question_id'];
            }

            foreach ($short_written_answer_question_ids as $short_written_answer_question_id) {
                $all_questions[]['question_id'] = $short_written_answer_question_id['question_id'];
            }

            foreach ($drag_drop_typea_question_ids as $drag_drop_typea_question_id) {
                $all_questions[]['question_id'] = $drag_drop_typea_question_id['question_id'];
            }

            foreach ($drag_drop_typeb_question_ids as $drag_drop_typeb_question_id) {
                $all_questions[]['question_id'] = $drag_drop_typeb_question_id['question_id'];
            }

            foreach ($drag_drop_typec_question_ids as $drag_drop_typec_question_id) {
                $all_questions[]['question_id'] = $drag_drop_typec_question_id['question_id'];
            }

            foreach ($drag_drop_typed_question_ids as $drag_drop_typed_question_id) {
                $all_questions[]['question_id'] = $drag_drop_typed_question_id['question_id'];
            }

            foreach ($drag_drop_typee_question_ids as $drag_drop_typee_question_id) {
                $all_questions[]['question_id'] = $drag_drop_typee_question_id['question_id'];
            }

            foreach ($multiple_choice_answer_question_ids as $multiple_choice_answer_question_id) {
                $all_questions[]['question_id'] = $multiple_choice_answer_question_id['question_id'];
            }

            foreach ($true_false_question_ids as $true_false_question_id) {
                $all_questions[]['question_id'] = $true_false_question_id['question_id'];
            }

            foreach ($hotspot_answer_question_ids as $hotspot_answer_question_id) {
                $all_questions[]['question_id'] = $hotspot_answer_question_id['question_id'];
            }
        } else if (sizeof($exam_subject_area_weightages) > 1) {

            $all_questions = array();

            foreach ($exam_subject_area_weightages as $exam_subject_area_weightage) {

                $number_of_sub_area_qs = ($exam_subject_area_weightage['weightage'] / 100) * $total_number_of_questions;

//                echo $number_of_sub_area_qs;

                $number_of_sub_area_qs = round($number_of_sub_area_qs);

//                echo '=>' . $number_of_sub_area_qs;

                $no_of_single_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['single_answer_weightage'] / 100);
                $no_of_multiple_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['multiple_answer_weightage'] / 100);
                $no_of_short_written_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['short_written_answer_weightage'] / 100);
                $no_of_drag_drop_typea_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['drag_drop_typea_answer_weightage'] / 100);
                $no_of_drag_drop_typeb_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['drag_drop_typeb_answer_weightage'] / 100);
                $no_of_drag_drop_typec_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['drag_drop_typeb_answer_weightage'] / 100);
                $no_of_drag_drop_typed_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['drag_drop_typed_answer_weightage'] / 100);
                $no_of_drag_drop_typee_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['drag_drop_typee_answer_weightage'] / 100);
                $no_of_multiple_choice_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['multiple_choice_answer_weightage'] / 100);
                $no_of_true_false_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['true_or_false_answer_weightage'] / 100);
                $no_of_hotspot_answer = $number_of_sub_area_qs * ($exam_subject_area_weightage['hotspot_answer_weightage'] / 100);

//                echo '........................<br>';
//                echo $no_of_single_answer . '<br/>';
//                echo $no_of_multiple_answer . '<br/>';
//                echo $no_of_short_written_answer . '<br/>';
//                echo $no_of_drag_drop_typea_answer . '<br/>';
//                echo $no_of_drag_drop_typeb_answer . '<br/>';
//                echo $no_of_drag_drop_typec_answer . '<br/>';
//                echo $no_of_drag_drop_typed_answer . '<br/>';
//                echo $no_of_drag_drop_typee_answer . '<br/>';
//                echo $no_of_multiple_choice_answer . '<br/>';
//                echo $no_of_true_false_answer . '<br/>';
//                echo $no_of_hotspot_answer . '<br/>';
//                echo '........................<br>';


                $total_set_questions = 0;

                if ($no_of_single_answer < 1) {
                    $no_of_single_answer = ceil($no_of_single_answer);
                } else {
                    $no_of_single_answer = round($no_of_single_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_single_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_single_answer;

                if ($no_of_multiple_answer < 1) {
                    $no_of_multiple_answer = ceil($no_of_multiple_answer);
                } else {
                    $no_of_multiple_answer = round($no_of_multiple_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_multiple_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_multiple_answer;

                if ($no_of_short_written_answer < 1) {
                    $no_of_short_written_answer = ceil($no_of_short_written_answer);
                } else {
                    $no_of_short_written_answer = round($no_of_short_written_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_short_written_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_short_written_answer;

                if ($no_of_drag_drop_typea_answer < 1) {
                    $no_of_drag_drop_typea_answer = ceil($no_of_drag_drop_typea_answer);
                } else {
                    $no_of_drag_drop_typea_answer = round($no_of_drag_drop_typea_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_drag_drop_typea_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_drag_drop_typea_answer;

                if ($no_of_drag_drop_typeb_answer < 1) {
                    $no_of_drag_drop_typeb_answer = ceil($no_of_drag_drop_typeb_answer);
                } else {
                    $no_of_drag_drop_typeb_answer = round($no_of_drag_drop_typeb_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_drag_drop_typeb_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_drag_drop_typeb_answer;

                if ($no_of_drag_drop_typec_answer < 1) {
                    $no_of_drag_drop_typec_answer = ceil($no_of_drag_drop_typec_answer);
                } else {
                    $no_of_drag_drop_typec_answer = round($no_of_drag_drop_typec_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_drag_drop_typec_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_drag_drop_typec_answer;

                if ($no_of_drag_drop_typed_answer < 1) {
                    $no_of_drag_drop_typed_answer = ceil($no_of_drag_drop_typed_answer);
                } else {
                    $no_of_drag_drop_typed_answer = round($no_of_drag_drop_typed_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_drag_drop_typed_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_drag_drop_typed_answer;

                if ($no_of_drag_drop_typee_answer < 1) {
                    $no_of_drag_drop_typee_answer = ceil($no_of_drag_drop_typee_answer);
                } else {
                    $no_of_drag_drop_typee_answer = round($no_of_drag_drop_typee_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_drag_drop_typee_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_drag_drop_typee_answer;

                if ($no_of_multiple_choice_answer < 1) {
                    $no_of_multiple_choice_answer = ceil($no_of_multiple_choice_answer);
                } else {
                    $no_of_multiple_choice_answer = round($no_of_multiple_choice_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_multiple_choice_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_multiple_choice_answer;

                if ($no_of_true_false_answer < 1) {
                    $no_of_true_false_answer = ceil($no_of_true_false_answer);
                } else {
                    $no_of_true_false_answer = round($no_of_true_false_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_true_false_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_true_false_answer;

                if ($no_of_hotspot_answer < 1) {
                    $no_of_hotspot_answer = ceil($no_of_hotspot_answer);
                } else {
                    $no_of_hotspot_answer = round($no_of_hotspot_answer);
                }
                if ($total_set_questions == $number_of_sub_area_qs) {
                    $no_of_hotspot_answer = 0;
                }
                $total_set_questions = $total_set_questions + $no_of_hotspot_answer;

                echo '************************<br>';
                echo $no_of_single_answer . '<br/>';
                echo $no_of_multiple_answer . '<br/>';
                echo $no_of_short_written_answer . '<br/>';
                echo $no_of_drag_drop_typea_answer . '<br/>';
                echo $no_of_drag_drop_typeb_answer . '<br/>';
                echo $no_of_drag_drop_typec_answer . '<br/>';
                echo $no_of_drag_drop_typed_answer . '<br/>';
                echo $no_of_drag_drop_typee_answer . '<br/>';
                echo $no_of_multiple_choice_answer . '<br/>';
                echo $no_of_true_false_answer . '<br/>';
                echo $no_of_hotspot_answer . '<br/>';
                echo '************************<br>';


                echo $no_of_single_answer . ':/<br/>';

                echo $no_of_multiple_answer . ':';

                $single_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "SINGLE_ANSWER", $no_of_single_answer);

//                print_r($single_answer_question_ids);die();

                if ($single_answer_question_ids == null && $no_of_single_answer > 0) {
                    $no_of_multiple_answer++;
                }

                echo $no_of_multiple_answer . '<br/>';

                echo $no_of_short_written_answer . ':';

                $multiple_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "MULTIPLE_ANSWER", $no_of_multiple_answer);
                if ($multiple_answer_question_ids == null && $no_of_multiple_answer > 0) {
                    $no_of_short_written_answer++;
                }

                echo $no_of_short_written_answer . '<br/>';

                echo $no_of_drag_drop_typea_answer . ':';

                $short_written_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "SHORT_WRITTEN", $no_of_short_written_answer);
                if ($short_written_answer_question_ids == null && $no_of_short_written_answer > 0) {
                    $no_of_drag_drop_typea_answer++;
                }

                echo $no_of_drag_drop_typea_answer . '<br/>';
                echo $no_of_drag_drop_typeb_answer . ':';


                $drag_drop_typea_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "DRAG_DROP_TYPEA_ANSWER", $no_of_drag_drop_typea_answer);
                if ($drag_drop_typea_question_ids == null && $no_of_drag_drop_typea_answer > 0) {
                    $no_of_drag_drop_typeb_answer++;
                }

                echo $no_of_drag_drop_typeb_answer . '<br/>';
                echo $no_of_drag_drop_typec_answer . ':';

                $drag_drop_typeb_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "DRAG_DROP_TYPEB_ANSWER", $no_of_drag_drop_typeb_answer);


                if ($drag_drop_typeb_question_ids == null && $no_of_drag_drop_typeb_answer > 0) {
                    $no_of_drag_drop_typec_answer++;
                }

                echo $no_of_drag_drop_typec_answer . '<br/>';

                echo $no_of_drag_drop_typed_answer . ':';

                $drag_drop_typec_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "DRAG_DROP_TYPEC_ANSWER", $no_of_drag_drop_typec_answer);
                if ($drag_drop_typec_question_ids == null && $no_of_drag_drop_typec_answer > 0) {
                    $no_of_drag_drop_typed_answer++;
                }

                echo $no_of_drag_drop_typed_answer . '<br/>';

                $drag_drop_typed_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "DRAG_DROP_TYPED_ANSWER", $no_of_drag_drop_typed_answer);
                if ($drag_drop_typed_question_ids == null && $no_of_drag_drop_typed_answer > 0) {
                    $no_of_drag_drop_typee_answer++;
                }

                $drag_drop_typee_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "DRAG_DROP_TYPEE_ANSWER", $no_of_drag_drop_typee_answer);
                if ($drag_drop_typee_question_ids == null && $no_of_drag_drop_typee_answer > 0) {
                    $no_of_multiple_choice_answer++;
                }

                $multiple_choice_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "MULTIPLE_CHOICE_ANSWER", $no_of_multiple_choice_answer);
                if ($multiple_choice_answer_question_ids == null && $no_of_multiple_choice_answer > 0) {
                    $no_of_true_false_answer++;
                }

                $true_false_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "TRUE_OR_FALSE_ANSWER", $no_of_true_false_answer);
                if ($true_false_question_ids == null && $no_of_true_false_answer > 0) {
                    $no_of_hotspot_answer++;
                }

                $hotspot_answer_question_ids = Question::model()->getRandomQuestions($exam_subject_area_weightage['subject_area_id'], "HOT_SPOT_ANSWER", $no_of_hotspot_answer);

                foreach ($single_answer_question_ids as $single_answer_question_id) {
                    $all_questions[]['question_id'] = $single_answer_question_id['question_id'];
                }

                foreach ($multiple_answer_question_ids as $multiple_answer_question_id) {
                    $all_questions[]['question_id'] = $multiple_answer_question_id['question_id'];
                }

                foreach ($short_written_answer_question_ids as $short_written_answer_question_id) {
                    $all_questions[]['question_id'] = $short_written_answer_question_id['question_id'];
                }

                foreach ($drag_drop_typea_question_ids as $drag_drop_typea_question_id) {
                    $all_questions[]['question_id'] = $drag_drop_typea_question_id['question_id'];
                }

                foreach ($drag_drop_typeb_question_ids as $drag_drop_typeb_question_id) {
                    $all_questions[]['question_id'] = $drag_drop_typeb_question_id['question_id'];
                }

                foreach ($drag_drop_typec_question_ids as $drag_drop_typec_question_id) {
                    $all_questions[]['question_id'] = $drag_drop_typec_question_id['question_id'];
                }

                foreach ($drag_drop_typed_question_ids as $drag_drop_typed_question_id) {
                    $all_questions[]['question_id'] = $drag_drop_typed_question_id['question_id'];
                }

                foreach ($drag_drop_typee_question_ids as $drag_drop_typee_question_id) {
                    $all_questions[]['question_id'] = $drag_drop_typee_question_id['question_id'];
                }

                foreach ($multiple_choice_answer_question_ids as $multiple_choice_answer_question_id) {
                    $all_questions[]['question_id'] = $multiple_choice_answer_question_id['question_id'];
                }

                foreach ($true_false_question_ids as $true_false_question_id) {
                    $all_questions[]['question_id'] = $true_false_question_id['question_id'];
                }

                foreach ($hotspot_answer_question_ids as $hotspot_answer_question_id) {
                    $all_questions[]['question_id'] = $hotspot_answer_question_id['question_id'];
                }
            }

            echo '<pre>';
            print_r($all_questions);
            echo '</pre>';
        }


//        die();

        return $all_questions;
    }

    public function getQuestionType($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $data[0]['question_type'];
    }

    public function getScoreForNotLoggedIn($examid, $questionid, $marks) {
        $total_marks = 0;
        $total_num_of_marks = 0;

        foreach ($marks as $question_result) {
            $total_marks+= $question_result;
        }

        $exam_details = Exam::model()->getExamDetails($examid);

        if ($exam_details['allow_custom_marks'] == 0) {
            $total_num_of_marks = sizeof($marks) * $exam_details['marks_per_question'];
        } else if ($exam_details['allow_custom_marks'] == 1) {

            $question = Question::model()->getQuestion($questionid);
            $total_num_of_marks+=$question['number_of_marks'];
        }

        if ($total_marks != 0) {
            $score = ($total_marks / $total_num_of_marks) * 100;
        } else {
            $score = 0;
        }

        $score = round($score, 1);

        return $score;
    }

    public function getStudentIdForUserId($userid, $examid) {

        $data = Yii::app()->db->createCommand()
                ->select('student_id')
                ->from('student')
                ->where('user_id=:user_id', array(':user_id' => $userid))
                ->queryAll();


        $data2 = Yii::app()->db->createCommand()
                ->select('student_exam_id')
                ->from('student_exam')
                ->where('student_id=' . $data[0]['student_id'] . ' AND exam_id=' . $examid)
                ->queryAll();

        if (isset($data2[0]['student_exam_id'])) {
            return $data2[0]['student_exam_id'];
        } else {
            return null;
        }
    }

    public function getExamInstructionForExam($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('exam_instruction')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if ($data != null) {
            return $data[0]['exam_instruction'];
        } else {
            return null;
        }
    }
    public function getExamPreseenByExamId($exam_id) {
        $data = array();
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_preseen_materials')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data;
    }
    public function getExamPreseenTabTitleId($exam_preseen_id) {
        $data = array();
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam_preseen_material_tabs')
                ->where('exam_preseen_material_id=:exam_preseen_material_id', array(':exam_preseen_material_id' => $exam_preseen_id))
                ->queryAll();
        return $data[0];
    }
    
    public function getBooleanText($boolean_value) {
        if ($boolean_value == 1) {
            return "Yes";
        } else if ($boolean_value == 0) {
            return "No";
        } else {
            return "Invalid";
        }
    }
    
    public static function getExamInfoById($exam_id) {


        $Criteria = new CDbCriteria();
        $Criteria->condition = "exam_id = " . $exam_id;
        // $Criteria->compare("exam_id",$exam_id);
        $exam = Exam::model()->find($Criteria);

        return $exam;
    }

}
