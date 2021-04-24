<?php

class SubjectLecturerController extends Controller {

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
                'actions' => array('create', 'update','index', 'view','addsubject','removesubject'),
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
        $model = new SubjectLecturer;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SubjectLecturer'])) {
            $model->attributes = $_POST['SubjectLecturer'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_lecturer_id));
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

        if (isset($_POST['SubjectLecturer'])) {
            $model->attributes = $_POST['SubjectLecturer'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_lecturer_id));
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
        $dataProvider = new CActiveDataProvider('SubjectLecturer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SubjectLecturer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SubjectLecturer']))
            $model->attributes = $_GET['SubjectLecturer'];

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
        $model = SubjectLecturer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subject-lecturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddSubject() {

        $status = "success";

        if (isset($_POST['subject_id'])) {
            $subjectID = $_POST['subject_id'];

            if ($subjectID == "prompt") {
                $status = "fail";
                $message = "Select a Subject to proceed";
                $subjectName = "N/A";
            } else {
                $subjectName = Subject::model()->getSubjectName($subjectID);


                $subjectSession = Yii::app()->session['subject_session'];

                if ($subjectSession == null) {
                    $subjectSession = array();
                    $subjectSession[] = array("subject_id" => $subjectID, "subject_name" => $subjectName);
                    $status = "success";
                    $message = "Subject Added";
                } else {
                    $item_found = false;

                    foreach ($subjectSession as $item) {
                        if ($item['subject_id'] == $subjectID) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {

                        $status = "fail";
                        $message = "Subject Already Exists!";
                    } else {
                        $subjectSession[] = array("subject_id" => $subjectID, "subject_name" => $subjectName);
                        $status = "success";
                        $message = "Subject Added";
                    }
                }


                Yii::app()->session['subject_session'] = $subjectSession;
                
                
            }
        } else {
            $status = "fail";
            $message = "Error";
            $subjectName = "N/A";
        }

        
//        print_r($subjectSession);
        
        echo CJSON::encode(array(
            'message' => $message,
            'status' => $status,
            'subjectName' => $subjectName,
            'subjectID'=> $subjectID
        ));
    }
    
    public function actionRemoveSubject(){
        
        if (isset($_POST) && isset($_POST['subject_id'])) {
             
            $subjectID =  $_POST['subject_id']; 
        
           
            $subjectSession = Yii::app()->session['subject_session'];
            
            
            if ($subjectSession != null) {
                
                $i = 0;
                  
                foreach ($subjectSession as $item) {
                    if ($item["subject_id"] == $subjectID) {
                        
                        unset($subjectSession[$i]);
                        $subjectSession  = array_values($subjectSession);
                    }
                    $i++;
                }
            } else {
                
                $subjectSession = array();
            }

            Yii::app()->session['subject_session'] = $subjectSession;
            
           
            echo CJSON::encode(array(
                'status' => 'success',
                'message' => 'Item successfully removed',
                'subjectSelected' => $_POST['subject_id']
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
        
        
    }

}
