<?php

class QuestionPartController extends Controller {

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
                'actions' => array('create', 'update', 'index', 'view', 'addQuestionPart', 'saveQuestionPart',
                    'removeQuestionPart', 'addMultipleChoiceQuestionPart', 'addAnswerToQuestionPart',
                    'addQuestionPartForDragDropTypeE', 'addOtherAnswer', 'saveQuestionPartForDragDropTypeE',
                    'saveOtherAnswer', 'removeOtherAnswer', 'saveQuestionPartForMultipleChoice', 'removeAnswerToQuestionPart', 'removeMultiChoiceQuestionPart'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
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
        $model = new QuestionPart;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['QuestionPart'])) {
            $model->attributes = $_POST['QuestionPart'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->question_part_id));
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

        if (isset($_POST['QuestionPart'])) {
            $model->attributes = $_POST['QuestionPart'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->question_part_id));
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
        $dataProvider = new CActiveDataProvider('QuestionPart');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new QuestionPart('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['QuestionPart']))
            $model->attributes = $_GET['QuestionPart'];

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
        $model = QuestionPart::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'question-part-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddQuestionPart() {
        $errorInputs = Array();
//        $typeErrorInputs = Array();

        $status = "fail";

        if (isset($_POST['question_part']) &&
                isset($_POST['answer']) &&
                $_POST['question_part'] != null &&
                $_POST['answer'] != null) {

            $status = "success";

            $session_name = $_POST['session_name'];

            $question_part = $_POST['question_part'];
            $answer = $_POST['answer'];
            $count = $_POST['count'];
            $up = $_POST['up'];


            $Session = Yii::app()->session[$session_name];

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "answer" => $answer,
                        "position" => $count);

                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;
                    foreach ($Session as $item) {
                        if ($item['question_part'] == $question_part && $item['answer'] == $answer) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {

                        $status = "fail";
                        $message = "Question Part Already Exists!";
                    } else {
//                        if ($up == 'UPDATE') {
                        $change = FALSE;
                        $qpartCount = $_POST['question_part_count'];
                        foreach ($Session as $key => $item) {
                            if ($item['position'] == $count) {
                                $Session[$key] = array("question_part" => $question_part,
                                    "answer" => $answer,
                                    "position" => $count);

                                $change = TRUE;
                            }
                        }

                        if ($change === FALSE) {
                            if (isset($Session[$count - 1])) {
                                $Session[$count - 1] = array("question_part" => $question_part,
                                    "answer" => $answer,
                                    "position" => $count);
                            } else {
                                $Session[] = array("question_part" => $question_part,
                                    "answer" => $answer,
                                    "position" => $count);
                            }
                        }

                        if ($change == false) {
                            $status = "success";
                        } else {
                            $status = "success2";
                        }


                        $message = "Question Part Area Added";
                    }
                }

                Yii::app()->session[$session_name] = $Session;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }
            if ($_POST['answer'] == null) {
                $errorInputs[] = "answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionSaveQuestionPart() {

        $errorInputs = Array();

        $status = "fail";

        if (isset($_POST['question_part']) &&
                isset($_POST['answer']) &&
                $_POST['question_part'] != null &&
                $_POST['answer'] != null) {

            $status = "success";

            $session_name = $_POST['session_name'];

            $question_part = $_POST['question_part'];
            $answer = $_POST['answer'];
            $count = $_POST['count'];

            $Session = Yii::app()->session[$session_name];



            $SessionUpdated = array();

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "answer" => $answer);

                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {
                            $item_found = true;


                            $item['question_part'] = $question_part;
                            $item['answer'] = $answer;
                        } else {
                            
                        }
                        $SessionUpdated[] = $item;
                    }

                    if (!$item_found) {
                        $status = "fail";
                        $message = "Question Part Not Found!";
                    } else {
                        $status = "success";
                        $message = "Question Part Changed";
                    }
                }

                Yii::app()->session[$session_name] = $SessionUpdated;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }
            if ($_POST['answer'] == null) {
                $errorInputs[] = "answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionRemoveQuestionPart() {

        if (isset($_POST) && isset($_POST['count'])) {
            $status = "success";
            $message = "Question Part Successfully Removed";
            $count = $_POST['count'];

            if ($count != NULL) {

                $session_name = $_POST['session_name'];
                $Session = Yii::app()->session[$session_name];

                if ($Session != null) {
                    $i = 0;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {
                            unset($Session[$i]);
                            $Session = array_values($Session);
                        }
                        $i++;
                    }
                } else {
                    $Session = array();
                }

                Yii::app()->session[$session_name] = $Session;

                $status = "success";
                $message = "Question Part Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a Question Part before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public function actionAddMultipleChoiceQuestionPart() {
        $errorInputs = Array();
        $status = "fail";

        if (isset($_POST['question_part']) &&
                $_POST['question_part'] != null) {
            $status = "success";

            $session_name = $_POST['session_name'];


            $question_part = $_POST['question_part'];
            $count = $_POST['count'];
            $correct_choice = $_POST['is_correct'];
            $option = $_POST['option'];

            $Session = Yii::app()->session[$session_name];
            
            if (isset($_POST['is_correct'])) {
                if ($_POST['is_correct'] == 0) {
                    $status = "fail";
                    $message = "option not selected";
                    if ($_POST['question_part'] == null) {
                        $errorInputs[] = "question_part_" . $_POST['count'];
                    }
                }
            }

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "position" => $count, "is_correct" => $correct_choice, "option" => $option);
                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['question_part'] == $question_part) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {
                        $status = "fail";
                        $message = "Question Part Already Exists!";
                    } else {

                        $change = FALSE;

                        foreach ($Session as $key => $item) {
                            if ($item['position'] == $count) {//                                
                                $Session[$key] = array("question_part" => $question_part,
                                    "position" => $count, "is_correct" => $correct_choice, "option" => $option);

                                $change = TRUE;
                            }
                        }

                        if ($change === FALSE) {
                            if (isset($Session[$count - 1])) {

                                $Session[$count - 1] = array("question_part" => $question_part,
                                    "position" => $count, "is_correct" => $correct_choice);
                            } else {
                                $Session[] = array("question_part" => $question_part,
                                    "position" => $count, "is_correct" => $correct_choice);
                            }
                        }
                        $status = "success";
                        $message = "Question Part Area Added";
                    }
                }
                Yii::app()->session[$session_name] = $Session;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }
        }

        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionAddAnswerToQuestionPart() {

        if (isset($_POST['answer_text']) && $_POST['answer_text'] != null) {
            $answer_text = $_POST['answer_text'];

            $question_part = $_POST['question_part'];
            $count = $_POST['count'];
            $i = $_POST['i'];
            $is_correct = $_POST['is_correct'];
            $status = "success";

            if ($_POST['question_part'] == null) {
                $status = "fail";
                $message = "Question Part Cannot be Blank!";
            }
        } else {
            $status = "fail";
            $message = "Answer Text Cannot be Blank!";
        }

        if ($status == "success") {
            $Session = Yii::app()->session['multiple_choice_answer_session'];

            if ($Session == null) {
                $Session = array();
                $Session[$count - 1][] = array("question_part" => $question_part,
                    "answer_text" => $answer_text,
                    "is_correct" => $is_correct,
                    "position" => $count,
                    "answer_position" => $i);

                $status = "success";
                $message = "Question Part Answer Added";
            } else {
                $item_found = false;

                foreach ($Session as $items) {
                    foreach ($items as $key => $item) {
                        if ($item['question_part'] == $question_part && $item['answer_text'] == $answer_text && $item['is_correct'] == $is_correct) {
                            $item_found = true;
                        }
                    }
                }

                if ($item_found) {

                    $status = "fail";
                    $message = "Question Part Answer Already Exists!";
                } else {
                    $change = FALSE;
//                    var_dump($Session[$count]);
//                    die;

                    foreach ($Session as $items) {

                        foreach ($items as $key => $item) {
                            if ($key == $i) {
                                if ($item['answer_position'] == $i) {
                                    $Session[$count][$key] = array("question_part" => $question_part,
                                        "answer_text" => $answer_text,
                                        "is_correct" => $is_correct,
                                        "position" => $count,
                                        "answer_position" => $i);

                                    $change = TRUE;
                                }
                            }
                        }
                    }


                    if ($change === FALSE) {
                        if (isset($Session[$count - 1][$i - 1])) {
                            $Session[$count - 1][$i - 1] = array("question_part" => $question_part,
                                "answer_text" => $answer_text,
                                "is_correct" => $is_correct,
                                "position" => $count,
                                "answer_position" => $i);
                        } else {
                            $Session[$count - 1][] = array("question_part" => $question_part,
                                "answer_text" => $answer_text,
                                "is_correct" => $is_correct,
                                "position" => $count,
                                "answer_position" => $i);
                        }
                    }

                    $status = "success";
                    $message = "Question Part Answer Added";
                }
            }

            Yii::app()->session['multiple_choice_answer_session'] = $Session;
        }


        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message
        ));
    }

    public function actionRemoveAnswerToQuestionPart() {
        if (isset($_POST) && isset($_POST['count'])) {
            $count = $_POST['count'];
            $k = $_POST['i'];

            if ($k != NULL) {
                $session_name = $_POST['session_name'];
                $Session = Yii::app()->session[$session_name];

                if ($Session != null) {
                    $i = 0;

                    foreach ($Session[$count - 1] as $item) {
                        if ($item['answer_position'] == $k) {
                            unset($Session[$count - 1][$i]);
                            $Session[$count - 1] = array_values($Session[$count - 1]);
                        }
                        $i++;
                    }
                } else {
                    $Session = array();
                }

                Yii::app()->session[$session_name] = $Session;

                $status = "success";
                $message = "Question Part Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a Question Part before proceeding";
            }
            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public function actionAddQuestionPartForDragDropTypeE() {
        $errorInputs = Array();


        $status = "fail";

        if (isset($_POST['question_part']) &&
                isset($_POST['question_part_text']) &&
                isset($_POST['answer']) &&
                $_POST['question_part'] != null &&
                $_POST['question_part_text'] != null &&
                $_POST['answer'] != null) {



            $status = "success";

            $session_name = $_POST['session_name'];

            $question_part = $_POST['question_part'];
            $question_part_text = $_POST['question_part_text'];
            $answer = $_POST['answer'];
            $count = $_POST['count'];
            //$up = $_POST['up'];

            $other_session = Yii::app()->session['other_answer_session'];

            if ($other_session != null) {
                $item_found = false;
                foreach ($other_session as $item) {
                    if ($item['other_answer'] == $answer) {
                        $item_found = true;
                    }
                }

                if ($item_found) {
                    $status = "fail";
                    $message = "Answer Already Exists as an other answer!";
                }
            }


            $Session = Yii::app()->session[$session_name];

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "question_part_text" => $question_part_text,
                        "answer" => $answer,
                        "position" => $count);

                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['question_part'] == $question_part && $item['question_part_text'] == $question_part && $item['answer'] = $answer) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {

                        $status = "fail";
                        $message = "Question Part Already Exists!";
                    } else {
                        $change = FALSE;

                        foreach ($Session as $key => $item) {
                            if ($item['position'] == $count) {
                                $Session[$key] = array("question_part" => $question_part,
                                    "question_part_text" => $question_part_text,
                                    "answer" => $answer,
                                    "position" => $count);

                                $change = TRUE;
                            }
                        }

                        if ($change === FALSE) {
                            if (isset($Session[$count - 1])) {

                                $Session[$count - 1] = array("question_part" => $question_part,
                                    "question_part_text" => $question_part_text,
                                    "answer" => $answer,
                                    "position" => $count);
                            } else {
                                $Session[] = array("question_part" => $question_part,
                                    "question_part_text" => $question_part_text,
                                    "answer" => $answer,
                                    "position" => $count);
                            }
                        }
                        $status = "success";
                        $message = "Question Part Area Added";
                    }
                }

                Yii::app()->session[$session_name] = $Session;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }

            if ($_POST['question_part_text'] == null) {
                $errorInputs[] = "question_part_text_" . $_POST['count'];
            }

            if ($_POST['answer'] == null) {
                $errorInputs[] = "answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionAddOtherAnswer() {
//        print_r($_POST);
//                die();

        $errorInputs = Array();
//        $typeErrorInputs = Array();
        $count = $_POST['count'];
        $up = $_POST['up'];
        $status = "fail";

        if (isset($_POST['other_answer']) &&
                $_POST['other_answer'] != null) {

            $status = "success";

            $question_type = $_POST['question_type'];
            $session_name = $_POST['session_name'];
            $other_answer = $_POST['other_answer'];
            $Session = Yii::app()->session[$session_name];


            if ($question_type == "drag_drop_typed") {
                $answer_1 = $_POST['answer_1'];
                $answer_2 = $_POST['answer_2'];

                if ($other_answer == $answer_1 || $other_answer == $answer_2) {
                    $status = "fail";
                    $message = "Other Answer Already Exists as a correct answer!";
                }
            } else if ($question_type == "drag_drop_typee") {

                $typee_session = Yii::app()->session['drag_drop_typee_question_part_session'];

                if ($typee_session != null) {
                    $item_found = false;
                    foreach ($typee_session as $item) {
                        if ($item['answer'] == $other_answer) {
                            $item_found = true;
                        }
                    }

                    if ($item_found) {
                        $status = "fail";
                        $message = "Other Answer Already Exists as a correct answer!";
                    }
                }
            }

            if ($status == "success") {
                //var_dump($Session);die;
                if ($Session == null) {
                    $Session = array();
                    $Session[] = array(
                        "other_answer" => $other_answer,
                        "position" => $count);

                    $status = "success";
                    $message = "Other Answer Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['other_answer'] == $other_answer) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {

                        $status = "fail";
                        $message = "Other Answer Already Exists!";
                    } else {
                        if ($up == 'UPDATE') {
                            $qpartCount = $_POST['qpart_count'];

//                            var_dump($Session);
                            $sessionIndex = ($count - $qpartCount);
//                             echo $qpartCount."ccccc". $sessionIndex;die;

                            if (isset($Session[$count - 1])) {

                                $Session[$sessionIndex] = array(
                                    "other_answer" => $other_answer,
                                    "position" => $count);
                            } else {
                                $Session[] = array(
                                    "other_answer" => $other_answer,
                                    "position" => $count);
                            }
                        } else {

                            if (isset($Session[$count - 1])) {

                                $Session[$count - 1] = array(
                                    "other_answer" => $other_answer,
                                    "position" => $count);
                            } else {
                                $Session[] = array(
                                    "other_answer" => $other_answer,
                                    "position" => $count);
                            }
                        }
                        $status = "success";
                        $message = "Other Answer Added";
                    }
                }

                Yii::app()->session[$session_name] = $Session;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['other_answer'] == null) {
                $errorInputs[] = "other_answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ),
            $errorInputs
        ));
    }

    public function actionSaveQuestionPartForDragDropTypeE() {
        $errorInputs = Array();

        $status = "fail";

        if (isset($_POST['question_part']) &&
                isset($_POST['question_part_text']) &&
                isset($_POST['answer']) &&
                $_POST['question_part'] != null &&
                $_POST['question_part_text'] != null &&
                $_POST['answer'] != null) {

            $status = "success";

            $session_name = $_POST['session_name'];

            $question_part = $_POST['question_part'];
            $question_part_text = $_POST['question_part_text'];
            $answer = $_POST['answer'];
            $count = $_POST['count'];

            $Session = Yii::app()->session[$session_name];

            $typee_session = Yii::app()->session['drag_drop_typee_question_part_session'];

            if ($typee_session != null) {
                $item_found = false;
                foreach ($typee_session as $item) {
                    if ($item['answer'] == $answer && $item['question_part'] == $question_part && $item['question_part_text'] == $question_part_text) {
                        $item_found = true;
                    }
                }

                if ($item_found) {
                    $status = "fail";
                    $message = "Answer Already Exists!";
                }
            }

            $other_session = Yii::app()->session['other_answer_session'];

            if ($other_session != null) {
                $item_found = false;
                foreach ($other_session as $item) {
                    if ($item['other_answer'] == $answer) {
                        $item_found = true;
                    }
                }

                if ($item_found) {
                    $status = "fail";
                    $message = "Answer Already Exists as an Other Answer!";
                }
            }

            $SessionUpdated = array();

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "question_part_text" => $question_part_text,
                        "answer" => $answer);

                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {
                            $item_found = true;

                            $item['question_part'] = $question_part;
                            $item['question_part_text'] = $question_part_text;
                            $item['answer'] = $answer;
                        } else {
                            
                        }
                        $SessionUpdated[] = $item;
                    }

                    if (!$item_found) {
                        $status = "fail";
                        $message = "Question Part Not Found!";
                    } else {
                        $status = "success";
                        $message = "Question Part Changed";
                    }
                }

                Yii::app()->session[$session_name] = $SessionUpdated;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }
            if ($_POST['question_part_text'] == null) {
                $errorInputs[] = "question_part_text_" . $_POST['count'];
            }
            if ($_POST['answer'] == null) {
                $errorInputs[] = "answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionSaveOtherAnswer() {
        $errorInputs = Array();

        $status = "fail";

        if (isset($_POST['other_answer']) &&
                $_POST['other_answer'] != null) {

            $status = "success";

            $session_name = $_POST['session_name'];

            $other_answer = $_POST['other_answer'];
            $count = $_POST['count'];

            $Session = Yii::app()->session[$session_name];


            $question_type = $_POST['question_type'];

            if ($question_type == "drag_drop_typed") {
                
            } else if ($question_type == "drag_drop_typee") {

                $other_session = Yii::app()->session['other_answer_session'];

                if ($other_session != null) {
                    $item_found = false;
                    foreach ($other_session as $item) {
                        if ($item['other_answer'] == $other_answer) {
                            $item_found = true;
                        }
                    }

                    if ($item_found) {
                        $status = "fail";
                        $message = "Other Answer Already Exists";
                    }
                }

                $typee_session = Yii::app()->session['drag_drop_typee_question_part_session'];

                if ($typee_session != null) {
                    $item_found = false;
                    foreach ($typee_session as $item) {
                        if ($item['answer'] == $other_answer) {
                            $item_found = true;
                        }
                    }

                    if ($item_found) {
                        $status = "fail";
                        $message = "Other Answer Already Exists As a Correct Answer!";
                    }
                }
            }

            $SessionUpdated = array();

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array(
                        "other_answer" => $other_answer,
                        "position" => $count);

                    $status = "success";
                    $message = "Other Answer Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {
                            $item_found = true;

                            $item['other_answer'] = $other_answer;
                        } else {
                            
                        }
                        $SessionUpdated[] = $item;
                    }

                    if (!$item_found) {
                        $status = "fail";
                        $message = "Other Answer Not Found!";
                    } else {
                        $status = "success";
                        $message = "Other Answer Changed";
                    }
                }

                Yii::app()->session[$session_name] = $SessionUpdated;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['other_answer'] == null) {
                $errorInputs[] = "other_answer_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionRemoveOtherAnswer() {
        if (isset($_POST) && isset($_POST['count'])) {

            $count = $_POST['count'];

            if ($count != NULL) {

                $session_name = $_POST['session_name'];

                $Session = Yii::app()->session[$session_name];


                if ($Session != null) {

                    $i = 0;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {

                            unset($Session[$i]);
                            $Session = array_values($Session);
                        }
                        $i++;
                    }
                } else {
                    $Session = array();
                }
                Yii::app()->session[$session_name] = $Session;

                $status = "success";
                $message = "Other Answer Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select Other Answer before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public function actionSaveQuestionPartForMultipleChoice() {
        $errorInputs = Array();

        $status = "fail";

        if (isset($_POST['question_part']) &&
                $_POST['question_part'] != null) {

            $status = "success";

            $session_name = $_POST['session_name'];

            $question_part = $_POST['question_part'];
            $count = $_POST['count'];
            $is_correct = $_POST['is_correct'];
            $question_part_id = $_POST['question_part_id'];

            $Session = Yii::app()->session[$session_name];

            $SessionUpdated = array();
            $finalArray = array();
            
            if (isset($_POST['is_correct'])) {
                if ($_POST['is_correct'] == 0) {
                    $status = "fail";
                    $message = "option not selected";
                    if ($_POST['question_part'] == null) {
                        $errorInputs[] = "question_part_" . $_POST['count'];
                    }
                }
            }

            if ($status == "success") {

                if ($Session == null) {
                    $Session = array();
                    $Session[] = array("question_part" => $question_part,
                        "position" => $count, "is_correct" => $is_correct, "question_part_id" => $question_part_id);

                    $status = "success";
                    $message = "Question Part Area Added";
                } else {
                    $item_found = false;

                    foreach ($Session as $key => $value) {
                        foreach ($value as $k => $item) {
                            if ($item['position'] == $count) {
                                $item_found = true;
                                $item['question_part'] = $question_part;
                                $item['is_correct'] = $is_correct;
                                $item['question_part_id'] = $question_part_id;
                            }
                            $SessionUpdated[$key][$k] = $item;
                        }
                    }


                    if (!$item_found) {
                        $status = "fail";
                        $message = "Question Part Not Found!";
                    } else {
                        $status = "success";
                        $message = "Question Part Changed";
                    }
                }

                Yii::app()->session[$session_name] = $SessionUpdated;
            } else {
                
            }
        } else {
            $status = "fail";

            $message = "Please enter all the values before proceeding";

            if ($_POST['question_part'] == null) {
                $errorInputs[] = "question_part_" . $_POST['count'];
            }

            if ($_POST['is_correct'] == null) {
                $errorInputs[] = "No correct answer for question part question_part_" . $_POST['count'];
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'message' => $message
            ),
            $errorInputs
        ));
    }

    public function actionRemoveMultiChoiceQuestionPart() {

        if (isset($_POST) && isset($_POST['count'])) {
            $status = "success";
            $message = "Question Part Successfully Removed";
            $count = $_POST['count'];

            if ($count != NULL) {

                $session_name = $_POST['session_name'];
                $Session = Yii::app()->session[$session_name];

                if ($Session != null) {
                    $i = 0;

                    foreach ($Session as $key => $value) {

                        foreach ($value as $k => $item) {
                            if ($item['position'] == $count) {
                                unset($Session[$key]);
                            }
                        }
                        $Session = array_values($Session);
                    }
                } else {
                    $Session = array();
                }

                Yii::app()->session[$session_name] = $Session;

                $status = "success";
                $message = "Question Part Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a Question Part before proceeding";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

}
