<?php

class CustomController extends Controller
{
    public $layout='/layouts/column2';
    
   public function actionCustomError()
	{
            $message = Yii::app()->request->getParam(Consts::STR_MESSAGE, 'Error occured');
	    $this->render('custom-error', array(Consts::STR_MESSAGE => $message));
	}    
}

?>
