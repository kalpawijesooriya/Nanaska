<?php

/**
 * This is the model class for table "take".
 *
 * The followings are the available columns in table 'take':
 * @property integer $take_id
 * @property integer $student_id
 * @property integer $exam_id
 * @property string $date
 * @property integer $status
 * @property integer $total_time
 *
 * The followings are the available model relations:
 * @property PaperQuestion[] $paperQuestions
 * @property Student $student
 * @property Exam $exam
 */
class Take extends CActiveRecord {

    public $student_name;
    public $email;
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
            array('student_id, exam_id, status, total_time', 'numerical', 'integerOnly' => true),
            array('date', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('take_id, student_id, exam_id, date, status', 'safe', 'on' => 'search'),
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
            'status' => 'Status'
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
    
    public function searchForEssayExams() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        //die;
        $criteria = new CDbCriteria;
        $criteria->with = array('exam','student.user');
        $criteria->compare('take_id', $this->take_id);    
        $criteria->compare('exam.exam_id', $this->exam_id);
        $criteria->compare('exam.exam_type', 'ESSAY', true);
        $criteria->compare('date', $this->date, true);
        //$criteria->compare('status', $this->turnMarkOrUnmark($this->status));
        if (isset($_GET['Take'])) {
            $criteria->compare('email', $_GET['Take']['email'], true);
            $criteria->compare('first_name', $_GET['Take']['student_name'], true);
        }
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public static function TruncateText($text, $max_len) {
        $len = mb_strlen($text, 'UTF-8');
        if ($len <= $max_len)
            return $text;
        else
            return mb_substr($text, 0, $max_len - 1, 'UTF-8') . '...';
    }
    public function getExamIdOfTake($take_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('exam_id')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryScalar();
        
        return $question_results;
    }

    public function getExamID($take_id) {
        $data = Yii::app()->db->createCommand()
                ->select('exam_id')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryRow();

        return $data['exam_id'];
    }

    public function getTake($take_id) {
        $take = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();

        return $take[0];
    }

    public function getTakeIdsforExamId($exam_id) {
        $take_ids = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();
        if (isset($take_ids)) {
            return $take_ids;
        } else {
            return null;
        }
    }

    public function getTakeIdsforExamIdandStudentId($exam_id, $student_id) {
        $take_ids = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                //->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->where('exam_id=' . $exam_id . ' AND student_id=' . $student_id)
                ->queryAll();
        if (isset($take_ids)) {
            return $take_ids;
        } else {
            return null;
        }
    }

    public function getTakeIdsOfSubject($subject_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('take_id, status')
                ->from('take')
//                ->where('take_id=:take_id', array(':take_id' => $take_id))
                ->queryAll();



        $question_array = array();

        foreach ($question_results as $question_result) {
            $take_id = $question_result['take_id'];
            $exam_id = Take::model()->getExamIdOfTake($take_id);
            $exam_model = new Exam;
            $exam_model = Exam::model()->findByPk($exam_id);
            $sub_id = Exam::model()->getSubjectForExam($exam_id);

            if ($sub_id == $subject_id) {
                if($exam_model->exam_type != "ESSAY"){
                    $question_array[] = $question_result;
                }else{
                    if($question_result['status'] == 1){
                        $question_array[] = $question_result;
                    }
                }
                
            }
        }

        $take_ids = array();

        foreach ($question_array as $item) {
            $take_id = $item['take_id'];

            $found = false;
            foreach ($take_ids as $take_id_item) {
                if ($take_id == $take_id_item) {
                    $found = true;
                }
            }
            if (!$found) {
                $take_ids[] = $take_id;
            }
        }
//        $take_ids = array();
//        $take_ids = Yii::app()->db->createCommand()
//                        ->select('take_id')
//                        ->from('take')
//                        ->naturalJoin('exam')
//                        ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
//                        ->queryAll();
//                var_dump($take_ids); die;
        return $take_ids;
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

    public function getExamIdFromStudentId($student_id) {
        $exam_ids = Yii::app()->db->createCommand()
                ->select('exam_id')
                ->from('take')
                //->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->where('student_id=' . $student_id)
                ->queryAll();
        if (isset($exam_ids)) {
            return $exam_ids;
        } else {
            return null;
        }
    }

    public function getDateTaken($exam_id) {
        $question_results = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                ->queryAll();

        return $question_results[0]['date'];
    }

    public function getPaidPaperCount() {
        $takes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->queryAll();

        $paid_paper_count = 0;

        foreach ($takes as $take) {
            $exam_id = $take['exam_id'];
            $exam_details = Exam::model()->getExamDetails($exam_id);

            if ($exam_details['exam_type'] == "PRESET" || $exam_details['exam_type'] == "DYNAMIC" || $exam_details['exam_type'] == "ESSAY") {
                $paid_paper_count++;
            }
        }

        return $paid_paper_count;
    }

    public function getFreePaperCount() {
        $takes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->queryAll();

        $free_paper_count = 0;

        foreach ($takes as $take) {
            $exam_id = $take['exam_id'];
            $exam_details = Exam::model()->getExamDetails($exam_id);

            if ($exam_details['exam_type'] == "SAMPLE") {
                $free_paper_count++;
            }
        }

        return $free_paper_count;
    }

    public function getPaidStudents() {
        $takes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->queryAll();

        $paid_students = array();

        foreach ($takes as $take) {
            $exam_id = $take['exam_id'];
            $exam_details = Exam::model()->getExamDetails($exam_id);

            if ($exam_details['exam_type'] == "PRESET" || $exam_details['exam_type'] == "DYNAMIC" || $exam_details['exam_type'] == "ESSAY") {
                $paid_students[] = $take['student_id'];
            }
        }

        return $paid_students;
    }

    public function getFreeStudents() {
        $takes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('take')
                ->queryAll();

        $free_students = array();

        foreach ($takes as $take) {
            $exam_id = $take['exam_id'];
            $exam_details = Exam::model()->getExamDetails($exam_id);

            if ($exam_details['exam_type'] == "SAMPLE") {
                $free_students[] = $take['student_id'];
            }
        }

        return $free_students;
    }
    public function getMarkOrUnmark($value){
        if($value == 1){
            return "Marked";
        }else{
            return "Un-marked";
        }
    }
    public function getResultOfTheTake($take_id, $status){
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
    public function turnMarkOrUnmark($value){
        if(strcasecmp($value, "Marked")){
            return 1;
        }else if(strcasecmp($value, "Un-marked")){
            return 0;
        }else{
            return 2;
        }
    }
    public function getTotalOfTheTake($take_id){
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
}
