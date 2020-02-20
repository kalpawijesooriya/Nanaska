<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property integer $question_id
 * @property integer $subject_area_id
 * @property string $question_type
 * @property integer $number_of_marks
 * @property string $question_text
 * @property integer $exclude_from_dynamic
 * @property string $question_logic

 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 * @property PaperQuestion[] $paperQuestions
 * @property SubjectArea $subjectArea
 * @property QuestionPart[] $questionParts
 */
class Question extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subject_area_id, question_type, number_of_marks, question_text', 'required'),
            array('subject_area_id, exclude_from_dynamic, status', 'numerical', 'integerOnly' => true),
            array('number_of_marks', 'numerical'),
            array('question_type', 'length', 'max' => 22),
            array('question_logic', 'length', 'max' => 65536),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('question_id, subject_area_id, question_type, number_of_marks, question_text, exclude_from_dynamic, status, question_logic', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::HAS_MANY, 'Answer', 'question_id'),
            'paperQuestions' => array(self::HAS_MANY, 'PaperQuestion', 'question_id'),
            'subjectArea' => array(self::BELONGS_TO, 'SubjectArea', 'subject_area_id'),
            'questionParts' => array(self::HAS_MANY, 'QuestionPart', 'question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'question_id' => 'Question ID',
            'subject_area_id' => 'Subject Area',
            'question_type' => 'Question Type',
            'number_of_marks' => 'Number Of Marks',
            'question_text' => 'Question Text',
            'exclude_from_dynamic' => 'Exclude From Dynamic',
            'status' => 'Status',
            'question_logic' => 'Question Logic',
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

        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('subject_area_id', $this->subject_area_id);
        $criteria->compare('question_type', $this->question_type, true);
        $criteria->compare('number_of_marks', $this->number_of_marks);
        $criteria->compare('question_text', $this->question_text, true);
        $criteria->compare('exclude_from_dynamic', $this->exclude_from_dynamic);
        $criteria->compare('status', $this->status);
        $criteria->compare('question_logic', $this->question_logic, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getQuestionsByQuestionId($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();

        return $data;
    }

    public function getHotspotQuestionsId($question_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('hotspot')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();

        return $data;
    }

    public function getExamTime($exam_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        return $data[0]['time'];
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

    public function getRandomQuestions($subject_area_id, $question_type, $no_of_questions) {
//        $data = Yii::app()->db->createCommand()
//                ->select('question_id')
//                ->from('question')
//                ->where('subject_area_id=:subject_area_id AND question_type=:question_type', array(':subject_area_id' => $subject_area_id, ':question_type' => $question_type))
//                ->queryScalar();
//
//        $selected_question_ids = array();
//
//        if ($data != null) {
//            for ($count = 1; $count <= $no_of_questions; $count++) {
//                $index = rand(0, sizeof($data) - 1);
//
//                $question_id = $data[$index];
//
//
//                if (!in_array($question_id, $selected_question_ids)) {
//                    $selected_question_ids[] = $question_id;
//                }
//            }
//        }
//
//
//        return $selected_question_ids;
        
        $data = Yii::app()->db->createCommand()
                ->select('question_id')
                ->from('question')
                ->where('subject_area_id=:subject_area_id AND question_type=:question_type', array(':subject_area_id' => $subject_area_id, ':question_type' => $question_type))
                ->order(array('RAND()'))
                ->limit($no_of_questions)
                ->queryAll();
        if($data != null){
            return $data;
        }else{
            return array();
        }
        
    }

    public function getQuestion($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        return $questiondata[0];
    }

    public function getQuestionType($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('question_type')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();

        if (isset($questiondata[0]['question_type'])) {
            return $questiondata[0]['question_type'];
        } else {
            return "Please return to the next question";
        }
    }

    public function getMarksOfQuestion($is_correct, $allow_custom_marks, $number_of_marks, $marks_per_question, $allow_minus_marks) {
        if ($is_correct) {
            if ($allow_custom_marks == 1) {
                $marks = $number_of_marks;
            } else if ($allow_custom_marks == 0) {
                $marks = $marks_per_question;
            }
        } else {
            if ($allow_custom_marks == 1) {
                if ($allow_minus_marks == 1) {
                    $marks = -1;
                } else if ($allow_minus_marks == 0) {
                    $marks = 0;
                }
            } else if ($allow_custom_marks == 0) {
                $marks = 0;
            }
        }

        return $marks;
    }

    public function getSubjectAreaOfQuestion($question_id) {
        $questiondata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        $subject_area_id = $questiondata[0]['subject_area_id'];

        $subjectareadata = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_area')
                ->where('subject_area_id=:subject_area_id', array(':subject_area_id' => $subject_area_id))
                ->queryAll();

        return $subjectareadata[0]['subject_area_name'];
    }

    public function getSubjectAreaIdOfQuestion($question_id) {

        $questiondata = Yii::app()->db->createCommand()
                ->select('subject_area_id')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();
        $subject_area_id = $questiondata[0]['subject_area_id'];
        return $subject_area_id;
    }
    public function getQuestionText($question_id) {
        $questiontext = Yii::app()->db->createCommand()
                ->select('question_text')
                ->from('question')
                ->where('question_id=:question_id', array(':question_id' => $question_id))
                ->queryAll();

        return $questiontext[0]['question_text'];
    }
}
