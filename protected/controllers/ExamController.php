<?php

class ExamController extends Controller {

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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'takeExam', 'startExam', 'cal', 'notLoggedinViewExam', 'viewDetailsForNotLoggedin',
                    'ViewEachAvailabelExam', 'testPurchase', 'endExam', 'viewExamSummary', 'ConvertCurrency',
                    'ViewNextQuestions', 'ViewPreviousQuestions', 'viewDropdownQuestions', 'viewTimer', 'examStatus', 'destroySession',
                    'viewUnansweredQuestions', 'viewMarkedQuestions', 'viewQuestion', 'viewExamSummaryNotLoggedIn', 'loadCourseLevels',
                    'examView', 'examError', 'setFlagedQuestion', 'startEssayExam', 'viewNextEssayQuestion', 'viewPreviousEssayQuestions',
                    'viewStartEssayQuestion', 'essayExamStatus', 'viewEssayUnansweredQuestions', 'getSession','Ajax','GetCourses',
                    'viewEssayQuestion', 'viewEssayMarkedQuestions', 'endEssayExam', 'viewDropdownEssayQuestions', 'viewExamSumm', 'questionExhibit', 'questionReference'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'viewexam', 'viewDetails'),
                'users' => array('@'),
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
        $model = new Exam;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Exam'])) {
            $model->attributes = $_POST['Exam'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->exam_id));
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

        if (isset($_POST['Exam'])) {
            $model->attributes = $_POST['Exam'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->exam_id));
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
        $dataProvider = new CActiveDataProvider('Exam');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Exam('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Exam']))
            $model->attributes = $_GET['Exam'];

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
        $model = Exam::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'exam-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionviewexam() {
        $this->render('viewexam', array('courseModel' => Course::model()->findAll(), 'courseLevelModel' => $this->loadCourseLevels()));
//        $this->render('not_available_exam');
    }

    public function loadCourseLevels() {

        $courses = Course::model()->findAll();
        $course_levels = array();
        if ($courses === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        foreach ($courses as $course) {
            $course_levels[$course->course_id] = Level::model()->getLevelsForCourseWithID($course->course_id);
        }
        return $course_levels;
    }

    public function actionLoadCourseLevels() {
        $course_id = Yii::app()->request->getPost('course_id', -1);
        $data = Level::model()->getLevelsForCourseWithID($course_id);
        $levels = CHtml::listData($data, 'level_id', 'level_name');

        echo "<option value=''>Select Level</option>";
        foreach ($levels as $value => $level) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($level), true);
        }
    }

    public function actionViewEachAvailabelExam() {


//        if (isset($_REQUEST['courseID'])) {
//            $viewexam_courseID = $_REQUEST['courseID'];
//            // echo $viewexam_courseID;die;
//        }
//
//        if (isset($_REQUEST['levelID'])) {
//            $viewexam_levelID = $_REQUEST['levelID'];
//
//        }

        if (isset($_REQUEST['viewexam_coursename'])) {
            $viewexam_course = $_REQUEST['viewexam_coursename'];
// echo $viewexam_course;die;
        }
//        Yii::app()->session['userViewDetails'] =array();
//        var_dump(Yii::app()->session['userViewDetails'] );die;
//         if (empty(Yii::app()->session['userViewDetails'])) {
//             
//            $userViewDetail = array(
//                'viewExam_courseID'=>$viewexam_courseID,
//                'viewExam_levelID'=>$viewexam_levelID,
//                'viewExam_course'=>$viewexam_course,
//            );
//            Yii::app()->session['userViewDetails'] = $userViewDetail;
//        }else{
//            
//        } 
//                var_dump(Yii::app()->session['userViewDetails'] );die;


        if (isset($_REQUEST['viewexam_subject'])) {
            $viewexam_subject = $_REQUEST['viewexam_subject'];
        }

        if (isset($_REQUEST['viewexam_examtitle'])) {
            $viewexam_examtitle = $_REQUEST['viewexam_examtitle'];
        }

        if (isset($_REQUEST['viewexam_examtype'])) {
            $viewexam_examtype = $_REQUEST['viewexam_examtype'];
        }

        if (isset($_REQUEST['viewexam_description'])) {
            $viewexam_description = $_REQUEST['viewexam_description'];
        }

        if (isset($_REQUEST['viewexam_examprice'])) {
            $viewexam_examprice = $_REQUEST['viewexam_examprice'];
        }

        if (isset($_REQUEST['viewexam_examtime'])) {
            $viewexam_examtime = $_REQUEST['viewexam_examtime'];
        }

        if (isset($_REQUEST['viewexam_image'])) {
            $viewexam_examimage = $_REQUEST['viewexam_image'];
        }

        if (isset($_REQUEST['viewexam_exam_id'])) {
            $viewexam_exam_id = $_REQUEST['viewexam_exam_id'];
        }

        $this->renderPartial('view_each_available_exam', array('courseModel' => Course::model()->findAll(),
            'courseLevelModel' => $this->loadCourseLevels(),
            'viewexam_coursename' => $viewexam_course,
            'viewexam_subject' => $viewexam_subject,
            'viewexam_exam_id' => $viewexam_exam_id,
            'viewexam_examtitle' => $viewexam_examtitle,
            'viewexam_examtype' => $viewexam_examtype,
            'viewexam_description' => $viewexam_description,
            'viewexam_examprice' => $viewexam_examprice,
            'viewexam_image' => $viewexam_examimage,
            'viewexam_examtime' => $viewexam_examtime), false, true);
    }

    public function actionViewDetails() {

        $levelid = $_POST['levelId'];
// $courseID = $_POST['courseID'];

        $data = Exam::model()->getSubjectsForLevelId($levelid);

        $coursename = Exam::model()->getCourseNameFromLevelID($levelid);

        echo $this->renderPartial('viewexamnew', array('id' => $levelid, 'courseName' => $coursename), false, true);
    }

    public function actionTakeExam() {
        $exam_id = $_POST['exam_id'];


        $redirect_url = "";

        $exam_details = Exam::model()->getExamDetails($exam_id);

        $starting_date = $_POST['starting_date'];
        $expiry_date = $_POST['expiry_date'];
        $examType = $_POST['exam_type'];

        $status = "fail";

        if ($examType != 'SAMPLE') {

            if ($starting_date != "N/A" || $expiry_date != "N/A") {
                $current_date = strtotime(date('m/d/Y'));

                if ($current_date >= strtotime($starting_date) && $current_date <= strtotime($expiry_date)) {
                    $status = "success";
                }
            } else {
                $status = "success";
            }
        } else {
            $status = "success";
        }




        if ($status == "success") {
            if ($exam_details['exam_type'] == "PRESET" || $exam_details['exam_type'] == "SAMPLE") {
                $exam_questions = Exam::model()->getQuestionsOfExamById($exam_id);
            } else if ($exam_details['exam_type'] == "DYNAMIC") {
                $exam_questions = Exam::model()->getQuestionsOfDynamicExamById($exam_id);
            } else if ($exam_details['exam_type'] == "ESSAY") {
                $exam_questions = Exam::model()->getQuestionsOfExamById($exam_id);
            }


            $exam_question_session = array();

            $count = 1;

            foreach ($exam_questions as $exam_question) {
                $exam_question_session[] = array(
                    "question_number" => $count,
                    "question_id" => $exam_question['question_id'],
                    "time_taken" => 0,
                    "answer_id" => null,
                    "flag" => 0,
                    "answer_correct" => null,
                    "exam_ID" => $exam_id
                );
                $count++;
            }
            $exam_question_session[0]['current_question'] = 9;
            Yii::app()->session['exam_question_session'] = $exam_question_session;

            if ($exam_details['exam_type'] == "ESSAY") {
                $redirect_url = CController::createUrl('exam/startEssayExam', array('id' => $exam_id));
            } else {
                $redirect_url = CController::createUrl('exam/startExam', array('id' => $exam_id));
            }


            //add to taken_exam_log
            $examTakenLog = new ExamTakenLog();
            $examTakenLog->exam_id = $exam_id;
            $examTakenLog->user_id = (Yii::app()->user) ? Yii::app()->user->getId() : null;
//            $examTakenLog->timestamp = date("h:i:sa");
            $examTakenLog->save();
        }

        echo CJSON::encode(array(
            'status' => $status,
            'redirect_url' => $redirect_url
        ));
    }

    public function actionViewNextQuestions() {

        $question_number = $_POST['question_number_count'];
        $time = '';
        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($question_number);

        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {
                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }


        $exam_question = $this->renderpartial('exam_questions', array('question_number' => $question_number), true, false);
//print_r($_POST['question_count_key']);
        // $session = Yii::app()->session['exam_question_session'];

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }

        $flag_value = 0;
        if ($_POST['question_count_key'] >= -1) {
            $flag_value = isset($session[$_POST['question_count_key'] + 1]['flag']) ? $session[$_POST['question_count_key'] + 1]['flag'] : 0;
        }
        $question_type = Question::model()->getQuestionType($question_id);

        Yii::app()->session['exam_question_session'] = $session;

//comments
        echo CJSON::encode(array(
            'next_question_number' => $question_number + 1,
            'previous_question_number_count' => $question_number - 1,
            'flag_value' => $flag_value,
            'exam_questions' => $exam_question,
            'no_of_questions' => sizeof($session),
            'question_type' => $question_type,
                //'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionQuestionExhibit() {
        $qId = $_POST['question_id'];
        $session_q = $_POST['question_session'];
        $qout = $this->renderPartial('question_exhibit', array('questionID' => $session_q[$qId]['question_id']), true, false);

        $questions = $this->renderPartial('question_exhibit', array('questionID' => $session_q[$qId]['question_id']), TRUE, FALSE);


        $status = 'success';
        echo CJSON::encode(array(
            'status' => $status,
            'qID' => $session_q[$qId]['question_id'],
            'qoutput' => $questions,
                //'answeroutput' => $answeroutput,
        ));
    }

    public function actionQuestionReference() {
        $qId = $_POST['question_id'];
        $session_q = $_POST['question_session'];
        $questions = $this->renderPartial('reference_materials', array('questionID' => $session_q[$qId]['question_id']), TRUE, FALSE);


        $status = 'success';
        echo CJSON::encode(array(
            'status' => $status,
            'qID' => $session_q[$qId]['question_id'],
            'qoutput' => $questions,
        ));
    }

    public function actionViewStartEssayQuestion() {

        $question_number = $_POST['question_number_count'];

        //$time = '';
        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($question_number);
        $answer = "";

        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($question_id);
        $question_details = EssayQuestion::model()->getDetailsByQuestionId($question_id);
        if ($essayType == "NORMAL") {
            $exam_question = $this->renderpartial('_essay_normal_questions', array('question_number' => $question_number), true, false);
        } else {
            $exam_question = $this->renderpartial('_essay_email_questions', array('question_number' => $question_number), true, false);
        }

        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {
                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }
        $flag_value = 0;
        if ($_POST['question_count_key'] > -1) {

            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;

            if (isset($session[$question_number - 1]['answer_id'])) {

                if ($session[$question_number - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$question_number - 1]['answer_id'];
                }
            }
        } else {
            if (isset($session[$question_number - 1]['answer_id'])) {

                if ($session[$question_number - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$question_number - 1]['answer_id'];
                }
            }
        }
        $session[0]['current_question'] = $question_id;
        Yii::app()->session['exam_question_session'] = $session;

        echo CJSON::encode(array(
            'next_question_number' => $question_number + 1,
            'previous_question_number_count' => $question_number - 1,
            'flag_value' => $flag_value,
            'answer' => $answer,
            'exam_questions' => $exam_question,
            'question_id' => $question_id,
            'no_of_questions' => sizeof($session),
            // 'reference_material' => $question_details['reference_material'],
            //'question_type' => $question_type,
            'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionViewNextEssayQuestion() {

        $question_number = $_POST['question_number_count'];

        $time = '';
        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($question_number);
        $answer = "";

        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($question_id);
        $session[0]['current_question'] = $question_id;
        $question_details = EssayQuestion::model()->getDetailsByQuestionId($question_id);
        if ($essayType == "NORMAL") {
            $exam_question = $this->renderpartial('_essay_normal_questions', array('question_number' => $question_number), true, false);
        } else {
            $exam_question = $this->renderpartial('_essay_email_questions', array('question_number' => $question_number), true, false);
        }

        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {
                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }
        $flag_value = 0;
        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;

            if (isset($session[$question_number - 1]['answer_id'])) {

                if ($session[$question_number - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$question_number - 1]['answer_id'];
                }
            }
        } else {
            if (isset($session[$question_number - 1]['answer_id'])) {

                if ($session[$question_number - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$question_number - 1]['answer_id'];
                }
            }
        }

        $unansweredQuestions = 0;
        foreach ($session as $data) {
            if ($data['answer_id'] == "") {
                $unansweredQuestions++;
            }
        }

        Yii::app()->session['exam_question_session'] = $session;

        echo CJSON::encode(array(
            'next_question_number' => $question_number + 1,
            'previous_question_number_count' => $question_number - 1,
            'flag_value' => $flag_value,
            'answer' => $answer,
            'exam_questions' => $exam_question,
            'no_of_questions' => sizeof($session),
            'unanswered' => $unansweredQuestions,
            // 'reference_material' => $question_details['reference_material'],
            //'question_type' => $question_type,
            'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionGetSession() {

//        var_dump( Yii::app()->session['exam_question_session']);die;

        echo CJSON::encode(array(
            'session' => Yii::app()->session['exam_question_session'],
        ));
    }

    public function actionViewPreviousQuestions() {
        $previous_question_number = $_POST['previous_question_number_count'];

        $exam_question = $this->renderpartial('exam_questions', array('question_number' => $previous_question_number), true, false);

        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($previous_question_number);


        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {

                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }

        $flag_value = 0;
        if ($_POST['question_count_key'] > 0) {
            $flag_value = $session[$_POST['question_count_key'] - 1]['flag'];
        }
        $question_type = Question::model()->getQuestionType($question_id);

        Yii::app()->session['exam_question_session'] = $session;

        $exam_question = $this->renderpartial('exam_questions', array('question_number' => $previous_question_number), true, false);

        echo CJSON::encode(array(
            'next_question_number' => $previous_question_number + 1,
            'previous_question_number_count' => $previous_question_number - 1,
            'flag_value' => $flag_value,
            'exam_questions' => $exam_question,
            'no_of_questions' => sizeof($session),
            'question_type' => $question_type,
                //'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionViewPreviousEssayQuestions() {
        $previous_question_number = $_POST['previous_question_number_count'];

        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($previous_question_number);
        $answer = "";
        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($question_id);
        $session[0]['current_question'] = $question_id;
        $question_details = EssayQuestion::model()->getDetailsByQuestionId($question_id);
        if ($essayType == "NORMAL") {
            $exam_question = $this->renderpartial('_essay_normal_questions', array('question_number' => $previous_question_number), true, false);
        } else {
            $exam_question = $this->renderpartial('_essay_email_questions', array('question_number' => $previous_question_number), true, false);
        }

        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {

                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        $flag_value = 0;
        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;

            if (isset($session[$previous_question_number - 1]['answer_id'])) {
                if ($session[$previous_question_number - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$previous_question_number - 1]['answer_id'];
                }
            }
        }

        Yii::app()->session['exam_question_session'] = $session;

        echo CJSON::encode(array(
            'next_question_number' => $previous_question_number + 1,
            'previous_question_number_count' => $previous_question_number - 1,
            'flag_value' => $flag_value,
            'exam_questions' => $exam_question,
            'no_of_questions' => sizeof($session),
            'answer' => $answer,
            //  'reference_material' => $question_details['reference_material'],
            //  'question_type' => $question_type,
            'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionViewDropdownQuestions() {
        $dropdown_question_num = Yii::app()->request->getPost('question_num', -1);

        $exam_question = $this->renderpartial('exam_questions', array('question_number' => $dropdown_question_num), true, false);

        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($dropdown_question_num);

        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {


                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }
        Yii::app()->session['exam_question_session'] = $session;
        $flag_value = $this->getFlagVlaueOfQuestionNo($dropdown_question_num);
        $question_type = Question::model()->getQuestionType($question_id);


        echo CJSON::encode(array(
            'next_question_number' => $dropdown_question_num + 1,
            'previous_question_number_count' => $dropdown_question_num - 1,
            'no_of_questions' => sizeof($session),
            'flag_value' => $flag_value,
            'exam_questions' => $exam_question,
            'question_type' => $question_type,
                //'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionViewDropdownEssayQuestions() {
        $dropdown_question_num = Yii::app()->request->getPost('question_num', -1);
        $session = Yii::app()->session['exam_question_session'];
        $question_id = $this->getIdOfQuestionNo($dropdown_question_num);
        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($question_id);
        $answer = "";
        $question_details = EssayQuestion::model()->getDetailsByQuestionId($question_id);
        if ($essayType == "NORMAL") {
            $exam_question = $this->renderpartial('_essay_normal_questions', array('question_number' => $dropdown_question_num), true, false);
        } else {
            $exam_question = $this->renderpartial('_essay_email_questions', array('question_number' => $dropdown_question_num), true, false);
        }


        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {

                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }


        $flagged = 0;
        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;

            if (isset($session[$dropdown_question_num - 1]['answer_id'])) {

                if ($session[$dropdown_question_num - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$dropdown_question_num - 1]['answer_id'];
                }
            }
        } else {
            if (isset($session[$dropdown_question_num - 1]['answer_id'])) {

                if ($session[$dropdown_question_num - 1]['answer_id'] == null) {
                    $answer = "";
                } else {
                    $answer = $session[$dropdown_question_num - 1]['answer_id'];
                }
            }
        }

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }
        Yii::app()->session['exam_question_session'] = $session;
        $flag_value = $this->getFlagVlaueOfQuestionNo($dropdown_question_num);

        echo CJSON::encode(array(
            'next_question_number' => $dropdown_question_num + 1,
            'previous_question_number_count' => $dropdown_question_num - 1,
            'no_of_questions' => sizeof($session),
            'flag_value' => $flag_value,
            'exam_questions' => $exam_question,
            'answer' => $answer,
            //'reference_material' => $question_details['reference_material'],
            // 'question_type' => $question_type,
            'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function getFlagVlaueOfQuestionNo($question_no) {
        $session = Yii::app()->session['exam_question_session'];
        $flag = 0;
        foreach ($session as $key => $question) {
            if ($question['question_number'] == $question_no) {
                $flag = $question['flag'];
            }
        }
        return $flag;
    }

    public function getIdOfQuestionNo($question_no) {
        $session = Yii::app()->session['exam_question_session'];
        $id = -1;
        foreach ($session as $key => $question) {
            if ($question['question_number'] == $question_no) {
                $id = $question['question_id'];
            }
        }
        return $id;
    }

    public function actionViewUnansweredQuestions() {
        $exam_questions = Yii::app()->session['exam_question_session'];
        $question_array = array();
        foreach ($exam_questions as $exam_question) {
            if ($this->is_element_empty($exam_question['answer_id'])) {
                $question_array[] = array(
                    'id' => $exam_question['question_id'],
                    'number' => $exam_question['question_number']
                );
            }
        }
        $this->renderPartial('_view_question_list', array('question_array' => $question_array,
            'title' => 'Unanswered Questions'), false, true);
    }

    public function actionViewEssayUnansweredQuestions() { 
        
        $exam_questions = Yii::app()->session['exam_question_session'];
        $question_array = array();
        foreach ($exam_questions as $exam_question) {
            if ($this->is_element_empty($exam_question['answer_id'])) {
                $question_array[] = array(
                    'id' => $exam_question['question_id'],
                    'number' => $exam_question['question_number']
                );
            }
        }        
       
        $this->renderPartial('_view_essay_question_list', array('question_array' => $question_array,
            'title' => 'Unanswered Questions'), false, true);
    }

    public function actionViewMarkedQuestions() {
        $exam_questions = Yii::app()->session['exam_question_session'];
        $question_array = array();
        foreach ($exam_questions as $exam_question) {
            if ($exam_question['flag'] !== 0) {
                $question_array[] = array(
                    'id' => $exam_question['question_id'],
                    'number' => $exam_question['question_number']
                );
            }
        }
        $this->renderPartial('_view_question_list', array('question_array' => $question_array,
            'title' => 'Marked Questions'), false, true);
    }

    public function actionViewEssayMarkedQuestions() {
        $exam_questions = Yii::app()->session['exam_question_session'];
        $question_array = array();
        foreach ($exam_questions as $exam_question) {
            if ($exam_question['flag'] !== 0) {
                $question_array[] = array(
                    'id' => $exam_question['question_id'],
                    'number' => $exam_question['question_number']
                );
            }
        }
        $this->renderPartial('_view_essay_question_list', array('question_array' => $question_array,
            'title' => 'Marked Questions'), false, true);
    }

    public function is_element_empty($element) {
        if (is_array($element)) {
            $all_elements_empty = true;
            foreach ($element as $element) {
                if ($element !== "") {
                    $all_elements_empty = false;
                    break;
                }
            }
            return $all_elements_empty;
        } else {
            if ($element === null || $element === '' || $element === 'null' || $element === '<p><br data-mce-bogus="1"></p>') {
                return TRUE;
            } else {
                return false;
            }
        }
    }

    public function actionViewQuestion() {

        $question_id = Yii::app()->request->getPost('question_id', -1);
        $question_num = Yii::app()->request->getPost('question_num', -1);
//        $exam_question = $this->renderPartial('_view_exam_question', array('question_id' => $question_id), true, false);

        $exam_question = $this->renderPartial('exam_questions', array('question_number' => $question_num), true, true);


        $session = Yii::app()->session['exam_question_session'];
        $flag_value = $this->getFlagVlaueOfQuestionNo($question_num);
        $question_type = Question::model()->getQuestionType($question_id);

//        echo $question_type;die;

        echo CJSON::encode(array(
            'next_question_number' => $question_num + 1,
            'previous_question_number_count' => $question_num - 1,
            'no_of_questions' => sizeof($session),
            'flag_value' => $flag_value,
            'exam_question' => $exam_question,
            'question_type' => $question_type,
                //'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionViewEssayQuestion() {

        $question_id = Yii::app()->request->getPost('question_id', -1);
        $question_num = Yii::app()->request->getPost('question_num', -1);

        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($question_id);

        if ($essayType == "NORMAL") {
            $exam_question = $this->renderpartial('_essay_normal_questions', array('question_number' => $question_num), true, false);
        } else {
            $exam_question = $this->renderpartial('_essay_email_questions', array('question_number' => $question_num), true, false);
        }

        $session = Yii::app()->session['exam_question_session'];
        //  $flag_value = $this->getFlagVlaueOfQuestionNo($question_num);
        if (isset($session[$question_num - 1]['answer_id'])) {

            if ($session[$question_num - 1]['answer_id'] == null) {
                $answer = "";
            } else {
                $answer = $session[$question_num - 1]['answer_id'];
            }
        } else {
            $answer = "";
        }

        echo CJSON::encode(array(
            'next_question_number' => $question_num + 1,
            'previous_question_number_count' => $question_num - 1,
            'no_of_questions' => sizeof($session),
            'answer' => $answer,
            'exam_question' => $exam_question,
            // 'question_type' => $question_type,
            'session' => Yii::app()->session['exam_question_session']
        ));
    }

    public function actionStartExam($id) {
        $this->renderPartial('exam_form', array('exam_id' => $id), false, true);
        //window.open("http://www.w3schools.com", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400");
    }

    public function actionStartEssayExam($id) {
        $this->renderPartial('essay_exam_form', array('exam_id' => $id), false, true);
        //window.open("http://www.w3schools.com", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400");
    }

    public function actionCal() {
        $this->render('calculator');
    }

    public function actionNotLoggedinViewExam() {
        $this->render('view_exam_not_loggedin', array('courseModel' => Course::model()->findAll(), 'courseLevelModel' => $this->loadCourseLevels()));
//    $this->render('not_available_exam');
    }

    public function actionViewDetailsForNotLoggedin() {
        $levelid = $_POST['levelId'];

        $data = Exam::model()->getSubjectsForLevelId($levelid);

        $coursename = Exam::model()->getCourseNameFromLevelID($levelid);

        echo $this->renderPartial('viewSamplePapers', array('id' => $levelid, 'courseName' => $coursename), false, true);
    }

    public function actionViewTimer() {
        $this->render('timer');
    }

    public function actionExamStatusRevised() {
        $session = Yii::app()->session['exam_question_session'];
        $exam_id = Yii::app()->request->getPost('exam_id', -1);
//        $exam_status = $this->renderPartial('_exam_status', array('exam_questions' => $session, 'exam_id' => $exam_id),true, false);

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
        }

        Yii::app()->session['exam_question_session'] = $session;

        echo $this->renderPartial('_exam_status_2', array('exam_questions' => $session, 'exam_id' => $exam_id), true, false);
//        echo CJSON::encode(array(
//            'session' => Yii::app()->session['exam_question_session'],
//            'exam_status' => $exam_status
//        ));
    }

    public function actionExamStatus() {
        $session = Yii::app()->session['exam_question_session'];
        $exam_id = Yii::app()->request->getPost('exam_id', -1);

        $time = 0;
        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {


                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else if ($session[$_POST['question_count_key']]['time_taken'] == null) {
                    $time = 0;
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
        }

        $flagged = 0;
        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
                if ($_POST['flag'] == "true") {
                    $flagged = 1;
                }
            }
        }
        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['flag'] = $flagged;
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }

        Yii::app()->session['exam_question_session'] = $session;
        $new_session = Yii::app()->session['exam_question_session'];

        $arrayDataProvider = new CArrayDataProvider($new_session, array(
            'keyField' => 'question_id',
            'sort' => array(
                'attributes' => array(
                    'question_number'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10000,
            ),
        ));

        $unanswered = 0;        
        
        
        foreach ($new_session as $data) {
            if ($data['answer_id'] == "null") {
                $unanswered++;
            }
        }
        
        

        $this->renderPartial('_exam_status', array('question_array' => $arrayDataProvider,
            'exam_id' => $exam_id,
            'title' => 'Review Exam',
            'unanswered' => $unanswered,
            'time_status' => Yii::app()->request->getPost('time_status', Consts::STATUS_TIME_OVER)), false, true);
    }

    //---------------------------------------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------------------------------   







    public function actionEndExam() {


        $user_id = Yii::app()->user->getID();


        if ($user_id != null) {

            $exam_id = $_POST['exam_id'];

            $student_id = Student::model()->getStudentIdForUserId($user_id);

            $exam_questions = Yii::app()->session['exam_question_session'];


            $model_take = new Take;

            $model_take->exam_id = $exam_id;
            $model_take->student_id = $student_id;
            $model_take->date = date("Y/m/d");
            $model_take->total_time = $_POST['total_exam_time'];
            if ($model_take->save()) {
                $take_id = $model_take->getPrimaryKey();

                $question_number = 1;

                foreach ($exam_questions as $exam_question) {
                    $question = Question::model()->getQuestion($exam_question['question_id']);
                    $question_type = $question['question_type'];

                    if ($question_type == "SINGLE_ANSWER") {

                        $model_paper_question = new PaperQuestion;

                        $model_paper_question->take_id = $take_id;
                        $model_paper_question->question_id = $exam_question['question_id'];
                        $model_paper_question->answer_id = $exam_question['answer_id'];
                        $model_paper_question->time_taken = $exam_question['time_taken'];
                        $model_paper_question->question_marked = $exam_question['flag'];
                        $model_paper_question->question_number = $question_number;

                        if ($model_paper_question->save()) {
                            
                        } else {
                            print_r($model_paper_question->errors);
                            die();
                        }

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($correct_answer_id != null) {
                            if ($correct_answer_id[0]['answer_id'] == $exam_question['answer_id']) {
                                if ($exam_details['allow_custom_marks'] == 1) {
                                    $model_final_result->mark = $question['number_of_marks'];
                                } else if ($exam_details['allow_custom_marks'] == 0) {
                                    $model_final_result->mark = $exam_details['marks_per_question'];
                                }
                            } else {
                                if ($exam_details['allow_custom_marks'] == 1) {
                                    if ($exam_details['allow_minus_marks'] == 1) {
                                        $model_final_result->mark = -1;
                                    } else if ($exam_details['allow_minus_marks'] == 0) {
                                        $model_final_result->mark = 0;
                                    }
                                } else if ($exam_details['allow_custom_marks'] == 0) {
                                    $model_final_result->mark = 0;
                                }
                            }
                        } else {
                            $model_final_result->mark = 0;
                        }



                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "MULTIPLE_ANSWER") {
                        $answer_array = $exam_question['answer_id'];


                        $total_marks = 0;
                        if (!empty($answer_array)) {
                            foreach ($answer_array as $answer_id) {
                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->answer_id = $answer_id;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }

                                $is_correct = Answer::model()->getIs_correct($answer_id);

                                if ($is_correct == 1) {
                                    $total_marks++;
                                } else {
                                    $total_marks = 0;
                                }
                            }
                        }

                        $number_of_is_corrects = 0;
                        foreach (Answer::model()->numberOfIs_corrects($exam_question['question_id']) as $corrects) {
                            if ($corrects['is_correct'] == 1) {
                                $number_of_is_corrects++;
                            }
                        }

                        $exam_details = Exam::model()->getExamDetails($exam_id);
                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        if ($total_marks == $number_of_is_corrects) {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "SHORT_WRITTEN") {
                        $answer_array = $exam_question['answer_id'];
                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);
                        $index = 0;
                        $total_correct = 0;
                        $number_of_question_parts = sizeof($question_parts);
                        if (!empty($answer_array)) {
                            foreach ($answer_array as $answer_item) {
                                $question_part_id = $question_parts[$index]['question_part_id'];
                                $model_paper_question = new PaperQuestion;
                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $question_part_id;
                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }
                                $index++;
                                $question_part_answer = Answer::model()->getAnswerOfQuestionPart($question_part_id, $exam_question['question_id']);
                                $question_part_answer_obj = AnswerText::model()->getAnswerText($question_part_answer['answer_text_id']);
                                $question_part_answer_text = $question_part_answer_obj['answer_text'];
                                $question_part_answer_text = strtolower($question_part_answer_text);
                                $answer_item = strtolower($answer_item);
                                if ($question_part_answer_text == $answer_item) {
                                    $total_correct++;
                                }
                            }
                        }
                        $model_final_result = new FinalResult;
                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);
                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($total_correct == $number_of_question_parts) {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }
                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "DRAG_DROP_TYPEA_ANSWER") {

                        $answer_array = $exam_question['answer_id'];

                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $index = 0;

                        $total_correct = 0;
                        $number_of_question_parts = sizeof($question_parts);

                        if (!empty($answer_array)) {

                            foreach ($answer_array as $answer_item) {
                                $question_part_id = $question_parts[$index]['question_part_id'];

                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $question_part_id;
                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;



                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }
                                $index++;

                                $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);


                                foreach ($question_part_answer as $question_part_answer_item) {

                                    if ($question_part_answer_item['is_correct'] == 1) {

                                        $correct_answer_id = $question_part_answer_item['answer_text_id'];
                                    }
                                }

//                        echo $correct_answer_id.':'.$answer_item.'<br/>';

                                if ($correct_answer_id == $answer_item) {
                                    $total_correct++;
                                }
                            }
                        }



                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($total_correct == $number_of_question_parts) {
                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {
                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "DRAG_DROP_TYPEB_ANSWER") {

                        $answer_array = $exam_question['answer_id'];
                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $question_part_count = 0;
                        $total_marks = 0;

                        if (!empty($answer_array)) {
                            foreach (array_chunk($answer_array, 2) as $answer_id) {
                                foreach ($answer_id as $answer) {
                                    $model_paper_question = new PaperQuestion;

                                    $model_paper_question->take_id = $take_id;
                                    $model_paper_question->question_id = $exam_question['question_id'];
                                    $model_paper_question->question_part_id = $question_parts[$question_part_count]['question_part_id'];
                                    $model_paper_question->answer_id = $answer;
                                    $model_paper_question->time_taken = $exam_question['time_taken'];
                                    $model_paper_question->question_marked = $exam_question['flag'];
                                    $model_paper_question->question_number = $question_number;



                                    if ($model_paper_question->save()) {
                                        
                                    } else {
                                        print_r($model_paper_question->errors);
                                        die();
                                    }
                                }
                                $correct_answer_id_array = Answer::model()->getAnswerTextIdFromQuestionPartId($question_parts[$question_part_count]['question_part_id']);

                                foreach ($correct_answer_id_array as $correct_answer_ids) {
                                    if ($correct_answer_ids['answer_text_id'] == $answer_id[0]) {
                                        $total_marks++;
                                    } else if ($correct_answer_ids['answer_text_id'] == $answer_id[1]) {
                                        $total_marks++;
                                    }
                                }
                                $question_part_count++;
                            }
                        }

                        $size_of_question_parts = sizeof($question_parts);
                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        $model_final_result = new FinalResult;
                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];


                        if ($total_marks / 2 == $size_of_question_parts) {
                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {
                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "DRAG_DROP_TYPEC_ANSWER") {
                        $answer_array = $exam_question['answer_id'];

                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $index = 0;

                        $total_correct = 0;
                        $number_of_question_parts = sizeof($question_parts);


                        if (!empty($answer_array)) {

                            foreach ($answer_array as $answer_item) {
                                $question_part_id = $question_parts[$index]['question_part_id'];

                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $question_part_id;
                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }
                                $index++;

                                $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                                foreach ($question_part_answer as $question_part_answer_item) {
                                    if ($question_part_answer_item['is_correct'] == 1) {
                                        $correct_answer_id = $question_part_answer_item['answer_text_id'];
                                    }
                                }

//                            echo $correct_answer_id . ':' . $answer_item . '<br/>';

                                if ($correct_answer_id == $answer_item) {
                                    $total_correct++;
                                }
                            }
                        }

//                    echo 'Final result: ' . $total_correct . '<br/>';

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($total_correct == $number_of_question_parts) {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                $model_final_result->mark = $question['number_of_marks'];
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = $exam_details['marks_per_question'];
                            }
                        } else {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                if ($exam_details['allow_minus_marks'] == 1) {
                                    $model_final_result->mark = -1;
                                } else if ($exam_details['allow_minus_marks'] == 0) {
                                    $model_final_result->mark = 0;
                                }
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = 0;
                            }
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "DRAG_DROP_TYPED_ANSWER") {
                        $answer_array = $exam_question['answer_id'];

                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $quetion_part_id = $question_parts[0]['question_part_id'];

                        $total_correct = 0;

                        if (!empty($answer_array)) {
                            foreach ($answer_array as $answer_item) {
                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $quetion_part_id;

                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = 2;
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }

                                $is_correct = Answer::model()->getIs_correctForDragTypeD($answer_item);

                                if ($is_correct == 1) {
                                    $total_correct++;
                                } else {
                                    $total_correct = 0;
                                }
                            }
                        }

                        $exam_details = Exam::model()->getExamDetails($exam_id);
                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        if ($total_correct == 2) {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "DRAG_DROP_TYPEE_ANSWER") {
                        $answer_array = $exam_question['answer_id'];

                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $index = 0;

                        $total_correct = 0;
                        $number_of_question_parts = sizeof($question_parts);

                        if (!empty($answer_array)) {
                            foreach ($answer_array as $answer_item) {
                                $question_part_id = $question_parts[$index]['question_part_id'];

                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $question_part_id;
                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }
                                $index++;

                                $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                                foreach ($question_part_answer as $question_part_answer_item) {
                                    if ($question_part_answer_item['is_correct'] == 1) {
                                        $correct_answer_id = $question_part_answer_item['answer_id'];
                                    }
                                }

//                            echo $correct_answer_id . ':' . $answer_item . '<br/>';

                                if ($correct_answer_id == $answer_item) {
                                    $total_correct++;
                                }
                            }
                        }

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($total_correct == $number_of_question_parts) {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                $model_final_result->mark = $question['number_of_marks'];
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = $exam_details['marks_per_question'];
                            }
                        } else {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                if ($exam_details['allow_minus_marks'] == 1) {
                                    $model_final_result->mark = -1;
                                } else if ($exam_details['allow_minus_marks'] == 0) {
                                    $model_final_result->mark = 0;
                                }
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = 0;
                            }
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "MULTIPLE_CHOICE_ANSWER") {
                        $answer_array = $exam_question['answer_id'];

                        $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                        $index = 0;

                        $total_correct = 0;
                        $number_of_question_parts = sizeof($question_parts);

                        if (!empty($answer_array)) {
                            foreach ($answer_array as $answer_item) {
                                $question_part_id = $question_parts[$index]['question_part_id'];

                                $model_paper_question = new PaperQuestion;

                                $model_paper_question->take_id = $take_id;
                                $model_paper_question->question_id = $exam_question['question_id'];
                                $model_paper_question->question_part_id = $question_part_id;
                                $model_paper_question->answer_id = $answer_item;
                                $model_paper_question->time_taken = $exam_question['time_taken'];
                                $model_paper_question->question_marked = $exam_question['flag'];
                                $model_paper_question->question_number = $question_number;

                                if ($model_paper_question->save()) {
                                    
                                } else {
                                    print_r($model_paper_question->errors);
                                    die();
                                }
                                $index++;

                                $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                                foreach ($question_part_answer as $question_part_answer_item) {
                                    if ($question_part_answer_item['is_correct'] == 1) {
                                        $correct_answer_id = $question_part_answer_item['answer_id'];
                                    }
                                }

//                        echo $correct_answer_id.':'.$answer_item.'<br/>';

                                if ($correct_answer_id == $answer_item) {
                                    $total_correct++;
                                }
                            }
                        }

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($total_correct == $number_of_question_parts) {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                $model_final_result->mark = $question['number_of_marks'];
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = $exam_details['marks_per_question'];
                            }
                        } else {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                if ($exam_details['allow_minus_marks'] == 1) {
                                    $model_final_result->mark = -1;
                                } else if ($exam_details['allow_minus_marks'] == 0) {
                                    $model_final_result->mark = 0;
                                }
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = 0;
                            }
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "TRUE_OR_FALSE_ANSWER") {
                        $model_paper_question = new PaperQuestion;

                        $model_paper_question->take_id = $take_id;
                        $model_paper_question->question_id = $exam_question['question_id'];
                        $model_paper_question->answer_id = $exam_question['answer_id'];
                        $model_paper_question->time_taken = $exam_question['time_taken'];
                        $model_paper_question->question_marked = $exam_question['flag'];
                        $model_paper_question->question_number = $question_number;

                        if ($model_paper_question->save()) {
                            
                        } else {
                            print_r($model_paper_question->errors);
                            die();
                        }

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                        $exam_details = Exam::model()->getExamDetails($exam_id);

                        if ($correct_answer_id == NULL) {
                            $correct_answer = false;
                        } else {
                            $correct_answer = true;
                        }

                        if ($exam_question['answer_id'] == "0") {
                            $user_answer = false;
                        } else {
                            $user_answer = true;
                        }

                        if ($user_answer == $correct_answer) {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                $model_final_result->mark = $question['number_of_marks'];
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = $exam_details['marks_per_question'];
                            }
                        } else {
                            if ($exam_details['allow_custom_marks'] == 1) {
                                if ($exam_details['allow_minus_marks'] == 1) {
                                    $model_final_result->mark = -1;
                                } else if ($exam_details['allow_minus_marks'] == 0) {
                                    $model_final_result->mark = 0;
                                }
                            } else if ($exam_details['allow_custom_marks'] == 0) {
                                $model_final_result->mark = 0;
                            }
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    } else if ($question_type == "HOT_SPOT_ANSWER") {

                        $model_paper_question = new PaperQuestion;


                        $model_paper_question->take_id = $take_id;
                        $model_paper_question->question_id = $exam_question['question_id'];

                        if (isset($exam_question['answer_id'][0])) {
                            if ($exam_question['answer_id'][0] != null) {
                                $model_paper_question->answer_id = $exam_question['answer_id'][0];
                            }
                        }

                        $model_paper_question->time_taken = $exam_question['time_taken'];
                        $model_paper_question->question_marked = $exam_question['flag'];
                        $model_paper_question->question_number = $question_number;

                        if ($model_paper_question->save()) {
                            
                        } else {
                            print_r($model_paper_question->errors);
                            die();
                        }

                        $model_final_result = new FinalResult;

                        $model_final_result->take_id = $take_id;
                        $model_final_result->question_id = $exam_question['question_id'];
                        $model_final_result->question_number = $question_number;
                        $model_final_result->time_taken = $exam_question['time_taken'];

                        $question_details = Question::model()->getHotspotQuestionsId($exam_question['question_id']);

                        foreach ($question_details as $details) {
                            $coords = $details['coordinates'];
                            $pieces = explode("/", $coords);
                            $answerCount = count($pieces);  //count of answers
                        }

                        $correctAnswerCount = 0;
                        if (isset($exam_question['answer_id'][0])) {
                            $answerhotspot = $exam_question['answer_id'][0];
                            $answerhotspotSplit = explode(",", $answerhotspot);
                            foreach ($answerhotspotSplit as $key => $value) {
                                if (substr($value, 0, 1) == 'C' || substr($value, 1, 1) == 'C') {
                                    $correctAnswerCount++;
                                }
                            }
                        }

                        $exam_details = Exam::model()->getExamDetails($exam_id);
                        if ($answerCount == $correctAnswerCount) {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {

                            $model_final_result->mark = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }

                        if ($model_final_result->save()) {
                            
                        } else {
                            print_r($model_final_result->errors);
                            die();
                        }
                    }

                    $question_number++;
                }
            } else {
                print_r($model_take->errors);
                die();
            }



            $student_exams = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('student_exam')
                    ->where('student_id=:student_id AND exam_id=:exam_id ', array(':student_id' => $student_id, ':exam_id' => $exam_id))
                    ->queryAll();

            if ($student_exams != null) {
                StudentExam::model()->deleteByPk($student_exams[0]['student_exam_id']);
            }

            $model_past_exam = new PastExam;

            $model_past_exam->student_id = $student_id;
            $model_past_exam->exam_id = $exam_id;
            $model_past_exam->take_id = $take_id;

            if ($model_past_exam->save()) {
                
            } else {
                print_r($model_past_exam->errors);
                die();
            }

            $redirect_url = CController::createUrl('exam/viewExamSummary&id=' . $take_id);

            echo CJSON::encode(array(
                'status' => "success",
                'type' => "PRESETNSAMPLE",
                'redirect_url' => $redirect_url
            ));

            // SAMPLE PAPERS FOR NOT LOGGED IN USERS
        } else {

            if (isset($_REQUEST['exam_id'])) {
                $exam_id = $_REQUEST['exam_id'];
            }

            $exam_questions = Yii::app()->session['exam_question_session'];

            $question_number = 1;
            $no_correct_ans = 0;
            $no_incorrect_ans = 0;
            $number_of_ques = 0;
            $score = 0;
            $total_time_taken = 0;
            $mark = Array();

            foreach ($exam_questions as $exam_question) {

                $question = Question::model()->getQuestion($exam_question['question_id']);
                $question_type = $question['question_type'];
                $questionNum[] = $question_number;
                $questionid[] = $exam_question['question_id'];
                //echo $question_type;die;

                if ($question_type == "SINGLE_ANSWER") {
                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($correct_answer_id != null) {

                        $time[] = $exam_question['time_taken'];

                        if ($correct_answer_id[0]['answer_id'] == $exam_question['answer_id']) {
                            $no_correct_ans++;
                            $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        } else {
                            $no_incorrect_ans++;
                            $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                        }
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "MULTIPLE_ANSWER") {

                    $answer_array = $exam_question['answer_id'];

                    //var_dump($exam_question);die;

                    $total_marks = 0;
                    $time[] = $exam_question['time_taken'];

                    if ($answer_array != 'null' && $answer_array != null) {

                        foreach ($answer_array as $answer_id) {

                            $is_correct = Answer::model()->getIs_correct($answer_id);

                            if ($is_correct == 1) {
                                $total_marks++;
                            } else {
                                $total_marks = 0;
                            }
                        }
                    } else {
                        echo 'gkg';
                    }

                    $number_of_is_corrects = 0;
                    foreach (Answer::model()->numberOfIs_corrects($exam_question['question_id']) as $corrects) {
                        if ($corrects['is_correct'] == 1) {
                            $number_of_is_corrects++;
                        }
                    }


                    $exam_details = Exam::model()->getExamDetails($exam_id);


                    if ($total_marks == $number_of_is_corrects) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "SHORT_WRITTEN") {

                    $answer_array = $exam_question['answer_id'];
                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);
                    $index = 0;
                    $total_correct = 0;
                    $number_of_question_parts = sizeof($question_parts);
                    $time[] = $exam_question['time_taken'];

                    if ($answer_array != 'null' && $answer_array != null) {

                        foreach ($answer_array as $answer_item) {

                            $question_part_id = $question_parts[$index]['question_part_id'];

                            $index++;
                            $question_part_answer = Answer::model()->getAnswerOfQuestionPart($question_part_id, $exam_question['question_id']);
                            $question_part_answer_obj = AnswerText::model()->getAnswerText($question_part_answer['answer_text_id']);
                            $question_part_answer_text = $question_part_answer_obj['answer_text'];
                            $question_part_answer_text = strtolower($question_part_answer_text);
                            $answer_item = strtolower($answer_item);
                            if ($question_part_answer_text == $answer_item) {
                                $total_correct++;
                            }
                        }
                    }

                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);
                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_correct == $number_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "DRAG_DROP_TYPEA_ANSWER") {
                    $answer_array = $exam_question['answer_id'];

                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);
                    $index = 0;
                    $total_correct = 0;
                    $number_of_question_parts = sizeof($question_parts);

                    $time[] = $exam_question['time_taken'];

                    if ($answer_array != 'null' && $answer_array != null) {

                        foreach ($answer_array as $answer_item) {

                            $question_part_id = $question_parts[$index]['question_part_id'];

                            $index++;

                            $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                            foreach ($question_part_answer as $question_part_answer_item) {
                                if ($question_part_answer_item['is_correct'] == 1) {
                                    $correct_answer_id = $question_part_answer_item['answer_text_id'];
                                }
                            }

                            if ($correct_answer_id == $answer_item) {
                                $total_correct++;
                            }
                        }
                    }


                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_correct == $number_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    // var_dump($mark);die;

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "DRAG_DROP_TYPEB_ANSWER") {

                    $answer_array = $exam_question['answer_id'];
                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                    $question_part_count = 0;
                    $total_marks = 0;
                    $time[] = $exam_question['time_taken'];


                    if ($answer_array != 'null' && $answer_array != null) {
                        foreach (array_chunk($answer_array, 2) as $answer_id) {
                            $correct_answer_id_array = Answer::model()->getAnswerTextIdFromQuestionPartId($question_parts[$question_part_count]['question_part_id']);

                            foreach ($correct_answer_id_array as $correct_answer_ids) {
                                if ($correct_answer_ids['answer_text_id'] == $answer_id[0]) {
                                    $total_marks++;
                                } else if ($correct_answer_ids['answer_text_id'] == $answer_id[1]) {
                                    $total_marks++;
                                }
                            }
                            $question_part_count++;
                        }
                    }

                    $size_of_question_parts = sizeof($question_parts);
                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_marks / 2 == $size_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "DRAG_DROP_TYPEC_ANSWER") {

                    $answer_array = $exam_question['answer_id'];

                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                    $index = 0;

                    $total_correct = 0;
                    $number_of_question_parts = sizeof($question_parts);
                    $time[] = $exam_question['time_taken'];

                    if ($answer_array != 'null' && $answer_array != null) {
                        foreach ($answer_array as $answer_item) {
                            $question_part_id = $question_parts[$index]['question_part_id'];

                            $index++;

                            $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                            foreach ($question_part_answer as $question_part_answer_item) {
                                if ($question_part_answer_item['is_correct'] == 1) {
                                    $correct_answer_id = $question_part_answer_item['answer_text_id'];
                                }
                            }

//                            echo $correct_answer_id . ':' . $answer_item . '<br/>';

                            if ($correct_answer_id == $answer_item) {
                                $total_correct++;
                            }
                        }
                    }

                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_correct == $number_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "DRAG_DROP_TYPED_ANSWER") {
                    $answer_array = $exam_question['answer_id'];

                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                    $quetion_part_id = $question_parts[0]['question_part_id'];

                    $total_correct = 0;

                    $time[] = $exam_question['time_taken'];

                    if ($answer_array != 'null' && $answer_array != null) {
                        foreach ($answer_array as $answer_item) {
                            $is_correct = Answer::model()->getIs_correctForDragTypeD($answer_item);

                            if ($is_correct == 1) {
                                $total_correct++;
                            } else {
                                $total_correct = 0;
                            }
                        }
                    }

                    $exam_details = Exam::model()->getExamDetails($exam_id);
                    if ($total_correct == 2) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);
                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "DRAG_DROP_TYPEE_ANSWER") {
                    $answer_array = $exam_question['answer_id'];

                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                    $index = 0;

                    $total_correct = 0;
                    $number_of_question_parts = sizeof($question_parts);

                    $time[] = $exam_question['time_taken'];


                    if ($answer_array != 'null' && $answer_array != null) {
                        foreach ($answer_array as $answer_item) {
                            $question_part_id = $question_parts[$index]['question_part_id'];
                            $index++;

                            $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                            foreach ($question_part_answer as $question_part_answer_item) {
                                if ($question_part_answer_item['is_correct'] == 1) {
                                    $correct_answer_id = $question_part_answer_item['answer_id'];
                                }
                            }

                            if ($correct_answer_id == $answer_item) {
                                $total_correct++;
                            }
                        }
                    }

                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_correct == $number_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "MULTIPLE_CHOICE_ANSWER") {
                    $answer_array = $exam_question['answer_id'];

                    $question_parts = QuestionPart::model()->getQuestionPartsOfQuestion($exam_question['question_id']);

                    $index = 0;

                    $total_correct = 0;
                    $number_of_question_parts = sizeof($question_parts);
                    $time[] = $exam_question['time_taken'];
                    $correct_answer_id = 0;

                    if ($answer_array != 'null' && $answer_array != null) {
                        foreach ($answer_array as $answer_item) {
                            $question_part_id = $question_parts[$index]['question_part_id'];
                            $index++;

                            $question_part_answer = Answer::model()->getAnswersOfQuestionPart($question_part_id, $exam_question['question_id']);

                            foreach ($question_part_answer as $question_part_answer_item) {
                                if ($question_part_answer_item['is_correct'] == 1) {
                                    $correct_answer_id = $question_part_answer_item['answer_id'];
                                }
                            }

                            if ($correct_answer_id == $answer_item) {
                                $total_correct++;
                            }
                        }
                    }

                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);

                    if ($total_correct == $number_of_question_parts) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }
                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "TRUE_OR_FALSE_ANSWER") {

                    $correct_answer_id = Answer::model()->getCorrectAnswersOfQuestion($exam_question['question_id']);

                    $exam_details = Exam::model()->getExamDetails($exam_id);
                    $time[] = $exam_question['time_taken'];

                    if ($correct_answer_id == NULL) {
                        $correct_answer = false;
                    } else {
                        $correct_answer = true;
                    }

                    if ($exam_question['answer_id'] == "0") {
                        $user_answer = false;
                    } else {
                        $user_answer = true;
                    }

                    if ($user_answer == $correct_answer) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else if ($question_type == "HOT_SPOT_ANSWER") {
                    $question_details = Question::model()->getHotspotQuestionsId($exam_question['question_id']);
                    $time[] = $exam_question['time_taken'];
                    foreach ($question_details as $details) {
                        $coords = $details['coordinates'];
                        $pieces = explode("/", $coords);
                        $answerCount = count($pieces);  //count of answers
                    }

                    $answerhotspot = isset($exam_question['answer_id'][0]) ? $exam_question['answer_id'][0] : "";

                    $answerhotspotSplit = explode(",", $answerhotspot);
                    $correctAnswerCount = 0;
                    foreach ($answerhotspotSplit as $key => $value) {
                        if (substr($value, 0, 1) == 'C' || substr($value, 1, 1) == 'C') {
                            $correctAnswerCount++;
                        }
                    }

                    $exam_details = Exam::model()->getExamDetails($exam_id);
                    if ($answerCount == $correctAnswerCount) {
                        $no_correct_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(TRUE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    } else {
                        $no_incorrect_ans++;
                        $mark[] = Question::model()->getMarksOfQuestion(FALSE, $exam_details['allow_custom_marks'], $question['number_of_marks'], $exam_details['marks_per_question'], $exam_details['allow_minus_marks']);
                    }

                    $score = Exam::model()->getScoreForNotLoggedIn($exam_id, $exam_question['question_id'], $mark);

                    $number_of_ques = sizeof($questionNum);
                } else {
                    echo 'This is not a question type. Sorry!!!';
                    die;
                }
            }


//            foreach ($time as $eachTime) {
//                $total_time_taken += $eachTime;
//            }
            $total_time_taken = $_POST['timer'];

            $this->render('exam_summary_not_logged_in', array(
                'examID' => $exam_id,
                'score' => $score,
                'numberOfQuestions' => $number_of_ques,
                'noOfCorrectAns' => $no_correct_ans,
                'noOfIncorrectAns' => $no_incorrect_ans,
                'totalTimeTaken' => $total_time_taken,
                'mark' => $mark,
                'questionid' => $questionid,
                    ), false, true);
        }
    }

//    public function actionViewExamSumm($examID,) {
//        $this->render('exam_summary_not_logged_in', array(
//            'examID' => $exam_id,
//            'score' => $score,
//            'numberOfQuestions' => $number_of_ques,
//            'noOfCorrectAns' => $no_correct_ans,
//            'noOfIncorrectAns' => $no_incorrect_ans,
//            'totalTimeTaken' => $total_time_taken,
//            'mark' => $mark,
//            'questionid' => $questionid,
//        ));
//    }

    public function actionViewExamSummary($id) {
        $this->render('exam_summary', array(
            "take_id" => $id
        ));
    }

    public function actionConvertCurrency() {

        $examPrice = $_POST['price'];
        $currency = $_POST['currency'];
        $examid = $_POST['examid'];


        if ($currency == 'LKR') {
            $url = "http://www.google.com/finance/converter?a=$examPrice&from=GBP&to=LKR";
            $data = file_get_contents($url);
            preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
            $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
            echo round($converted, 2);
        } else if ($currency == 'USD') {
            $url = "http://www.google.com/finance/converter?a=$examPrice&from=GBP&to=USD";
            $data = file_get_contents($url);
            preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
            $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
            echo round($converted, 2);
        } else {

            $static_price = Exam::model()->getExamPrice($examid);

            echo $static_price;
        }
    }

    function actionExamView() {
        
    }

    public function actionExamError() {
        $this->render("errorpageforexam");
    }

    public function actionDestroySession() {
        $session_name = $_POST['session_name'];
        Yii::app()->session[$session_name] = array();
    }

    public function actionSetFlagedQuestion() {
        $session = Yii::app()->session['exam_question_session'];

        $flagged = 0;
        if (isset($_POST['flag']) || isset($session[$_POST['question_count_key']]['flag'])) {
            if ($_POST['flag'] == "true") {
                $flagged = 1;
            }
        }

        if ($_POST['question_count_key'] > -1) {
            $session[$_POST['question_count_key']]['flag'] = $flagged;
        }


        Yii::app()->session['exam_question_session'] = $session;
    }

    public function actionEssayExamStatus() {
        $session = Yii::app()->session['exam_question_session'];
        $exam_id = Yii::app()->request->getPost('exam_id', -1);

        $time = 0;
        if ($_POST['question_count_key'] > -1) {
            if (isset($_POST['timetaken']) || isset($session[$_POST['question_count_key']]['time_taken'])) {


                if ($session[$_POST['question_count_key']]['time_taken'] == 0) {
                    $time = $_POST['timetaken'];
                } else if ($session[$_POST['question_count_key']]['time_taken'] == null) {
                    $time = 0;
                } else {
                    $time = $session[$_POST['question_count_key']]['time_taken'] + $_POST['timetaken'];
                }
            }
            $session[$_POST['question_count_key']]['answer_id'] = $_POST['answer_id'];
            $session[$_POST['question_count_key']]['time_taken'] = $time;
        }


        Yii::app()->session['exam_question_session'] = $session;
        $new_session = Yii::app()->session['exam_question_session'];

        $arrayDataProvider = new CArrayDataProvider($new_session, array(
            'keyField' => 'question_id',
            'sort' => array(
                'attributes' => array(
                    'question_number'
                ),
            ),
            'pagination' => array(
                'pageSize' => 10000,
            ),
        ));

        $unanswered = 0;
        foreach ($new_session as $data) {
            if ($data['answer_id'] === '<p><br data-mce-bogus="1"></p>' || $data['answer_id']=== null) {
                $unanswered++;
            }
        }


        $this->renderPartial('_exam_status_essay', array('question_array' => $arrayDataProvider,
            'exam_id' => $exam_id,
            'title' => 'Review Exam',
            'unanswered' => $unanswered,
            'time_status' => Yii::app()->request->getPost('time_status', Consts::STATUS_TIME_OVER)), false, true);
    }

    public function actionEndEssayExam() {


        $user_id = Yii::app()->user->getID();
        $redirect_url = "N/A";

        if ($user_id != null) {

            $exam_id = $_POST['exam_id'];

            $student_id = Student::model()->getStudentIdForUserId($user_id);

            $exam_questions = Yii::app()->session['exam_question_session'];


            $model_take = new Take;

            $model_take->exam_id = $exam_id;
            $model_take->student_id = $student_id;
            $model_take->date = date("Y/m/d");
            $model_take->total_time = $_POST['total_exam_time'];
            if ($model_take->save()) {
                $take_id = $model_take->getPrimaryKey();
                foreach ($exam_questions as $exam_question) {
                    $model_paper_question = new PaperQuestion;
                    $model_paper_question->take_id = $take_id;
                    $model_paper_question->question_id = $exam_question['question_id'];
                    if (Util::is_element_empty($exam_question['answer_id'])) {
                        $model_paper_question->answer_id = "";
                    } else {
                        $model_paper_question->answer_id = $exam_question['answer_id'];
                    }
                    $model_paper_question->time_taken = $exam_question['time_taken'];
                    $model_paper_question->question_number = $exam_question['question_number'];
                    if ($model_paper_question->save()) {
                        
                    } else {
                        print_r($model_paper_question->errors);
                        die();
                    }
                    $section_no = ExamQuestion::model()->getSectionNo($exam_id, $exam_question['question_id']);
                    $model_essay_answer = new EssayAnswer;
                    $model_essay_answer->exam_id = $exam_id;
                    $model_essay_answer->student_id = $student_id;
                    $model_essay_answer->section_no = $section_no;
                    $model_essay_answer->status = 0;
                    $model_essay_answer->take_id = $take_id;
                    $model_essay_answer->question_id = $exam_question['question_id'];
                    if ($model_essay_answer->save()) {
                        
                    } else {
                        print_r($model_essay_answer->errors);
                        die();
                    }
                }


                $student_exams = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('student_exam')
                        ->where('student_id=:student_id AND exam_id=:exam_id ', array(':student_id' => $student_id, ':exam_id' => $exam_id))
                        ->queryAll();

                if ($student_exams != null) {
                    StudentExam::model()->deleteByPk($student_exams[0]['student_exam_id']);
                }

                $model_past_exam = new PastExam;

                $model_past_exam->student_id = $student_id;
                $model_past_exam->exam_id = $exam_id;
                $model_past_exam->take_id = $take_id;

                if ($model_past_exam->save()) {
                    
                } else {
                    print_r($model_past_exam->errors);
                    die();
                }

                $redirect_url = CController::createUrl('exam/viewExamSummary&id=' . $take_id);
            } else {
                print_r($model_take->errors);
                die();
            }
        }

        echo CJSON::encode(array(
            'status' => "success",
            'type' => "ESSAY",
            'redirect_url' => $redirect_url
        ));
    }
    public function actionAjax()
    {
        if (isset($_POST['data'])) {
            $course_id =$_POST['data'];
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('level')
                ->where('course_id=:course_id', array(':course_id' => $course_id))
                ->queryAll();
            $myJSON=json_encode($data);

            echo($myJSON);

        }else
            echo"dddd";
    }

    public function actionGetCourses()
    {
        if (isset($_POST['data'])) {
            $level_id =$_POST['data'];
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject')
                ->where('level_id=:level_id', array(':level_id' => $level_id))
                ->queryAll();
            $myJSON=json_encode($data);

            echo($myJSON);

        }else
            echo"Error";
    }
}
