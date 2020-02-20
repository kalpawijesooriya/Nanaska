<?php

class SubjectExamOrderController extends Controller {

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
                'actions' => array('create', 'update','index', 'view', 'addPaperPosition', 'savePaperOrder', 'savePaperOrderEdit'),
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
        $model = new SubjectExamOrder;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SubjectExamOrder'])) {
            $model->attributes = $_POST['SubjectExamOrder'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_exam_order_id));
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

        if (isset($_POST['SubjectExamOrder'])) {
            $model->attributes = $_POST['SubjectExamOrder'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_exam_order_id));
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
        $dataProvider = new CActiveDataProvider('SubjectExamOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SubjectExamOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SubjectExamOrder']))
            $model->attributes = $_GET['SubjectExamOrder'];

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
        $model = SubjectExamOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subject-exam-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddPaperPosition() {
//            $status="success";
//            
        $status = "fail";
        $message = Array();
        $errorInputs = Array();


        $count = $_POST['count'];

        if (isset($_POST['exam_type']) &&
                isset($_POST['exam_id']) &&
                isset($_POST['subject_id']) &&
                $_POST['exam_type'] != null &&
                $_POST['exam_id'] != null &&
                $_POST['subject_id'] != null) {

            $status = "success";

            $exam_type = $_POST['exam_type'];
            $exam_id = $_POST['exam_id'];
            $subject_id = $_POST['subject_id'];


            $paperSession = Yii::app()->session['paper_session'];

            if ($status == "success") {
                if ($paperSession == null) {
                    $paperSession = array();
                    $paperSession[] = array("subject_id" => $subject_id,
                        "exam_id" => $exam_id,
                        "count" => $count);

                    $status = "success";
                    $message = "Paper Added";
                } else {
                    $item_found = false;

                    foreach ($paperSession as $item) {
                        if ($item['subject_id'] == $subject_id && $item['exam_id'] == $exam_id) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {

                        $status = "fail";
                        $message[] = "paper already exists!";
                    } else {
                        $paperSession[] = array("subject_id" => $subject_id,
                            "exam_id" => $exam_id,
                            "count" => $count);

                        $status = "success";
                        $message = "Paper Added";
                    }
                }
                Yii::app()->session['paper_session'] = $paperSession;
            }
        } else {

            $status = "fail";

            $message[] = "Please enter all the values before proceeding";

            if ($_POST['exam_type'] == null) {
                $errorInputs[] = "exam_type_" . $count;
            }
            if ($_POST['exam_id'] == null) {
                $errorInputs[] = "exam_id_" . $count;
            }
        }
//        print_r($paperSession);

        echo CJSON::encode(array(
            array(
                'status' => $status
            ),
            $errorInputs,
            $message
        ));
    }

    public function actionSavePaperOrder() {
        $paperSession = Yii::app()->session['paper_session'];

        $status = "fail";
        $redirect_url = "N/A";
        $message = Array();
        $errorInputs = Array();

        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                $_POST ['course_id'] != null &&
                $_POST ['level_id'] != null &&
                $_POST['subject_id'] != null) {

            $status = "success";

            $course_id = $_POST['course_id'];
            $level_id = $_POST['level_id'];
            $subject_id = $_POST['subject_id'];
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
        }

        if ($_POST['subject_id'] != null) {
            $subject_exam_orders = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('subject_exam_order')
                    ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                    ->queryAll();
            if (!empty($subject_exam_orders)) {
                $status = "fail";
                $message[] = "The Exam Order For this Subject has already been set.";
            }
        }

        if ($status == "success") {
            if (!empty($paperSession)) {
                foreach ($paperSession as $item) {
                    $subject_exam_order_model = new SubjectExamOrder;

                    $subject_exam_order_model->subject_id = $item['subject_id'];
                    $subject_exam_order_model->exam_id = $item['exam_id'];
                    $subject_exam_order_model->position = $item['count'];

                    if ($subject_exam_order_model->save()) {
                        
                    } else {
                        print_r($subject_exam_order_model->errors);
                        die();
                    }
                }
                $redirect_url = CController::createUrl('subject/view&id=' . $subject_id);
            } else {
                $status = "fail";

                $message[] = "Please Add at least one paper before procceeding.";
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message
        ));
    }

    public function actionSavePaperOrderEdit() {
        $paperSession = Yii::app()->session['paper_session'];

        $status = "fail";
        $redirect_url = "N/A";
        $message = Array();
        $errorInputs = Array();

        if (isset($_POST['course_id']) &&
                isset($_POST['level_id']) &&
                isset($_POST['subject_id']) &&
                $_POST ['course_id'] != null &&
                $_POST ['level_id'] != null &&
                $_POST['subject_id'] != null) {

            $status = "success";

            $course_id = $_POST['course_id'];
            $level_id = $_POST['level_id'];
            $subject_id = $_POST['subject_id'];
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
        }

        $subject_exam_orders = Yii::app()->db->createCommand()
                ->select('*')
                ->from('subject_exam_order')
                ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                ->queryAll();

        foreach ($subject_exam_orders as $subject_exam_order) {
            SubjectExamOrder::model()->deleteByPk($subject_exam_order['subject_exam_order_id']);
        }


        if ($_POST['subject_id'] != null) {
            $subject_exam_orders = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('subject_exam_order')
                    ->where('subject_id=:subject_id', array(':subject_id' => $subject_id))
                    ->queryAll();
            if (!empty($subject_exam_orders)) {
                $status = "fail";
                $message[] = "The Exam Order For this Subject has already been set.";
            }
        }

        if ($status == "success") {


            if (!empty($paperSession)) {
                foreach ($paperSession as $item) {
                    $subject_exam_order_model = new SubjectExamOrder;

                    $subject_exam_order_model->subject_id = $item['subject_id'];
                    $subject_exam_order_model->exam_id = $item['exam_id'];
                    $subject_exam_order_model->position = $item['count'];

                    if ($subject_exam_order_model->save()) {
                        
                    } else {
                        print_r($subject_exam_order_model->errors);
                        die();
                    }
                }
                $redirect_url = CController::createUrl('subject/view&id=' . $subject_id);
            } else {
                $status = "fail";

                $message[] = "Please Add at least one paper before procceeding.";
            }
        }


        echo CJSON::encode(array(
            array(
                'status' => $status,
                'redirect_url' => $redirect_url
            ),
            $errorInputs,
            $message
        ));
    }

}
