<?php

class TestimonialsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations

		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'view', 'create', 'update', 'admin'),
				'users'=>array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Testimonials;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Testimonials']))
		{

            $model->attributes=$_POST['Testimonials'];
            $rnd = rand(0,9999);  // generate random number between 0-9999

            $uploadedFile=CUploadedFile::getInstance($model,'image_url');
            $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
            $model->image_url = '/uploads/testimonials/'.$fileName;


			if($model->save())
            {
                $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/testimonials/'.$fileName);
                $this->redirect(array('view','id'=>$model->testimonials_id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Testimonials']))
		{
            $_POST['Testimonials']['image_uri'] = $model->image_url;
			$model->attributes=$_POST['Testimonials'];
            $uploadedFile=CUploadedFile::getInstance($model,'image_uri');


			if($model->save()){

                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/testimonials/'.$model->image_url);
                    //$this->redirect(array('view','id'=>$model->testimonials_id));
                    echo "done";
                }


            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Testimonials');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Testimonials('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Testimonials']))
			$model->attributes=$_GET['Testimonials'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Testimonials the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Testimonials::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Testimonials $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='testimonials-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
