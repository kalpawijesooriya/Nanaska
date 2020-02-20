<?php

class NewsController extends Controller {

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
//                'actions' => array('index', 'view', 'viewBroadcast'),
//                'users' => array('*'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'viewBroadcast','create', 'createBroadcast', 'update', 'updateBroadcast', 'viewBroadcastNews', 'viewLevelNews', 'ValidateNews','admin'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'updateNews'),
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

    public function actionViewBroadcast($id) {
        $this->render('viewBroadcast', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {            //create level news
        $date_time = date('m/d/Y h:i:s a', time());
        $model = new News('level');
      
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['News'])) {   
            $model->attributes = $_POST['News'];  

                $model->send_date_time = $date_time;
                $uploadedFile = CUploadedFile::getInstance($model, 'attachment');
                if ($uploadedFile != NULL) {
                    $model->attachment = $uploadedFile;
                }
                $model->news_type = 'LEVEL_NEWS';
                
               
                if ($model->save()) {
                    $upload_dir = $this->getUploadDir($model->news_id);
                    
                    if ($uploadedFile != NULL) {
                        $uploadedFile->saveAs($upload_dir . $uploadedFile);
                    }

                    $this->redirect(array('view', 'id' => $model->news_id));
                } else {
                    //throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
                   // print_r($model->errors);
                }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    protected function getUploadDir($news_id) {
        $dir = Yii::getPathOfAlias('webroot') . '/images/NewsImageAttachments/' . $news_id . '/';
        if(!is_dir($dir)) {
            mkdir($dir);
        }
     //   echo $dir;die();
        return $dir;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $date_time = date('m/d/Y h:i:s a', time());
       
        $model = $this->loadModel($id);
        //$rnd = rand(0, 9999);  // generate random number between 0-9999
         
        if (isset($_POST["News"])) {
           
            $model->attributes = $_POST['News'];
            $model->send_date_time = $date_time;        //sets data and time for level news
            
           
            $uploadedFile = CUploadedFile::getInstance($model, 'attachment');
//            
//            if (is_object($uploadedFile) && get_class($uploadedFile)==='CUploadedFile'){
//            $model->attachment = $uploadedFile;
//            }           
           
            
            if ($uploadedFile != NULL) {                
                $model->attachment = $uploadedFile;
            }else{
                $upFile = News::model()->getNewsAttachment($model->news_id);
                $model->attachment = $upFile;
            }

            if ($model->news_type == 'BROADCAST_NEWS') {
                $model->news_type = 'BROADCAST_NEWS';
                $model->send_date_time = $date_time;        //sets date and time for broadcast news                
             
                if ($model->save()) {
                    $this->redirect(array('viewBroadcast', 'id' => $model->news_id));
                } 
            } else {
                $model->news_type = 'LEVEL_NEWS';               
                $model->setScenario('level');              
                
                    if ($model->save()) {
                        $upload_dir = $this->getUploadDir($model->news_id);

                        if (!empty($uploadedFile)) {  // check if uploaded file is set or not                           
                            $uploadedFile->saveAs($upload_dir . $uploadedFile);
                            $this->redirect(array('view', 'id' => $model->news_id));
                        } else {                          
                            $this->redirect(array('view', 'id' => $model->news_id));
                        }
                    } 
              //  }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateBroadcast($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['News'])) {
            $model->news_type = 'BROADCAST_NEWS';
            //$model->level_id='7';
            $model->attachment = NULL;
            $model->send_date_time = $date_time;
           
            if ($model->save()) {
                $this->redirect(array('viewBroadcast', 'id' => $model->news_id));
            }
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

        $dataProvider = new CActiveDataProvider('News');

        $this->render('index', array(
            'dataProvider' => $dataProvider, 'type' => '<h1 class="light_heading">News</h1>'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new News('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];

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
        $model = News::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateNews() {

        if (isset($_POST['news_type'])) {
            $news_type = $_POST['news_type'];
            if ($news_type == "LEVEL_NEWS") {
                echo $this->renderPartial('viewNews', array());
            } else if ($news_type == "BROADCAST_NEWS") {
                echo $this->renderPartial('viewBroadcastNews', array());
            }
        }
    }

    public function actionCreateBroadcast() {       //create broadcast news
        $model = new News;
        $date_time = date('m/d/Y h:i:s a', time());

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            $model->news_type = 'BROADCAST_NEWS';
            $model->level_id = NULL;
            $model->attachment = NULL;
            $model->send_date_time = $date_time;

            if ($model->save()) {
                $this->redirect(array('viewBroadcast', 'id' => $model->news_id));
            }
        }
        $this->render('createBroadcastNews', array(
            'model' => $model,
        ));
    }

    public function actionViewBroadcastNews() {
        $dataProvider = new CActiveDataProvider('News', array(
                    'criteria' => array(
                        'condition' => "news_type='BROADCAST_NEWS'"
                    )
                ));

        $this->render('viewBroadcastNews', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionViewLevelNews() {
        $dataProvider = new CActiveDataProvider('News', array(
                    'criteria' => array(
                        'condition' => "news_type='LEVEL_NEWS'"
                    )
                ));

        $this->render('viewLevelNews', array(
            'dataProvider' => $dataProvider
        ));
    }    
    
}
