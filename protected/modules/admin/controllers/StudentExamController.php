<?php

class StudentExamController extends Controller {

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
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//                                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'dynamicexam', 'presetexam', 'createPresetexam', 'createDynamicexam', 'essayExam', 'createEssayExam'),
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
        $model = new StudentExam;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['StudentExam'])) {
            $model->attributes = $_POST['StudentExam'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->student_exam_id));
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

        if (isset($_POST['StudentExam'])) {
            $model->attributes = $_POST['StudentExam'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->student_exam_id));
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
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('StudentExam');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new StudentExam('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StudentExam']))
            $model->attributes = $_GET['StudentExam'];

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
        $model = StudentExam::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-exam-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDynamicexam($id) {
        $model = new StudentExam;
        $this->render('dynamicexam', array('model' => $model, 'id' => $id));
    }

    public function actionCreateDynamicexam() {
        if (isset($_POST['dexams'])) {

            if (isset($_POST['startdate'])) {

                foreach ($_POST['startdate'] as $key => $start_date) {
//                       $exam_start_date     = date_create($start_date);
//                       $exam_expire_date    = date_create($_POST['expiry_date'][$key]);
//                       
//                       $s_date  = date_format($exam_start_date, "m/d/Y"); 
//                       $e_date  = date_format($exam_expire_date, "m/d/Y");

                    $model_student_exam = new StudentExam;

                    $model_student_exam->student_id = $_POST['student_id'];
                    $model_student_exam->exam_id = $_POST['dexams'];
                    $model_student_exam->start_date = $start_date;
                    $model_student_exam->expiry_date = isset($_POST['expiredate'][$key]) ? $_POST['expiredate'][$key] : NULL;

                    if ($model_student_exam->save()) {
                        
                    } else {
                        print_r($model_student_exam->errors);
                        die;
                    }
                }
            }
        } else {
            echo 'select an exam to add!';
            die;
        }
        $this->redirect(array('student/view', 'id' => $model_student_exam->student_id));
    }

    public function actionPresetexam($id) {
        $model = New StudentExam;
        $this->render('presetexam', array('model' => $model, 'id' => $id));
    }

    public function actionCreatePresetExam() {

        if (isset($_POST['selected_exams'])) {

            $selected_exam_array = $_POST['selected_exams'];
            //print_r($selected_exam_array); die;
            foreach ($selected_exam_array as $selected) {
                $model_exam_student = new StudentExam;

                $model_exam_student->student_id = $_POST['student_id'];
                $model_exam_student->exam_id = $selected;
                $model_exam_student->start_date = $_POST['startdate'];
                $model_exam_student->expiry_date = $_POST['expiredate'];

                if ($model_exam_student->save()) {
                    
                } else {
                    print_r($model_exam_student->errors);
                    die;
                }
            }

            $this->redirect(array('student/view', 'id' => $model_exam_student->student_id));
        } else {

            echo 'Please select exams';
        }
    }

    public function actionEssayExam($id) {
        $model = New StudentExam;
        $this->render('essayexam', array('model' => $model, 'id' => $id));
    }

    public function actionCreateEssayExam() {
        if (isset($_POST['selected_exams'])) {

            $selected_exam_array = $_POST['selected_exams'];
            //print_r($selected_exam_array); die;
            foreach ($selected_exam_array as $selected) {
                $model_exam_student = new StudentExam;

                $model_exam_student->student_id = $_POST['student_id'];
                $model_exam_student->exam_id = $selected;
                $model_exam_student->start_date = $_POST['startdate'];
                $model_exam_student->expiry_date = $_POST['expiredate'];

                if ($model_exam_student->save()) {
                    
                } else {
                    print_r($model_exam_student->errors);
                    die;
                }
            }

            $this->redirect(array('student/view', 'id' => $model_exam_student->student_id));
        }
    }

}

