<?php

include_once 'EmailHandler.php';

class LecturerController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'index', 'view', 'suspend', 'reactivate', 'ViewAuthoredQuestions',
                    'getQuestionsByLecturer', 'showAuthoredQuestions', 'setPrivilegeLevels', 'editPrivilegeLevels',
                    'setPrivilegeLevel', 'unsetPrivilegeLevel', 'savePrivilegeLevels'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update', 'admin'),
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

    public function actionViewAuthoredQuestions() {
        $this->render('view_authored_questions', array(
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {


        $model = new User;
        $model_lecturer = new Lecturer;

        $model->setscenario('created');

        $model_subject_lecturer = new SubjectLecturer;


        $subjects = Yii::app()->session['subject_session'];

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {

            $sendpass = $_POST['User']['password'];
            $pass = md5($_POST['User']['password']);
            $_POST['User']['password'] = $pass;

            $model->attributes = $_POST['User'];
            $model_lecturer->attributes = $_POST['Lecturer'];
            $model_lecturer->user_id = 0; //temporary user id for validate()
            //$model_student->attributes = $_POST['Student'];

            $dbtransaction = Yii::app()->db->beginTransaction();

            $validate = false;
            $model_validate = $model->validate();
            $model_lecturer_validate = $model_lecturer->validate();
            if ($model_validate && $model_lecturer_validate) {
                $validate = true;
            }

            try {
                if ($validate && $model->save()) {
                    $user_id = $model->getPrimaryKey();
                    $model_lecturer->user_id = $model->user_id;
                    $lec_id = "";
                    //$model_lecturer->note = $_POST['note'];
                    //$model_lecturer->extra_number = $_POST['extra_number'];
                    //$model_lecturer->lecturer_code = $_POST['lecturer_code'];

                    if ($model_lecturer->save()) {
//                        echo'success!';die();

                        $model_subject_lecturer->lecturer_id = $model_lecturer->lecturer_id;

                        if (!empty($subjects)) {

                            $model_subject_lecturer->lecturer_id = $model_lecturer->lecturer_id;

                            $lecId = $model_subject_lecturer->lecturer_id;

//                            print_r($subjects);
                            //echo $_POST['User']['email'];die;

                            foreach ($subjects as $subject) {
                                $model_subject_lecturer2 = new SubjectLecturer;
                                $model_subject_lecturer2->lecturer_id = $lecId;


                                $model_subject_lecturer2->subject_id = $subject['subject_id'];


                                if ($model_subject_lecturer2->save()) {
                                    $lec_id = $model_subject_lecturer2->getPrimaryKey();
                                } else {
                                    // print_r($model_subject_lecturer2->errors);
//                                    die();
                                    throw new Exception();
                                }
                            }
                            $dbtransaction->commit();
                            Yii::app()->session['subject_session'] = Array();
                        } else {

                            $dbtransaction->commit();

                            Yii::app()->session['subject_session'] = Array();
                        }

                        $subject = "LearnCima Credentials";
                        $message = "We are happy to inform you that we have successfully registered you in our portal. Now you can use following email address and password to login.\n" . "<br/><br/>Email : " . $_POST['User']['email'] . "<br/><br/>password : " . $sendpass;
                        $email = $_POST['User']['email'];

                        sendEmail($subject, $message, $email);

                        //  $user_id = Yii::app()->user->id;

                        $model_lecturer_audit = new Audit;
                        $model_lecturer_audit->user_id = $user_id;
                        $model_lecturer_audit->action_id = $lec_id;
                        $model_lecturer_audit->action_name = "LECTURER_MANAGEMENT";
                        $model_lecturer_audit->action = 'SAVE';
                        $model_lecturer_audit->date = date("Y/m/d");
                        $model_lecturer_audit->time = date("h:i:sa");
                        $model_lecturer_audit->status = 1;

                        if ($model_lecturer_audit->save()) {
                            
                        } else {
                            print_r($model_lecturer_audit->errors);
                            die();
                        }


                        $this->redirect(array('view', 'id' => $model_lecturer->lecturer_id));
                    } else {
                        print_r($model_lecturer->errors);
                        die();
                    }
                } else {
//                    print_r($model->errors);
//                    die();
                }
            } catch (Exception $e) {
                print_r($e);
                die();
                $dbtransaction->rollback();
            }
        } else {
            Yii::app()->session['subject_session'] = Array();
        }

        $this->render('create', array(
            'model' => $model,
            'model_lecturer' => $model_lecturer,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
//        $model = $this->loadModel($id);

        $user_id = Lecturer::getUserIdByLecturerId($id);

        $model = User::model()->findByPk($user_id);

        $criteria = new CDbCriteria;
        $criteria->condition = "user_id >= '.$user_id.'";
        $model_lecturer = Lecturer::model()->find($criteria);

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];
            $model_lecturer->attributes = $_POST['Lecturer'];
            $validate = false;
            $model_validate = $model->validate();
            $model_lecturer_validate = $model_lecturer->validate();
            if ($model_validate && $model_lecturer_validate) {
                $validate = true;
            }

            if ($validate && $model->save()) {

                if ($model_lecturer->save()) {
//                  
                    $subLecIds = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('subject_lecturer')
                            ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $id))
                            ->queryAll();

                    foreach ($subLecIds as $subLecId) {
                        SubjectLecturer::model()->deleteByPk($subLecId['subject_lecturer_id']);
                    }


                    $subjects = Yii::app()->session['subject_session'];
                    print_r($subjects);
                    if (!empty($subjects)) {

                        foreach ($subjects as $subject) {
                            $model_subject_lecturer2 = new SubjectLecturer;
                            $model_subject_lecturer2->lecturer_id = $id;

                            $model_subject_lecturer2->subject_id = $subject['subject_id'];


                            if ($model_subject_lecturer2->save()) {
                                
                            } else {
                                print_r($model_subject_lecturer2->errors);
                                throw new Exception();
                            }
                        }
                        Yii::app()->session['subject_session'] = Array();
                    }
                }

                $model_lecturer_audit = new Audit;
                $model_lecturer_audit->user_id = $model->user_id;
                $model_lecturer_audit->action_id = $model_lecturer->lecturer_id;
                $model_lecturer_audit->action_name = "LECTURER_MANAGEMENT";
                $model_lecturer_audit->action = 'EDIT';
                $model_lecturer_audit->date = date("Y/m/d");
                $model_lecturer_audit->time = date("h:i:sa");
                $model_lecturer_audit->status = 1;

                if ($model_lecturer_audit->save()) {
                    
                } else {
                    print_r($model_lecturer_audit->errors);
                    die();
                }

                $this->redirect(array('view', 'id' => $id));
            }
        } else {

            $subjectIds = SubjectLecturer::loadLecturerSubjectSession($id);

            $subjectNames = Array();

            foreach ($subjectIds as $subjectId) {
                $subjectNames[] = Subject::model()->getSubjectName($subjectId['subject_id']);
            }

            $subjects = Array();

            foreach ($subjectIds as $index => $subjectId) {
                $subjects[] = Array("subject_id" => $subjectId['subject_id'], "subject_name" => $subjectNames[$index]);
            }

            Yii::app()->session['subject_session'] = $subjects;
        }

        $this->render('update', array(
            'model' => $model,
            'lecturer_model' => $model_lecturer,
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
            //$this->loadModel($id)->delete();

            $subLecIds = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('subject_lecturer')
                    ->where('lecturer_id=:lecturer_id', array(':lecturer_id' => $id))
                    ->queryAll();

            foreach ($subLecIds as $subLecId) {
                SubjectLecturer::model()->deleteByPk($subLecId['subject_lecturer_id']);
            }

            $lec = Lecturer::model()->findByPk($id);
            $user_id = $lec->user_id;

            $this->loadModel($id)->delete();
            User::model()->deleteByPk($user_id);


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
        $dataProvider = new CActiveDataProvider('Lecturer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
//        $model = new Lecturer('search');
//        $model = new User('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['User']))
//            $model->attributes = $_GET['User'];
//
//        $this->render('admin', array(
//            'model' => $model,
//        ));

        $model = new Lecturer('search');
        //$model_user = new User('search');

        $model->unsetAttributes();  // clear any default values
        //$model_user->unsetAttributes();

        if (isset($_GET['Lecturer']))
            $model->attributes = $_GET['Lecturer'];



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
        $model = Lecturer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lecturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetLevelsForCourse() {
        $data = Level::model()->findAll('course_id=:course_id', array(':course_id' => (int) $_POST['course_id']));

        $data = CHtml::listData($data, 'level_id', 'level_name');
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionSuspend() {
        $lec_id = $_POST['lecturer_id'];
        $model = Lecturer::model()->findByPk($lec_id);

        $model->status = 0;

        if ($model->save()) {
            $status = "success";
        } else {
            print_r($model->errors);
            die();
        }

        echo CJSON::encode(array(
            'status' => $status
        ));
    }

    public function actionReactivate() {
        $lec_id = $_POST['lecturer_id'];
        $model = Lecturer::model()->findByPk($lec_id);

        $model->status = 1;

        if ($model->save()) {
            $status = "success";
        } else {
            print_r($model->errors);
            die();
        }

        echo CJSON::encode(array(
            'status' => $status
        ));
    }

    public function actionGetQuestionsByLecturer() {
        echo $_POST['lecturer_id'];
    }

    public function actionShowAuthoredQuestions() {
        $unapproved_questions = array();

        if (isset($_POST['lecturer_code']) && $_POST['lecturer_code'] != null) {
            $status = "success";
            $lecturer_code = $_POST['lecturer_code'];

            $user_id = Lecturer::getUserIdByLecturerCode($lecturer_code);
            $lecturer_id = Lecturer::getLecturerIdByUserId($user_id);
            $unapproved_questions = Question::model()->getUnApprovedQuestionsByUserId($user_id);
            $this->renderPartial('authored_questions_table_form', array(
                'questions' => $unapproved_questions,
                'lecturer_id' => $lecturer_id
                    ), false, true);
        } else {
            $status = "fail";
        }
    }

    public function actionSetPrivilegeLevels($id) {
        $this->render('_setPrivilegeLevels', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSetPrivilegeLevel() {
        echo CJSON::encode(array(
            'status' => "success"
        ));
    }

    public function actionUnsetPrivilegeLevel() {
        echo CJSON::encode(array(
            'status' => "success"
        ));
    }

    public function actionSavePrivilegeLevels() {
        $lecturer_id = $_POST['lecturer_id'];

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

        $model_lecturer_privilege = new LecturerPrivilege;

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

    public function actionEditPrivilegeLevels($id) {
        $lecturer_privilege = LecturerPrivilege::model()->getPrivilegeByLecturerId($id);

        $this->render('_editPrivilegeLevels', array(
            'model' => $this->loadModel($id),
            'model_lecturer_privilege' => $lecturer_privilege
        ));
    }

}
