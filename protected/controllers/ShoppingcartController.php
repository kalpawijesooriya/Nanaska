<?php

define('TYPE_DYNAMIC', 'DYNAMIC');
define('TYPE_PRESET', 'PRESET');
define('TYPE_ESSAY', 'ESSAY');

class ShoppingcartController extends Controller {

    public function filters() {
        return array('accessControl'); // perform access control for CRUD operations
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('addExam', 'viewCart', 'pgresponse', 'removeRequest', 'checkout', 'purchaseBulk', 'test'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionAddExam() {
        $data = array();
        $data['response'] = FALSE;
        $error_messages = array();

        if (!isset(Yii::app()->session[Consts::STR_SHOPPING_CART])) {
            $shopping_cart = array(
                "exams" => array(),
            );
            Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart;
        }
        if (Yii::app()->request->getPost('exam_id', -1) && Yii::app()->request->getPost('exam_id', -1) != "") {
            $exam_id = Yii::app()->request->getPost('exam_id', -1);

            $shopping_cart = Yii::app()->session[Consts::STR_SHOPPING_CART];

            if ($this->validateExamID($exam_id)) {
                $shopping_cart['exams'][] = array('shopping_cart_exam_id' => $this->getNewShoppingCartExamID(), 'exam_id' => $exam_id);
                Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart;
                $data['response'] = TRUE;
            } else {
                $error_messages[] = "this exam already added";
            }
        }
        $data['error_messages'] = $error_messages;
//        echo '<pre>';
//        print_r(Yii::app()->session['shopping_cart']);

        echo CJSON::encode(array(
            'response' => $data['response'],
            'shopping_cart_qty' => sizeof(Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS]),
            'message' => $data['error_messages']
        ));
    }

    public function getNewShoppingCartExamID() {
        $exam_list = Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS];

        $last_id = 0;
        if (isset($exam_list)) {
            foreach ($exam_list as $exam_data) {
                $last_id = $exam_data['shopping_cart_exam_id'];
            }
        }
        $last_id++;

        return $last_id;
    }

    public function validateExamID($exam_id) {
        $exam_data = Exam::model()->getExam($exam_id);

        if ($exam_data['exam_type'] == Consts::EXAM_TYPE_DYNAMIC) {
            return TRUE;
        } else {

            $exam_list = Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS];
            foreach ($exam_list as $exam_data) {
                if ($exam_data['exam_id'] == $exam_id) {
                    return FALSE;
                }
            }
            return TRUE;
        }
    }

    /**
     * Displays the shopping cart
     */
    public function actionViewCart() {
//          unset(Yii::app()->session['shopping_cart']);die();
        $exams = array();
        $this->render('shoppingCart', array('exams' => $exams));
    }

    public function actionRemoveRequest() {
        $shopping_cart_session = Yii::app()->session[Consts::STR_SHOPPING_CART];

        $shopping_cart_exam_id = Yii::app()->request->getPost('removeItem', -1);

        $exam_list = $shopping_cart_session['exams'];
        $total_price = 0;
        foreach ($exam_list as $key => $exam_list_item) {
            if ($exam_list_item['shopping_cart_exam_id'] == $shopping_cart_exam_id) {
                unset($exam_list[$key]);
            }
        }
        if (isset($exam_list)) {
            foreach ($exam_list as $shopping_cart_exam) {
                $exam_price = Exam::model()->getExamPrice($shopping_cart_exam['exam_id']);
                $exam_price_float = floatval($exam_price);
                $total_price = $total_price + $exam_price_float;
            }
        }
        $shopping_cart_session['exams'] = $exam_list;
        Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart_session;

//        die($total_price);
        $price_parts = explode('.', $total_price);

        if (count($price_parts) > 1) {
            $total_amount = (int) $price_parts[0] . str_pad($price_parts[1], 2, "0", STR_PAD_RIGHT);
        } else {
            $total_amount = (int) $price_parts[0] . "00";
        }

        $merchantReferenceNo = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 20);
        $merchantResponseUrl = Yii::app()->createAbsoluteUrl('shoppingcart/Pgresponse');
        $messageHash = Yii::app()->params['payment']['pgInstanceId'] . "|" . Yii::app()->params['payment']['merchantId'] . "|" . Yii::app()->params['payment']['perform'] . "|" . Yii::app()->params['payment']['currencyCode'] . "|" . $total_amount . "|" . $merchantReferenceNo . "|" . $merchantResponseUrl . "|" . Yii::app()->params['payment']['hashKey'] . "|";
        $message_hash = "DYNAMIC-URL:8:" . base64_encode(sha1($messageHash, true));

        echo CJSON::encode(array(
            'status' => Consts::STATUS_SUCCESS,
            'message' => 'Item successfully updated',
            'shopping_cart_qty' => sizeof(Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS]),
            'total_price' => number_format($total_price, 2, '.', ''),
            'total_price_pay' => $total_amount,
            'ref' => $merchantReferenceNo,
            'message_hash' => $message_hash
        ));
    }

    public function actionPurchaseBulk() {
        $data = array();
        $data['response'] = FALSE;
        $error_messages = array();

        if (!isset(Yii::app()->session[Consts::STR_SHOPPING_CART])) {
            $shopping_cart = array(
                "exams" => array(),
            );
            Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart;
        }

        if (Yii::app()->request->getPost('exam_id', -1) && Yii::app()->request->getPost('exam_id', -1) != "" && Yii::app()->request->getPost('no_of_papers', 0) != 0) {
            $exam_id = Yii::app()->request->getPost('exam_id', -1);
            $number_of_papers = Yii::app()->request->getPost('no_of_papers', 0);
            $added_papers = 0;
            if ($this->validateExamID($exam_id)) {
                for ($i = 0; $i < $number_of_papers; $i++) {
                    $shopping_cart = Yii::app()->session[Consts::STR_SHOPPING_CART];
                    $shopping_cart[Consts::STR_EXAMS][] = array('shopping_cart_exam_id' => $this->getNewShoppingCartExamID(), 'exam_id' => $exam_id);
                    Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart;
                    $added_papers++;
                }
                $data['response'] = TRUE;
            } else {
                $error_messages[] = "this exam already added";
            }
        }
        $data['error_messages'] = $error_messages;
//        echo '<pre>';
//        print_r(Yii::app()->session['shopping_cart']);

        echo CJSON::encode(array(
            'response' => $data['response'],
            'message' => $data['error_messages'],
            'shopping_cart_qty' => sizeof(Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS]),
            'added_papers' => $added_papers
        ));
    }
    
    public function actionCheckout() {

        $shopping_cart_session = Yii::app()->session[Consts::STR_SHOPPING_CART];
        $user_id = Yii::app()->user->getId();
        $student_id = Student::model()->getStudentIdForUserId($user_id);
        $exam_list = $shopping_cart_session[Consts::STR_EXAMS];
        
        
        if (!empty($exam_list)) {
            foreach ($exam_list as $key => $exam_list_item) {
                $student_exam = new StudentExam();
                $student_exam->student_id = $student_id;
                $student_exam->start_date = "N/A";
                $student_exam->expiry_date = "N/A";
                $student_exam->exam_id = $exam_list_item['exam_id'];

                if ($student_exam->save()) {
                    
                } else {
                    print_r($student_exam->errors);
                    die();
                }
            }
            $this->unsetShoppingCartSession();
            $status = Consts::STATUS_SUCCESS;
            $message = CController::createUrl('user/viewScheduledExams&id=' . $user_id);
        }
        else{
            $status = Consts::STATUS_EMPTY;
            $message = Consts::MSG_EMPTY_CART;
        }
        echo CJSON::encode(array(
                'status' => $status,
                'message' => $message
            ));
    }
    
    public function actionPgresponse() {
       
        $transactionId = isset($_POST["transaction_id"]) ? $_POST["transaction_id"] : '';
        $status = isset($_POST["status"]) ? $_POST["status"] : '';

        $statusText = '';
        if ($status == "50020") {
            $this->checkoutExams($transactionId, $status);
            $statusText = 'Transaction Passed';
        } else if ($status == "50097") {
            $this->checkoutExams($transactionId, $status);
            $statusText = 'Test Transaction Passed';
        } else {
            $statusText = 'Transaction Failed';
        }

        $this->render('paymentResponse', array('status'=>$statusText, 'transactionId' =>$transactionId));
    }
    
    private function checkoutExams($transactionId, $status) {

        $shopping_cart_session = Yii::app()->session[Consts::STR_SHOPPING_CART];
        $user_id = Yii::app()->user->getId();
        $student_id = Student::model()->getStudentIdForUserId($user_id);
        $exam_list = $shopping_cart_session[Consts::STR_EXAMS];

        $txnHistory = new PaymentHistory();
        $txnHistory->transaction_id = $transactionId;
        if ($status == "50020") {
            $txnHistory->status = 'PASSED';
        } else if ($status == "50097") {
            $txnHistory->status = 'TEST PASSED';
        } else {
            $txnHistory->status = 'FAILED';
        }        
        $txnHistory->save();
        
        if (!empty($exam_list)) {
            foreach ($exam_list as $exam_list_item) {
                $student_exam = new StudentExam();
                $student_exam->student_id = $student_id;
                $student_exam->start_date = "N/A";
                $student_exam->expiry_date = "N/A";
                $student_exam->exam_id = $exam_list_item['exam_id'];
                $student_exam->transaction_id = $transactionId;

                $student_exam->save();
            }
            $this->unsetShoppingCartSession();
        }
        
        return true;
    }

        public function actionTest() {
        $user_id = Yii::app()->user->getId();
        $model = User::model()->findByPk($user_id);
        $student_id = Student::model()->getStudentIdForUserId($user_id);
        $this->render('exam_list_summary', array(
            'model' => $model,
            'student_exam_model' => StudentExam::model()->getExamsForStudentId($student_id)
        ));
    }
    
    public function unsetShoppingCartSession() {
        $shopping_cart_session = Yii::app()->session[Consts::STR_SHOPPING_CART];
        $shopping_cart_session[Consts::STR_EXAMS] = array();
        Yii::app()->session[Consts::STR_SHOPPING_CART] = $shopping_cart_session;
    }

}
