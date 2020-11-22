<?php

class TakeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'getResultPerExam', 'getExamIdsforStudentId', 'getPaperForTakeIds', 'getExamsForEmails'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Take;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Take'])) {
            $model->attributes = $_POST['Take'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->take_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Take'])) {
            $model->attributes = $_POST['Take'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->take_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Take');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Take('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Take']))
            $model->attributes = $_GET['Take'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Take::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'take-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actiongetResultPerExam() {

        $from_date = strtotime($_POST['start_date']);
        $to_date = strtotime($_POST['end_date']);

        $take_ids = Take::model()->getTakeIdsforExamId($_POST['exam_id']);

        $passMark = Exam::model()->getPasmark($_POST['exam_id']);
        $exam_type = Exam::model()->getExamType($_POST['exam_id']);
        $passCount = 0;
        $failCount = 0;



        $take_id_marks = array();

        if (!empty($take_ids)) {
            foreach ($take_ids as $take_id) {
                $date = strtotime($take_id['date']);
                if ($date >= $from_date && $date <= $to_date) {
                    if ($exam_type == 'ESSAY') {
                        if ($take_id['status'] == 1) {
                            $total_marks = Take::model()->getTotalOfTheTake($take_id['take_id']);
                            $take_id_marks[$take_id['take_id']] = $total_marks;
                            $time_taken = PaperQuestion::model()->getTotalTimeTaken($take_id['take_id']);
                            $take_id_time_taken[$take_id['take_id']] = $time_taken;
                            if ($passMark <= $total_marks) {
                                $passCount++;   //number of studens passed the exam
                            } else {
                                $failCount++;  //number of students failed the exam
                            }
                        }
                    } else {
                        $marks_array = FinalResult::model()->getFinalResultById($take_id['take_id']);
                        $total_marks = 0;
                        $time_taken = 0;
                        foreach ($marks_array as $marks) {
                            $total_marks = $total_marks + $marks['mark'];
                            $time_taken = $time_taken + $marks['time_taken'];
                        }
                        //echo $time_taken ; die;
                        $take_id_marks[$take_id['take_id']] = $total_marks;
                        $take_id_time_taken[$take_id['take_id']] = $time_taken;


                        if ($passMark <= $total_marks) {
                            $passCount++;   //number of studens passed the exam
                        } else {
                            $failCount++;  //number of students failed the exam
                        }
                    }
                }
            }

            if (!empty($take_id_marks)) {
                //maximum, minimum and average marks
                $highest_marks = max($take_id_marks);
                $lowest_marks = min($take_id_marks);
                $average_marks = array_sum($take_id_marks) / count($take_id_marks);

                //maximum, minimum and average time
                $highest_time = max($take_id_time_taken);
                $lowest_time = min($take_id_time_taken);
                $average_time = array_sum($take_id_time_taken) / count($take_id_time_taken);
            } else {
                //maximum, minimum and average marks
                $highest_marks = 0;
                $lowest_marks = 0;
                $average_marks = 0;

                //maximum, minimum and average time
                $highest_time = 0;
                $lowest_time = 0;
                $average_time = 0;
            }


            echo $this->renderPartial('_results_per_exam', array('passCount' => $passCount, 'failCount' => $failCount, 'highest_marks' => $highest_marks, 'lowest_marks' => $lowest_marks, 'average_marks' => $average_marks, 'highest_time' => $highest_time, 'lowest_time' => $lowest_time, 'average_time' => $average_time));
        } else {
            $exam_details = Exam::model()->getExamDetails($_POST['exam_id']);
            echo '<br>';
            echo '<h5>No Exams have been taken under </h5>' . $exam_details['exam_name'];
        }
    }

    public function actiongetExamIdsforStudentId() {
        if (isset($_POST['student_id'])) {

            $studentID = (int) $_POST['student_id'];

            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('take')
                    ->where('student_id=:student_id', array(':student_id' => $studentID))
                    ->queryAll();


            $first_option_set = 0;
            $count = 0;


            $set_ids = array();
            foreach ($data as $d) {

                $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);

                $ExamName = $ExamData['exam_name'];

                $found = false;
                foreach ($set_ids as $set_id) {
                    if ($set_id == $ExamData['exam_id']) {
                        $found = true;
                    }
                }

                if (!$found) {
                    $set_ids[] = $ExamData['exam_id'];

                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($ExamName), true);

                    $count++;
                }
            }

            if ($count == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                echo CHtml::tag('option', array('value' => '', 'disabled' => 'disabled'), 'No Exams', true);
            }
        } else {
            echo 'Student id not set';
        }
    }

    public function actionGetExamsForEmails() {

        $studentEmail = $_POST['email'];
        $userID = Student::model()->getuserIDFromEmail($studentEmail);
        $studentID = Student::model()->getStudentIdForUserId($userID);
        $status = "fail";

        $first_option_set = 0;
        $count = 0;

        if ($userID != null) {
            $status = "success";

            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('take')
                    ->where('student_id=:student_id', array(':student_id' => $studentID))
                    ->queryAll();

            $set_ids = array();
            $examModeified = array();

            foreach ($data as $d) {
                $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);

                $ExamName = $ExamData['exam_name'];

                $found = false;
                foreach ($set_ids as $set_id) {
                    if ($set_id == $ExamData['exam_id']) {
                        $found = true;
                    }
                }

                if (!$found) {
                    $set_ids[] = $ExamData['exam_id'];

                    if ($first_option_set == 0) {
                        //  $examModeified[] = CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                        $first_option_set = 1;
                    }
                    $examModeified[] = CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($ExamName), true);

                    $count++;
                }
            }

            if ($count == 0) {
                // $examModeified[] = CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                $examModeified[] = CHtml::tag('option', array('value' => '', 'disabled' => 'disabled'), 'No Exams', true);
            }
        }

        echo CJSON::encode(array(
            'status' => $status,
            'examDetails' => $examModeified
        ));
    }

    public function actiongetPaperForTakeIds() {
        $numCount = 0;
        if (isset($_POST['student_email']) && $_POST['exam_id']) {
            $data_user = Yii::app()->db->createCommand()
                    ->select('user_id')
                    ->from('user')
                    ->where('email=:email', array(':email' => $_POST['student_email']))
                    ->queryScalar();


            $data_student = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $data_user))
                    ->queryScalar();
            $exam_model = new Exam;
            $exam_model = Exam::model()->findByPk($_POST['exam_id']);
            $take_ids = Take::model()->getTakeIdsforExamIdandStudentId($_POST['exam_id'], $data_student);
            if ($exam_model->exam_type == "ESSAY") {

                echo '<table class="table" id="paper_questions">';
                foreach ($take_ids as $take) {
                    echo '<tr>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td><b>Take Id: ' . $take['take_id'] . '</b></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Question number</td><td>Question Id</td><td>Marked</td><td>Time Taken</td><td>Marks(%)</td>';
                    echo '</tr>';
                    $question_results = PaperQuestion::model()->getQuestionsOfExamByTakeId($take['take_id']);
                    foreach ($question_results as $question_paper) {
                        //$essay_answer = EssayAnswer::model()->getDetailsOfQuestion($take['take_id'], $question_paper['question_id']);
                        echo '<tr>';
                        echo '<td>' . $question_paper['question_number'] . '</td>';
                        echo '<td>' . $question_paper['question_id'] . '</td>';


                        //  echo '<td>' . $paper['answer_id'] . '</td>';
                        echo '<td>' . EssayAnswer::model()->getStatus($take['take_id'], $question_paper['question_id']) . '</td>';
                        echo '<td>' . $question_paper['time_taken'] . '</td>';
                        echo '<td>' . round(EssayAnswer::model()->getMarkForTheQuestion($take['take_id'], $question_paper['question_id']),2) . '</td>';
                        echo '</tr>';
                    }
                }

                echo '</table>';
            } else {
                echo '<table class="table" id="paper_questions">';

                foreach ($take_ids as $take) {
                    $question_results = FinalResult::model()->getFinalResultById($take['take_id']);
                    $numCount = 0;
                    foreach ($question_results as $question_paper) {
                        $paper_info = PaperQuestion::model()->getPaperInfoColumns($question_paper['take_id'], $question_paper['question_id']);

                        if (!empty($paper_info)) {
                            foreach ($paper_info as $paper) {
                                if ($numCount == 0) {
                                    echo '<tr>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<td><b>Take Id: ' . $take['take_id'] . '</b></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<td>Question No</td><td>Question Id</td><td>Question Part</td><td>Answer</td><td>Marked</td><td>Time Taken(min)</td><td>Marks</td>';
                                    echo '</tr>';
                                    echo '<tr></tr>';
                                }

                                $numCount++;

                                echo '<tr>';
                                echo '<td>' . $paper['question_number'] . '</td>';
                                echo '<td>' . $paper['question_id'] . '</td>';
                                echo '<td>' . QuestionPart::model()->getQuestionPartText($paper['question_part_id']) . '</td>';
                                //  echo '<td>' . $paper['answer_id'] . '</td>';
                                $qtype = Question::model()->getQuestionTypeByQuestionId($paper['question_id']);
                                if ($qtype == 'SHORT_WRITTEN') {
                                    echo '<td>' . $paper['answer_id'] . '</td>';
                                } else {
                                    $ans_text_id = Answer::model()->getAnswertextIdByAnswerID($paper['answer_id']);
                                    $answer_text = AnswerText::model()->getAnswerTextById($ans_text_id);
                                    echo '<td>' . $answer_text . '</td>';
                                }

                                //  echo '<td>' . $paper['answer_id'] . '</td>';
                                echo '<td>' . $paper['question_marked'] . '</td>';

                                $mins = $paper['time_taken'] / 60;
                                $secs = $paper['time_taken'] % 60;
                                $roundmins = round($mins);

                                if ($secs > 30) {
                                    $roundmins = $roundmins - 1;
                                }
//                                echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';


                                echo '<td>' . $roundmins . '</td>';
                                echo '<td>' . round($question_paper['mark'],2) . '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                }
                echo '</table>';
            }
        }
    }

}
