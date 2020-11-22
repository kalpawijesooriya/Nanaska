<?php

class EssayAnswerController extends Controller
{
        public $layout = '/layouts/column2';
    
        public function filters() {
            return array(
                'accessControl', // perform access control for CRUD operations
            );
        }
        public function accessRules() {
            return array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('index', 'view', 'viewIndividualAnswer', 'saveFeedback', 'viewIndividualFeedback'),
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
	public function actionIndex()
	{ 
                $model = new Take('search');
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['Take']))
                    $model->attributes = $_GET['Take'];

                $this->render('index', array(
                    'model' => $model,
                ));
	}
        public function actionView($id)
	{
                $this->render('view', array(
                    'model' => $this->loadModel($id),
                ));
	}
        public function actionViewIndividualAnswer($take_id, $question_id)
	{
                $this->render('view_individual_answer', array(
                    'question_id' => $question_id,
                    'take_id' => $take_id,
                ));
	}
        public function loadModel($id) {
            $model = Take::model()->findByPk($id);
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        public function actionSaveFeedback()
	{
            $error = array();
            $message = array();
            $redirect_url = "N/A";
            if (isset($_POST['question_id']) &&
                isset($_POST['marks_per_question']) &&
                isset($_POST['take_id']) &&
                isset($_POST['business_comment']) &&
                isset($_POST['accounting_comment']) &&
                isset($_POST['leadership_comment']) &&
                isset($_POST['people_comment']) &&
                isset($_POST['business_mark']) &&
                isset($_POST['accounting_mark']) &&
                isset($_POST['leadership_mark']) &&
                isset($_POST['people_mark']) &&
                isset($_POST['overall_comment']) &&
                $_POST ['question_id'] != null &&
                $_POST ['marks_per_question'] != null &&
                $_POST['take_id'] != null
                ) {
                  
                $status = "success";
            } else {
                $status = "fail";
                $message[] = "Request error";
            }
            if($_POST['business_mark'] != null){
                $business_type_mark = $_POST['business_mark'];
                
            }else{
                $business_type_mark = 0;
            }
            if($_POST['accounting_mark'] != null){
                $accounting_type_mark = $_POST['accounting_mark'];
            }else{
                $accounting_type_mark = 0;
            }
            if($_POST['leadership_mark'] != null){
                $leadership_type_mark = $_POST['leadership_mark'];
            }else{
                $leadership_type_mark = 0;
            }
            if($_POST['people_mark'] != null){
                $people_type_mark = $_POST['people_mark'];
            }else{
                $people_type_mark = 0;
            }
            
            if(is_numeric($people_type_mark) && is_numeric($leadership_type_mark) && is_numeric($accounting_type_mark) && is_numeric($business_type_mark)){
                if($people_type_mark == (int) $people_type_mark && $leadership_type_mark == (int) $leadership_type_mark && $accounting_type_mark == (int) $accounting_type_mark && $business_type_mark == (int) $business_type_mark){
                    $status = "success";
                }else{
                    $status = "fail";
                    $message[] = "Marks should be integers";
                    if($people_type_mark == (int) $people_type_mark){
                        $error[] = "people_mark";
                    }
                    if($leadership_type_mark == (int) $leadership_type_mark){
                        $error[] = "business_mark";
                    }
                    if($accounting_type_mark == (int) $accounting_type_mark){
                        $error[] = "accounting_mark";
                    }
                    if($business_type_mark == (int) $business_type_mark){
                        $error[] = "leadership_mark";
                    }
                }
                
            }else{
                $status = "fail";
                $message[] = "Marks should be numerics";
                if(!is_numeric($people_type_mark)){
                    $error[] = "people_mark";
                }
                if(!is_numeric($business_type_mark)){
                    $error[] = "business_mark";
                }
                if(!is_numeric($accounting_type_mark)){
                    $error[] = "accounting_mark";
                }
                if(!is_numeric($leadership_type_mark)){
                    $error[] = "leadership_mark";
                }
            }
            
            if($status == "success"){
                $marks_per_question = (int)$_POST ['marks_per_question'];
                $total_marks_entered = (int) $people_type_mark + (int) $leadership_type_mark + (int) $accounting_type_mark + (int) $business_type_mark;
                
                if($marks_per_question < $total_marks_entered){
                    
                    $status = "fail";
                    $message[] = "Marks you entered exceeds the marks allocated for the question";
                }
                
            }
            
            if($status == "success"){
                $take_id = $_POST['take_id'];
                $question_id = $_POST['question_id'];
                $essay_answer_id = EssayAnswer::model()->getEssayAnswerId($take_id, $question_id);
                $essay_exam_feedback_id = EssayExamFeedback::model()->getEssayExamFeedbackID($essay_answer_id);
                if($essay_exam_feedback_id != null){
                    $model = new EssayExamFeedback;
                    $model = $model->findByPk($essay_exam_feedback_id);
                    $model->business_type_comment = $_POST['business_comment'];
                    $model->accounting_type_comment = $_POST['accounting_comment'];
                    $model->leadership_type_comment = $_POST['leadership_comment'];
                    $model->people_type_comment = $_POST['people_comment'];
                    $model->business_type_mark = $business_type_mark;
                    $model->accounting_type_mark = $accounting_type_mark;
                    $model->leadership_type_mark = $leadership_type_mark;
                    $model->people_type_mark = $people_type_mark;
                    $model->overall_comment = $_POST['overall_comment'];
                    if ($model->update()) {
                        $model_answer = new EssayAnswer;
                        $model_answer = $model_answer->findByPk($essay_answer_id);
                        $model_answer->status = 1;
                        if ($model_answer->update()) {
                            $essay_answer_ids = EssayAnswer::model()->getEssayAnswerIds($take_id);
                            $all_marked = true;
                            foreach ($essay_answer_ids as $ids){
                                $stats = EssayAnswer::model()->getStatusByEssayID($ids['essay_answer_id']);
                                if($stats == 0){
                                    $all_marked = false;
                                    break;
                                }
                            }
                            if($all_marked){
                                $model_take = new Take;
                                $model_take = $model_take->findByPk($take_id);
                                $model_take->status = 1;
                                if ($model_take->update()) {
                                    
                                }else{
                                    print_r($model_take->errors);
                                    die();
                                }
                            }
                        }else {
                            print_r($model_answer->errors);
                            die();
                        }
                    } else {
                        print_r($model->errors);
                        die();
                    }
                }else{
                    $model = new EssayExamFeedback;
                    $model->essay_answer_id = $essay_answer_id;
                    $model->business_type_comment = $_POST['business_comment'];
                    $model->accounting_type_comment = $_POST['accounting_comment'];
                    $model->leadership_type_comment = $_POST['leadership_comment'];
                    $model->people_type_comment = $_POST['people_comment'];
                    $model->business_type_mark = $business_type_mark;
                    $model->accounting_type_mark = $accounting_type_mark;
                    $model->leadership_type_mark = $leadership_type_mark;
                    $model->people_type_mark = $people_type_mark;
                    $model->overall_comment = $_POST['overall_comment'];
                    if ($model->save()) {
                        $model_answer = new EssayAnswer;
                        $model_answer = $model_answer->findByPk($essay_answer_id);
                        $model_answer->status = 1;
                        if ($model_answer->update()) {
                            $essay_answer_ids = EssayAnswer::model()->getEssayAnswerIds($take_id);
                            $all_marked = true;
                            foreach ($essay_answer_ids as $ids){
                                $stats = EssayAnswer::model()->getStatusByEssayID($ids['essay_answer_id']);
                                if($stats == 0){
                                    $all_marked = false;
                                    break;
                                }
                            }
                            if($all_marked){
                                $model_take = new Take;
                                $model_take = $model_take->findByPk($take_id);
                                $model_take->status = 1;
                                if ($model_take->update()) {
                                    
                                }else{
                                    print_r($model_take->errors);
                                    die();
                                }
                            }
                        }else {
                            print_r($model_answer->errors);
                            die();
                        }
                      
                    } else {
                        print_r($model->errors);
                        die();
                    }
                }
                $redirect_url = CController::createUrl('essayAnswer/view&id=' . $take_id);
            }
            //print_r($status);die;
            echo CJSON::encode(array(
                array(
                    'status' => $status,
                    'redirect_url' => $redirect_url
                ),
                $error,
                $message
                
            ));   
	}
        public function actionViewIndividualFeedback($take_id, $question_id)
	{
                $this->render('_view_individual_feedback', array(
                    'question_id' => $question_id,
                    'take_id' => $take_id,
                ));
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}