<?php
include_once 'EmailHandler.php';

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array('create', 'ForgotPassword', 'viewResetPassword', 'resetPassword', 'passwordsent', 'CreateTempUser', 'payment', 'paymentResult', 'sendMaterialMail', 'Pgresponse', 'captcha', 'viewStudentActivationInfo', 'activateAccount'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'admin', 'updatepass', 'view', 'checkout', 'viewScheduledExams', 'detail', 'viewPastExams', 'readmoreLevelNews', 'detailLecturer', 'viewLecturerDetails', 'viewChangeLecPass', 'saveLecPass', 'lecpasswordsent'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
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
        $model = new User;
        $model_student = new Student;
       
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            if (!isset($_POST['logincheck'])) {
                $model_temp_user = new TemporaryUser;

                $model_temp_user->attributes = $_POST['User'];
                if ($model_temp_user->save()) {
                    $this->redirect(Yii::app()->homeUrl);
                } else {
                    print_r($model_temp_user->errors);
                    die();
                }
            } else {

                $model->attributes = $_POST['User'];
                $model->user_type = 'STUDENT';

                $user_email = $model->email;
                if ($model->password != NULL && $model->repeatpassword != NULL) {
                    if ($model->password == $model->repeatpassword) {
                        $model->password = md5($model->password);
                        $model->repeatpassword = md5($model->repeatpassword);
                    }
                }

                $dbtransaction = Yii::app()->db->beginTransaction();

                try {

                    if ($model->save()) {
                        $model_student->user_id = $model->user_id;
                        $userID = $model->user_id;
                        $model_student->sitting_id = $model->sitting_id;


                        $model_student->level_id = $model->level_id;

                        $model_student->status = 0;
                        $model_student->student_type = "PART_TIME";
                        $model_student->show_exam_breakdown = 0;

                        //generate unique id for student
                        $student_unique_code = rand(11, 99) . uniqid() . $model_student->user_id . rand(11, 99) . rand(11, 99) . rand(11, 99);
                        $model_student->student_unique_code = $student_unique_code;

                        if ($model_student->save()) {
                            $dbtransaction->commit();
                             $student_id = $model_student->getPrimaryKey();
                            Yii::app()->user->setState('account', 'TRUE');


                            $subject = "Account activation";
                            $link = CHtml::link('here', Yii::app()->createAbsoluteUrl('user/activateAccount', array('token' => $student_unique_code)));
                            $message = "Please click " . $link . " to activate your account";

                            sendEmail($subject, $message, $user_email);

                            $model_suser_audit = new Audit;
                            $model_suser_audit->user_id = $model->user_id;
                            $model_suser_audit->action_id = $student_id;
                            $model_suser_audit->action_name = "STUDENT_MANAGEMENT";
                            $model_suser_audit->action = 'CREATE';
                            $model_suser_audit->date = date("Y/m/d");
                            $model_suser_audit->time = date("h:i:sa");
                            $model_suser_audit->status = 1;

                            if ($model_suser_audit->save()) {
                                
                            } else {
                                print_r($model_suser_audit->errors);
                                die();
                            }

                            $this->redirect(array('viewStudentActivationInfo'));

                            // $this->redirect(array('view', 'id' => $model->user_id));
                        } else {
                            echo '<pre>';
                            print_r($model_student->errors);
                            die();
                        }
                    }
                } catch (CDbException $e) {
                    echo '<pre>';
                    print_r($e);
                    $dbtransaction->rollback();
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionActivateAccount() {

        if (isset($_REQUEST['token'])) {
            //$user_id = $_REQUEST['id'];
            // $user_model = User::model()->findByPk($user_id);
//            $student_id = Student::model()->getStudentIdForUserId($user_id);
//            $student_model = Student::model()->findByPk($student_id);

            $student_model = Student::model()->getStudentByStudentUniqueCode($_REQUEST['token']);
            if (empty($student_model)) {
                echo "Invalid Token";
                die();
            }
            $student_model->status = 1;

            if ($student_model->update()) {
                $this->redirect(array('view', 'id' => $student_model->user_id));
            } else {
                echo '<pre>';
                print_r($student_model->errors);
                die;
            }
        }
    }

    public function actionCreateTempUser() {
        $model = new TemporaryUser;

        $model->first_name = $_POST['first_name'];
        $model->last_name = $_POST['last_name'];
        $model->phone_number = $_POST['phone_number'];
        $model->address = $_POST['address'];
        $model->country = $_POST['country'];
        $model->email = $_POST['email'];
        $model->course_id = $_POST['course'];
        $model->level_id = $_POST['level'];
        $model->sitting_id = $_POST['sitting'];

        $model->save();


        $this->redirect(array('index'));
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

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];

            if ($model->update())
                $this->redirect(array('view', 'id' => $model->user_id));
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
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

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
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //Forgot password method
    public function actionForgotPassword() {

        $model = new User;

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $email = $model->email;

            //check valid email
            $validator = new CEmailValidator;
            if ($email != null) {
                if ($validator->validateValue($email)) {
                    //check email existence
                    $email_exist = User::model()->checkEmailExist($email);
                    if ($email_exist == "yes") {
                        //get user data
                        $user_data = User::model()->getUserByEmail($email);
                        $model = $this->loadModel($user_data->user_id);

                        $token = User::model()->generateToken($email);
                        $model->reset_token = $token;



                        //genarate new password
                        //$new_password = rand(10000, 99999);
                        // $model->password = md5($new_password);

                        if ($model->update()) {
                            //send new password to email                            

                            $reset_url = $this->createAbsoluteUrl('viewResetPassword', array('token' => $token));
                            $link = CHtml::link($reset_url, Yii::app()->createAbsoluteUrl('user/viewResetPassword', array('token' => $token)));
                            $subject = "Reset Password";
                            //$message = "your new password is " . $new_password;
                            $message = "
                        Hello $email ,<br/>
                        Plese go to following URL to reset your password:<br/>
                        $link <br/><br/>
                        NOTE: This is only valid for one hour only <br/><br/>
                        LearnCIMA
                        ";
                            sendEmail($subject, $message, $email);
                            $this->redirect($this->createUrl('user/passwordsent'));
                        }
                    } else {
                        //if email is not registered
                        Yii::app()->user->setFlash('fp_error', "Sorry, this is not a registered email address");
                    }
                } else {
                    //if email is invalid
                    Yii::app()->user->setFlash('fp_error', "Please enter a valid email address");
                }
            } else {
                Yii::app()->user->setFlash('fp_error', "Please enter your email address");
            }
        }

        $this->render('forgotpassword', array('model' => $model));
    }

    public function actionViewResetPassword() {

        if (isset($_GET['token'])) {

            $user = User::model()->findByAttributes(array('reset_token' => $_GET['token']));

            // var_dump($user['user_id']);die;

            if (!$user) {
                Yii::app()->user->setFlash('error', "Invalid Token");
                $this->redirect('forgotpassword');
            } elseif (!User::model()->validateToken($_GET['token'])) {
                Yii::app()->user->setFlash('notice', "Token has expired");
                $this->redirect('forgotpassword');
            } else {
                $this->render('resetPassword', array('user' => $user['user_id']));
            }
        }
    }

    public function actionResetPassword() {

        if (isset($_POST['newPass']) && isset($_POST['repeatPass'])) {

            $newpass = $_POST['newPass'];
            $repeatPass = $_POST['repeatPass'];

            $model = $this->loadModel($_REQUEST['user']);

            if ($newpass == $repeatPass) {
                $model->password = md5($newpass);
                $model->update();
                $this->redirect($this->createUrl('user/lecpasswordsent'));
            } else {
                Yii::app()->user->setFlash('error', "New password do not match with repeat new password!");
            }
        }
        // $this->render('resetPassword');
    }

    //sucessfull password sent redirection
    public function actionpasswordsent() {
        $this->render('passwordsent');
    }

    public function actionLecpasswordsent() {
        $this->render('lecPassChange');
    }

    public function actionUpdatepass($id) {
        $model = $this->loadModel($id);


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User']['current_password'])) {

            //$model->current_password= md5($_POST['User']['current_password']);

            if (md5($_POST['User']['current_password']) == $model->password) {
                if ($_POST['User']['new_password'] == $_POST['User']['repeat_new_password']) {
                    $model->password = md5($_POST['User']['new_password']);
                    $model->update();
                    $this->redirect(array('view', 'id' => $model->user_id));
                } else {
                    Yii::app()->user->setFlash('error', "New password do not match with repeat new password!");
                }
            } else {
                Yii::app()->user->setFlash('error', "Password do not match with current password!");
            }
        }
        $this->render('updatepass', array(
            'model' => $model,
        ));
    }

    public function actionViewScheduledExams($id) {
        $model = $this->loadModel($id);
        $user_id = Yii::app()->user->getId();
        $student_id = Student::model()->getStudentIdForUserId($user_id);

        $this->render('_scheduledExams', array(
            'model' => $model,
            'student_id' => $student_id
        ));
    }

    public function actionViewPastExams($id) {
        $model = $this->loadModel($id);
        $user_id = Yii::app()->user->getId();
        $student_id = Student::model()->getStudentIdForUserId($user_id);

        $this->render('_pastExams', array(
            'model' => $model,
            'student_id' => $student_id
        ));
    }

    public function actiondetail() {
        $this->render('detail');
    }

    public function actionPayment() {
        $price = null;
        
        if (isset($_POST['price'])){
            $price = $_POST['price'];
        }
        
//        if (isset($_GET['price'])) {
//            if ($_GET['price'] == 'INTEGRATED') {
//                $price = 595;
//            } else if ($_GET['price'] == 'OBJECTIVE') {
//                $price = 350;
//            } else if ($_GET['price'] == 'MANAGERIAL') {
//                $price = 495;
//            } else if ($_GET['price'] == 'REVISION') {
//                $price = 350;
//            } else if ($_GET['price'] == 'REVISION-MG') {
//                $price = 275;
//            }
//        }
        $this->render('payment', array('price' => $price));
    }

    public function actionPaymentResult() {

        $model = new FrontendPayment;
        $merchantReferenceNo = uniqid(); //substr(number_format(time() * mt_rand(), 0, '', ''), 0, 20);

        $model->first_name = $_POST['first_name'];
        $model->last_name = $_POST['last_name'];
        $model->address = $_POST['address'];
        $model->cima_id = $_POST['cima_id'];
        $model->email = $_POST['email'];
        $model->contact_no = $_POST['contact_no'];
        $model->course = $_POST['course'];
        $model->amount = $_POST['amount'];
        $model->ref_no = $merchantReferenceNo;

        $subject_header = "LearnCIMA.com - Pre Payment Submission";
        $message_body = "LearnCIMA.com - Pre Payment Submission<br/><br/> Following customer has filled details for the payment submission<br/><br/>
                First Name:- " . $model->first_name . "<br/>
                Last Name:- " . $model->last_name . "<br/>
                Address:- " . $model->address . "<br/>
                CIMA ID:- " . $model->cima_id . "<br/>
                Email:- " . $model->email . "<br/>
                Contact No.:- " . $model->contact_no . "<br/>
                Course:- " . $model->course . "<br/>
                Amount:- " . $model->amount . "<br/>
                Ref No.:- " . $model->ref_no . "<br/>";
        if ($model->save()) {
            ?>
            <script type="text/javascript">
                /* <![CDATA[ */
                var google_conversion_id = 962159633;
                var google_conversion_language = "en";
                var google_conversion_format = "3";
                var google_conversion_color = "ffffff";
                var google_conversion_label = "zOtsCPyyglkQkcjlygM";
                var google_conversion_value = <?php echo $_POST['amount']; ?>;
                var google_conversion_currency = "GBP";
                var google_remarketing_only = false;
                /* ]]> */
            </script>
            <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/962159633/?value=<?php echo $_POST['amount']; ?>&amp;currency_code=GBP&amp;label=zOtsCPyyglkQkcjlygM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>


            <?php
            sendEmail($subject_header, $message_body, Yii::app()->params['infomail']);

            $model_front_payment_audit = new Audit;
            if (Yii::app()->user->id != null) {
                $user_id = Yii::app()->user->id;
                $model_front_payment_audit->user_id = $user_id;
            } else {
                $model_front_payment_audit->user_id = null;
            }
            $model_front_payment_audit->action_id = $model->id;
            $model_front_payment_audit->action_name = "FRONT_END_PAYMENT";
            $model_front_payment_audit->action = "PAY";
            $model_front_payment_audit->date = date("Y/m/d");
            $model_front_payment_audit->time = date("h:i:sa");
            $model_front_payment_audit->status = 1;

            if ($model_front_payment_audit->save()) {
                
            } else {
                print_r($model_front_payment_audit->errors);
                die();
            }

            $this->redirect(array('frontendPayment/view', 'id' => $model->id));
        } else {
            print_r($model->errors);
            die;
        }
    }

    public function actionPgresponse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $transactionId = isset($_POST["transaction_id"]) ? $_POST["transaction_id"] : '';
            $refNo = isset($_POST["merchant_reference_no"]) ? $_POST["merchant_reference_no"] : '';
            $status = isset($_POST["status"]) ? $_POST["status"] : '';

            $txn = FrontendPayment::model()->findByAttributes(array('ref_no' => $refNo/* , 'status' => 'pending' */));

            $statusText = '';
            $txnStatus = '';
            if ($txn) {
                if ($status == 50020) {
                    $statusText = 'Transaction Passed';
                    $txnStatus = 'SUCCESS';
                    $transac_id = $transactionId;
                } else if ($status == 50097) {
                    $statusText = 'Test Transaction Passed';
                    $txnStatus = 'TEST_SUCCESS';
                    $transac_id = $transactionId;
                } else {
                    $txnStatus = 'FAILED';
                    $statusText = 'Transaction Failed';
                    $transac_id = $transactionId;
                }

                $txn->status = $txnStatus;
                $txn->transaction_id = $transac_id;
                $txn->update();

                $user_details = FrontendPayment::model()->findByAttributes(array('transaction_id' => $transac_id/* , 'status' => 'pending' */));
                $first_name = $user_details->first_name;

                $ip_address = $_SERVER['REMOTE_ADDR'];
                $date_time = date('m/d/Y h:i:s a', time());
                $u_agent = $_SERVER['HTTP_USER_AGENT'];
                $ub = '';
                if (preg_match('/MSIE/i', $u_agent)) {
                    $ub = "Internet Explorer";
                } elseif (preg_match('/Firefox/i', $u_agent)) {
                    $ub = "Mozilla Firefox";
                } elseif (preg_match('/Safari/i', $u_agent)) {
                    $ub = "Apple Safari";
                } elseif (preg_match('/Chrome/i', $u_agent)) {
                    $ub = "Google Chrome";
                } elseif (preg_match('/Flock/i', $u_agent)) {
                    $ub = "Flock";
                } elseif (preg_match('/Opera/i', $u_agent)) {
                    $ub = "Opera";
                } elseif (preg_match('/Netscape/i', $u_agent)) {
                    $ub = "Netscape";
                }

                $message = "LearnCIMA.com-Payment Submission  <br /><br />                   
                    Amount(GBP):" . $user_details->amount . "\n<br /><br/>
                    Transaction status: " . $txnStatus . "<br />
                    Transcation reference: " . $refNo . "<br />
                    Date and time : " . $date_time . "<br /><br />
                        
                    Payment Details <br /><br />
                    First Name: " . $user_details->first_name . "<br />
                    Last Name:  " . $user_details->last_name . "<br />
                    Address: :  " . $user_details->address . "<br />
                    CIMA ID:   " . $user_details->cima_id . "<br />
                    Email:   " . $user_details->email . "<br />
                    Contact No: " . $user_details->contact_no . "<br />
                    Course: " . $user_details->course . "<br />
                    Amount(GBP): " . $user_details->amount . "<br />
                    <br /><br />
                    Sent from : " . $_SERVER['REMOTE_ADDR'] . "<br />
                    Browser : " . Yii::app()->browser->getBrowser() . "<br />
                    Date and time : " . $date_time . "<br /><br />";

                $header = "LearnCIMA.com-Payment Submission " . $user_details->first_name . " " . $user_details->last_name . " " . $user_details->email . " " . $user_details->amount;

                // $message = "A transaction has occured! refrence no : " . $refNo;
                sendEmail($header, $message, Yii::app()->params['infomail']);
            }

            $this->render('paymentResponse', array('status' => $statusText, 'refNo' => $refNo));
        }
    }

    public function actionReadmoreLevelNews() {
        $levelid = $_REQUEST['levelid'];
        $messageid = $_REQUEST['messageid'];

        $this->render('radmore_level_news', array('levelid' => $levelid, 'messageid' => $messageid));
    }

    public function actionSendMaterialMail() {
        $mail_address = $_POST['mail'];
        $status = "fail";
        $msg = "";
        if (isset($_POST['mail']) && $mail_address != "") {

            if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
                $status = 'fail';
                $msg = "Please enter a valid email address";
            } else {
                $subject = "LearnCIMA.com-Free Materials Request from " . $mail_address;
                $email_admin = Yii::app()->params['infomail'];
                $date_time = date('m/d/Y h:i:s a', time());

                $message = "Materials Request <br /><br />                   
                    Email : " . $mail_address . "\n<br /><br/>
                    IP address : " . $_SERVER['REMOTE_ADDR'] . "<br />
                    Browser : " . Yii::app()->browser->getBrowser() . "<br />
                    Date and time : " . $date_time . "<br />";

                // $message = "Email Address :" . $mail_address;
                sendEmail($subject, $message, $email_admin);
                $status = 'success';
                $msg = "Materials will be sent to your email soon.";
            }
        } else {
            $status = 'fail';
            $msg = "Please enter an email";
        }

        echo CJSON::encode(array(
            'status' => $status,
            'msg' => $msg
        ));
    }

    public function actionDetailLecturer() {
        $this->render('detail_lecturer');
    }

    public function actionViewLecturerDetails() {
        $user_id = $_REQUEST['id'];
        $this->render('viewLecturerDetails', array('id' => $user_id));

        //echo $user_id;
    }

    public function actionViewChangeLecPass() {
        $user_id = $_REQUEST['id'];
        $this->render('updateLecPass', array('id' => $user_id));
    }

    public function actionSaveLecPass($id) {

        $model = $this->loadModel($id);

        $currentpass = $_POST['currentPass'];
        $newpass = $_POST['newPass'];
        $repeatPass = $_POST['repeatPass'];

        if (md5($currentpass) == $model->password) {
            if ($newpass == $repeatPass) {
                $model->password = md5($newpass);
                $model->update();
                $this->redirect($this->createUrl('user/lecpasswordsent'));
            } else {
                Yii::app()->user->setFlash('error', "New password do not match with repeat new password!");
            }
        } else {
            Yii::app()->user->setFlash('error', "Password do not match with current password!");
        }
        //$this->render('detailLecturer');
    }

    public function actionViewStudentActivationInfo() {
        $this->render('student_activation_information');
    }

}
