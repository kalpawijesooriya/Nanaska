<?php

class DefaultController extends Controller
{
    public $layout='/layouts/column1';
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
                {
                $this->redirect(Yii::app()->homeUrl.'?r=site/login');
            }
            else
                {
                $this->pageTitle = 'LearnCIMA Admin Dashboard';
                $this->render('index');
            }
	}
        
        

}