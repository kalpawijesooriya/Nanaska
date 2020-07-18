<?php

define('ADMIN_EMAIL', Yii::app()->params['infomail']);
require_once 'EmailHandler.php';

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'

        $model = new ProductCategories();
        $strategiccommenceDate = $model->getCommencement(1);
        $strategiccommenceString = (strlen($strategiccommenceDate['commencement']) > 1 ? '('.$strategiccommenceDate['commencement'].')' : '(Coming Soon...)');

        $managerialcommenceDate = $model->getCommencement(2);
        $managerialcommenceString = (strlen($managerialcommenceDate['commencement']) > 1 ? '('.$managerialcommenceDate['commencement'].')' : '(Coming Soon...)');

        $operationalcommenceDate = $model->getCommencement(3);
        $operationalcommenceString = (strlen($operationalcommenceDate['commencement']) > 1 ? '('.$operationalcommenceDate['commencement'].')' : '(Coming Soon...)');

        $foundationcommenceDate = $model->getCommencement(4);
        $foundationcommenceString = (strlen($foundationcommenceDate['commencement']) > 1 ? '('.$foundationcommenceDate['commencement'].')' : '(Coming Soon...)');

        $this->render('index',array(
            'strategicCommencement'=> $strategiccommenceString,
            'managerialCommencement'=> $managerialcommenceString,
            'operationalCommencement'=> $operationalcommenceString,
            'foundationCommencement'=> $foundationcommenceString,
        ));

    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionCustomError() {
        $message = Yii::app()->request->getParam(Consts::STR_MESSAGE, 'Error occured');
        $this->render('custom-error', array(Consts::STR_MESSAGE => $message));
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {

                // $browser = get_browser();
                $date_time = date('m/d/Y h:i:s a', time());
                $today = getdate();

                $message = "
                    Name  : " . $model->name . "\n<br />
                    Email : " . $model->email . "\n<br />
                    Subject : Nanaska.com-Contact Us Submission: " . $model->subject . "<br /><br />
                    Message : \n<br /><br />" . $model->body . '<br/><br/><br/>
                    IP address : ' . $_SERVER['REMOTE_ADDR'] . '<br />
                    Browser : ' . Yii::app()->browser->getBrowser() . '<br />
                    Date and time : ' . $date_time . '<br />';

                //  $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
//				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
               
                sendEmail("Nanaska.com-Contact Us Submission " . $model->subject, $message, ADMIN_EMAIL);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if (Yii::app()->user->isGuest) {
                    $this->render('index');
                } else if (User::model()->getType() == 'SUPERADMIN') {

                    $model_user_login_audit = new LoginAudit;
                    $model_user_login_audit->user_id = Yii::app()->user->id;
                    $model_user_login_audit->action = 'LOGIN';
                    $model_user_login_audit->date = date("Y/m/d");
                    $model_user_login_audit->time = date("h:i:sa");
                    $model_user_login_audit->status = 1;

                    if ($model_user_login_audit->save()) {
                        
                    } else {
                        print_r($model_user_login_audit->errors);
                        die();
                    }


                    $this->redirect(array('/admin'));
                } else if (User::model()->getType() == 'LECTURER') {

                    $model_user_login_audit = new LoginAudit;
                    $model_user_login_audit->user_id = Yii::app()->user->id;
                    $model_user_login_audit->action = 'LOGIN';
                    $model_user_login_audit->date = date("Y/m/d");
                    $model_user_login_audit->time = date("h:i:sa");
                    $model_user_login_audit->status = 1;

                    if ($model_user_login_audit->save()) {
                        
                    } else {
                        print_r($model_user_login_audit->errors);
                        die();
                    }

                    $this->redirect(array('/admin'));
                } else if (User::model()->getType() == 'STUDENT' && Student::model()->getStatus() == 1) {

                    $model_user_login_audit = new LoginAudit;
                    $model_user_login_audit->user_id = Yii::app()->user->id;
                    $model_user_login_audit->action = 'LOGIN';
                    $model_user_login_audit->date = date("Y/m/d");
                    $model_user_login_audit->time = date("h:i:sa");
                    $model_user_login_audit->status = 1;

                    if ($model_user_login_audit->save()) {
                        
                    } else {
                        print_r($model_user_login_audit->errors);
                        die();
                    }


                    $this->redirect(array('user/detail'));
                } else {
                    $this->redirect(array("inactive"));
                }
            }
            //	$this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {

        $model_user_login_audit = new LoginAudit;
        $model_user_login_audit->user_id = Yii::app()->user->id;
        $model_user_login_audit->action = 'LOG_OUT';
        $model_user_login_audit->date = date("Y/m/d");
        $model_user_login_audit->time = date("h:i:sa");
        $model_user_login_audit->status = 1;

        if ($model_user_login_audit->save()) {
            
        } else {
            print_r($model_user_login_audit->errors);
            die();
        }

        Yii::app()->user->logout();

        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionInactive() {
        $this->render('inactive');
    }

    public function actiontermsofservice() {
        $this->render('termsofservice');
    }

    public function actionViewAboutus() {
        $this->render('aboutus');
    }

    public function actionViewTestamonial() {
        $this->render('testimonial');
    }

    public function actionleadLecture() {
        $this->render('leadLecture');
    }


    public function actionViewPrivacy() {
        $this->render('privacy');
    }

    public function actionViewOurProduct() {
        
        $model = new ProductCategories();
        $strategiccommenceDate = $model->getCommencement(1);
        $strategiccommenceString = (strlen($strategiccommenceDate['commencement']) > 1 ? '('.$strategiccommenceDate['commencement'].')' : '(Coming Soon...)');
        
        $managerialcommenceDate = $model->getCommencement(2);
        $managerialcommenceString = (strlen($managerialcommenceDate['commencement']) > 1 ? '('.$managerialcommenceDate['commencement'].')' : '(Coming Soon...)');
        
        $operationalcommenceDate = $model->getCommencement(3);
        $operationalcommenceString = (strlen($operationalcommenceDate['commencement']) > 1 ? '('.$operationalcommenceDate['commencement'].')' : '(Coming Soon...)');
        
        $foundationcommenceDate = $model->getCommencement(4);
        $foundationcommenceString = (strlen($foundationcommenceDate['commencement']) > 1 ? '('.$foundationcommenceDate['commencement'].')' : '(Coming Soon...)');
        
        $this->render('products',array(
            'strategicCommencement'=> $strategiccommenceString,
            'managerialCommencement'=> $managerialcommenceString,
            'operationalCommencement'=> $operationalcommenceString,
            'foundationCommencement'=> $foundationcommenceString,
        ));
        //$this->render('ourProduct');
    }
    
    public function actionDetails($id, $level, $course){
        
        $model = new ProductCategories;
        $commenceDate = $model->getCommencement($id);
        $commenceString = (strlen($commenceDate['commencement']) > 1 ? '('.$commenceDate['commencement'].')' : '(Coming Soon...)');
        
        $this->render('courselevels/'.$level.'/'.$course, array(
            'commencement'=>$commenceString
        ));
    }
    
    
//    public function actionViewProducts() {
//        
//        $model = new ProductCategories();
//        $data = $model->findAll();
//        
//        $this->render('products',array(
//            'data'=> $data,
//        ));
//    }

    public function actionViewBroadcastNews() {
        $newsId = $_REQUEST['news_id'];
        $this->render('broadcast_news', array('news_id' => $newsId));
    }

    public function actionourSpecialty() {
        $this->render('ourSpecialty');
    }
    public function actionsyllabus() {
        $this->render('syllabus');
    }
    public function actiontestimonials() {
        $this->render('testimonials');
    }

}
