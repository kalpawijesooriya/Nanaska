<?php

class SubjectController extends Controller {

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
                'actions' => array('admin', 'create', 'update', 'GetSubjectsforDynamicExams', 'index',
                    'view', 'getsubjects', 'getsubjects2', 'setPapersForSubject', 'editPaperOrder',
                    'getSubjectsForUser', 'getSubjectsForUserAdvancedSearch', 'getSubjectsForPresetExam','getSubjectsForUserAdvancedSearchInQuestionManagement'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('admin', 'create', 'update', 'GetSubjectsforDynamicExams'),
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
        $model = new Subject;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Subject'])) {
            $model->attributes = $_POST['Subject'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_id));
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

        if (isset($_POST['Subject'])) {
            $model->attributes = $_POST['Subject'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subject_id));
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
            try {
                $this->loadModel($id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(404, 'Cannot delete - this is being used by another place.');
            }


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
//        $dataProvider = new CActiveDataProvider('Subject');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
        $model = new Subject('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Subject']))
            $model->attributes = $_GET['Subject'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Subject('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Subject']))
            $model->attributes = $_GET['Subject'];

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
        $model = Subject::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subject-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetSubjects() {

        if (isset($_POST['level_id'])) {

            $levelID = (int) $_POST['level_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('subject_id')
                    ->from('subject')
                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                }
            } else {
                echo '<option value="">Select Subject</option>';
            }
        } else {
            echo 'Level id not set';
        }
    }

    public function actionGetSubjectsForPresetExam() {
        $status = "fail";
        if (isset($_POST['level_id'])) {


            $levelID = (int) $_POST['level_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('subject_id')
                    ->from('subject')
                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                    ->queryAll();

            $subModeified = array();
            $status = "success";

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                    if ($first_option_set == 0) {
                        //$subModeified[] = CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                        $first_option_set = 1;
                    }
                    $subModeified[] = CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                }
            } else {
                //$subModeified[] = '<option value="">Select Subject</option>';
            }
        } else {
            $subModeified[] = 'Level id not set';
        }

        echo CJSON::encode(array(
            'status' => $status,
            'subjectDetails' => $subModeified
        ));
    }

    //get subjects for dynamic exmas // do not make any changes to following code.
    public function actionGetSubjectsforDynamicExams() {

        if (isset($_POST['dynamic_level_id'])) {

            $levelID = (int) $_POST['dynamic_level_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('subject_id')
                    ->from('subject')
                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                    ->queryAll();

            $first_option_set = 0;
            foreach ($data as $d) {
                $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                if ($first_option_set == 0) {
                    echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                    $first_option_set = 1;
                }
                echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
            }
        } else {
            echo 'Level id not set';
        }
    }

    public function actionGetSubjects2() {

        if (isset($_POST['level_id'])) {

            $levelID = (int) $_POST['level_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('subject_id')
                    ->from('subject')
                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                }
            } else {
                echo '<option value="">Select Subject</option>';
            }
        } else {
            echo 'Level id not set';
        }
    }

    public function actionSetPapersForSubject() {
        Yii::app()->session['paper_session'] = array();

        $this->render('setPapersForSubject', array(
        ));
    }

    public function actionEditPaperOrder($id) {
        Yii::app()->session['paper_session'] = array();

        $this->render('editPaperOrder', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionGetSubjectsForUser() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            if (isset($_POST['level_id'])) {

                $levelID = (int) $_POST['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id')
                        ->from('subject')
                        ->where('level_id=:level_id', array(':level_id' => $levelID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        } else {

            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            if (isset($_POST['level_id'])) {

                $levelID = (int) $_POST['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id, subject_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and level_id=:level_id', array(':lecturer_id' => $lecture_id, ':level_id' => $levelID))
                        ->queryAll();

                //            $data = Yii::app()->db->createCommand()
                //                    ->selectdistinct('subject_id')
                //                    ->from('subject')
                //                    ->where('level_id=:level_id', array(':level_id' => $levelID))
                //                    ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), $d['subject_name'], true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        }
    }

    public function actionGetSubjectsForUserAdvancedSearch() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            if (isset($_POST['Exam']['level_id'])) {
                $levelID = (int) $_POST['Exam']['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id')
                        ->from('subject')
                        ->where('level_id=:level_id', array(':level_id' => $levelID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        } else {

            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            if (isset($_POST['Exam']['level_id'])) {

                $levelID = (int) $_POST['Exam']['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id, subject_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and level_id=:level_id', array(':lecturer_id' => $lecture_id, ':level_id' => $levelID))
                        ->queryAll();


                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), $d['subject_name'], true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        }
    }

    public function actionGetSubjectsForUserAdvancedSearchInQuestionManagement() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            if (isset($_POST['Question']['level_id'])) {
                $levelID = (int) $_POST['Question']['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id')
                        ->from('subject')
                        ->where('level_id=:level_id', array(':level_id' => $levelID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), CHtml::encode($subjectName), true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        } else {

            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            if (isset($_POST['Question']['level_id'])) {

                $levelID = (int) $_POST['Question']['level_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('subject_id, subject_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and level_id=:level_id', array(':lecturer_id' => $lecture_id, ':level_id' => $levelID))
                        ->queryAll();


                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $subjectName = Subject::model()->getSubjectName($d['subject_id']);
                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['subject_id']), $d['subject_name'], true);
                    }
                } else {
                    echo '<option value="">Select Subject</option>';
                }
            } else {
                echo 'Level id not set';
            }
        }
    }

}
