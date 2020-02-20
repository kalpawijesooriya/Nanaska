<?php

class ExamController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column2';
    public $content;

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
                'actions' => array('index', 'view', 'create', 'update', 'validateEssayExam', 'validate', 'addQuestionToExam', 'addQuestionToEssayExam', 'getViews',
                    'getViewByType', 'suspend', 'reactivate', 'saveExhibitData', 'saveExam', 'removeQuestionFromExam',
                    'getExamsByType', 'getExams', 'getDynamicExams', 'renderBlank', 'getFinalQuestionSelector', 'admin',
                    'getExamsForStudent', 'getExamSummary', 'getTakes', 'setExamImage', 'saveExamImage', 'ConvertCurrency', 'getEssayQuestionByArea',
                    'removeQuestionFromEssayExam', 'saveEssayExam', 'setExamInstruction', 'savePreseenMaterials', 'saveExamInstructions', 'editExamInstruction', 'renderDialogBoc', 'exportToExcel', 'getEssayExams', 'setAttachments',
                    'uploadAttachments', 'setPreseen', 'updateTablesData', 'saveTablesFormulae', 'setTables', 'clearSession',
                    'updateTables', 'saveAttachments', 'setExhibit', 'removeAttachments', 'exportExamSheetToPDF', 'exportExamSheetToPDFUsingTCPDF', 'GetExamSummaryForResultsManagement','export'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
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

        $subjectAreas = Yii::app()->session['subject_area_session'];

        $dbtransaction = Yii::app()->db->beginTransaction();

        if (isset($_POST['Exam'])) {
            echo "create";
            die();

            $subject_id = $_POST['subject_id'];
            $model->subject_id = $subject_id;



            $calculator_allowed = $_POST['calculator_allowed'];

            if ($calculator_allowed == "1") {
                $model->calculator_allowed = 1;
            } else {
                $model->calculator_allowed = 0;
            }

            $exam_type = $_POST['exam_type'];
            $model->exam_type = $exam_type;


            $model->attributes = $_POST['Exam'];

            try {

                if ($model->save()) {

                    if (!empty($subjectAreas)) {

                        $exam_id = $model->getPrimaryKey();

                        foreach ($subjectAreas as $subjectArea) {
                            $model_exam_subject_area = new ExamSubjectArea;
                            $model_exam_subject_area->exam_id = $exam_id;


                            $model_exam_subject_area->subject_area_id = $subjectArea['subject_area_id'];

                            $model_exam_subject_area->weightage = floatval($subjectArea['subject_area_weight']);
                            $model_exam_subject_area->single_answer_weightage = floatval($subjectArea['single_answer_question_weight']);
                            $model_exam_subject_area->multiple_answer_weightage = floatval($subjectArea['multiple_answer_question_weight']);
                            $model_exam_subject_area->short_written_answer_weightage = floatval($subjectArea['short_written_answer_question_weight']);
                            $model_exam_subject_area->drag_drop_typea_answer_weightage = floatval($subjectArea['drag_drop_typea_answer_question_weight']);
                            $model_exam_subject_area->drag_drop_typeb_answer_weightage = floatval($subjectArea['drag_drop_typeb_answer_question_weight']);
                            $model_exam_subject_area->drag_drop_typec_answer_weightage = floatval($subjectArea['drag_drop_typec_answer_question_weight']);
                            $model_exam_subject_area->drag_drop_typed_answer_weightage = floatval($subjectArea['drag_drop_typed_answer_question_weight']);
                            $model_exam_subject_area->drag_drop_typee_answer_weightage = floatval($subjectArea['drag_drop_typee_answer_question_weight']);
                            $model_exam_subject_area->multiple_choice_answer_weightage = floatval($subjectArea['multiple_choice_answer_question_weight']);
                            $model_exam_subject_area->true_or_false_answer_weightage = floatval($subjectArea['true_or_false_answer_question_weight']);
                            $model_exam_subject_area->hotspot_answer_weightage = floatval($subjectArea['hotspot_answer_question_weight']);


                            if ($model_exam_subject_area->save()) {
                                
                            } else {
                                // print_r($model_exam_subject_area->errors);
                                throw new Exception();
                            }
                        }
                        $dbtransaction->commit();
                        Yii::app()->session['subject_area_session'] = Array();
                    }

                    $this->redirect(array('view', 'id' => $model->exam_id));
                } else {
                    // print_r($model->errors);
                    die;
                }
            } catch (Exception $e) {
                // print_r($e);
                $dbtransaction->rollback();
            }
        } else {
            Yii::app()->session['subject_area_session'] = Array();
            Yii::app()->session['question_session'] = Array();
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

        Yii::app()->session['question_session'] = Array();
        Yii::app()->session['subject_area_session'] = Array();

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
//            $this->loadModel($id)->delete();

            $examSubjectAreaIds = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('exam_subject_area')
                    ->where('exam_id=:exam_id', array(':exam_id' => $id))
                    ->queryAll();

            foreach ($examSubjectAreaIds as $examSubjectAreaId) {
                ExamSubjectArea::model()->deleteByPk($examSubjectAreaId['exam_subject_area_id']);
            }


            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

//    public function actionDelete($id) {
//        if (Yii::app()->request->isPostRequest) {
//            // we only allow deletion via POST request
//            //$this->loadModel($id)->delete();
//
//            $subLecIds = Yii::app()->db->createCommand()
//                    ->select('*')
//                    ->from('subject_lecturer')
//                    ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $id))
//                    ->queryAll();
//
//            foreach ($subLecIds as $subLecId) {
//                SubjectLecturer::model()->deleteByPk($subLecId['subject_lecturer_id']);
//            }
//
//            $lec = Lecturer::model()->findByPk($id);
//            $user_id = $lec->user_id;
//
//            $this->loadModel($id)->delete();
//            User::model()->deleteByPk($user_id);
//
//
//            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if (!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        } else
//            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
//    }

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
        if (isset($_GET['Exam'])) {

            $model->attributes = $_GET['Exam'];
        }

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

    public function actionValidate() {

        $errorInputs = Array();
        $redirect_url = "N/A";
        $message = Array();
        $typeErrorInputs = Array();

        $course_id = $_POST['course_id'];
        $level_id = $_POST['level_id'];
        $subject_id = $_POST['subject_id'];
        $exam_name = $_POST['exam_name'];
        $exam_description = $_POST['exam_description'];
        $number_of_questions = $_POST['number_of_questions'];
        $exam_type = $_POST['exam_type'];
        $time = $_POST['time'];
        $calculator_allowed = $_POST['cal_yes'];

        $exam_price = $_POST['exam_price'];

        $marks_per_question = $_POST['marks_per_question'];
        $enable_custom_marks = $_POST['enable_custom_marks'];
        $enable_minus_marks = $_POST['enable_minus_marks'];

        //get table formula data
//        $tab_count = $_POST['tab_count'];
//        for ($i = 1; $i <= $tab_count; $i++) {
//            if (isset($_POST["tab_title_$i"])) {
//                $tab_title[$i] = $_POST["tab_title_$i"];
//            } else {
//                $tab_title[$i] = null;
//            }
//            if (isset($_POST["table_formula_$i"])) {
//                $table_formula[$i] = $_POST["table_formula_$i"];
//            } else {
//                $table_formula[$i] = null;
//            }
//        }

        if (isset($_POST['allow_view_marked_questions'])) {
            $allow_view_marked_questions = $_POST['allow_view_marked_questions'];
//            echo $allow_view_marked_questions;
        } else {
//            echo 'no';die();
            $allow_view_marked_questions = 0;
        }


        if (isset($_POST['allow_goto_question'])) {
            $allow_goto_question = $_POST['allow_goto_question'];
        } else {
            $allow_goto_question = 0;
        }

        if (isset($_POST['allow_view_unanswered_questions'])) {
            $allow_view_unanswered_questions = $_POST['allow_view_unanswered_questions'];
        } else {
            $allow_view_unanswered_questions = 0;
        }

        $pass_mark = $_POST['pass_mark'];
        $expiry_duration = $_POST['expiry_duration'];

        $time_temp = ($time == (int) $time) ? (int) $time : (float) $time;
        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                isset($_POST['exam_name']) &&
                isset($_POST['exam_description']) &&
                isset($_POST['number_of_questions']) &&
                isset($_POST['exam_type']) &&
                isset($_POST['time']) &&
                isset($_POST['cal_yes']) &&
                isset($_POST['exam_price']) &&
                isset($_POST['pass_mark']) &&
                isset($_POST['expiry_duration']) &&
                $_POST ['course_id'] != null &&
                $_POST['level_id'] != null &&
                $_POST['subject_id'] != null &&
                $_POST['exam_name'] != null &&
                $_POST['exam_description'] != null &&
                $_POST['number_of_questions'] != null &&
                $_POST['exam_type'] != null &&
                $_POST['time'] != null &&
                $_POST['cal_yes'] != null &&
                $_POST['exam_price'] != null &&
                $_POST['pass_mark'] != null &&
                $_POST['expiry_duration'] != null &&
                $number_of_questions > 0 &&
                $time > 0 &&
                $exam_price > 0 &&
                $_POST['pass_mark'] > 0 &&
                $_POST['expiry_duration'] > 0 &&
                !strpos($time, ".") &&
                is_int($time_temp)) {

            $status = "success";
        } else {
            $status = "fail";

            $message[] = "Please enter all the values before proceeding";

            if ($_POST['course_id'] == null) {
                $errorInputs[] = "course_id";
            }
            if ($_POST['level_id'] == null) {
                $errorInputs[] = "level_id";
            }
            if ($_POST['subject_id'] == null) {
                $errorInputs[] = "subject_id";
            }
            if ($_POST['exam_name'] == null) {
                $errorInputs[] = "exam_name";
            }
            if ($_POST['exam_description'] == null) {
                $errorInputs[] = "exam_description";
            }
            //echo intval($number_of_questions); die;
            if ($_POST['number_of_questions'] == null || $number_of_questions <= 0) {
                $errorInputs[] = "number_of_questions";
                if ($number_of_questions <= 0) {
                    $message[] = "Number of questions cannot be zero!";
                }
            }
            if ($_POST['exam_type'] == null) {
                $errorInputs[] = "exam_type";
            }
            if ($_POST['time'] == null || $time <= 0) {
                $errorInputs[] = "time";
                if ($time <= 0) {
                    $message[] = "Time cannot be zero!";
                }
            }
            if ($_POST['exam_price'] == null || $exam_price <= 0) {
                $errorInputs[] = "exam_price";
                if ($exam_price <= 0) {
                    $message[] = "Exam price cannot be zero!";
                }
            }
            if ($_POST['pass_mark'] == null || $_POST['pass_mark'] <= 0) {
                $errorInputs[] = "pass_mark";
                if ($_POST['pass_mark'] <= 0) {
                    $message[] = "Pass mark cannot be zero!";
                }
            }
            if ($_POST['expiry_duration'] == null || $_POST['expiry_duration'] <= 0) {
                $errorInputs[] = "expiry_duration";
                if ($_POST['expiry_duration'] <= 0) {
                    $message[] = "Expiry duration cannot be zero!";
                }
            }

            if ($enable_custom_marks != "true") {
                if ($_POST['marks_per_question'] == null || $_POST['marks_per_question'] <= 0) {
                    $errorInputs[] = "marks_per_question";
                    if ($_POST['marks_per_question'] <= 0) {
                        $message[] = "Marks per question cannot be zero!";
                    }
                }
            }
            if (strpos($time, ".") || !is_int($time_temp)) {
                $errorInputs[] = "time";
                $message[] = "Time should be in minutes";
            }
        }


        $exams = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();

        if ($exam_type == "DYNAMIC") {
            foreach ($exams as $exam) {
                if ($exam['subject_id'] == $subject_id && $exam['exam_type'] == "DYNAMIC") {
                    $status = "fail";
                    $message[] = "A Dynamic Exam for the Selected Subject Already Exists!";
                    break;
                }
            }
        }


        $subjectAreas = Yii::app()->session['subject_area_session'];

        // var_dump(Yii::app()->session);die;

        $questions = Yii::app()->session['question_session'];

        if ($exam_type == "PRESET" || $exam_type == "SAMPLE") {
            if ($number_of_questions != sizeof($questions)) {
                $status = "fail";
                $message[] = "The number of questions that you have added does not match the number of questions specified";
            }
        }

        if ($exam_type == "DYNAMIC") {
            if (empty($subjectAreas)) {
                $status = "fail";
                $message[] = "You must add at least one Subject Area weightage before proceeding";
            } else {
                $totalWeightage = 0;
                foreach ($subjectAreas as $subjectArea) {
                    $totalWeightage = $totalWeightage + $subjectArea['subject_area_weight'];
                }
                if ($totalWeightage != 100) {
                    $status = "fail";
                    $message[] = "The subject area weightage total should be equal to 100";
                }
            }
        } else if ($exam_type == "SAMPLE" || $exam_type == "PRESET") {
            if (empty($questions)) {
                $status = "fail";
                $message[] = "You must add at least one question before proceeding";
            }
        }

        if (!is_numeric($number_of_questions)) {
            $typeErrorInputs[] = "number_of_questions";
        }
        if (!is_numeric($time)) {
            $typeErrorInputs[] = "time";
        }
        if (!is_numeric($exam_price)) {
            $typeErrorInputs[] = "exam_price";
        }
        if (!is_numeric($pass_mark)) {
            $typeErrorInputs[] = "pass_mark";
        }
        if (!is_numeric($expiry_duration)) {
            $typeErrorInputs[] = "expiry_duration";
        }
        if ($enable_custom_marks != "true") {
            if (!is_numeric($marks_per_question)) {
                $typeErrorInputs[] = "marks_per_question";
            }
        }

        if (!empty($typeErrorInputs)) {
            $status = "fail";
            $message[] = "These should contain only numeric characters";
        }

//        if ($exam_type == "SAMPLE" || $exam_type == "PRESET") {
//            $status = "success";
//        }



        if ($status == "success") {


            $model = new Exam;

            $dbtransaction = Yii::app()->db->beginTransaction();

            $model->subject_id = $subject_id;


            if ($calculator_allowed == "true") {
                $cal = 1;
            } else {
                $cal = 0;
            }

            $model->calculator_allowed = $cal;
            $model->exam_type = $exam_type;
            $model->exam_name = $exam_name;
            $model->exam_description = $exam_description;
            $model->number_of_questions = $number_of_questions;
            $model->time = $time;
            $model->exam_price = $exam_price;
            $model->pass_mark = $pass_mark;
            $model->expiry_duration = $expiry_duration;

            if ($enable_custom_marks == "true") {
                $model->marks_per_question = 0;
            } else {
                $model->marks_per_question = $marks_per_question;
            }

            if ($enable_custom_marks == "true") {
                $model->allow_custom_marks = 1;
                if ($enable_minus_marks == "true") {
                    $model->allow_minus_marks = 1;
                } else if ($enable_minus_marks == "false") {
                    $model->allow_minus_marks = 0;
                }
            } else if ($enable_custom_marks == "false") {
                $model->allow_custom_marks = 0;
                $model->allow_minus_marks = 0;
            }

            if ($allow_view_marked_questions == "true") {
                $model->allow_view_marked_questions = 1;
            } else if ($allow_view_marked_questions == "false") {
                $model->allow_view_marked_questions = 0;
            }

            if ($allow_goto_question == "true") {
                $model->allow_goto_question = 1;
            } else if ($allow_goto_question == "false") {
                $model->allow_goto_question = 0;
            }

            if ($allow_view_unanswered_questions == "true") {
                $model->allow_view_unanswered_questions = 1;
            } else if ($allow_view_unanswered_questions == "false") {
                $model->allow_view_unanswered_questions = 0;
            }








            try {
                if ($status == "success") {
                    if ($model->save()) {
                        $exam_id = $model->getPrimaryKey();
                        if ($exam_type == "DYNAMIC") {
                            if (!empty($subjectAreas)) {

                                $exam_id = $model->getPrimaryKey();

                                foreach ($subjectAreas as $subjectArea) {
                                    $model_exam_subject_area = new ExamSubjectArea;
                                    $model_exam_subject_area->exam_id = $exam_id;


                                    $model_exam_subject_area->subject_area_id = $subjectArea['subject_area_id'];

                                    $model_exam_subject_area->weightage = floatval($subjectArea['subject_area_weight']);
                                    $model_exam_subject_area->single_answer_weightage = floatval($subjectArea['single_answer_question_weight']);
                                    $model_exam_subject_area->multiple_answer_weightage = floatval($subjectArea['multiple_answer_question_weight']);
                                    $model_exam_subject_area->short_written_answer_weightage = floatval($subjectArea['short_written_answer_question_weight']);
                                    $model_exam_subject_area->drag_drop_typea_answer_weightage = floatval($subjectArea['drag_drop_typea_answer_question_weight']);
                                    $model_exam_subject_area->drag_drop_typeb_answer_weightage = floatval($subjectArea['drag_drop_typeb_answer_question_weight']);
                                    $model_exam_subject_area->drag_drop_typec_answer_weightage = floatval($subjectArea['drag_drop_typec_answer_question_weight']);
                                    $model_exam_subject_area->drag_drop_typed_answer_weightage = floatval($subjectArea['drag_drop_typed_answer_question_weight']);
                                    $model_exam_subject_area->drag_drop_typee_answer_weightage = floatval($subjectArea['drag_drop_typee_answer_question_weight']);
                                    $model_exam_subject_area->multiple_choice_answer_weightage = floatval($subjectArea['multiple_choice_answer_question_weight']);
                                    $model_exam_subject_area->true_or_false_answer_weightage = floatval($subjectArea['true_or_false_answer_question_weight']);
                                    $model_exam_subject_area->hotspot_answer_weightage = floatval($subjectArea['hotspot_answer_question_weight']);


                                    if ($model_exam_subject_area->save()) {
                                        
                                    } else {
                                        //print_r($model_exam_subject_area->errors);
                                        throw new Exception();
                                    }
                                }
                                $dbtransaction->commit();
                                Yii::app()->session['subject_area_session'] = Array();
                            }
                            $message[] = "Exam Saved";
                            $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
                        } else if ($exam_type == "SAMPLE" || $exam_type == "PRESET") {
                            if (!empty($questions)) {

                                $exam_id = $model->getPrimaryKey();

                                foreach ($questions as $questionID) {
                                    $model_exam_question = new ExamQuestion;
                                    $model_exam_question->exam_id = $exam_id;

                                    $model_exam_question->question_id = $questionID;



                                    if ($model_exam_question->save()) {
                                        
                                    } else {
                                        print_r($model_exam_question->errors);
                                        throw new Exception();
                                    }
                                }
                                $dbtransaction->commit();
                                Yii::app()->session['question_session'] = Array();
                            }
                            $message[] = "Exam Saved";
                            $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
                        }

                        //save table formulae data
//                        for ($i = 1; $i <= $tab_count; $i++) {
//                            if (isset($tab_title[$i]) && isset($table_formula[$i])) {
//                                if ($tab_title[$i] != null) {
//                                    if ($table_formula[$i] != null) {
//                                        $model_exam_tables_and_formulae = new ExamTablesAndFormulae;
//
//                                        $model_exam_tables_and_formulae->exam_id = $exam_id;
//                                        $model_exam_tables_and_formulae->tables_and_formulae_text = $table_formula[$i];
//                                        $model_exam_tables_and_formulae->tab_position = $i;
//
//                                        if ($model_exam_tables_and_formulae->save()) {
//                                            $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
//                                            $model_exam_tables_and_formulae_tab_title = new ExamTablesAndFormulaeTabTitle;
//
//                                            $model_exam_tables_and_formulae_tab_title->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
//                                            $model_exam_tables_and_formulae_tab_title->tab_title = $tab_title[$i];
//
//                                            if ($model_exam_tables_and_formulae_tab_title->save()) {
//                                                
//                                            } else {
//                                                print_r($model_exam_tables_and_formulae_tab_title->errors);
//                                                die();
//                                            }
//                                        } else {
//                                            print_r($model_exam_tables_and_formulae[$i]->errors);
//                                            die();
//                                        }
//                                    }
//                                }
//                            }
//                        }

                        $user_id = Yii::app()->user->id;

                        $model_exam_audit = new Audit;
                        $model_exam_audit->user_id = $user_id;
                        $model_exam_audit->action_id = $exam_id;
                        $model_exam_audit->action_name = "EXAM_MANAGEMENT";
                        $model_exam_audit->action = 'SAVE';
                        $model_exam_audit->date = date("Y/m/d");
                        $model_exam_audit->time = date("h:i:sa");
                        $model_exam_audit->status = 1;

                        if ($model_exam_audit->save()) {
                            
                        } else {
                            print_r($model_exam_audit->errors);
                        }
                    } else {
                        print_r($model->errors);
                    }
                }
            } catch (Exception $e) {
                print_r($e);
                $dbtransaction->rollback();
            }
        }




        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message,
            $typeErrorInputs
        ));
    }

    public function actionAddQuestionToExam() {
        $question_id = $_POST['question_id'];

        $question_session = Yii::app()->session['question_session'];

        $warning = 0;

        if ($question_id == null) {
            $status = "fail";
            $message = "Select a question before proceeding";
        } else {
            if ($question_session == null) {
                $question_session = array();
                $question_session[] = $question_id;

                $status = "success";
                $message = "Question Added";
            } else {
                $item_found = false;

                foreach ($question_session as $item) {
                    if ($item == $question_id) {
                        $item_found = true;
                    }
                }
                if ($item_found) {
                    $status = "fail";
                    $message = "Question Already Exists!";
                } else {
                    $question_session[] = $question_id;

                    $status = "success";
                    $message = "Question Added";
                }
            }
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('exam_question')
                    ->where('question_id=:question_id', array(':question_id' => $question_id))
                    ->queryAll();

            if (!empty($data)) {
                $warning = 1;
            }
        }
//        print_r($question_session);

        Yii::app()->session['question_session'] = $question_session;

        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message,
            'question_id' => $question_id,
            'warning' => $warning
        ));
    }

    public function actionGetFinalQuestionSelector() {
        //  Yii::app()->clientScript->scriptMap = array('jquery.js' => false, 'jquery-ui.min.js' => false, 'jquery.min.js' => false);
        $subject_id = $_POST['subject_id'];
        $subject_area_id = $_POST['subject_area_id'];
        $question_type = $_POST['question_type'];

        $qarray = $_POST['selected_id'];

        $decodeQArray = json_decode($qarray, true);      

        $exam_questions = array();        
        
        $question_session = Yii::app()->session['question_session'];
            foreach ($question_session as $qID) {
                $exam_questions[] = array("question_id" => $qID);
            }

//        if ($decodeQArray != null) {
//            foreach ($decodeQArray as $qID) {
//                $exam_questions[] = array("question_id" => $qID);
//            }
//            
//        } else {
//            $question_session = Yii::app()->session['question_session'];
//            foreach ($question_session as $qID) {
//                $exam_questions[] = array("question_id" => $qID);
//            }
//        }




        $this->renderPartial('_finalQuestionSelector', array('subject_id' => $subject_id, 'subject_area_id' => $subject_area_id, 'question_type' => $question_type, 'exam_questions' => $exam_questions), false, true);
    }

    public function actionRenderBlank() {
        $output = $this->renderPartial('_blank_form', "", false, true);

        echo CJSON::encode(array(
            // 'status' => $status,
            'output' => $output,
                //'answeroutput' => $answeroutput,
        ));
    }

    public function actionRenderDialogBoc() {
        $questionId = $_POST['question_id'];

        $questions = $this->renderPartial('_viewQuestionDialog', array('question_id' => $questionId), TRUE, FALSE);
        $status = 'success';
        echo CJSON::encode(array(
            array(
                'status' => $status,
                'qoutput' => $questions
            ),
        ));
    }

    public function actionGetEssayQuestionByArea() {
        //print_r($_POST['subject_area_id']); die;
        $status = array();
        $subject_area = $_POST['subject_area'];
        $questions = Question::model()->getQuestionsBySubjectAreaAndQuestionType($subject_area, 'ESSAY_ANSWER');
        foreach ($questions as $q) {
            $Qstatus = Question::model()->checkQuestionStatus($q);
            if ($Qstatus != 0) {
                $status[] = CHtml::tag('option', array('value' => $q), CHtml::encode($q), true);
            }
        }
        //$status[]='<option value="476">476</option>';
        echo CJSON::encode(array(
            'status' => $status
        ));
    }

    public function actionGetViewByType() {
        $exam_type = $_POST['exam_type'];
        $numberOfSubjectAreas = $_POST['numberOfSubjectAreas'];
        $subject_id = $_POST['subject_id'];


        if ($exam_type == "PRESET" || $exam_type == "SAMPLE") {
            $this->renderPartial('_questionSelector', array('subject_id' => $subject_id, 'exam_questions' => null), false, true);
        } else if ($exam_type == "DYNAMIC") {
            $process = false;
            for ($count = 1; $count <= $numberOfSubjectAreas; $count++) {
                $process = ($count == 9) ? true : false;
                $this->renderPartial('_weightageForm', array(
                    'count' => $count,
                    'numberOfSubjectAreas' => $numberOfSubjectAreas,
                    'subject_id' => $subject_id,
                    'exam_id' => null,
                    'exam_subject_area' => null), false, $process);
            }
        } else if ($exam_type == "ESSAY") {
            //echo 'xxxxxxx';die;
            Yii::app()->session['question_session'] = Array();
            Yii::app()->session['question_session_section'] = Array();
            $this->renderPartial('_essayExamInfo', array('subject_id' => $subject_id, 'exam_questions' => null), false, true);
        }
    }

    public function actionSuspend() {
        $exam_id = $_POST['exam_id'];
        $model = Exam::model()->findByPk($exam_id);

        $model->status = 0;

//        if ($model->save()) {
//            $status="success";
//        } else {
//            print_r($model->errors);die();
//        }

        Exam::model()->updateByPk($exam_id, array(
            'status' => 0
        ));

        $status = "success";

        echo CJSON::encode(array(
            'status' => $status
        ));
    }

    public function actionReactivate() {
        $exam_id = $_POST['exam_id'];
        $model = Exam::model()->findByPk($exam_id);

        $model->status = 1;

//        if ($model->save()) {
//            $status = "success";
//        } else {
//            print_r($model->errors);
//            die();
//        }
        Exam::model()->updateByPk($exam_id, array(
            'status' => 1
        ));

        $status = "success";

        echo CJSON::encode(array(
            'status' => $status
        ));
    }

    public function actionSaveExam() {
        $errorInputs = Array();
        $redirect_url = "N/A";
        $message = Array();
        $typeErrorInputs = Array();

        $exam_id = $_POST['exam_id'];


        $course_id = $_POST['course_id'];
        $level_id = $_POST['level_id'];
        $subject_id = $_POST['subject_id'];
        $exam_name = $_POST['exam_name'];
        $exam_description = $_POST['exam_description'];
        $number_of_questions = $_POST['number_of_questions'];
        $exam_type = $_POST['exam_type'];
        $time = $_POST['time'];
        $calculator_allowed = $_POST['cal_yes'];
        $exam_price = $_POST['exam_price'];
        $marks_per_question = $_POST['marks_per_question'];

        $enable_custom_marks = $_POST['enable_custom_marks'];

        $enable_minus_marks = $_POST['enable_minus_marks'];


        //get table and formulae data
//        $tab_count = $_POST['tab_count'];
//        for ($i = 1; $i <= $tab_count; $i++) {
//            if (isset($_POST["tab_title_$i"])) {
//                $tab_title[$i] = $_POST["tab_title_$i"];
//            } else {
//                $tab_title[$i] = null;
//            }
//            if (isset($_POST["table_formula_$i"])) {
//                $table_formula[$i] = $_POST["table_formula_$i"];
//            } else {
//                $table_formula[$i] = null;
//            }
//        }


        if (isset($_POST['allow_view_marked_questions'])) {
            $allow_view_marked_questions = $_POST['allow_view_marked_questions'];
//            echo $allow_view_marked_questions;
        } else {
//            echo 'no';die();
            $allow_view_marked_questions = 0;
        }


        if (isset($_POST['allow_goto_question'])) {
            $allow_goto_question = $_POST['allow_goto_question'];
        } else {
            $allow_goto_question = 0;
        }

        if (isset($_POST['allow_view_unanswered_questions'])) {
            $allow_view_unanswered_questions = $_POST['allow_view_unanswered_questions'];
        } else {
            $allow_view_unanswered_questions = 0;
        }

        $pass_mark = $_POST['pass_mark'];
        $expiry_duration = $_POST['expiry_duration'];
        $time_temp = ($time == (int) $time) ? (int) $time : (float) $time;
        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                isset($_POST['exam_name']) &&
                isset($_POST['exam_description']) &&
                isset($_POST['number_of_questions']) &&
                isset($_POST['exam_type']) &&
                isset($_POST['time']) &&
                isset($_POST['cal_yes']) &&
                isset($_POST['exam_price']) &&
                isset($_POST['pass_mark']) &&
                isset($_POST['expiry_duration']) &&
                $_POST ['course_id'] != null &&
                $_POST['level_id'] != null &&
                $_POST['subject_id'] != null &&
                $_POST['exam_name'] != null &&
                $_POST['exam_description'] != null &&
                $_POST['number_of_questions'] != null &&
                $_POST['exam_type'] != null &&
                $_POST['time'] != null &&
                $_POST['cal_yes'] != null &&
                $_POST['exam_price'] != null &&
                $_POST['pass_mark'] != null &&
                $_POST['expiry_duration'] != null &&
                $number_of_questions > 0 &&
                $time > 0 &&
                $exam_price > 0 &&
                $_POST['pass_mark'] > 0 &&
                $_POST['expiry_duration'] > 0 &&
                !strpos($time, ".") &&
                is_int($time_temp)) {

            $status = "success";
        } else {
            $status = "fail";

            $message[] = "Please enter all the values before proceeding";

            if ($_POST['course_id'] == null) {
                $errorInputs[] = "course_id";
            }
            if ($_POST['level_id'] == null) {
                $errorInputs[] = "level_id";
            }
            if ($_POST['subject_id'] == null) {
                $errorInputs[] = "subject_id";
            }
            if ($_POST['exam_name'] == null) {
                $errorInputs[] = "exam_name";
            }
            if ($_POST['exam_description'] == null) {
                $errorInputs[] = "exam_description";
            }
            if ($_POST['number_of_questions'] == null) {
                $errorInputs[] = "number_of_questions";
            }
            if ($_POST['exam_type'] == null) {
                $errorInputs[] = "exam_type";
            }
            if ($_POST['time'] == null || $time <= 0) {
                $errorInputs[] = "time";
            }
            if ($_POST['exam_price'] == null || $exam_price <= 0) {
                $errorInputs[] = "exam_price";
            }
            if ($_POST['pass_mark'] == null || $_POST['pass_mark'] <= 0) {
                $errorInputs[] = "pass_mark";
            }
            if ($_POST['expiry_duration'] == null || $_POST['expiry_duration'] <= 0) {
                $errorInputs[] = "expiry_duration";
            }

            if ($enable_custom_marks != "true") {
                if ($_POST['marks_per_question'] == null || $_POST['marks_per_question'] <= 0) {
                    $errorInputs[] = "marks_per_question";
                }
            }
            if (strpos($time, ".") || !is_int($time_temp)) {
                $errorInputs[] = "time";
                $message[] = "Time should be in minutes";
            }
        }

        $questions = Yii::app()->session['question_session'];

        if ($exam_type == "DYNAMIC") {
            $subjectAreas = Yii::app()->session['subject_area_session'];



            if (empty($subjectAreas)) {
                $status = "fail";
                $message[] = "You must add at least one Subject Area weightage before proceeding";
            } else {

                $totalWeightage = 0;
                foreach ($subjectAreas as $subjectArea) {
                    $totalWeightage = $totalWeightage + $subjectArea['subject_area_weight'];
                }
                if ($totalWeightage != 100) {
                    $status = "fail";
                    $message[] = "The subject area weightage total should be equal to 100";
                }
            }
        } else if ($exam_type == "PRESET" || $exam_type == "SAMPLE") {
            //echo sizeof($questions);die();
            if ($number_of_questions != sizeof($questions)) {
//                echo 'no';die();
                $status = "fail";

//                echo sizeof($questions);die();
                $message[] = "The number of questions that you have added does not match the number of questions specified";
            }
        }


        if (!is_numeric($number_of_questions)) {
            $typeErrorInputs[] = "number_of_questions";
        }
        if (!is_numeric($time)) {
            $typeErrorInputs[] = "time";
        }
        if (!is_numeric($exam_price)) {
            $typeErrorInputs[] = "exam_price";
        }

        if (!is_numeric($pass_mark)) {
            $typeErrorInputs[] = "pass_mark";
        }
        if (!is_numeric($expiry_duration)) {
            $typeErrorInputs[] = "expiry_duration";
        }

        if ($enable_custom_marks != "true") {
            if (!is_numeric($marks_per_question)) {
                $typeErrorInputs[] = "marks_per_question";
            }
        }

        if (!empty($typeErrorInputs)) {
            $status = "fail";
            $message[] = "These should contain only numeric characters";
        }
//
//        if ($exam_type == "SAMPLE" || $exam_type == "PRESET") {
//            $status = "success";
//        }


        $exams = Yii::app()->db->createCommand()
                ->select('*')
                ->from('exam')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();


        if ($exam_type == "DYNAMIC") {
            foreach ($exams as $exam) {
                if ($exam_id != $exam['exam_id']) {
                    if ($exam['subject_id'] == $subject_id && $exam['exam_type'] == "DYNAMIC") {
                        $status = "fail";
                        $message[] = "A Dynamic Exam for the Selected Subject Already Exists!";
                        break;
                    }
                }
            }
        }



        if ($status == "success") {


            $model = Exam::model()->findByPk($exam_id);
//            print_r($model);die();

            $dbtransaction = Yii::app()->db->beginTransaction();

            $model->subject_id = $subject_id;


            if ($calculator_allowed == "true") {
                $cal = 1;
            } else {
                $cal = 0;
            }

            $model->calculator_allowed = $cal;
            $model->exam_type = $exam_type;
            $model->exam_name = $exam_name;
            $model->exam_description = $exam_description;
            $model->number_of_questions = $number_of_questions;
            $model->time = $time;
            $model->exam_price = $exam_price;
            $model->pass_mark = $pass_mark;
            $model->expiry_duration = $expiry_duration;

            if ($enable_custom_marks == "true") {
                $model->marks_per_question = 0;
            } else {
                $model->marks_per_question = $marks_per_question;
            }

            if ($enable_custom_marks == "true") {
                $model->allow_custom_marks = 1;
                if ($enable_minus_marks == "true") {
                    $model->allow_minus_marks = 1;
                } else if ($enable_minus_marks == "false") {
                    $model->allow_minus_marks = 0;
                }
            } else if ($enable_custom_marks == "false") {
                $model->allow_custom_marks = 0;
                $model->allow_minus_marks = 0;
            }

            if ($allow_view_marked_questions == "true") {
                $model->allow_view_marked_questions = 1;
            } else if ($allow_view_marked_questions == "false") {
                $model->allow_view_marked_questions = 0;
            }

            if ($allow_goto_question == "true") {
                $model->allow_goto_question = 1;
            } else if ($allow_goto_question == "false") {
                $model->allow_goto_question = 0;
            }

            if ($allow_view_unanswered_questions == "true") {
                $model->allow_view_unanswered_questions = 1;
            } else if ($allow_view_unanswered_questions == "false") {
                $model->allow_view_unanswered_questions = 0;
            }

            try {

                if ($model->save()) {
                    $exam_id = $model->getPrimaryKey();

                    if ($exam_type == "DYNAMIC") {
                        if (!empty($subjectAreas)) {

                            $exam_id = $model->getPrimaryKey();

                            $examSubjectAreaIds = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('exam_subject_area')
                                    ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                                    ->queryAll();

                            foreach ($examSubjectAreaIds as $examSubjectAreaId) {
                                ExamSubjectArea::model()->deleteByPk($examSubjectAreaId['exam_subject_area_id']);
                            }

                            foreach ($subjectAreas as $subjectArea) {
                                $model_exam_subject_area = new ExamSubjectArea;
                                $model_exam_subject_area->exam_id = $exam_id;


                                $model_exam_subject_area->subject_area_id = $subjectArea['subject_area_id'];

                                $model_exam_subject_area->weightage = floatval($subjectArea['subject_area_weight']);
                                $model_exam_subject_area->single_answer_weightage = floatval($subjectArea['single_answer_question_weight']);
                                $model_exam_subject_area->multiple_answer_weightage = floatval($subjectArea['multiple_answer_question_weight']);
                                $model_exam_subject_area->short_written_answer_weightage = floatval($subjectArea['short_written_answer_question_weight']);
                                $model_exam_subject_area->drag_drop_typea_answer_weightage = floatval($subjectArea['drag_drop_typea_answer_question_weight']);
                                $model_exam_subject_area->drag_drop_typeb_answer_weightage = floatval($subjectArea['drag_drop_typeb_answer_question_weight']);
                                $model_exam_subject_area->drag_drop_typec_answer_weightage = floatval($subjectArea['drag_drop_typec_answer_question_weight']);
                                $model_exam_subject_area->drag_drop_typed_answer_weightage = floatval($subjectArea['drag_drop_typed_answer_question_weight']);
                                $model_exam_subject_area->drag_drop_typee_answer_weightage = floatval($subjectArea['drag_drop_typee_answer_question_weight']);
                                $model_exam_subject_area->multiple_choice_answer_weightage = floatval($subjectArea['multiple_choice_answer_question_weight']);
                                $model_exam_subject_area->true_or_false_answer_weightage = floatval($subjectArea['true_or_false_answer_question_weight']);
                                $model_exam_subject_area->hotspot_answer_weightage = floatval($subjectArea['hotspot_answer_question_weight']);


                                if ($model_exam_subject_area->save()) {
                                    
                                } else {
                                    print_r($model_exam_subject_area->errors);
                                    throw new Exception();
                                }
                            }
                            $dbtransaction->commit();
                            Yii::app()->session['subject_area_session'] = Array();
                        }
                        $message[] = "Exam Saved";
//                    $dbtransaction->commit();
                        $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
                    }
                    if ($exam_type == "SAMPLE" || $exam_type == "PRESET") {
                        if (!empty($questions)) {

                            $exam_id = $model->getPrimaryKey();

                            $examQuestionIds = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('exam_question')
                                    ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                                    ->queryAll();

//                            print_r($examQuestionIds);die();


                            foreach ($examQuestionIds as $examQuestionId) {
                                ExamQuestion::model()->deleteByPk($examQuestionId['exam_question_id']);
                            }


//                            print_r($questions);die();

                            foreach ($questions as $questionID) {
                                $model_exam_question = new ExamQuestion;
                                $model_exam_question->exam_id = $exam_id;

                                $model_exam_question->question_id = $questionID;

                                if ($model_exam_question->save()) {
//                                    echo 'yes';
                                } else {
                                    print_r($model_exam_question->errors);
                                    throw new Exception();
                                }
                            }

                            $dbtransaction->commit();
                            Yii::app()->session['question_session'] = Array();
                        }
                        $message[] = "Exam Saved";
                        $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
                    }

//                    $examTablesAndFormulaeIds = Yii::app()->db->createCommand()
//                            ->select('*')
//                            ->from('exam_tables_and_formulae')
//                            ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
//                            ->queryAll();
//
//                    foreach ($examTablesAndFormulaeIds as $examTablesAndFormulaeId) {
//
//                        $examTablesAndFormulaeTabTitleIds = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('exam_tables_and_formulae_tab_title')
//                                ->where('exam_tables_and_formulae_id=:exam_tables_and_formulae_id', array(':exam_tables_and_formulae_id' => $examTablesAndFormulaeId['exam_tables_and_formulae_id']))
//                                ->queryAll();
//
//                        foreach ($examTablesAndFormulaeTabTitleIds as $examTablesAndFormulaeTabTitleId) {
//                            ExamTablesAndFormulaeTabTitle::model()->deleteByPk($examTablesAndFormulaeTabTitleId['exam_tables_and_formulae_tab_title_id']);
//                        }
//
//                        ExamTablesAndFormulae::model()->deleteByPk($examTablesAndFormulaeId['exam_tables_and_formulae_id']);
//                    }
                    //save the table and formulae data
//                    for ($i = 1; $i <= $tab_count; $i++) {
//                        if (isset($tab_title[$i]) && isset($table_formula[$i])) {
//                            if ($tab_title[$i] != null) {
//                                if ($table_formula[$i] != null) {
//                                    $model_exam_tables_and_formulae = new ExamTablesAndFormulae;
//
//                                    $model_exam_tables_and_formulae->exam_id = $exam_id;
//                                    $model_exam_tables_and_formulae->tables_and_formulae_text = $table_formula[$i];
//                                    $model_exam_tables_and_formulae->tab_position = $i;
//
//                                    if ($model_exam_tables_and_formulae->save()) {
//                                        $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
//                                    } else {
//                                        print_r($model_exam_tables_and_formulae[$i]->errors);
//                                        die();
//                                    }
//                                }
//
//                                $model_exam_tables_and_formulae_tab_title = new ExamTablesAndFormulaeTabTitle;
//
//                                $model_exam_tables_and_formulae_tab_title->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
//                                $model_exam_tables_and_formulae_tab_title->tab_title = $tab_title[$i];
//
//                                if ($model_exam_tables_and_formulae_tab_title->save()) {
//                                    
//                                } else {
//                                    print_r($model_exam_tables_and_formulae_tab_title->errors);
//                                    die();
//                                }
//                            }
//                        }
//                    }


                    $user_id = Yii::app()->user->id;

                    $model_exam_audit = new Audit;
                    $model_exam_audit->user_id = $user_id;
                    $model_exam_audit->action_id = $exam_id;
                    $model_exam_audit->action_name = "EXAM_MANAGEMENT";
                    $model_exam_audit->action = 'EDIT';
                    $model_exam_audit->date = date("Y/m/d");
                    $model_exam_audit->time = date("h:i:sa");
                    $model_exam_audit->status = 1;

                    if ($model_exam_audit->save()) {
                        
                    } else {
                        print_r($model_exam_audit->errors);
                        die();
                    }
                } else {
                    print_r($model->errors);
                    die();
                }
            } catch (Exception $e) {
                print_r($e);
                die();
                $dbtransaction->rollback();
            }
        }

        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message,
            $typeErrorInputs
        ));
    }

    public function actionRemoveQuestionFromExam() {

        if (isset($_POST) && isset($_POST['question_id'])) {

            $question_id = $_POST['question_id'];

            if ($question_id != NULL) {
                $question_session = Yii::app()->session['question_session'];

                if ($question_session != null) {

                    $i = 0;

                    foreach ($question_session as $session_question_id) {
                        if ($session_question_id == $question_id) {

                            unset($question_session[$i]);
                            $question_session = array_values($question_session);
                        }
                        $i++;
                    }
                } else {

                    $question_session = array();
                }

                Yii::app()->session['question_session'] = $question_session;

                $status = "success";
                $message = "Question Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a question before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public function actionGetExamsByType() {
        if (isset($_POST['exam_type']) && isset($_POST['subject_id'])) {

            $subject_id = (int) $_POST['subject_id'];

            $exam_type = $_POST['exam_type'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('exam_id')
                    ->from('exam')
                    ->where('subject_id=:subject_id AND exam_type=:exam_type', array(':subject_id' => $subject_id, ':exam_type' => $exam_type))
                    ->queryAll();

//            print_r($data);die();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $examData = Exam::getExamInfoById($d['exam_id']);

                    $examName = $examData['exam_name'];

                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($examName), true);
                }
            } else {
                echo '<option value="">Select Exam</option>';
            }
        } else {
            echo 'Subject ID and Exam Type not set';
        }
    }

    public function actionGetExams() {

        if (isset($_POST['subject_id'])) {

            $subjectID = (int) $_POST['subject_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('exam_id')
                    ->from('exam')
                    ->where('(exam_type="PRESET") AND subject_id=:subject_id', array(':subject_id' => $subjectID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {

                    $Estatus = Exam::model()->checkExamStatus($d['exam_id']);

                    if ($Estatus != 0) {

                        $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);

                        $ExamName = $ExamData['exam_name'];
//                echo $subjectAreaName;
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Exams', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($ExamName), true);
                    }
                }
            } else {
                echo '<option value="">Select Exams</option>';
            }
        } else {
            echo 'Subject id not set';
        }
    }

    public function actionGetEssayExams() {
        if (isset($_POST['subject_id'])) {

            $subjectID = (int) $_POST['subject_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('exam_id')
                    ->from('exam')
                    ->where('exam_type="ESSAY" AND subject_id=:subject_id', array(':subject_id' => $subjectID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $Estatus = Exam::model()->checkExamStatus($d['exam_id']);

                    if ($Estatus != 0) {
                        $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);

                        $ExamName = $ExamData['exam_name'];
//                echo $subjectAreaName;
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => '', 'disabled' => 'disabled'), 'Select Exams', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($ExamName), true);
                    }
                }
            } else {
                echo '<option value="" disabled="disabled">Select Exams</option>';
            }
        } else {
            echo 'Subject id not set';
        }
    }

    public function actionGetDynamicExams() {


        if (isset($_POST['dynamic_subject_id'])) {

            $subjectID = (int) $_POST['dynamic_subject_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('exam_id')
                    ->from('exam')
                    //->where('subject_id=:subject_id', array(':subject_id' => $subjectID))
                    ->where('exam_type="DYNAMIC" AND subject_id=' . $subjectID)
                    ->queryAll();

            $first_option_set = 0;
            foreach ($data as $d) {

                $Estatus = Exam::model()->checkExamStatus($d['exam_id']);

                if ($Estatus != 0) {
                    $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);

                    $ExamName = $ExamData['exam_name'];
//                echo $subjectAreaName;
//                if ($first_option_set == 0) {
//                    echo CHtml::tag('option', array('value' => ''), '', true);
//                    $first_option_set = 1;
//                }
                    echo CHtml::tag('option', array('value' => $d['exam_id'], 'selected' => true), CHtml::encode($ExamName), true);
                }
            }
        } else {
            echo 'Subject id not set';
        }
    }

    public function actionGetExamsForStudent() {


        if (isset($_POST['subject_id']) && isset($_POST['student_email'])) {

            $subjectID = (int) $_POST['subject_id'];
            //$studentID = (int) $_POST['student_id'];

            $data_user = Yii::app()->db->createCommand()
                    ->select('user_id')
                    ->from('user')
                    ->where('email=:email', array(':email' => $_POST['student_email']))
                    ->queryAll();


            $data_student = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $data_user[0]['user_id']))
                    ->queryAll();

            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('past_exam')
                    ->where('student_id=:student_id', array(':student_id' => $data_student[0]['student_id']))
                    ->queryAll();

//            print_r($data);

            $first_option_set = 0;
            $count = 0;


            $set_ids = array();
            if (count($data) > 0) {
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

                        if ($ExamData['subject_id'] == $subjectID) {


                            if ($first_option_set == 0) {
                                echo CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                                $first_option_set = 1;
                            }
                            echo CHtml::tag('option', array('value' => $d['exam_id']), CHtml::encode($ExamName), true);

                            $count++;
                        }
                    }
                }
            } else {
                echo '<option value="">Select Exam</option>';
            }

            if ($count == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Exam', true);
                echo CHtml::tag('option', array('value' => '', 'disabled' => 'disabled'), 'No Exams', true);
            }
        } else {
            echo 'Subject id or Student id not set';
        }
    }

    public function actionGetExamSummary() {
        //$student_email = $_POST['student_email'];

        if (isset($_POST['student_email'])) {
            $data_user = Yii::app()->db->createCommand()
                    ->select('user_id')
                    ->from('user')
                    ->where('email=:email', array(':email' => $_POST['student_email']))
                    ->queryAll();


            $data_student = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $data_user[0]['user_id']))
                    ->queryAll();

            $exam_id = $_POST['exam_id'];
            $take_id = $_POST['take_id'];

            echo $this->renderPartial('exam_summary', array('take_id' => $take_id, 'student_id' => $data_student[0]['student_id']), false, true);
        }
    }

    public function actionGetExamSummaryForResultsManagement() {
        //$student_email = $_POST['student_email'];

        if (isset($_POST['student_email'])) {
            $data_user = Yii::app()->db->createCommand()
                    ->select('user_id')
                    ->from('user')
                    ->where('email=:email', array(':email' => $_POST['student_email']))
                    ->queryAll();


            $data_student = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $data_user[0]['user_id']))
                    ->queryAll();

            $exam_id = $_POST['exam_id'];
            $take_id = $_POST['take_id'];

            echo $this->renderPartial('exam_summary_for_results_management', array('take_id' => $take_id, 'student_id' => $data_student[0]['student_id']), false, true);
        }
    }

    public function actionGetTakes() {


        if (isset($_POST['student_email']) && isset($_POST['exam_id'])) {

            // $studentID = (int) $_POST['student_id'];
            $examID = (int) $_POST['exam_id'];
            $model = new Exam;
            $model = $model->findByPk($examID);
            $data_user = Yii::app()->db->createCommand()
                    ->select('user_id')
                    ->from('user')
                    ->where('email=:email', array(':email' => $_POST['student_email']))
                    ->queryAll();


            $data_student = Yii::app()->db->createCommand()
                    ->select('student_id')
                    ->from('student')
                    ->where('user_id=:user_id', array(':user_id' => $data_user[0]['user_id']))
                    ->queryAll();
            if ($model->exam_type == "ESSAY") {
                $data = Yii::app()->db->createCommand()
                        ->select('take_id')
                        ->from('take')
                        ->where('student_id=:student_id AND exam_id=:exam_id AND status=:status', array(':student_id' => $data_student[0]['student_id'], ':exam_id' => $examID, ':status' => 1))
                        ->queryAll();
            } else {
                $data = Yii::app()->db->createCommand()
                        ->select('take_id')
                        ->from('past_exam')
                        ->where('student_id=:student_id AND exam_id=:exam_id', array(':student_id' => $data_student[0]['student_id'], ':exam_id' => $examID))
                        ->queryAll();
            }


//            print_r($data);
//            die();

            $first_option_set = 0;
            $count = 1;
            if (count($data) > 0) {
                foreach ($data as $d) {

//                $ExamData = Exam::model()->getExamNameByExamId($d['exam_id']);
//                $ExamName = $ExamData['exam_name'];
//                echo $subjectAreaName;

                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Take', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['take_id']), CHtml::encode($count), true);

                    $count++;
                }
            } else {
                echo '<option value="">Select Take</option>';
            }
        } else {
            echo 'Subject id or Student id not set';
        }
    }

    public function actionConvertCurrency() {
        echo 'hello';
    }

    public function actionSetExamImage($id) {
        $this->render('_add_exam_image', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSaveExamImage() {
        $exam_id = $_POST['exam_id'];

        $model = new Exam;
        $model = $model->findByPk($exam_id);

        $pic = CUploadedFile::getInstanceByName('exam_image');

        if ($pic != NULL) {
            $model->exam_image = $pic->name;

            if ($model->update()) {

                $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/exam_images/' . $pic->name);

                $this->redirect(array('view', 'id' => $model->exam_id));
            } else {
                print_r($model->errors);
                die();
            }
        } else {
            Yii::app()->user->setFlash(Consts::STATUS_IMAGE_NOT_SET, Consts::ERROR_IMAGE_NOT_SET);
            $this->redirect(array('view', 'id' => $model->exam_id));
        }
    }

    public function actionValidateEssayExam() {
        $errorInputs = Array();
        $redirect_url = "N/A";
        $message = Array();
        $typeErrorInputs = Array();

        $course_id = $_POST['course_id'];
        $level_id = $_POST['level_id'];
        $subject_id = $_POST['subject_id'];
        $exam_name = $_POST['exam_name'];
        $exam_description = $_POST['exam_description'];
        $number_of_questions = $_POST['number_of_questions'];
        $exam_type = $_POST['exam_type'];

        $time = $_POST['time'];
        $calculator_allowed = $_POST['cal_yes'];

        $exam_price = $_POST['exam_price'];

        $pass_mark = $_POST['pass_mark'];
        $expiry_duration = $_POST['expiry_duration'];
        $no_of_questions_section = $_POST['no_of_questions_section'];
        $section_time = $_POST['section_time'];
        $no_selected_questions = $_POST['no_selected_questions'];
        $questions = $_POST['questions'];



        //get table formula data
//        $tab_count = $_POST['tab_count'];
//        for ($i = 1; $i <= $tab_count; $i++) {
//            if (isset($_POST["tabessay_title_" . $i])) {
//                $tabessay_title[$i] = $_POST["tabessay_title_" . $i];
//            } else {
//                $tabessay_title[$i] = null;
//            }
//            if (isset($_POST["tableessay_formula_$i"])) {
//                $tableessay_formula[$i] = $_POST["tableessay_formula_" . $i];
//            } else {
//                $tableessay_formula[$i] = null;
//            }
//        }
        //$section_questions = $_POST['section_questions'];
        //$attchment = $_POST['attchment'];
        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                isset($_POST['exam_name']) &&
                isset($_POST['exam_description']) &&
                isset($_POST['number_of_questions']) &&
                isset($_POST['exam_type']) &&
                isset($_POST['time']) &&
                isset($_POST['cal_yes']) &&
                isset($_POST['exam_price']) &&
                isset($_POST['pass_mark']) &&
                isset($_POST['expiry_duration']) &&
                $_POST ['course_id'] != null &&
                $_POST['level_id'] != null &&
                $_POST['subject_id'] != null &&
                $_POST['exam_name'] != null &&
                $_POST['exam_description'] != null &&
                $_POST['number_of_questions'] != null &&
                $_POST['exam_type'] != null &&
                $_POST['time'] != null &&
                $_POST['cal_yes'] != null &&
                $_POST['exam_price'] != null &&
                $_POST['pass_mark'] != null &&
                $_POST['expiry_duration'] != null) {

            $status = "success";
        } else {
            $status = "fail";

            $message[] = "Please enter all the values before proceeding";

            if ($_POST['course_id'] == null) {
                $errorInputs[] = "course_id";
            }
            if ($_POST['level_id'] == null) {
                $errorInputs[] = "level_id";
            }
            if ($_POST['subject_id'] == null) {
                $errorInputs[] = "subject_id";
            }
            if ($_POST['exam_name'] == null) {
                $errorInputs[] = "exam_name";
            }
            if ($_POST['exam_description'] == null) {
                $errorInputs[] = "exam_description";
            }
            if ($_POST['number_of_questions'] == null) {
                $errorInputs[] = "number_of_questions";
            }
            if ($_POST['exam_type'] == null) {
                $errorInputs[] = "exam_type";
            }
            if ($_POST['time'] == null) {
                $errorInputs[] = "time";
            }
            if ($_POST['exam_price'] == null) {
                $errorInputs[] = "exam_price";
            }
            if ($_POST['pass_mark'] == null) {
                $errorInputs[] = "pass_mark";
            }
            if ($_POST['expiry_duration'] == null) {
                $errorInputs[] = "expiry_duration";
            }
        }

        $total_no_questions = 0;
        $numerofquestioniszero = false;
        foreach ($no_of_questions_section as $no_of_que_section) {
            if ($no_of_que_section != 0) {
                $total_no_questions = $total_no_questions + $no_of_que_section;
            } else {
                $numerofquestioniszero = true;
            }
        }

        if ($numerofquestioniszero == true) {
            $status = "fail";
            $message[] = "Section questions cannot be zero!";
        }

        $total_time = 0;
        $sectimeiszero = false;
        foreach ($section_time as $sec_time) {
            if ($sec_time != 0) {
                $total_time = $total_time + $sec_time;
            } else {
                $sectimeiszero = true;
            }
        }

        if ($sectimeiszero == true) {
            $status = "fail";
            $message[] = "Section time cannot be zero!";
        }

        if ($total_time != $time) {
            $status = "fail";
            $message[] = "Total sections time does not match with total exam time!";
        }

        if ($total_no_questions != $number_of_questions) {
            $status = "fail";
            $message[] = "Total questions of sections does not match with total exam questions!";
        } else {
            $x = 0;
            foreach ($no_selected_questions as $section_question) {
                if ($section_question != $no_of_questions_section[$x]) {
                    $status = "fail";
                    $message[] = "you selected different no of questions for the section " . ($x + 1) . "!";
                    break;
                }
                $x++;
            }
        }

        if (!is_numeric($number_of_questions)) {
            $typeErrorInputs[] = "number_of_questions";
        }
        if (!is_numeric($time)) {
            $typeErrorInputs[] = "time";
        }
        if (!is_numeric($exam_price)) {
            $typeErrorInputs[] = "exam_price";
        }
        if (!is_numeric($pass_mark)) {
            $typeErrorInputs[] = "pass_mark_essay";
        }
        if (!is_numeric($expiry_duration)) {
            $typeErrorInputs[] = "expiry_duration_essay";
        }
        $y = 1;
        foreach ($no_of_questions_section as $no_of_que_section) {
            if (!is_numeric($no_of_que_section)) {
                $typeErrorInputs[] = "no_of_questions_" . $y;
            }
            $y++;
        }
        $z = 1;
        foreach ($section_time as $s_time) {

            if (!is_numeric($s_time)) {
                $typeErrorInputs[] = "section_time_" . $z;
            }
            $z++;
        }

        if (!empty($typeErrorInputs)) {
            $status = "fail";
            $message[] = "These should contain only numeric characters";
        }
        if ($status == "success") {
            $model = new Exam;

            //$dbtransaction = Yii::app()->db->beginTransaction();

            $model->subject_id = $subject_id;


            //allow to use the calculator
            if (isset($_POST['cal_yes'])) {
                $cal = $_POST['cal_yes'];
                if ($cal == "true") {
                    $allow_calculator = 1;
                } else {
                    $allow_calculator = 0;
                }
            } else {
                $allow_calculator = 0;
            }

            //allow to view marked questions
            if (isset($_POST['allow_view_marked_questionss'])) {
                $marked = $_POST['allow_view_marked_questionss'];
                if ($marked == "true") {
                    $allow_view_marked_questions = 1;
                } else {
                    $allow_view_marked_questions = 0;
                }
            } else {
                $allow_view_marked_questions = 0;
            }


            //allow to go to questions
            if (isset($_POST['allow_goto_questionss'])) {
                $marked_go = $_POST['allow_goto_questionss'];
                if ($marked_go == "true") {
                    $allow_goto_question = 1;
                } else {
                    $allow_goto_question = 0;
                }
            } else {
                $allow_goto_question = 0;
            }

            //allow to view unanswered questions
            if (isset($_POST['allow_view_unanswered_questionss'])) {
                $marked_view = $_POST['allow_view_unanswered_questionss'];
                if ($marked_view == "true") {
                    $allow_view_unanswered_questions = 1;
                } else {
                    $allow_view_unanswered_questions = 0;
                }
            } else {
                $allow_view_unanswered_questions = 0;
            }

            $model->calculator_allowed = $allow_calculator;
            $model->exam_type = $exam_type;
            $model->exam_name = $exam_name;
            $model->exam_description = $exam_description;
            $model->number_of_questions = $number_of_questions;
            $model->time = $time;
            $model->exam_price = $exam_price;
            $model->pass_mark = $pass_mark;
            $model->expiry_duration = $expiry_duration;
            $model->marks_per_question = 0;
            $model->allow_custom_marks = 0;
            $model->allow_minus_marks = 0;
            $model->allow_view_marked_questions = $allow_view_marked_questions;
            $model->allow_goto_question = $allow_goto_question;
            $model->allow_view_unanswered_questions = $allow_view_unanswered_questions;
            $model->status = 1;
            //$questions = Yii::app()->session['question_session'];
            //$question_session_section = Yii::app()->session['question_session_section'];

            try {
                if ($model->save()) {
                    $exam_id = $model->getPrimaryKey();

                    $i = 0;
                    foreach ($section_time as $time) {
                        $model_exam_section = new EssayExamSection;
                        $model_exam_section->exam_id = $exam_id;
                        $model_exam_section->section_time = $time;
                        $model_exam_section->section_number = $i + 1;
                        $model_exam_section->number_of_questions = $no_of_questions_section[$i];


                        if ($model_exam_section->save()) {
                            $x = 0;
                            foreach ($questions[$i] as $questionID) {
                                $model_exam_question = new ExamQuestion;
                                $model_exam_question->exam_id = $exam_id;
                                $model_exam_question->question_id = $questionID;
                                $model_exam_question->section_number = $i + 1;

                                if ($model_exam_question->save()) {
                                    
                                } else {
                                    print_r($model_exam_question->errors);
                                    throw new Exception();
                                }
                                $x++;
                            }
                        } else {
                            print_r($model_exam_section->errors);
                            throw new Exception();
                        }
                        $i++;
                    }
//                    $upload_dir = getUploadDirReferenceMaterial();
//                    if(!empty($attchment)){
//                        foreach($attchment as $attcht){
//                            if($attcht != null){
//                                move_uploaded_file($attachment, $upload_dir);
//                            }
//                        }
//                    }
                    //$uploadfile3 = isset($_FILES['attachment_file_1']) ? $_FILES['attachment_file_1'] : array();
                    //alert($uploadfile3['name']);
                    //$dbtransaction->commit();
                    Yii::app()->session['question_session'] = Array();
                    Yii::app()->session['question_session_section'] = Array();
                    $message[] = "Exam Saved";
                    $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);

                    //save table and formulae data
//                    for ($i = 1; $i <= $tab_count; $i++) {
//                        if (isset($tabessay_title[$i]) && isset($tableessay_formula[$i])) {
//                            if ($tabessay_title[$i] != null) {
//                                if ($tableessay_formula[$i] != null) {
//
//                                    $model_exam_tables_and_formulae = new ExamTablesAndFormulae;
//
//                                    $model_exam_tables_and_formulae->exam_id = $exam_id;
//                                    $model_exam_tables_and_formulae->tables_and_formulae_text = $tableessay_formula[$i];
//                                    $model_exam_tables_and_formulae->tab_position = $i;
//
//                                    if ($model_exam_tables_and_formulae->save()) {
//                                        $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
//                                        $model_exam_tables_and_formulae_tab_title = new ExamTablesAndFormulaeTabTitle;
//
//                                        $model_exam_tables_and_formulae_tab_title->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
//                                        $model_exam_tables_and_formulae_tab_title->tab_title = $tabessay_title[$i];
//
//                                        if ($model_exam_tables_and_formulae_tab_title->save()) {
//                                            
//                                        } else {
//                                            print_r($model_exam_tables_and_formulae_tab_title->errors);
//                                            die();
//                                        }
//                                    } else {
//                                        print_r($model_exam_tables_and_formulae[$i]->errors);
//                                        die();
//                                    }
//                                }
//                            }
//                        }
//                    }
                } else {
                    var_dump($model->getErrors());
                    die;
                }
            } catch (Exception $e) {
                var_dump($model->getErrors());
                die;
                //$dbtransaction->rollback();
            }
        }
        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message,
            $typeErrorInputs
        ));
    }

    public function actionAddQuestionToEssayExam() {
        $question_id = $_POST['question_id'];
        $section_no = $_POST['section_no'];
        $question_session = Yii::app()->session['question_session'];
        $question_session_section = Yii::app()->session['question_session_section'];
        $warning = 0;

        if ($question_id == null) {
            $status = "fail";
            $message = "Select a question before proceeding";
        } else {
            if ($question_session == null) {
                $question_session = array();
                $question_session[] = $question_id;
                $question_session_section[] = $section_no;
                $status = "success";
                $message = "Question Added";
            } else {
                $item_found = false;

                foreach ($question_session as $item) {
                    if ($item == $question_id) {
                        $item_found = true;
                    }
                }
                if ($item_found) {
                    $status = "fail";
                    $message = "Question Already Exists!";
                } else {
                    $question_session[] = $question_id;
                    $question_session_section[] = $section_no;
                    $status = "success";
                    $message = "Question Added";
                }
            }
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('exam_question')
                    ->where('question_id=:question_id', array(':question_id' => $question_id))
                    ->queryAll();

            if (!empty($data)) {
                $warning = 1;
            }
        }
//        print_r($question_session);

        Yii::app()->session['question_session'] = $question_session;
        Yii::app()->session['question_session_section'] = $question_session_section;
        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message,
            'question_id' => $question_id,
            'warning' => $warning
        ));
    }

    public function actionRemoveQuestionFromEssayExam() {

        if (isset($_POST) && isset($_POST['question_id'])) {

            $question_id = $_POST['question_id'];
            if ($question_id != NULL) {
                $question_session = Yii::app()->session['question_session'];
                $question_session_section = Yii::app()->session['question_session_section'];
                if ($question_session != null) {

                    $i = 0;

                    foreach ($question_session as $session_question_id) {
                        if ($session_question_id == $question_id) {
                            unset($question_session_section[$i]);
                            unset($question_session[$i]);
                            $question_session = array_values($question_session);
                            $question_session_section = array_values($question_session_section);
                        }
                        $i++;
                    }
                } else {

                    $question_session = array();
                    $question_session_section = array();
                }
                Yii::app()->session['question_session'] = $question_session;
                Yii::app()->session['question_session_section'] = $question_session_section;
                $status = "success";
                $message = "Question Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a question before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    protected function getUploadDirReferenceMaterial() {
        $dir1 = Yii::getPathOfAlias('webroot') . '/images/essay_exam_attachment/dire/';

        if (!is_dir($dir1)) {
            mkdir($dir1);
        }
        return dir1;
    }

    protected function getUploadDirPreseen($exam_id) {
        $dir1 = Yii::getPathOfAlias('webroot') . '/images/essay_exam_preseen/' . $exam_id . '/';

        if (!is_dir($dir1)) {
            mkdir($dir1);
        }
        return $dir1;
    }

    protected function getUploadDirTables($exam_id) {
        $dir1 = Yii::getPathOfAlias('webroot') . '/images/table_formulae/' . $exam_id . '/';

        if (!is_dir($dir1)) {
            mkdir($dir1);
        }
        return $dir1;
    }

    public function actionSaveEssayExam() {
        //die;
        $errorInputs = Array();
        $redirect_url = "N/A";
        $message = Array();
        $typeErrorInputs = Array();
        $exam_id = $_POST['exam_id'];
        $course_id = $_POST['course_id'];
        $level_id = $_POST['level_id'];
        $subject_id = $_POST['subject_id'];
        $exam_name = $_POST['exam_name'];
        $exam_description = $_POST['exam_description'];
        $number_of_questions = $_POST['number_of_questions'];
        $exam_type = $_POST['exam_type'];

        $time = $_POST['time'];
        $calculator_allowed = $_POST['cal_yes'];

        $exam_price = $_POST['exam_price'];

        $pass_mark = $_POST['pass_mark'];
        $expiry_duration = $_POST['expiry_duration'];
        $no_of_questions_section = $_POST['no_of_questions_section'];
        $section_time = $_POST['section_time'];
        $no_selected_questions = $_POST['no_selected_questions'];
        $questions = $_POST['questions'];

        //get table formula data
//        $tab_count = $_POST['tab_count'];
//        for ($i = 1; $i <= $tab_count; $i++) {
//            if (isset($_POST["tabessay_title_" . $i])) {
//                $tabessay_title[$i] = $_POST["tabessay_title_" . $i];
//            } else {
//                $tabessay_title[$i] = null;
//            }
//            if (isset($_POST["tableessay_formula_$i"])) {
//                $tableessay_formula[$i] = $_POST["tableessay_formula_" . $i];
//            } else {
//                $tableessay_formula[$i] = null;
//            }
//        }
        //$removed_sections = $_POST['removed_section'];
        //$section_questions = $_POST['section_questions'];
        //$attchment = $_POST['attchment'];
        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                isset($_POST['exam_name']) &&
                isset($_POST['exam_description']) &&
                isset($_POST['number_of_questions']) &&
                isset($_POST['exam_type']) &&
                isset($_POST['time']) &&
                isset($_POST['cal_yes']) &&
                isset($_POST['exam_price']) &&
                isset($_POST['pass_mark']) &&
                isset($_POST['expiry_duration']) &&
                $_POST ['course_id'] != null &&
                $_POST['level_id'] != null &&
                $_POST['subject_id'] != null &&
                $_POST['exam_name'] != null &&
                $_POST['exam_description'] != null &&
                $_POST['number_of_questions'] != null &&
                $_POST['exam_type'] != null &&
                $_POST['time'] != null &&
                $_POST['cal_yes'] != null &&
                $_POST['exam_price'] != null &&
                $_POST['pass_mark'] != null &&
                $_POST['expiry_duration'] != null) {

            $status = "success";
        } else {
            $status = "fail";

            $message[] = "Please enter all the values before proceeding";

            if ($_POST['course_id'] == null) {
                $errorInputs[] = "course_id";
            }
            if ($_POST['level_id'] == null) {
                $errorInputs[] = "level_id";
            }
            if ($_POST['subject_id'] == null) {
                $errorInputs[] = "subject_id";
            }
            if ($_POST['exam_name'] == null) {
                $errorInputs[] = "exam_name";
            }
            if ($_POST['exam_description'] == null) {
                $errorInputs[] = "exam_description";
            }
            if ($_POST['number_of_questions'] == null) {
                $errorInputs[] = "number_of_questions";
            }
            if ($_POST['exam_type'] == null) {
                $errorInputs[] = "exam_type";
            }
            if ($_POST['time'] == null) {
                $errorInputs[] = "time";
            }
            if ($_POST['exam_price'] == null) {
                $errorInputs[] = "exam_price";
            }
            if ($_POST['pass_mark'] == null) {
                $errorInputs[] = "pass_mark";
            }
            if ($_POST['expiry_duration'] == null) {
                $errorInputs[] = "expiry_duration";
            }
        }
        $total_no_questions = 0;

        $questioniszero = false;
        foreach ($no_of_questions_section as $no_of_que_section) {
            if ($no_of_que_section != 0) {
                $total_no_questions = $total_no_questions + $no_of_que_section;
            } else {
                $questioniszero = true;
            }
        }


        if ($questioniszero == true) {
            $status = "fail";
            $message[] = "Section question numbers cannot be zero!";
        }

        $total_time = 0;
        $timeiszero = false;
        foreach ($section_time as $sec_time) {
            if ($sec_time != 0) {
                $total_time = $total_time + $sec_time;
            } else {
                $timeiszero = true;
            }
        }

        if ($timeiszero == true) {
            $status = "fail";
            $message[] = "Section time cannot be zero!";
        }


        if ($total_time != $time) {
            $status = "fail";
            $message[] = "Total time of sections does not match with total exam time!";
        }
        if ($total_no_questions != $number_of_questions) {
            $status = "fail";
            $message[] = "Total questions of sections does not match with total exam questions!";
        } else {
            $x = 0;
            foreach ($no_selected_questions as $section_question) {
                if ($section_question != $no_of_questions_section[$x]) {
                    $status = "fail";
                    $message[] = "you selected different number of questions for the section " . ($x + 1) . "!";
                    break;
                }
                $x++;
            }
        }

        if (!is_numeric($number_of_questions)) {
            $typeErrorInputs[] = "number_of_questions";
        }
        if (!is_numeric($time)) {
            $typeErrorInputs[] = "time";
        }
        if (!is_numeric($exam_price)) {
            $typeErrorInputs[] = "exam_price";
        }
        if (!is_numeric($pass_mark)) {
            $typeErrorInputs[] = "pass_mark_essay";
        }
        if (!is_numeric($expiry_duration)) {
            $typeErrorInputs[] = "expiry_duration_essay";
        }
        $y = 1;
        foreach ($no_of_questions_section as $no_of_que_section) {
            if (!is_numeric($no_of_que_section)) {
                $typeErrorInputs[] = "no_of_questions_" . $y;
            }
            $y++;
        }
        $z = 1;
        foreach ($section_time as $s_time) {

            if (!is_numeric($s_time)) {
                $typeErrorInputs[] = "section_time_" . $z;
            }
            $z++;
        }

        if (!empty($typeErrorInputs)) {
            $status = "fail";
            $message[] = "These should contain only numeric characters";
        }
        if ($status == "success") {
            $model = Exam::model()->findByPk($exam_id);

            $model->subject_id = $subject_id;


            //allow the calculator
            if (isset($_POST['cal_yes'])) {
                $cal = $_POST['cal_yes'];
                if ($cal == "true") {
                    $allow_cal = 1;
                } else {
                    $allow_cal = 0;
                }
            } else {
                $allow_cal = 0;
            }


            //allow to view marked questions
            if (isset($_POST['allow_view_marked_questions'])) {
                $marked = $_POST['allow_view_marked_questions'];
                if ($marked == "true") {
                    $allow_view_marked_questions = 1;
                } else {
                    $allow_view_marked_questions = 0;
                }
            } else {
                $allow_view_marked_questions = 0;
            }


            //allow to go to questions
            if (isset($_POST['allow_goto_question'])) {
                $marked = $_POST['allow_goto_question'];
                if ($marked == "true") {
                    $allow_goto_question = 1;
                } else {
                    $allow_goto_question = 0;
                }
            } else {
                $allow_goto_question = 0;
            }

            //allow to view unanswered questions
            if (isset($_POST['allow_view_unanswered_questions'])) {
                $marked = $_POST['allow_view_unanswered_questions'];
                if ($marked == "true") {
                    $allow_view_unanswered_questions = 1;
                } else {
                    $allow_view_unanswered_questions = 0;
                }
            } else {
                $allow_view_unanswered_questions = 0;
            }

            $model->calculator_allowed = $allow_cal;
            $model->exam_type = $exam_type;
            $model->exam_name = $exam_name;
            $model->exam_description = $exam_description;
            $model->number_of_questions = $number_of_questions;
            $model->time = $time;
            $model->exam_price = $exam_price;
            $model->pass_mark = $pass_mark;
            $model->expiry_duration = $expiry_duration;
            $model->marks_per_question = 0;
            $model->allow_custom_marks = 0;
            $model->allow_minus_marks = 0;
            $model->allow_view_marked_questions = $allow_view_marked_questions;
            $model->allow_goto_question = $allow_goto_question;
            $model->allow_view_unanswered_questions = $allow_view_unanswered_questions;
            $model->status = 1;


//            $questions = Yii::app()->session['question_session'];
//            $question_session_section = Yii::app()->session['question_session_section'];
            //die;
            try {
                if ($model->save()) {
                    $exam_id = $model->getPrimaryKey();
                    $questions_id = Yii::app()->db->createCommand()
                            ->select('exam_question_id')
                            ->from('exam_question')
                            ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                            ->queryAll();

                    $sections = Yii::app()->db->createCommand()
                            ->select('essay_exam_section_id')
                            ->from('essay_exam_section')
                            ->where('exam_id=:exam_id', array(':exam_id' => $exam_id))
                            ->queryAll();


                    //   var_dump($sections);die;

                    foreach ($questions_id as $question_id) {
                        if ($question_id != "") {
                            ExamQuestion::model()->deleteByPk($question_id['exam_question_id']);
                        }
                    }
                    foreach ($sections as $section) {
                        EssayExamSection::model()->deleteByPk($section['essay_exam_section_id']);
                    }


                    $i = 0;
                    foreach ($section_time as $time) {
                        $model_exam_section = new EssayExamSection;
                        $model_exam_section->exam_id = $exam_id;
                        $model_exam_section->section_time = $time;
                        $model_exam_section->section_number = $i + 1;
                        $model_exam_section->number_of_questions = $no_of_questions_section[$i];


                        if ($model_exam_section->save()) {
                            $x = 0;
                            foreach ($questions[$i] as $questionID) {
                                $model_exam_question = new ExamQuestion;
                                $model_exam_question->exam_id = $exam_id;
                                $model_exam_question->question_id = $questionID;
                                $model_exam_question->section_number = $i + 1;

                                if ($model_exam_question->save()) {
                                    
                                } else {
                                    print_r($model_exam_question->errors);
                                    throw new Exception();
                                }
                                $x++;
                            }
                        } else {
                            print_r($model_exam_section->errors);
                            throw new Exception();
                        }
                        $i++;
                    }
                    Yii::app()->session['question_session'] = Array();
                    Yii::app()->session['question_session_section'] = Array();
                    $message[] = "Exam Saved";
                    $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
                } else {
                    print_r($model->errors);
                }
            } catch (Exception $e) {
                print_r($e);
                //$dbtransaction->rollback();
            }
            $redirect_url = CController::createUrl('exam/view&id=' . $model->exam_id);
        }


        //delete the existing data
//        $table_formula = ExamTablesAndFormulae::model()->findAllByAttributes(array('exam_id' => $exam_id));
//        foreach ($table_formula as $table_formula_data) {
//            $table_formula_tab = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $table_formula_data->exam_tables_and_formulae_id));
//            ExamTablesAndFormulaeTabTitle::model()->deleteByPk($table_formula_tab->exam_tables_and_formulae_tab_title_id);
//            ExamTablesAndFormulae::model()->deleteByPk($table_formula_data->exam_tables_and_formulae_id);
//        }
        //save table and formulae data
//        for ($i = 1; $i <= $tab_count; $i++) {
//            if (isset($tabessay_title[$i]) && isset($tableessay_formula[$i])) {
//                //add the updated data
//                if ($tabessay_title[$i] != null) {
//                    if ($tableessay_formula[$i] != null) {
//                        $model_exam_tables_and_formulae = new ExamTablesAndFormulae;
//
//                        $model_exam_tables_and_formulae->exam_id = $exam_id;
//                        $model_exam_tables_and_formulae->tables_and_formulae_text = $tableessay_formula[$i];
//                        $model_exam_tables_and_formulae->tab_position = $i;
//
//                        if ($model_exam_tables_and_formulae->save()) {
//                            $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
//                            $model_exam_tables_and_formulae_tab_title = new ExamTablesAndFormulaeTabTitle;
//
//                            $model_exam_tables_and_formulae_tab_title->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
//                            $model_exam_tables_and_formulae_tab_title->tab_title = $tabessay_title[$i];
//
//                            if ($model_exam_tables_and_formulae_tab_title->save()) {
//                                
//                            } else {
//                                print_r($model_exam_tables_and_formulae_tab_title->errors);
//                                die();
//                            }
//                        } else {
//                            print_r($model_exam_tables_and_formulae[$i]->errors);
//                            die();
//                        }
//                    }
//                }
//            }
//        }



        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message,
            $typeErrorInputs
        ));
    }

    public function actionSetExamInstruction($id) {
        $this->render('_add_exam_instruction', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionEditExamInstruction($id) {
        $this->render('_edit_exam_instruction', array(
            'model' => $this->loadModel($id),
        ));
    }

    //add preseen material data
    public function actionSetPreseen($id) {
        $this->render('_add_preseen_materials', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSetTables($id) {
        $this->render('_add_tables_formulae', array(
            'model' => $this->loadModel($id),
        ));
    }

    //edit table formulae 
    public function actionUpdateTables($id) {
        $this->render('_edit_tables_formulae', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSaveExamInstructions() {
        $exam_id = $_POST['exam_id'];
        $instruction = $_POST['instruction'];

        $model = new Exam;
        $model = $model->findByPk($exam_id);

        if ($instruction == 'text_answer1') {
            $textInstruction = $_POST['txt_ins'];
            $model->exam_instruction = $textInstruction;
            if ($model->update()) {
                $this->redirect(array('view', 'id' => $model->exam_id));
            } else {
                print_r($model->errors);
                die();
            }
        } else if ($instruction == 'image_answer1') {
            $uploadimages = isset($_FILES['instruction_file']) ? $_FILES['instruction_file'] : array();
            $uploadImageName = isset($uploadimages['name']) ? $uploadimages['name'] : null;
            $model->exam_instruction = $uploadImageName;

            if ($model->update()) {
                $upload_dir = $this->getUploadDir($model->exam_id);

                if (isset($_FILES['instruction_file'])) {
                    move_uploaded_file($_FILES['instruction_file']['tmp_name'], $upload_dir . $uploadImageName);
                }
                $this->redirect(array('view', 'id' => $model->exam_id));
            } else {
                print_r($model->errors);
                die();
            }
        }
    }

    //to get the exam instruction image directory
    protected function getUploadDir($examid) {
        $dir = Yii::getPathOfAlias('webroot') . '/images/exam_instructions/' . $examid . '/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        //   echo $dir;die();
        return $dir;
    }

    public function actionExportToExcel($id) {
        $model = $this->loadModel($id);
        $this->render('exportToExcel', array(
            'model' => $model,
        ));
    }

    public function actionSetAttachments($id) {
        $this->render('_attachment_upload', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionUploadAttachments($id) {
        $attachments = Exam::model()->getAttachments($id);
        $this->render('_add_attachments', array(
            'model' => $this->loadModel($id),
            'attachments' => $attachments,
        ));
    }

    public function actionSaveAttachments() {

        $attachments = CUploadedFile::getInstancesByName('attachment_file');
        $exam_id = $_POST['exam_id'];
        $model = new Exam;
        $model = $model->findByPk($exam_id);
        if (count($attachments) > 0) {
            foreach ($attachments as $key => $pic) {


                $model_attachment = new ExamAttachment;
                $picname = uniqid() . $pic->name;

                $model_attachment->exam_id = $model->exam_id;
                $model_attachment->attachment = $picname;
                //print_r($picname); die;

                if ($model_attachment->save()) {
                    $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/essay_exam_attachment/' . $picname);
                } else {
                    print_r($model_attachment->errors);
                    die;
                }
            }
            $this->redirect(array('uploadAttachments', 'id' => $model->exam_id));
        } else {
            $this->redirect(array('uploadAttachments', 'id' => $model->exam_id));
        }
    }

    public function actionRemoveAttachments() {

        if (isset($_POST['file_name']) && $_POST['file_name'] != null) {
            $exam_id = $_POST['exam_id'];
            $file_name = $_POST['file_name'];

            $attachments = ExamAttachment::model()->getAttchId($exam_id, $file_name);
            if ($attachments != null) {
                if (unlink(Yii::getPathOfAlias('webroot') . '/images/essay_exam_attachment/' . $file_name)) {
                    ExamAttachment::model()->deleteByPk($attachments['exam_attachment_id']);

                    $status = "success";
                    $message = "Attachment removed";
                } else {
                    $status = "fail";
                    $message = "Faild to remove attachment";
                }
            } else {
                $status = "fail";
                $message = "Faild to remove attachment";
            }
        } else {
            $status = "fail";
            $message = "Please select attachment";
        }

        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            )
        ));
    }

    public function actionSavePreseenMaterials() {
        $exam_id = $_POST['exam_id'];

        $model = new Exam;
        $model = $model->findByPk($exam_id);

        //get preseen data
        for ($i = 1; $i < 16; $i++) {
            if (isset($_POST["pre_title_$i"])) {
                $pre_title[$i] = $_POST["pre_title_$i"];
            } else {
                $pre_title[$i] = null;
            }
            if (isset($_POST["pre_formula_$i"])) {
                $pre_formula[$i] = $_POST["pre_formula_$i"];
            } else {
                $pre_formula[$i] = null;
            }
        }


        //delete the existing records
        $exam_preseen_materials = ExamPreseenMaterials::model()->findAllByAttributes(array('exam_id' => $exam_id));
        if (!empty($exam_preseen_materials)) {
            foreach ($exam_preseen_materials as $exam_preseen_material) {
                $exam_preseen_material_tab = ExamPreseenMaterialTabs::model()->findByAttributes(array('exam_preseen_material_id' => $exam_preseen_material->exam_preseen_material_id));
                if (!empty($exam_preseen_material_tab)) {
                    ExamPreseenMaterialTabs::model()->deleteByPk($exam_preseen_material_tab->exam_preseen_material_tab_id);
                    ExamPreseenMaterials::model()->deleteByPk($exam_preseen_material->exam_preseen_material_id);
                }
            }
        }


        //save preseen material data
        for ($i = 1; $i < 16; $i++) {
            if (isset($pre_title[$i]) && isset($pre_formula[$i])) {
                if ($pre_title[$i] != null) {
                    if (isset($_POST["ref_answer$i"])) {
                        $checkbox1 = $_POST["ref_answer$i"];
                        if ($checkbox1 == "text_answer$i") {
                            if ($pre_formula[$i] != null) {
                                $model_exam_preseen_material = new ExamPreseenMaterials();

                                $model_exam_preseen_material->exam_id = $exam_id;
                                $model_exam_preseen_material->preseen_text = $pre_formula[$i];
                                $model_exam_preseen_material->preseen_pdf = null;
                                $model_exam_preseen_material->preseen_tab_position = $i;


                                if ($model_exam_preseen_material->save()) {
                                    $model_preseen_material_id = $model_exam_preseen_material->getPrimaryKey();
                                    $model_exam_preseen_material_tab_title = new ExamPreseenMaterialTabs();

                                    $model_exam_preseen_material_tab_title->exam_preseen_material_id = $model_preseen_material_id;
                                    $model_exam_preseen_material_tab_title->tab_title = $pre_title[$i];

                                    if ($model_exam_preseen_material_tab_title->save()) {
                                        
                                    } else {
                                        print_r($model_exam_preseen_material_tab_title->errors);
                                        die();
                                    }
                                } else {
                                    print_r($model_exam_preseen_material[$i]->errors);
                                    die();
                                }
                            }
                        } else if ($checkbox1 == "image_answer$i") {
                            $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
                            if ($uploadfile1['name'] != "") {
                                $questionReferenceMaterial_1 = new ExamPreseenMaterials;
                                $questionReferenceMaterial_1->exam_id = $exam_id;
                                $questionReferenceMaterial_1->preseen_text = null;
                                $questionReferenceMaterial_1->preseen_pdf = $uploadfile1['name'];
                                $questionReferenceMaterial_1->preseen_tab_position = $i;

                                if ($questionReferenceMaterial_1->save()) {
                                    $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                    $upload_dir = $this->getUploadDirPreseen($exam_id);

                                    if (isset($_FILES["ref_file$i"])) {
                                        move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
                                    }

                                    $model_question_reference_tab_title_1 = new ExamPreseenMaterialTabs();

                                    $model_question_reference_tab_title_1->exam_preseen_material_id = $questionReferenceMaterial_1_id;
                                    $model_question_reference_tab_title_1->tab_title = $pre_title[$i];
                                    if ($model_question_reference_tab_title_1->save()) {
                                        
                                    } else {
                                        print_r($model_question_reference_tab_title_1->getErrors());
                                        die();
                                    }
                                } else {

                                    print_r($questionReferenceMaterial_1->errors);
                                    die;
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->redirect(array('view', 'id' => $model->exam_id));
    }

    //set tables and formulae
    public function actionSaveTablesFormulae() {
        $exam_id = $_POST['exam_id'];

        $model = new Exam;
        $model = $model->findByPk($exam_id);

        //get preseen data
        for ($i = 1; $i < 16; $i++) {
            if (isset($_POST["pre_title_$i"])) {
                $pre_title[$i] = $_POST["pre_title_$i"];
            } else {
                $pre_title[$i] = null;
            }
            if (isset($_POST["pre_formula_$i"])) {
                $pre_formula[$i] = $_POST["pre_formula_$i"];
            } else {
                $pre_formula[$i] = null;
            }
        }


        //delete the existing records
        $exam_preseen_materials = ExamTablesAndFormulae::model()->findAllByAttributes(array('exam_id' => $exam_id));
        if (!empty($exam_preseen_materials)) {
            foreach ($exam_preseen_materials as $exam_preseen_material) {
                $exam_preseen_material_tab = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $exam_preseen_material->exam_tables_and_formulae_id));

                if (isset($exam_preseen_material_tab->exam_tables_and_formulae_tab_title_id)) {
                    ExamTablesAndFormulaeTabTitle::model()->deleteByPk($exam_preseen_material_tab->exam_tables_and_formulae_tab_title_id);
                    ExamTablesAndFormulae::model()->deleteByPk($exam_preseen_material->exam_tables_and_formulae_id);
                }
            }
        }


        //save preseen material data
        for ($i = 1; $i < 16; $i++) {
            if (isset($pre_title[$i]) && isset($pre_formula[$i])) {
                if ($pre_title[$i] != null) {
                    if (isset($_POST["ref_answer$i"])) {
                        $checkbox1 = $_POST["ref_answer$i"];
                        if ($checkbox1 == "text_answer$i") {
                            if ($pre_formula[$i] != null) {
                                $model_exam_tables_and_formulae = new ExamTablesAndFormulae;

                                $model_exam_tables_and_formulae->exam_id = $exam_id;
                                $model_exam_tables_and_formulae->tables_and_formulae_text = $pre_formula[$i];
                                $model_exam_tables_and_formulae->tab_position = $i;
                                $model_exam_tables_and_formulae->table_formulae_image = null;



                                if ($model_exam_tables_and_formulae->save()) {
                                    $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
                                    $model_exam_tables_and_formulae_tab_title = new ExamTablesAndFormulaeTabTitle;

                                    $model_exam_tables_and_formulae_tab_title->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
                                    $model_exam_tables_and_formulae_tab_title->tab_title = $pre_title[$i];

                                    if ($model_exam_tables_and_formulae_tab_title->save()) {
                                        
                                    } else {
                                        print_r($model_exam_tables_and_formulae_tab_title->errors);
                                        die();
                                    }
                                } else {
                                    print_r($model_exam_tables_and_formulae[$i]->errors);
                                    die();
                                }
                            }
                        } else if ($checkbox1 == "image_answer$i") {
                            $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
                            if ($uploadfile1['name'] != "") {
                                $model_exam_tables_and_formulae = new ExamTablesAndFormulae;

                                $model_exam_tables_and_formulae->exam_id = $exam_id;
                                $model_exam_tables_and_formulae->tables_and_formulae_text = null;
                                $model_exam_tables_and_formulae->tab_position = $i;
                                $model_exam_tables_and_formulae->table_formulae_image = $uploadfile1['name'];


                                if ($model_exam_tables_and_formulae->save()) {
                                    $model_exam_tables_and_formulae_id = $model_exam_tables_and_formulae->getPrimaryKey();
                                    $upload_dir = $this->getUploadDirTables($exam_id);

                                    if (isset($_FILES["ref_file$i"])) {
                                        move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
                                    }

                                    $model_question_reference_tab_title_1 = new ExamTablesAndFormulaeTabTitle();

                                    $model_question_reference_tab_title_1->exam_tables_and_formulae_id = $model_exam_tables_and_formulae_id;
                                    $model_question_reference_tab_title_1->tab_title = $pre_title[$i];
                                    if ($model_question_reference_tab_title_1->save()) {
                                        
                                    } else {
                                        print_r("2");
                                        print_r($model_question_reference_tab_title_1->getErrors());
                                        die();
                                    }
                                } else {
                                    print_r("1");
                                    var_dump($model_question_reference_tab_title_1);
                                    var_dump($model_exam_tables_and_formulae->getErrors());
                                    die;
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->redirect(array('view', 'id' => $model->exam_id));
    }

    //upload an exam exhibit
    public function actionSetExhibit($id) {
        $this->render('_add_exam_exhibit', array(
            'model' => $this->loadModel($id),
        ));
    }

    //exam exhibit image directory 
    protected function getExhibitDir($examid) {
        $dir = Yii::getPathOfAlias('webroot') . '/images/exam_exhibit/' . $examid . '/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        return $dir;
    }

    public function actionSaveExhibitData() {
        $exam_id = $_POST['exam_id'];

        $model = new Exam;
        $model = $model->findByPk($exam_id);

        $uploadimages = isset($_FILES['exhibit_file']) ? $_FILES['exhibit_file'] : array();
        $uploadImageName = isset($uploadimages['name']) ? $uploadimages['name'] : null;
        $model->exam_exhibit = $uploadImageName;

        if ($model->update()) {
            $upload_dir = $this->getExhibitDir($model->exam_id);

            if (isset($_FILES['exhibit_file'])) {
                move_uploaded_file($_FILES['exhibit_file']['tmp_name'], $upload_dir . $uploadImageName);
            }
            $this->redirect(array('view', 'id' => $model->exam_id));
        } else {
            print_r($model->errors);
            die();
        }
    }

    public function actionUpdateTablesData() {
        $exam_id = $_POST['exam_id'];

        for ($i = 1; $i < 16; $i++) {
            if (isset($_POST["ref_tab_title_$i"])) {
                $tab_title_reference[$i] = $_POST["ref_tab_title_$i"];
            }
        }

        $uploadfile = array();
        for ($i = 1; $i < 16; $i++) {
            $uploadfile[$i] = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
        }

        $table_formula = ExamTablesAndFormulae::model()->findAllByAttributes(array('exam_id' => $exam_id));
        if (!empty($table_formula)) {
            foreach ($table_formula as $table_formula_data) {
                if (!empty($table_formula_data)) {
                    $tab_position = $table_formula_data->tab_position;
                    if ($_POST["ref_answer$tab_position"] == "image_answer$tab_position") {
                        if ($uploadfile[$tab_position]['name'] != "") {
                            $table_formula_tab = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $table_formula_data->exam_tables_and_formulae_id));
                            ExamTablesAndFormulaeTabTitle::model()->deleteByPk($table_formula_tab->exam_tables_and_formulae_tab_title_id);
                            ExamTablesAndFormulae::model()->deleteByPk($table_formula_data->exam_tables_and_formulae_id);
                        }
                    } else {
                        $table_formula_tab = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $table_formula_data->exam_tables_and_formulae_id));
                        ExamTablesAndFormulaeTabTitle::model()->deleteByPk($table_formula_tab->exam_tables_and_formulae_tab_title_id);
                        ExamTablesAndFormulae::model()->deleteByPk($table_formula_data->exam_tables_and_formulae_id);
                    }
                }
            }
        }


        for ($i = 1; $i < 16; $i++) {
            $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
            if ($tab_title_reference[$i] != null) {
                if (isset($_POST["ref_answer$i"])) {
                    $checkbox1 = $_POST["ref_answer$i"];
                    if ($checkbox1 == "text_answer$i") {
                        $text1 = $_POST["ref_table_formula_$i"];
                        if ($text1 != null) {
                            $questionReferenceMaterial_1 = new ExamTablesAndFormulae;

                            $questionReferenceMaterial_1->exam_id = $exam_id;
                            $questionReferenceMaterial_1->tables_and_formulae_text = $text1;
                            $questionReferenceMaterial_1->table_formulae_image = null;
                            $questionReferenceMaterial_1->tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $model_question_reference_tab_title_1 = new ExamTablesAndFormulaeTabTitle;

                                $model_question_reference_tab_title_1->exam_tables_and_formulae_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {
                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    } else if ($checkbox1 == "image_answer$i") {

                        if ($uploadfile1['name'] != "") {
                            $questionReferenceMaterial_1 = new ExamTablesAndFormulae;
                            $questionReferenceMaterial_1->exam_id = $exam_id;
                            $questionReferenceMaterial_1->tables_and_formulae_text = null;
                            $questionReferenceMaterial_1->table_formulae_image = $uploadfile1['name'];
                            $questionReferenceMaterial_1->tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $upload_dir = $this->getUploadDirTables($exam_id);

                                if (isset($_FILES["ref_file$i"])) {
                                    move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
                                }

                                $model_question_reference_tab_title_1 = new ExamTablesAndFormulaeTabTitle;

                                $model_question_reference_tab_title_1->exam_tables_and_formulae_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {

                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    }
                }
            }
        }


        $this->redirect(array('view', 'id' => $exam_id));
    }

    function actionClearSession() {
        $newArray = array();
        $question_session = Yii::app()->session['question_session'];

        Yii::app()->session['question_session'] = $newArray;
        echo CJSON::encode(array(
            'output' => "OK",
                //'answeroutput' => $answeroutput,
        ));
    }

    public function actionExportExamSheetToPDF() {

        $model = $this->loadModel($_POST['btnExport']);
        ob_start();
        $this->renderPartial('_exam_description', array('model' => $model), false, true);
        $content = ob_get_clean();
        //var_export(htmlentities($content)); die;
        $margins = array(1, 1, 1, 1);
        Yii::import('application.extensions.html2pdf.*');
        require_once('html2pdf.class.php');
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', $margins);
        //$html2pdf->addFont('roboto', '', 'roboto.php');
        $html2pdf->WriteHTML($content, false);
        $html2pdf->Output('exemple.pdf', 'D');
    }

    public function actionExportExamSheetToPDFUsingTCPDF() {
        $model = $this->loadModel($_POST['btnExport']);
//        $content = $this->renderPartial('_exam_paper_to_pdf', array('model' => $model), false, true);
        $content = Yii::app()->controller->renderPartial('_exam_paper_to_pdf', array('model' => $model), true, true);

        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->getAliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", 3);
        $pdf->writeHTML($content, true, 0, true, 0);
        $pdf->Output("example_002.pdf", "I");
    }
    
    
    public function actionExport(){
        $examId = $_GET['exam_id'];
        $model = Exam::model()->findByPk($examId); 
        $this->render('_exam_description',array('model' => $model), false, true);
    }

}
