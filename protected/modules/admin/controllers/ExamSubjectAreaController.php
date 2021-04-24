<?php

class ExamSubjectAreaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column2';

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
                'actions' => array('create', 'update','index', 'view', 'addSubjectArea', 'saveSubjectArea', 'removeSubjectArea'),
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
        $model = new ExamSubjectArea;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExamSubjectArea'])) {
            $model->attributes = $_POST['ExamSubjectArea'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->exam_subject_area_id));
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

        if (isset($_POST['ExamSubjectArea'])) {
            $model->attributes = $_POST['ExamSubjectArea'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->exam_subject_area_id));
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
        $dataProvider = new CActiveDataProvider('ExamSubjectArea');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ExamSubjectArea('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ExamSubjectArea']))
            $model->attributes = $_GET['ExamSubjectArea'];

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
        $model = ExamSubjectArea::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'exam-subject-area-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddSubjectArea() {

        $errorInputs = Array();
        $typeErrorInputs = Array();

        $status = "fail";

        if (isset($_POST['subject_area_id']) &&
                isset($_POST['subject_area_weight']) &&
                isset($_POST['single_answer_question_weight']) &&
                isset($_POST['multiple_answer_question_weight']) &&
                isset($_POST['short_written_answer_question_weight']) &&
                isset($_POST['drag_drop_typea_answer_question_weight']) &&
                isset($_POST['drag_drop_typeb_answer_question_weight']) &&
                isset($_POST['drag_drop_typec_answer_question_weight']) &&
                isset($_POST['drag_drop_typed_answer_question_weight']) &&
                isset($_POST['drag_drop_typee_answer_question_weight']) &&
                isset($_POST['multiple_choice_answer_question_weight']) &&
                isset($_POST['true_or_false_answer_question_weight']) &&
                isset($_POST['hotspot_answer_question_weight']) &&
                isset($_POST['number_of_questions']) &&
                isset($_POST['update']) &&
                $_POST['subject_area_id'] != null &&
                $_POST['subject_area_weight'] != null &&
                $_POST['single_answer_question_weight'] != null &&
                $_POST['multiple_answer_question_weight'] != null &&
                $_POST['short_written_answer_question_weight'] != null &&
                $_POST['drag_drop_typea_answer_question_weight'] != null &&
                $_POST['drag_drop_typeb_answer_question_weight'] != null &&
                $_POST['drag_drop_typec_answer_question_weight'] != null &&
                $_POST['drag_drop_typed_answer_question_weight'] != null &&
                $_POST['drag_drop_typee_answer_question_weight'] != null &&
                $_POST['multiple_choice_answer_question_weight'] != null &&
                $_POST['true_or_false_answer_question_weight'] != null &&
                $_POST['hotspot_answer_question_weight'] != null &&
                $_POST['number_of_questions'] != null &&
                $_POST['update'] != null){

            $status = "success";

            $subject_area_id = $_POST['subject_area_id'];
            $subject_area_weight = $_POST['subject_area_weight'];
            $single_answer_question_weight = $_POST['single_answer_question_weight'];
            $multiple_answer_question_weight = $_POST['multiple_answer_question_weight'];
            $short_written_answer_question_weight = $_POST['short_written_answer_question_weight'];
            $drag_drop_typea_answer_question_weight = $_POST['drag_drop_typea_answer_question_weight'];
            $drag_drop_typeb_answer_question_weight = $_POST['drag_drop_typeb_answer_question_weight'];
            $drag_drop_typec_answer_question_weight = $_POST['drag_drop_typec_answer_question_weight'];
            $drag_drop_typed_answer_question_weight = $_POST['drag_drop_typed_answer_question_weight'];
            $drag_drop_typee_answer_question_weight = $_POST['drag_drop_typee_answer_question_weight'];
            $multiple_choice_answer_question_weight = $_POST['multiple_choice_answer_question_weight'];
            $true_or_false_answer_question_weight = $_POST['true_or_false_answer_question_weight'];
            $hotspot_answer_question_weight = $_POST['hotspot_answer_question_weight'];
            $number_of_questions = $_POST['number_of_questions'];
            $update = $_POST['update'];
            if (!is_numeric($subject_area_weight)) {
                $typeErrorInputs[] = "subject_area_weightage_" . $_POST['count'];
            }
            if (!is_numeric($single_answer_question_weight)) {
                $typeErrorInputs[] = "single_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($multiple_answer_question_weight)) {
                $typeErrorInputs[] = "multiple_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($short_written_answer_question_weight)) {
                $typeErrorInputs[] = "short_written_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typea_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typea_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typeb_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typeb_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typec_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typec_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typed_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typed_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typee_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typee_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($multiple_choice_answer_question_weight)) {
                $typeErrorInputs[] = "multiple_choice_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($true_or_false_answer_question_weight)) {
                $typeErrorInputs[] = "true_or_false_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($hotspot_answer_question_weight)) {
                $typeErrorInputs[] = "hotspot_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($number_of_questions)) {
                $typeErrorInputs[] = "number_of_questions";
            }


            if (empty($typeErrorInputs)) {

                $totalQuestionTypeWightage = floatval($single_answer_question_weight) +
                        floatval($multiple_answer_question_weight) +
                        floatval($short_written_answer_question_weight) +
                        floatval($drag_drop_typea_answer_question_weight) +
                        floatval($drag_drop_typeb_answer_question_weight) +
                        floatval($drag_drop_typec_answer_question_weight) +
                        floatval($drag_drop_typed_answer_question_weight) +
                        floatval($drag_drop_typee_answer_question_weight) +
                        floatval($multiple_choice_answer_question_weight) +
                        floatval($true_or_false_answer_question_weight) +
                        floatval($hotspot_answer_question_weight);

                if ($totalQuestionTypeWightage != 100) {
                    $status = "fail";
                    $message = "The Total Question Type weightage should be equal to 100";
                }
                
                //check questions exist for subject area
                $number_of_sub_area_qs = ($subject_area_weight / 100) * $number_of_questions;
                $number_of_sub_area_qs = round($number_of_sub_area_qs);
                
                $no_of_single_answer = $number_of_sub_area_qs * ($single_answer_question_weight / 100);
                $no_of_multiple_answer = $number_of_sub_area_qs * ($multiple_answer_question_weight / 100);
                $no_of_short_written_answer = $number_of_sub_area_qs * ($short_written_answer_question_weight / 100);
                $no_of_drag_drop_typea_answer = $number_of_sub_area_qs * ($drag_drop_typea_answer_question_weight / 100);
                $no_of_drag_drop_typeb_answer = $number_of_sub_area_qs * ($drag_drop_typeb_answer_question_weight / 100);
                $no_of_drag_drop_typec_answer = $number_of_sub_area_qs * ($drag_drop_typec_answer_question_weight / 100);
                $no_of_drag_drop_typed_answer = $number_of_sub_area_qs * ($drag_drop_typed_answer_question_weight / 100);
                $no_of_drag_drop_typee_answer = $number_of_sub_area_qs * ($drag_drop_typee_answer_question_weight / 100);
                $no_of_multiple_choice_answer = $number_of_sub_area_qs * ($multiple_choice_answer_question_weight / 100);
                $no_of_true_false_answer = $number_of_sub_area_qs * ($true_or_false_answer_question_weight / 100);
                $no_of_hotspot_answer = $number_of_sub_area_qs * ($hotspot_answer_question_weight / 100);


                if ($no_of_single_answer < 1) {
                    $no_of_single_answer = ceil($no_of_single_answer);
                } else {
                    $no_of_single_answer = round($no_of_single_answer);
                }
                if ($no_of_multiple_answer < 1) {
                    $no_of_multiple_answer = ceil($no_of_multiple_answer);
                } else {
                    $no_of_multiple_answer = round($no_of_multiple_answer);
                }
                if ($no_of_short_written_answer < 1) {
                    $no_of_short_written_answer = ceil($no_of_short_written_answer);
                } else {
                    $no_of_short_written_answer = round($no_of_short_written_answer);
                }
                if ($no_of_drag_drop_typea_answer < 1) {
                    $no_of_drag_drop_typea_answer = ceil($no_of_drag_drop_typea_answer);
                } else {
                    $no_of_drag_drop_typea_answer = round($no_of_drag_drop_typea_answer);
                }
                if ($no_of_drag_drop_typeb_answer < 1) {
                    $no_of_drag_drop_typeb_answer = ceil($no_of_drag_drop_typeb_answer);
                } else {
                    $no_of_drag_drop_typeb_answer = round($no_of_drag_drop_typeb_answer);
                }
                if ($no_of_drag_drop_typec_answer < 1) {
                    $no_of_drag_drop_typec_answer = ceil($no_of_drag_drop_typec_answer);
                } else {
                    $no_of_drag_drop_typec_answer = round($no_of_drag_drop_typec_answer);
                }
                if ($no_of_drag_drop_typed_answer < 1) {
                    $no_of_drag_drop_typed_answer = ceil($no_of_drag_drop_typed_answer);
                } else {
                    $no_of_drag_drop_typed_answer = round($no_of_drag_drop_typed_answer);
                }
                if ($no_of_drag_drop_typee_answer < 1) {
                    $no_of_drag_drop_typee_answer = ceil($no_of_drag_drop_typee_answer);
                } else {
                    $no_of_drag_drop_typee_answer = round($no_of_drag_drop_typee_answer);
                }
                if ($no_of_multiple_choice_answer < 1) {
                    $no_of_multiple_choice_answer = ceil($no_of_multiple_choice_answer);
                } else {
                    $no_of_multiple_choice_answer = round($no_of_multiple_choice_answer);
                }
                if ($no_of_true_false_answer < 1) {
                    $no_of_true_false_answer = ceil($no_of_true_false_answer);
                } else {
                    $no_of_true_false_answer = round($no_of_true_false_answer);
                }
                if ($no_of_hotspot_answer < 1) {
                    $no_of_hotspot_answer = ceil($no_of_hotspot_answer);
                } else {
                    $no_of_hotspot_answer = round($no_of_hotspot_answer);
                }
                
                $single_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "SINGLE_ANSWER", $no_of_single_answer);
                $multiple_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "MULTIPLE_ANSWER", $no_of_multiple_answer);
                $short_written_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "SHORT_WRITTEN", $no_of_short_written_answer);
                $drag_drop_typea_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEA_ANSWER", $no_of_drag_drop_typea_answer);
                $drag_drop_typeb_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEB_ANSWER", $no_of_drag_drop_typeb_answer);
                $drag_drop_typec_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEC_ANSWER", $no_of_drag_drop_typec_answer);
                $drag_drop_typed_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPED_ANSWER", $no_of_drag_drop_typed_answer);
                $drag_drop_typee_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEE_ANSWER", $no_of_drag_drop_typee_answer);
                $multiple_choice_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "MULTIPLE_CHOICE_ANSWER", $no_of_multiple_choice_answer);
                $true_false_question_ids = Question::model()->getRandomQuestions($subject_area_id, "TRUE_OR_FALSE_ANSWER", $no_of_true_false_answer);
                $hotspot_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "HOT_SPOT_ANSWER", $no_of_hotspot_answer);

                if(sizeof($single_answer_question_ids) != $no_of_single_answer ||
                        sizeof($multiple_answer_question_ids) != $no_of_multiple_answer ||
                        sizeof($short_written_answer_question_ids) != $no_of_short_written_answer ||
                        sizeof($drag_drop_typea_question_ids) != $no_of_drag_drop_typea_answer ||
                        sizeof($drag_drop_typeb_question_ids) != $no_of_drag_drop_typeb_answer ||
                        sizeof($drag_drop_typec_question_ids) != $no_of_drag_drop_typec_answer ||
                        sizeof($drag_drop_typed_question_ids) != $no_of_drag_drop_typed_answer ||
                        sizeof($drag_drop_typee_question_ids) != $no_of_drag_drop_typee_answer ||
                        sizeof($multiple_choice_answer_question_ids) != $no_of_multiple_choice_answer ||
                        sizeof($true_false_question_ids) != $no_of_true_false_answer ||
                        sizeof($hotspot_answer_question_ids) != $no_of_hotspot_answer){
                    
                    $status = 'fail';
                    $message = "Not enough questions for the subject area";
                            
                }
                //check questions exist for subject area
                
                
                $subjectAreaSession = Yii::app()->session['subject_area_session'];

                if ($status == "success") {

                    if ($subjectAreaSession == null) {
                        $subjectAreaSession = array();
                        $subjectAreaSession[] = array("subject_area_id" => $subject_area_id,
                            "subject_area_weight" => $subject_area_weight,
                            "single_answer_question_weight" => $single_answer_question_weight,
                            "multiple_answer_question_weight" => $multiple_answer_question_weight,
                            "short_written_answer_question_weight" => $short_written_answer_question_weight,
                            "drag_drop_typea_answer_question_weight" => $drag_drop_typea_answer_question_weight,
                            "drag_drop_typeb_answer_question_weight" => $drag_drop_typeb_answer_question_weight,
                            "drag_drop_typec_answer_question_weight" => $drag_drop_typec_answer_question_weight,
                            "drag_drop_typed_answer_question_weight" => $drag_drop_typed_answer_question_weight,
                            "drag_drop_typee_answer_question_weight" => $drag_drop_typee_answer_question_weight,
                            "multiple_choice_answer_question_weight" => $multiple_choice_answer_question_weight,
                            "true_or_false_answer_question_weight" => $true_or_false_answer_question_weight,
                            "hotspot_answer_question_weight" => $hotspot_answer_question_weight);


                        $status = "success";
                        $message = "Subject Area Added";
                    } else {
                        $item_found = false;
                        $i = 0;
                        foreach ($subjectAreaSession as $item) {
                            if ($item['subject_area_id'] == $subject_area_id) {
                                $item_found = true;

                                if($update == 1){                                    
                                    $subjectAreaSession[$i]['subject_area_weight'] = $subject_area_weight;
                                    $subjectAreaSession[$i]['single_answer_question_weight'] = $single_answer_question_weight;
                                    $subjectAreaSession[$i]['multiple_answer_question_weight'] = $multiple_answer_question_weight;
                                    $subjectAreaSession[$i]['short_written_answer_question_weight'] = $short_written_answer_question_weight;
                                    $subjectAreaSession[$i]['drag_drop_typea_answer_question_weight'] = $drag_drop_typea_answer_question_weight;
                                    $subjectAreaSession[$i]['drag_drop_typeb_answer_question_weight'] = $drag_drop_typeb_answer_question_weight;
                                    $subjectAreaSession[$i]['drag_drop_typec_answer_question_weight'] = $drag_drop_typec_answer_question_weight;
                                    $subjectAreaSession[$i]['drag_drop_typed_answer_question_weight'] = $drag_drop_typed_answer_question_weight;
                                    $subjectAreaSession[$i]['drag_drop_typee_answer_question_weight'] = $drag_drop_typee_answer_question_weight;
                                    $subjectAreaSession[$i]['multiple_choice_answer_question_weight'] = $multiple_choice_answer_question_weight;
                                    $subjectAreaSession[$i]['true_or_false_answer_question_weight'] = $true_or_false_answer_question_weight;
                                    $subjectAreaSession[$i]['hotspot_answer_question_weight'] = $hotspot_answer_question_weight;
                                    $status = "success";
                                    $message = "Subject Area added";
                                }else if($update == 0){
                                    $status = "fail";
                                    $message = "Subject Area already added";
                                }
                                break;
                            } 
                            $i++;
                        }
                        if (!$item_found) {

                            
                            $subjectAreaSession[] = array("subject_area_id" => $subject_area_id,
                                "subject_area_weight" => $subject_area_weight,
                                "single_answer_question_weight" => $single_answer_question_weight,
                                "multiple_answer_question_weight" => $multiple_answer_question_weight,
                                "short_written_answer_question_weight" => $short_written_answer_question_weight,
                                "drag_drop_typea_answer_question_weight" => $drag_drop_typea_answer_question_weight,
                                "drag_drop_typeb_answer_question_weight" => $drag_drop_typeb_answer_question_weight,
                                "drag_drop_typec_answer_question_weight" => $drag_drop_typec_answer_question_weight,
                                "drag_drop_typed_answer_question_weight" => $drag_drop_typed_answer_question_weight,
                                "drag_drop_typee_answer_question_weight" => $drag_drop_typee_answer_question_weight,
                                "multiple_choice_answer_question_weight" => $multiple_choice_answer_question_weight,
                                "true_or_false_answer_question_weight" => $true_or_false_answer_question_weight,
                                "hotspot_answer_question_weight" => $hotspot_answer_question_weight);

                            $status = "success";
                            $message = "Subject Area Added";
                        }
                    }



                    Yii::app()->session['subject_area_session'] = $subjectAreaSession;
                } else {
                    
                }
            } else {
                $status = "Fail";
                $message = "Please make sure you enter numbers";
            }
//            print_r($subjectAreaSession);
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

//            $_POST['subject_area_id'] != null &&
//                $_POST['subject_area_weight'] != null &&
//                $_POST['single_answer_question_weight'] != null &&
//                $_POST['multiple_answer_question_weight'] != null &&
//                $_POST['short_written_answer_question_weight'] != null &&
//                $_POST['drag_drop_typea_answer_question_weight'] != null &&
//                $_POST['drag_drop_typeb_answer_question_weight'] != null &&
//                $_POST['multiple_choice_answer_question_weight'] != null) {

            if ($_POST['subject_area_id'] == null) {
                $errorInputs[] = "subject_area_id_" . $_POST['count'];
            }
            if ($_POST['subject_area_weight'] == null) {
                $errorInputs[] = "subject_area_weightage_" . $_POST['count'];
            }
            if ($_POST['single_answer_question_weight'] == null) {
                $errorInputs[] = "single_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['multiple_answer_question_weight'] == null) {
                $errorInputs[] = "multiple_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['short_written_answer_question_weight'] == null) {
                $errorInputs[] = "short_written_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typea_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typea_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typeb_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typeb_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typec_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typec_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typed_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typed_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typee_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typee_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['multiple_choice_answer_question_weight'] == null) {
                $errorInputs[] = "multiple_choice_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['true_or_false_answer_question_weight'] == null) {
                $errorInputs[] = "true_or_false_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['hotspot_answer_question_weight'] == null) {
                $errorInputs[] = "hotspot_answer_weightage_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs,
            $typeErrorInputs
        ));
    }

    public function actionSaveSubjectArea() {

        $errorInputs = Array();
        $typeErrorInputs = Array();

        $status = "fail";

        if (isset($_POST['subject_area_id']) &&
                isset($_POST['subject_area_weight']) &&
                isset($_POST['single_answer_question_weight']) &&
                isset($_POST['multiple_answer_question_weight']) &&
                isset($_POST['short_written_answer_question_weight']) &&
                isset($_POST['drag_drop_typea_answer_question_weight']) &&
                isset($_POST['drag_drop_typeb_answer_question_weight']) &&
                isset($_POST['drag_drop_typec_answer_question_weight']) &&
                isset($_POST['drag_drop_typed_answer_question_weight']) &&
                isset($_POST['drag_drop_typee_answer_question_weight']) &&
                isset($_POST['multiple_choice_answer_question_weight']) &&
                isset($_POST['true_or_false_answer_question_weight']) &&
                isset($_POST['hotspot_answer_question_weight']) &&
                isset($_POST['number_of_questions']) &&
                $_POST['subject_area_id'] != null &&
                $_POST['subject_area_weight'] != null &&
                $_POST['single_answer_question_weight'] != null &&
                $_POST['multiple_answer_question_weight'] != null &&
                $_POST['short_written_answer_question_weight'] != null &&
                $_POST['drag_drop_typea_answer_question_weight'] != null &&
                $_POST['drag_drop_typeb_answer_question_weight'] != null &&
                $_POST['drag_drop_typec_answer_question_weight'] != null &&
                $_POST['drag_drop_typed_answer_question_weight'] != null &&
                $_POST['drag_drop_typee_answer_question_weight'] != null &&
                $_POST['multiple_choice_answer_question_weight'] != null &&
                $_POST['true_or_false_answer_question_weight'] != null &&
                $_POST['hotspot_answer_question_weight'] != null &&
                $_POST['number_of_questions'] != null) {

            $status = "success";

            $subject_area_id = $_POST['subject_area_id'];
            $subject_area_weight = $_POST['subject_area_weight'];
            $single_answer_question_weight = $_POST['single_answer_question_weight'];
            $multiple_answer_question_weight = $_POST['multiple_answer_question_weight'];
            $short_written_answer_question_weight = $_POST['short_written_answer_question_weight'];
            $drag_drop_typea_answer_question_weight = $_POST['drag_drop_typea_answer_question_weight'];
            $drag_drop_typeb_answer_question_weight = $_POST['drag_drop_typeb_answer_question_weight'];
            $drag_drop_typec_answer_question_weight = $_POST['drag_drop_typec_answer_question_weight'];
            $drag_drop_typed_answer_question_weight = $_POST['drag_drop_typed_answer_question_weight'];
            $drag_drop_typee_answer_question_weight = $_POST['drag_drop_typee_answer_question_weight'];
            $multiple_choice_answer_question_weight = $_POST['multiple_choice_answer_question_weight'];
            $true_or_false_answer_question_weight = $_POST['true_or_false_answer_question_weight'];
            $hotspot_answer_question_weight = $_POST['hotspot_answer_question_weight'];
            $number_of_questions = $_POST['number_of_questions'];

            if (!is_numeric($subject_area_weight)) {
                $typeErrorInputs[] = "subject_area_weightage_" . $_POST['count'];
            }
            if (!is_numeric($single_answer_question_weight)) {
                $typeErrorInputs[] = "single_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($multiple_answer_question_weight)) {
                $typeErrorInputs[] = "multiple_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($short_written_answer_question_weight)) {
                $typeErrorInputs[] = "short_written_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typea_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typea_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typeb_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typeb_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typec_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typec_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typed_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typed_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($drag_drop_typee_answer_question_weight)) {
                $typeErrorInputs[] = "drag_drop_typee_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($multiple_choice_answer_question_weight)) {
                $typeErrorInputs[] = "multiple_choice_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($true_or_false_answer_question_weight)) {
                $typeErrorInputs[] = "true_or_false_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($hotspot_answer_question_weight)) {
                $typeErrorInputs[] = "hotspot_answer_weightage_" . $_POST['count'];
            }
            if (!is_numeric($number_of_questions)) {
                $typeErrorInputs[] = "number_of_questions";
            }

            if (empty($typeErrorInputs)) {

                $totalQuestionTypeWightage = floatval($single_answer_question_weight) +
                        floatval($multiple_answer_question_weight) +
                        floatval($short_written_answer_question_weight) +
                        floatval($drag_drop_typea_answer_question_weight) +
                        floatval($drag_drop_typeb_answer_question_weight) +
                        floatval($drag_drop_typec_answer_question_weight) +
                        floatval($drag_drop_typed_answer_question_weight) +
                        floatval($drag_drop_typee_answer_question_weight) +
                        floatval($multiple_choice_answer_question_weight) +
                        floatval($true_or_false_answer_question_weight) +
                        floatval($hotspot_answer_question_weight);

                if ($totalQuestionTypeWightage != 100) {
                    $status = "fail";
                    $message = "The Total Question Type weightage should be equal to 100";
                }

                
                
                //check questions exist for subject area
                $number_of_sub_area_qs = ($subject_area_weight / 100) * $number_of_questions;
                $number_of_sub_area_qs = round($number_of_sub_area_qs);
                
                $no_of_single_answer = $number_of_sub_area_qs * ($single_answer_question_weight / 100);
                $no_of_multiple_answer = $number_of_sub_area_qs * ($multiple_answer_question_weight / 100);
                $no_of_short_written_answer = $number_of_sub_area_qs * ($short_written_answer_question_weight / 100);
                $no_of_drag_drop_typea_answer = $number_of_sub_area_qs * ($drag_drop_typea_answer_question_weight / 100);
                $no_of_drag_drop_typeb_answer = $number_of_sub_area_qs * ($drag_drop_typeb_answer_question_weight / 100);
                $no_of_drag_drop_typec_answer = $number_of_sub_area_qs * ($drag_drop_typec_answer_question_weight / 100);
                $no_of_drag_drop_typed_answer = $number_of_sub_area_qs * ($drag_drop_typed_answer_question_weight / 100);
                $no_of_drag_drop_typee_answer = $number_of_sub_area_qs * ($drag_drop_typee_answer_question_weight / 100);
                $no_of_multiple_choice_answer = $number_of_sub_area_qs * ($multiple_choice_answer_question_weight / 100);
                $no_of_true_false_answer = $number_of_sub_area_qs * ($true_or_false_answer_question_weight / 100);
                $no_of_hotspot_answer = $number_of_sub_area_qs * ($hotspot_answer_question_weight / 100);


                if ($no_of_single_answer < 1) {
                    $no_of_single_answer = ceil($no_of_single_answer);
                } else {
                    $no_of_single_answer = round($no_of_single_answer);
                }
                if ($no_of_multiple_answer < 1) {
                    $no_of_multiple_answer = ceil($no_of_multiple_answer);
                } else {
                    $no_of_multiple_answer = round($no_of_multiple_answer);
                }
                if ($no_of_short_written_answer < 1) {
                    $no_of_short_written_answer = ceil($no_of_short_written_answer);
                } else {
                    $no_of_short_written_answer = round($no_of_short_written_answer);
                }
                if ($no_of_drag_drop_typea_answer < 1) {
                    $no_of_drag_drop_typea_answer = ceil($no_of_drag_drop_typea_answer);
                } else {
                    $no_of_drag_drop_typea_answer = round($no_of_drag_drop_typea_answer);
                }
                if ($no_of_drag_drop_typeb_answer < 1) {
                    $no_of_drag_drop_typeb_answer = ceil($no_of_drag_drop_typeb_answer);
                } else {
                    $no_of_drag_drop_typeb_answer = round($no_of_drag_drop_typeb_answer);
                }
                if ($no_of_drag_drop_typec_answer < 1) {
                    $no_of_drag_drop_typec_answer = ceil($no_of_drag_drop_typec_answer);
                } else {
                    $no_of_drag_drop_typec_answer = round($no_of_drag_drop_typec_answer);
                }
                if ($no_of_drag_drop_typed_answer < 1) {
                    $no_of_drag_drop_typed_answer = ceil($no_of_drag_drop_typed_answer);
                } else {
                    $no_of_drag_drop_typed_answer = round($no_of_drag_drop_typed_answer);
                }
                if ($no_of_drag_drop_typee_answer < 1) {
                    $no_of_drag_drop_typee_answer = ceil($no_of_drag_drop_typee_answer);
                } else {
                    $no_of_drag_drop_typee_answer = round($no_of_drag_drop_typee_answer);
                }
                if ($no_of_multiple_choice_answer < 1) {
                    $no_of_multiple_choice_answer = ceil($no_of_multiple_choice_answer);
                } else {
                    $no_of_multiple_choice_answer = round($no_of_multiple_choice_answer);
                }
                if ($no_of_true_false_answer < 1) {
                    $no_of_true_false_answer = ceil($no_of_true_false_answer);
                } else {
                    $no_of_true_false_answer = round($no_of_true_false_answer);
                }
                if ($no_of_hotspot_answer < 1) {
                    $no_of_hotspot_answer = ceil($no_of_hotspot_answer);
                } else {
                    $no_of_hotspot_answer = round($no_of_hotspot_answer);
                }
            
                $single_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "SINGLE_ANSWER", $no_of_single_answer);
                $multiple_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "MULTIPLE_ANSWER", $no_of_multiple_answer);
                $short_written_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "SHORT_WRITTEN", $no_of_short_written_answer);
                $drag_drop_typea_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEA_ANSWER", $no_of_drag_drop_typea_answer);
                $drag_drop_typeb_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEB_ANSWER", $no_of_drag_drop_typeb_answer);
                $drag_drop_typec_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEC_ANSWER", $no_of_drag_drop_typec_answer);
                $drag_drop_typed_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPED_ANSWER", $no_of_drag_drop_typed_answer);
                $drag_drop_typee_question_ids = Question::model()->getRandomQuestions($subject_area_id, "DRAG_DROP_TYPEE_ANSWER", $no_of_drag_drop_typee_answer);
                $multiple_choice_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "MULTIPLE_CHOICE_ANSWER", $no_of_multiple_choice_answer);
                $true_false_question_ids = Question::model()->getRandomQuestions($subject_area_id, "TRUE_OR_FALSE_ANSWER", $no_of_true_false_answer);
                $hotspot_answer_question_ids = Question::model()->getRandomQuestions($subject_area_id, "HOT_SPOT_ANSWER", $no_of_hotspot_answer);
                
                if(sizeof($single_answer_question_ids) != $no_of_single_answer ||
                        sizeof($multiple_answer_question_ids) != $no_of_multiple_answer ||
                        sizeof($short_written_answer_question_ids) != $no_of_short_written_answer ||
                        sizeof($drag_drop_typea_question_ids) != $no_of_drag_drop_typea_answer ||
                        sizeof($drag_drop_typeb_question_ids) != $no_of_drag_drop_typeb_answer ||
                        sizeof($drag_drop_typec_question_ids) != $no_of_drag_drop_typec_answer ||
                        sizeof($drag_drop_typed_question_ids) != $no_of_drag_drop_typed_answer ||
                        sizeof($drag_drop_typee_question_ids) != $no_of_drag_drop_typee_answer ||
                        sizeof($multiple_choice_answer_question_ids) != $no_of_multiple_choice_answer ||
                        sizeof($true_false_question_ids) != $no_of_true_false_answer ||
                        sizeof($hotspot_answer_question_ids) != $no_of_hotspot_answer){
                    
                    $status = 'fail';
                    $message = "Not enough questions for the subject area";
                            
                }
                //check questions exist for subject area
                
                
                
                $subjectAreaSession = Yii::app()->session['subject_area_session'];
                $subjectAreaSessionUpdated = array();

                if ($status == "success") {

                    if ($subjectAreaSession == null) {
                        $subjectAreaSession = array();
                        $subjectAreaSession[] = array("subject_area_id" => $subject_area_id,
                            "subject_area_weight" => $subject_area_weight,
                            "single_answer_question_weight" => $single_answer_question_weight,
                            "multiple_answer_question_weight" => $multiple_answer_question_weight,
                            "short_written_answer_question_weight" => $short_written_answer_question_weight,
                            "drag_drop_typea_answer_question_weight" => $drag_drop_typea_answer_question_weight,
                            "drag_drop_typeb_answer_question_weight" => $drag_drop_typeb_answer_question_weight,
                            "drag_drop_typec_answer_question_weight" => $drag_drop_typec_answer_question_weight,
                            "drag_drop_typed_answer_question_weight" => $drag_drop_typed_answer_question_weight,
                            "drag_drop_typee_answer_question_weight" => $drag_drop_typee_answer_question_weight,
                            "multiple_choice_answer_question_weight" => $multiple_choice_answer_question_weight,
                            "true_or_false_answer_question_weight" => $true_or_false_answer_question_weight,
                            "hotspot_answer_question_weight" => $hotspot_answer_question_weight);


                        $status = "success";
                        $message = "Subject Area Added";
                    } else {
                        $item_found = false;

                        foreach ($subjectAreaSession as $item) {
                            if ($item['subject_area_id'] == $subject_area_id) {
                                $item_found = true;


                                $item['subject_area_weight'] = $subject_area_weight;
                                $item['single_answer_question_weight'] = $single_answer_question_weight;
                                $item['multiple_answer_question_weight'] = $multiple_answer_question_weight;
                                $item['short_written_answer_question_weight'] = $short_written_answer_question_weight;
                                $item['drag_drop_typea_answer_question_weight'] = $drag_drop_typea_answer_question_weight;
                                $item['drag_drop_typeb_answer_question_weight'] = $drag_drop_typeb_answer_question_weight;
                                $item['drag_drop_typec_answer_question_weight'] = $drag_drop_typec_answer_question_weight;
                                $item['drag_drop_typed_answer_question_weight'] = $drag_drop_typed_answer_question_weight;
                                $item['drag_drop_typee_answer_question_weight'] = $drag_drop_typee_answer_question_weight;
                                $item['multiple_choice_answer_question_weight'] = $multiple_choice_answer_question_weight;
                                $item['true_or_false_answer_question_weight'] = $true_or_false_answer_question_weight;
                                $item['hotspot_answer_question_weight'] = $hotspot_answer_question_weight;
                            } else {
                                
                            }
                            $subjectAreaSessionUpdated[] = $item;
                        }

                        if (!$item_found) {
                            $status = "fail";
                            $message = "Subject Area Not Found!";
                        } else {
                            $status = "success";
                            $message = "Subject Area Changed";
                        }
                    }

                    Yii::app()->session['subject_area_session'] = $subjectAreaSessionUpdated;
                } else {
                    
                }
            } else {
                $status = "Fail";
                $message = "Please make sure you enter numbers";
            }
//            print_r($subjectAreaSession);
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

//            $_POST['subject_area_id'] != null &&
//                $_POST['subject_area_weight'] != null &&
//                $_POST['single_answer_question_weight'] != null &&
//                $_POST['multiple_answer_question_weight'] != null &&
//                $_POST['short_written_answer_question_weight'] != null &&
//                $_POST['drag_drop_typea_answer_question_weight'] != null &&
//                $_POST['drag_drop_typeb_answer_question_weight'] != null &&
//                $_POST['multiple_choice_answer_question_weight'] != null) {

            if ($_POST['subject_area_id'] == null) {
                $errorInputs[] = "subject_area_id_" . $_POST['count'];
            }
            if ($_POST['subject_area_weight'] == null) {
                $errorInputs[] = "subject_area_weightage_" . $_POST['count'];
            }
            if ($_POST['single_answer_question_weight'] == null) {
                $errorInputs[] = "single_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['multiple_answer_question_weight'] == null) {
                $errorInputs[] = "multiple_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['short_written_answer_question_weight'] == null) {
                $errorInputs[] = "short_written_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typea_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typea_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typeb_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typeb_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typec_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typec_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typed_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typed_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['drag_drop_typee_answer_question_weight'] == null) {
                $errorInputs[] = "drag_drop_typee_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['multiple_choice_answer_question_weight'] == null) {
                $errorInputs[] = "multiple_choice_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['true_or_false_answer_question_weight'] == null) {
                $errorInputs[] = "true_or_false_answer_weightage_" . $_POST['count'];
            }
            if ($_POST['hotspot_answer_question_weight'] == null) {
                $errorInputs[] = "hotspot_answer_weightage_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs,
            $typeErrorInputs
        ));
    }

    public function actionRemoveSubjectArea() {
        if (isset($_POST) && isset($_POST['subject_area_id'])) {

            $subject_area_id = $_POST['subject_area_id'];
            //$count = $_POST['count'];
            if ($subject_area_id != NULL) {
                $subjectAreaSession = Yii::app()->session['subject_area_session'];

//                print_r($subjectAreaSession);

                if ($subjectAreaSession != null) {

                    $i = 0;

                    foreach ($subjectAreaSession as $item) {
                        if ($item['subject_area_id'] == $subject_area_id) {

                            unset($subjectAreaSession[$i]);
                            $subjectAreaSession = array_values($subjectAreaSession);


                            $examSubjectAreaIds = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('exam_subject_area')
                                    ->where('exam_id=:exam_id AND subject_area_id=:subject_area_id', array(':exam_id' => $_POST['exam_id'], ':subject_area_id' => $item['subject_area_id']))
                                    ->queryAll();
                            
//                            print_r($examSubjectAreaIds);die();

                            foreach ($examSubjectAreaIds as $examSubjectAreaId) {
                                ExamSubjectArea::model()->deleteByPk($examSubjectAreaId['exam_subject_area_id']);
                            }
                        }
                        $i++;
                    }
                } else {
                    $subjectAreaSession = array();
                }
                Yii::app()->session['subject_area_session'] = $subjectAreaSession;

                $status = "success";
                $message = "Subject Area Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a question before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                //'count' => $count
            ));
        } else {
            //echo "{'status':'error','message':'Invalid request'}";
            echo CJSON::encode(array(
                'status' => 'fail',
                'message' => 'Invalid request',
                //'count' => $count
            ));
        }
    }

}
