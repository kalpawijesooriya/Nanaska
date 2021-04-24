<?php

class EssayAnswerController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        public function actionViewIndividualFeedback($take_id, $question_id)
	{
                $this->render('_view_individual_feedback', array(
                    'question_id' => $question_id,
                    'take_id' => $take_id,
                ));
	}
                
	
        public function actionViewIndividualFeedbackInDialog()
	{
                $take_id = $_POST['take_id'];
                $question_id = $_POST['question_id'];
                $feedback = $this->renderPartial('_view_individual_feedback', array(
                    'question_id' => $question_id,
                    'take_id' => $take_id,
                ), TRUE, FALSE);
                echo CJSON::encode(array(
                    'feedback' => $feedback,
                        //'answeroutput' => $answeroutput,
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