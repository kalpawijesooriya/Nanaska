<?php

class LevelController extends Controller {

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
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view','getlevels','getLevelsForUser'),
//                'users' => array('*'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('getlevels', 'getLevelsForUser', 'index', 'view', 'create', 'update',
                    'GetLevelsforStudentCreation', 'admin', 'getLevelsForUserAdvancedSearch','getLevelsForUserAdvancedSearchInQuestionManagement'),
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
        $model = new Level;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Level'])) {
            $model->attributes = $_POST['Level'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->level_id));
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

        if (isset($_POST['Level'])) {
            $model->attributes = $_POST['Level'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->level_id));
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
//        $dataProvider = new CActiveDataProvider('Level');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
        $model = new Level('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Level']))
            $model->attributes = $_GET['Level'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new Level('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Level']))
            $model->attributes = $_GET['Level'];

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
        $model = Level::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'level-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetLevels() {

        if (isset($_POST['course_id'])) {

            $courseID = (int) $_POST['course_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('level_id')
                    ->from('level')
                    ->where('course_id=:course_id', array(':course_id' => $courseID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $levelData = Level::model()->getLevel($d['level_id']);

                    $levelName = $levelData['level_name'];

                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['level_id']), CHtml::encode($levelName), true);
                }
            } else {
                echo '<option value="">Select Level</option>';
            }
        } else {
            echo 'Course id not set';
        }
    }

    //get levels when creating student -> zah
    public function actionGetLevelsforStudentCreation() {

        if (isset($_POST['course_id'])) {

            $courseID = (int) $_POST['course_id'];

            $data = Yii::app()->db->createCommand()
                    ->selectdistinct('level_id')
                    ->from('level')
                    ->where('course_id=:course_id', array(':course_id' => $courseID))
                    ->queryAll();

            $first_option_set = 0;
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $levelData = Level::model()->getLevel($d['level_id']);

                    $levelName = $levelData['level_name'];

                    if ($first_option_set == 0) {
                        echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                        $first_option_set = 1;
                    }
                    echo CHtml::tag('option', array('value' => $d['level_id']), CHtml::encode($levelName), true);
                }
            } else {
                echo '<option value="">Select Level</option>';
            }
        } else {
            echo 'Course id not set';
        }
    }

    //getUserType
    public function actionGetLevelsForUser() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            if (isset($_POST['course_id'])) {

                $courseID = (int) $_POST['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id')
                        ->from('level')
                        ->where('course_id=:course_id', array(':course_id' => $courseID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), CHtml::encode($levelName), true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        } else {

            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            if (isset($_POST['course_id'])) {

                $courseID = (int) $_POST['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id, level_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and course_id=:course_id', array(':lecturer_id' => $lecture_id, ':course_id' => $courseID))
                        ->queryAll();
                //            $data = Yii::app()->db->createCommand()
                //                    ->selectdistinct('level_id')
                //                    ->from('level')
                //                    ->where('course_id=:course_id', array(':course_id' => $courseID))
                //                    ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), $d['level_name'], true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        }
    }

    public function actionGetLevelsForUserAdvancedSearch() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
            // var_dump($_POST['Exam']['course_id']);die;

            if (isset($_POST['Exam']['course_id'])) {

                //  $courseID = (int)Course::model()->getCourseIdByName($_POST['Exam']['course_id']);

                $courseID = (int) $_POST['Exam']['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id')
                        ->from('level')
                        ->where('course_id=:course_id', array(':course_id' => $courseID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), CHtml::encode($levelName), true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        } else {

            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);


            if (isset($_POST['Exam']['course_id'])) {

                $courseID = (int) $_POST['Exam']['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id, level_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and course_id=:course_id', array(':lecturer_id' => $lecture_id, ':course_id' => $courseID))
                        ->queryAll();               

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), $d['level_name'], true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        }
    }  
    
    public function actionGetLevelsForUserAdvancedSearchInQuestionManagement() {
        $user_id = Yii::app()->user->getId();
        if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
           
            if (isset($_POST['Question']['course_id'])) {             
                $courseID = (int) $_POST['Question']['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id,level_name')
                        ->from('level')
                        ->where('course_id=:course_id', array(':course_id' => $courseID))
                        ->queryAll();

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), CHtml::encode($levelName), true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        } else {
            $lecture_id = Lecturer::model()->getLecturerIdByUserId($user_id);
            if (isset($_POST['Question']['course_id'])) {

                $courseID = (int) $_POST['Question']['course_id'];

                $data = Yii::app()->db->createCommand()
                        ->selectdistinct('level_id, level_name')
                        ->from('subject_lecturer')
                        ->naturalJoin('subject')
                        ->naturalJoin('level')
                        ->naturalJoin('course')
                        ->where('lecturer_id=:lecturer_id and course_id=:course_id', array(':lecturer_id' => $lecture_id, ':course_id' => $courseID))
                        ->queryAll();               

                $first_option_set = 0;
                if (count($data) > 0) {
                    foreach ($data as $d) {
                        $levelData = Level::model()->getLevel($d['level_id']);

                        $levelName = $levelData['level_name'];

                        if ($first_option_set == 0) {
                            echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                            $first_option_set = 1;
                        }
                        echo CHtml::tag('option', array('value' => $d['level_id']), $d['level_name'], true);
                    }
                } else {
                    echo '<option value="">Select Level</option>';
                }
            } else {
                echo 'Course id not set';
            }
        }
    }

}
