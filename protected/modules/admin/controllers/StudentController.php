<?php

include_once 'EmailHandler.php';

class StudentController extends Controller {

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
                'actions' => array('index', 'view', 'addExamToStudent', 'removeExam', 'getViews',
                    'AddDynamicExams', 'getCourses', 'getLevels', 'create', 'admin', 'update', 'Suspend', 'Reactivate', 'Presetexam', 'getCourses', 'getAllStudentEmails',
                    'getCourseForEmail'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create','admin', 'update', 'Suspend', 'Reactivate', 'Presetexam', 'getCourses'),
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

    public function actionPresetexam() {
        
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new User;
        $model_student = new Student;

        //$exams = Yii::app()->session['exam_session'];       
//        if (!isset(Yii::app()->session['exam_session'])) {
//            Yii::app()->session['exam_session'] = array();
//        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
//        print_r($_POST); die();
        if (isset($_POST['User'])) {
            $sendpass = $_POST['User']['password'];
            $pass = md5($_POST['User']['password']);
            $_POST['User']['password'] = $pass;

            $model->attributes = $_POST['User'];
            $model->course_id = $_POST['course_id'];


            $dbtransaction = Yii::app()->db->beginTransaction();
            try {
//                   if($_POST['course_id']==NULL){
//                    Yii::app()->user->setFlash('error1', "Course and Level must be selected");
//                }
//                if($_POST['User']['sitting_id']==NULL){
//                    Yii::app()->user->setFlash('sitting', "Sitting should be selected");
//                }
                //save user data in the user table
                if ($model->save()) {


                    $user_id = $model->getPrimaryKey();

                    $model_student->user_id = $user_id;

                    $model_student->level_id = $_POST['User']['level_id'];

                    $model_student->note = $_POST['student_note'];

                    $model_student->sitting_id = $_POST['User']['sitting_id'];

                    $model_student->student_type = "FULL_TIME";

                    $model_student->status = 1;

                    if (isset($_POST['show_exam_breakdown']) == "yes") {
                        $model_student->show_exam_breakdown = 1;
                    } else {
                        $model_student->show_exam_breakdown = 0;
                    }




                    //save student data in the student table
                    if ($model_student->save()) {

                        $student_id = $model_student->getPrimaryKey();

//                        if (!empty($exams)) {
//
//                            $student_id = $model_student->getPrimaryKey();
//
//
//                            foreach ($exams as $exam) {
//                                $model_student_exam = new StudentExam;
//                                $model_student_exam->student_id = $student_id;
//
//                                $model_student_exam->exam_id = $exam['exam_id'];
//                                $model_student_exam->expiry_date = $exam['expiry_date'];
//
//
//
//                                if ($model_student_exam->save()) {
//                                    
//                                } else {
//                                    print_r($model_student_exam->errors);
//                                    die();
//                                    throw new Exception();
//                                }
//                            }
//
//                            Yii::app()->session['exam_session'] = Array();
//                        }
//                        if(!empty($_POST['num_of_papers'])){
//                           
//                            
//                            $start_date_array=array();
//                            $expired_date_array=array();
//                            $count=1;
//                            
//                            $date_array  = $_POST["date"];
//                            
//                            foreach($date_array as $val)
//                            {
//                                if($count%2==1)
//                                {
//                                    $start_date_array[]=$val;
//                                }
//                                else
//                                {
//                                    $expired_date_array[]=$val;
//                                }
//                                $count++;
//                            }
//                            
//                            foreach($expired_date_array as $expire_dates){
//                                
//                                $model_student_exam = new StudentExam;
//                                $model_student_exam->student_id = $model_student->getPrimaryKey();
//                                
//                                $model_student_exam->exam_id = $_POST['dexams'];
//                                $model_student_exam->expiry_date = $expire_dates;
//                                
//                                if ($model_student_exam->save()) {
//                                    
//                                } else {
//                                    print_r($model_student_exam->errors);
//                                    die();
//                                   throw new Exception();
//                                }
//                                
//                            }
//                      
//                        }
                        //echo'success!';
                        $dbtransaction->commit();
                        $subject = "LearnCIMA Credentials";
                        $message = "We are happy to inform you that we have successfully registered you in our portal. Now you can use following email address and password to login.\n" . "<br/><br/>Email : " . $_POST['User']['email'] . "<br/><br/>password : " . $sendpass;
                        $email = $_POST['User']['email'];

                        sendEmail($subject, $message, $email);


                        $model_student_audit = new Audit;
                        $model_student_audit->user_id = $user_id;
                        $model_student_audit->action_id = $student_id;
                        $model_student_audit->action_name = "STUDENT_MANAGEMENT";
                        $model_student_audit->action = 'SAVE';
                        $model_student_audit->date = date("Y/m/d");
                        $model_student_audit->time = date("h:i:sa");
                        $model_student_audit->status = 1;

                        if ($model_student_audit->save()) {
                            
                        } else {
                            print_r($model_student_audit->errors);
                            die();
                        }



                        $this->redirect(array('view', 'id' => $model_student->student_id));
                    }
                }
            } catch (Exception $e) {
                echo 'exception';
                print_r($e);
                die();
                $dbtransaction->rollback();
            }
        } else {
//            Yii::app()->session['exam_session'] = Array();
        }

        $this->render('create', array(
            'model' => $model,
                //'userModel'=>$userModel
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model_user = User::model()->findByPk($model->user->user_id);

        $exams = Yii::app()->session['exam_session'];

        $dbtransaction = Yii::app()->db->beginTransaction();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Student'])) {   //echo $_POST['Student']['last_name']; die();
            try {   //echo $model_user->first_name; die();
                $model->attributes = $_POST['Student'];

//                $model->student_type = "FULL_TIME";

                if (isset($_POST['show_exam_breakdown']) && $_POST['show_exam_breakdown'] == "yes") {
                    $model->show_exam_breakdown = 1;
                } else {
                    $model->show_exam_breakdown = 0;
                }

                $levelID = $_POST['Student']['level_id'];

                if ($levelID != null) {
                    $model->level_id = $levelID;
                }


                //echo $model_user->user_id; die();
                $model_user->first_name = $_POST['Student']['first_name'];

                $model_user->last_name = $_POST['Student']['last_name'];

                $model_user->email = $_POST['Student']['email'];

                $model_user->phone_number = $_POST['Student']['phone_number'];
                $model_user->address = $_POST['Student']['address'];

                if ($model->update() && $model_user->update()) {

//
//                    $studExamIds = Yii::app()->db->createCommand()
//                            ->select('*')
//                            ->from('student_exam')
//                            ->where('student_id=:student_id', array(':student_id' => $id))
//                            ->queryAll();
//
//
//
//                    foreach ($studExamIds as $studExamId) {
//                        StudentExam::model()->deleteByPk($studExamId['student_exam_id']);
//                    }

                    if (isset($_POST['deleted_exams'])) {

                        foreach ($_POST['deleted_exams'] as $deleted) {
                            StudentExam::model()->deleteByPk($deleted);
                        }

//                        $student_id = $id;
//
//
//                        foreach ($exams as $exam) {
//                            $model_student_exam = new StudentExam;
//                            $model_student_exam->student_id = $student_id;
//
//                            $model_student_exam->exam_id = $exam['exam_id'];
//                            $model_student_exam->expiry_date = $exam['expiry_date'];
//
//
//
//                            if ($model_student_exam->save()) {
//                                
//                            } else {
//                                print_r($model_student_exam->errors);
//                                die();
//                                throw new Exception();
//                            }
//                        }
//
//                        Yii::app()->session['exam_session'] = Array();
                    }

                    $dbtransaction->commit();

                    $model_student_audit = new Audit;
                    $model_student_audit->user_id = $model_user->user_id;
                    $model_student_audit->action_id = $model->student_id;
                    $model_student_audit->action_name = "STUDENT_MANAGEMENT";
                    $model_student_audit->action = 'EDIT';
                    $model_student_audit->date = date("Y/m/d");
                    $model_student_audit->time = date("h:i:sa");
                    $model_student_audit->status = 1;

                    if ($model_student_audit->save()) {
                        
                    } else {
                        print_r($model_student_audit->errors);
                        die();
                    }

                    $this->redirect(array('view', 'id' => $model->student_id));
                } else {
                    Yii::app()->user->setFlash('error', "Please check ");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('update'));
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', "Some Error Occured. Please Try Again.");
                $dbtransaction->rollback();
            }
        }

        $this->render('update', array(
            'model' => $model,
                //'model_user'=>$model_user,
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

            $user = User::model()->findByPk($id);


            $this->loadModel($id)->delete();
            User::model()->deleteByPk($user);

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
        $dataProvider = new CActiveDataProvider('Student');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Student('search');
        //$model_user = new User('search');

        $model->unsetAttributes();  // clear any default values
        //$model_user->unsetAttributes();

        if (isset($_GET['Student']))
            $model->attributes = $_GET['Student'];



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
        $model = Student::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddExamToStudent() {

        $exam_id = $_POST['exams'];


        $expiry_date = $_POST['publishDate'];


        $examName = "N/A";

//        echo $exam_id;

        $exam_session = Yii::app()->session['exam_session'];


        $errCode = 0;

        if ($expiry_date != null) {
            if ($exam_id == null) {
                $errCode = 1;
                $status = "fail";
                $message = "Select an exam before proceeding";
            } else {
                $exam_details = Exam::getExamNameByExamId($exam_id);

                $examName = $exam_details['exam_name'];



                if ($exam_session == null) {
                    $exam_session = array();
                    $exam_session[] = array('exam_id' => $exam_id, 'expiry_date' => $expiry_date);

                    $status = "success";
                    $message = "Exam Added";
                } else {
                    $item_found = false;

                    foreach ($exam_session as $item) {
                        if ($item['exam_id'] == $exam_id) {
                            $item_found = true;
                        }
                    }
                    if ($item_found) {
                        $errCode = 3;
                        $status = "fail";
                        $message = "Exam Already Exists!";
                    } else {
                        $exam_session[] = array('exam_id' => $exam_id, 'expiry_date' => $expiry_date);


                        $status = "success";
                        $message = "Exam Added";
                    }
                }
            }
        } else {
            $errCode = 2;
            $status = "fail";
            $message = "Please select the expiry date before proceeding";
        }

//        print_r($exam_session);

        Yii::app()->session['exam_session'] = $exam_session;



        echo CJSON::encode(array(
            'errorCode' => $errCode,
            'status' => $status,
            'message' => $message,
            'exam_id' => $exam_id,
            'exam_name' => $examName
        ));
    }

    public function actionRemoveExam() {

        if (isset($_POST) && isset($_POST['exam_id'])) {

            $examID = $_POST['exam_id'];


            $examSession = Yii::app()->session['exam_session'];

//            print_r($examSession);
//                        die();
//            echo $examID;die();
            if ($examSession != null) {

                $i = 0;

                foreach ($examSession as $item) {
                    if ($item['exam_id'] == $examID) {

                        unset($examSession[$i]);
                        $examSession = array_values($examSession);
                    }
                    $i++;
                }
            } else {

                $examSession = array();
            }

            Yii::app()->session['exam_session'] = $examSession;


            echo CJSON::encode(array(
                'status' => 'success',
                'message' => 'Exam successfully removed',
                'examSelected' => $_POST['exam_id']
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public function actionSuspend() {
        $stu_id = $_POST['student_id'];
        $model = Student::model()->findByPk($stu_id);

        $model->status = 0;

        if ($model->update()) {
            $st_status = "success";
        } else {
            print_r($model->errors);
        }

        echo CJSON::encode(array(
            'st_status' => $st_status
        ));
    }

    public function actionReactivate() {
        $stu_id = $_POST['student_id'];
        $model = Student::model()->findByPk($stu_id);

        $model->status = 1;

        if ($model->update()) {
            $st_status = "success";
        } else {
            print_r($model->errors);
        }

        echo CJSON::encode(array(
            'st_status' => $st_status
        ));
    }

    public function actionGetViews() {
        $level_id = $_POST['level_id'];
//        echo $level_id;
        $this->renderPartial('_addexamstostudent', array('level_id' => $level_id), false, true);
    }

    public function actionAddDynamicExams() {

        if ($_POST['num_of_papers'] != NULL) {
            $dynamic_exam_id = $_POST['dexams'];

            $dynamic_exam_details = Exam::model()->getExamNameByExamId($dynamic_exam_id);

            $dynamic_exam_name = $dynamic_exam_details['exam_name'];

            echo CHtml::tag('option', array('value' => $dynamic_exam_id), CHtml::encode($dynamic_exam_name), true);
        } else {
            echo 'Subject ID could not set';
        }
    }

    public function actionGetCourses() {
        if (isset($_POST['student_id'])) {

            $studentID = (int) $_POST['student_id'];

            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('past_exam')
                    ->where('student_id=:student_id', array(':student_id' => $studentID))
                    ->queryAll();

            $set_ids = array();

            $first_option_set = 0;

            if ($data == null) {
                echo CHtml::tag('option', array('value' => ''), 'Select Course', true);
                echo CHtml::tag('option', array('value' => '', 'disabled' => "disabled"), 'No Exams For Student', true);
            } else {
                foreach ($data as $d) {
                    $courseData = Exam::model()->getExamCourse($d['exam_id']);

                    $courseName = $courseData['course_name'];

                    $found = false;
                    foreach ($set_ids as $set_id) {
                        if ($set_id == $courseData['course_id']) {
                            $found = true;
                        }
                    }
                    if (!$found) {
                        $set_ids[] = $courseData['course_id'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Course', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $courseData['course_id']), CHtml::encode($courseName), true);
                    }
                }
            }
        } else {
            echo 'Student id not set';
        }
    }

    public function actionGetLevels() {

        if (isset($_POST['student_id'])) {
            $studentID = (int) $_POST['student_id'];
            $studentDetails = Student::model()->getStudentById($studentID);
            $levelName = Level::model()->getLevelName($studentDetails['level_id']);
            $status = "success";
            echo CJSON::encode(array(
                'status' => $status,
                'levelName' => $levelName,
                    //'answeroutput' => $answeroutput,
            ));
        } else {
            $status = "fail";
            echo CJSON::encode(array(
                'status' => $status,
                    //'levelName' => $levelName,
                    //'answeroutput' => $answeroutput,
            ));
        }
    }

    public function actionGetSubjects() {
        if (isset($_POST['student_id'])) {
            $studentID = (int) $_POST['student_id'];
            $studentDetails = Student::model()->getStudentById($studentID);
            // $levelDetails = Level::model()->getLevel($studentDetails['level_id']);
            $subjectName = Subject::model()->getSubjectsForUser($studentDetails['level_id']);

            return $subjectName;
        }
    }

    public function actionGetAllStudentEmails() {
        $studentEmails = Student::model()->getAllStudentDetails();
        $emails = array();
        foreach ($studentEmails as $details) {
            $emails[] = $details['email'];
        }

        echo CJSON::encode($emails);
    }

    public function actionGetCourseForEmail() {
        $studentEmail = $_POST['email'];
        $userID = Student::model()->getuserIDFromEmail($studentEmail);
        $status = "fail";
        //echo $userID;

        if ($userID != null) {
            $courses = Student::model()->getCoursesFromUserId($userID);
            $levels = Student::model()->getLevelDetails($userID);
            $subjects = Student::model()->getSubjectDetails($userID);

            $subModeified = array();

            foreach ($subjects as $sub) {
                $subModeified[] = CHtml::tag('option', array('value' => $sub['subject_id']), CHtml::encode($sub['subject_name']), true);
            }
            $status = "success";
        }

        echo CJSON::encode(array(
            'status' => $status,
            'courseID' => $courses['course_id'],
            'courseName' => $courses['course_name'],
            'levelName' => $levels['level_name'],
            'subjectDetails' => $subModeified
        ));
    }

}
