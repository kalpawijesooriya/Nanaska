<?php

class LecturerPrivilegeController extends Controller {

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
//                'actions' => array('index', 'view', 'saveChangesPrivilegeLevels'),
//                'users' => array('*'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'saveChangesPrivilegeLevels', 'create', 'update'),
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
        $model = new LecturerPrivilege;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LecturerPrivilege'])) {
            $model->attributes = $_POST['LecturerPrivilege'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->lecturer_privilege_id));
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

        if (isset($_POST['LecturerPrivilege'])) {
            $model->attributes = $_POST['LecturerPrivilege'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->lecturer_privilege_id));
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
        $dataProvider = new CActiveDataProvider('LecturerPrivilege');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new LecturerPrivilege('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LecturerPrivilege']))
            $model->attributes = $_GET['LecturerPrivilege'];

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
        $model = LecturerPrivilege::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lecturer-privilege-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSaveChangesPrivilegeLevels() {
        $lecturer_id = $_POST['lecturer_id'];

        $lecturer_privilege_id = $_POST['lecturer_privilege_id'];

        $cm = $_POST['cm'];
        $lm = $_POST['lm'];
        $sm = $_POST['sm'];
        $sam = $_POST['sam'];
        $sim = $_POST['sim'];
        $nm = $_POST['nm'];
        $com = $_POST['com'];
        $stm = $_POST['stm'];
        $lem = $_POST['lem'];
        $tm = $_POST['tm'];
        $em = $_POST['em'];
        $qm = $_POST['qm'];
        $rm = $_POST['rm'];
        $eam = $_POST['eam'];
        $al = $_POST['al'];

        $model_lecturer_privilege = $this->loadModel($lecturer_privilege_id);

        $model_lecturer_privilege->lecturer_id = $lecturer_id;
        $model_lecturer_privilege->course_management = $cm;
        $model_lecturer_privilege->level_management = $lm;
        $model_lecturer_privilege->subject_management = $sm;
        $model_lecturer_privilege->subject_area_management = $sam;
        $model_lecturer_privilege->sitting_management = $sim;
        $model_lecturer_privilege->news_management = $nm;
        $model_lecturer_privilege->country_management = $com;
        $model_lecturer_privilege->student_management = $stm;
        $model_lecturer_privilege->lecturer_management = $lem;
        $model_lecturer_privilege->temporary_users = $tm;
        $model_lecturer_privilege->exam_management = $em;
        $model_lecturer_privilege->question_management = $qm;
        $model_lecturer_privilege->result_management = $rm;
        $model_lecturer_privilege->essay_answer_management = $eam;
        $model_lecturer_privilege->activity_logs = $al;

        if ($model_lecturer_privilege->save()) {
            
        } else {
            print_r($model_lecturer_privilege->errors);
            die();
        }

        $redirect_url = CController::createUrl('lecturer/view&id=' . $lecturer_id);

        echo CJSON::encode(array(
            'status' => "success",
            'redirect_url' => $redirect_url
        ));
    }

}
