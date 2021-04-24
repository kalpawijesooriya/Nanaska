<?php

include_once 'EmailHandler.php';
require_once 'Excel/reader.php';

class QuestionController extends Controller {

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
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'getAnswerForms', 'SingleAnswerLoad',
                    'DragDropTypeB', 'suspend', 'reactivate', 'approve', 'admin', 'showUnapprovedQuestions',
                    'approveQuestion', 'disapproveQuestion', 'Bulkupload', 'singleanswerbulk', 'multipleanswerbulk', 'shortwrittenbulk', 'multiplechoicebulk',
                    'CreateSingleAnswerBulk', 'CreateMultipleAnswerBulk', 'CreateShortWrittenAnswerBulk', 'CreateMultipleChoiceBulk', 'viewQuestion', 'sendMail', 'reviewQuestion', 'getEssayType', 'removeDragDropTypeB', 'viewExample',
                    'questionStatistics', 'loadlevels', 'loadSubjects', 'loadSubjectAreas', 'loadQuestions',
                    'loadQuestionAndAnswer', 'viewReferenceMaterial', 'setReferenceMaterial', 'viewUpdateReferenceMaterial', 'updateReferenceMaterial', 'viewHotspot'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            //'users' => User::model()->getLectures(),
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

        $qtype = Question::model()->getQuestionTypeByQuestionId($id);

        if ($qtype != "HOT_SPOT_ANSWER") {
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        } else {
            $this->render('test_view', array(
                'model' => $this->loadModel($id),
            ));
        }
    }

    public function actionViewHotspot($id) {
        $this->render('test_view', array(
            'model' => $this->loadModel($id),
        ));
    }

    protected function getUploadDirExhibit($questionid) {
        $dir = Yii::getPathOfAlias('webroot') . '/images/exhibit_attachment/' . $questionid . '/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        //   echo $dir;die();
        return $dir;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Question;

//        echo '<script>alert("ewee");</script>';
//        if (!isset(Yii::app()->session['answer_session'])) {
//            Yii::app()->session['answer_session'] = array();
//        }
        //Yii::app()->session['answer_session'] = array();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Question'])) {

//            if(!isset($_POST['course_id'])){
//                Yii::app()->user->setFlash('course_error', "Course must be selected");
//            }
            $model->attributes = $_POST['Question'];
            $model->author_id = Yii::app()->user->getId();
            $model->date_created = date("Y/m/d");
            $model->question_type = $_POST['question_type'];

            if ($model->question_type != "ESSAY_ANSWER") {
                $model->exhibit_attachment = CUploadedFile::getInstance($model, 'exhibit_attachment');

                if ($model->exhibit_attachment != null) {
                    $exhibit_name = $model->exhibit_attachment->getName();
                }
            }

            //$dbtransaction = Yii::app()->db->beginTransaction();
            try {

                if ($model->save()) {
                    $question_id = $model->getPrimaryKey();
                    if ($model->exhibit_attachment != null) {
                        $upload_dir = $this->getUploadDirExhibit($question_id);
                        $model->exhibit_attachment->saveAs($upload_dir . $exhibit_name);
                    }


                    if ($model->question_type == "SHORT_WRITTEN") {
                        $heading_1 = $_POST['heading_1'];
                        $heading_2 = $_POST['heading_2'];

                        if ($heading_1 != null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->question_id = $question_id;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->heading_position = 1;

                            if ($model_heading_1->save()) {
                                
                            } else {
                                print_r($model_heading_1->errors);
                                die();
                            }
                        }

                        if ($heading_2 != null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->question_id = $question_id;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->heading_position = 2;

                            if ($model_heading_2->save()) {
                                
                            } else {
                                print_r($model_heading_2->errors);
                                die();
                            }
                        }

                        $shortWrittenQuestionPartSession = Yii::app()->session['short_written_question_part_session'];

                        if (!empty($shortWrittenQuestionPartSession)) {
                            foreach ($shortWrittenQuestionPartSession as $item) {
                                $model_question_part = new QuestionPart;

                                $model_question_part->question_id = $question_id;
                                $model_question_part->question_part_name = $item['question_part'];

                                if ($model_question_part->save()) {
                                    
                                } else {
                                    print_r($model_question_part->errors);
                                    die();
                                }

                                $question_part_id = $model_question_part->getPrimaryKey();


                                $answer_text = $item['answer'];

                                $model_anser_text = new AnswerText;
                                $model_anser_text->answer_text = $answer_text;
                                $model_anser_text->question_id = $question_id;
                                $answer_text_id;

                                if ($model_anser_text->save()) {
                                    $answer_text_id = $model_anser_text->getPrimaryKey();
                                } else {
                                    print_r($model_anser_text->errors);
                                    die();
                                }

                                $model_answer = new Answer;

                                $model_answer->question_id = $question_id;
                                $model_answer->question_part_id = $question_part_id;
                                $model_answer->answer_text_id = $answer_text_id;
                                $model_answer->is_correct = 1;

                                if ($model_answer->save()) {
                                    
                                } else {
                                    print_r($model_answer->errors);
                                    die();
                                }
                            }
                        }
                    }

                    //------------------start Single Answer Questions--------------------------
                    else if ($model->question_type == "SINGLE_ANSWER") {
//                        echo '<pre>';
//                        print_r($_POST); die;
                        if ($_POST['single_answer'] == "text_answer1") {

                            foreach ($_POST['answer'] as $key => $answer) {

                                if ($answer != null) {

                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $answer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        // print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['correct'][$key]) ? '1' : '0';



                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        //print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        } else if ($_POST['single_answer'] == "image_answer1") {

                            $images = CUploadedFile::getInstancesByName('imageanswer');

                            if (count($images) > 0) {
                                foreach ($images as $key => $pic) {

                                    if (in_array($pic->name, $_POST['deleted_img'])) {
                                        
                                    } else {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['correctimg'][$key]) ? '1' : '0';

                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/single_answer_images/' . $picname);
                                        } else {
                                            // print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        } else {
                            foreach ($_POST['answer'] as $key => $answer) {

                                if ($answer != null) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $answer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        //echo ">";
                                    } else {
                                        // print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['correct'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        //print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }


                            $images = CUploadedFile::getInstancesByName('imageanswer');
                            if (isset($images) && count($images) > 0) {
                                foreach ($images as $key => $pic) {
                                    if (in_array($pic->name, $_POST['deleted_img'])) {
                                        
                                    } else {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['correctimg'][$key]) ? '1' : '0';

                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/single_answer_images/' . $picname);
                                        } else {
                                            // print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //------------------end Single Answer Questions-------------------------- 
                    //start of multiple answer questions
                    else if ($model->question_type == "MULTIPLE_ANSWER") {

                        if ($_POST['single_answer'] == "text_answer1") {
                            foreach ($_POST['answer'] as $key => $answer) {

                                if ($answer != null) {

                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $answer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        // print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['correct'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        //print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        } else if ($_POST['single_answer'] == "image_answer1") {
                            $images = CUploadedFile::getInstancesByName('imageanswer');

                            if (isset($images) && count($images) > 0) {
                                foreach ($images as $key => $pic) {
                                    if (in_array($pic->name, $_POST['deleted_img'])) {
                                        
                                    } else {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['correctimg'][$key]) ? '1' : '0';

                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/multiple-answer-images/' . $picname);
                                        } else {
                                            // print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        } else {
                            foreach ($_POST['answer'] as $key => $answer) {

                                if ($answer != null) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $answer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        // print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['correct'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        //print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }


                            $images = CUploadedFile::getInstancesByName('imageanswer');


                            if (isset($images) && count($images) > 0) {
                                foreach ($images as $key => $pic) {
                                    if (in_array($pic->name, $_POST['deleted_img'])) {
                                        
                                    } else {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['correctimg'][$key]) ? '1' : '0';
                                        //$pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/multiple-answer-images/' . $picname);
                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/multiple-answer-images/' . $picname);
                                        } else {
                                            // print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //end of multiple answer questions
                    //------------------start Drag and Drop TypeA Answer Questions-------------------------- 
                    else if ($model->question_type == "DRAG_DROP_TYPEA_ANSWER") {
                        $dragDropTypeASession = Yii::app()->session['drag_drop_typea_session'];

                        if (!empty($dragDropTypeASession)) {
                            foreach ($dragDropTypeASession as $item) {
                                $model_question_part = new QuestionPart;

                                $model_question_part->question_id = $question_id;
                                $model_question_part->question_part_name = $item['question_part'];

                                if ($model_question_part->save()) {
                                    
                                } else {
                                    print_r($model_question_part->errors);
                                    die();
                                }

                                $question_part_id = $model_question_part->getPrimaryKey();

//                                $model_answer = new Answer;
//
//                                $model_answer->question_id = $question_id;
//                                $model_answer->question_part_id = $question_part_id;
//                                $model_answer->answer_text = $item['answer'];
//                                $model_answer->is_correct = 1;

                                $answer_text = $item['answer'];

                                $model_anser_text = new AnswerText;
                                $model_anser_text->answer_text = $answer_text;
                                $model_anser_text->question_id = $question_id;
                                $answer_text_id;

                                if ($model_anser_text->save()) {
                                    $answer_text_id = $model_anser_text->getPrimaryKey();
                                } else {
                                    print_r($model_anser_text->errors);
                                    die();
                                }

                                $model_answer = new Answer;

                                $model_answer->question_id = $question_id;
                                $model_answer->question_part_id = $question_part_id;
                                $model_answer->answer_text_id = $answer_text_id;
                                $model_answer->is_correct = 1;

                                if ($model_answer->save()) {
                                    
                                } else {
                                    print_r($model_answer->errors);
                                    die();
                                }
                            }
                        }
                    }
                    //------------------end Drag and Drop TypeA Answer Questions--------------------------
                    //------------------start Drag & Drop Type C Answer Questions--------------------------
                    else if ($model->question_type == "DRAG_DROP_TYPEC_ANSWER") {

                        $saved_answes_tb_names = array();
                        $tc_question_id = $model->question_id;
                        $tc_max_no_of_answers = $_POST['max_no_of_answers'];
                        $tc_max_no_of_question_parts = $_POST['max_no_of_question_parts'];

                        //save all answers
                        for ($i = 1; $i <= $tc_max_no_of_answers; $i++) {
                            $answer_tb_name = 'answer_' . $i;

                            $tc_answer_text_model = new AnswerText;
                            $tc_answer_text_model->answer_text = "";
                            if (isset($_POST[$answer_tb_name]) && $_POST[$answer_tb_name] != "") {
                                $tc_answer_text_model->answer_text = $_POST[$answer_tb_name];
                            }
                            $tc_answer_text_model->question_id = $tc_question_id;
                            if ($tc_answer_text_model->save()) {
                                $saved_answes_tb_names[$answer_tb_name] = $tc_answer_text_model->getPrimaryKey();
                            }
                        }


                        for ($i = 1; $i <= $tc_max_no_of_question_parts; $i++) {
                            $question_tb_name = 'question_' . $i;
                            $selectanswer_name = 'selectanswer_' . $i;
                            if (isset($_POST[$question_tb_name]) && $_POST[$question_tb_name] != "") {

                                //save question part
                                $tc_model_question_part = new QuestionPart;
                                $tc_model_question_part->question_part_name = $_POST[$question_tb_name];
                                $tc_model_question_part->question_id = $tc_question_id;
                                if ($tc_model_question_part->save()) {
                                    $tc_question_part_id = $tc_model_question_part->question_part_id;

                                    //save answer  
                                    $tc_model_answer = new Answer;
                                    $tc_model_answer->question_id = $tc_question_id;
                                    $tc_model_answer->question_part_id = $tc_question_part_id;
                                    $tc_model_answer->is_correct = 1;
                                    $tc_model_answer->answer_text_id = $saved_answes_tb_names[$_POST[$selectanswer_name]];

                                    if ($tc_model_answer->save()) {
                                        //$saved_answes_tb_names[] = $_POST[$selectanswer_name];
                                    }
                                }
                            }
                        }

                        /*
                          //save other answers
                          for ($i = 1; $i <= $tc_max_no_of_answers; $i++) {
                          $answer_tb_name = 'answer_' . $i;
                          if (!in_array($answer_tb_name, $saved_answes_tb_names) && $_POST[$answer_tb_name] != "") {
                          $tc_model_answer = new Answer;
                          $tc_model_answer->question_id = $tc_question_id;
                          $tc_model_answer->is_correct = 0;
                          $tc_model_answer->answer_text = $_POST[$answer_tb_name];
                          $tc_model_answer->save();
                          }
                          }
                         * 
                         */
                    }
                    //------------------end Drag & Drop Type C Answer Questions-------------------------- 
                    else if ($model->question_type == "MULTIPLE_CHOICE_ANSWER") {
                        $heading_1 = $_POST['heading_1'];
                        $heading_2 = $_POST['heading_2'];

                        if ($heading_1 != null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->question_id = $question_id;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->heading_position = 1;

                            if ($model_heading_1->save()) {
                                
                            } else {
                                print_r($model_heading_1->errors);
                                die();
                            }
                        }

                        if ($heading_2 != null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->question_id = $question_id;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->heading_position = 2;

                            if ($model_heading_2->save()) {
                                
                            } else {
                                print_r($model_heading_2->errors);
                                die();
                            }
                        }

                        $answers = Yii::app()->session['multiple_choice_answer_session'];
                        $questionPartData = Yii::app()->session['multiple_choice_session'];

                        // var_dump($answers);
                        //die;

                        foreach ($answers as $answer) {
                            foreach ($answer as $key => $items) {
                                $model_answer_text = new AnswerText;

                                $model_answer_text->answer_text = $items['answer_text'];
                                $model_answer_text->question_id = $question_id;

                                $answer_text_id;

                                if ($model_answer_text->save()) {
                                    $answer_text_id = $model_answer_text->getPrimaryKey();
                                } else {
                                    print_r($model_answer_text->errors);
                                    die();
                                }

                                $dataObjs = QuestionPart::model()->findAllByAttributes(array(
                                    'question_id' => $question_id,
                                    'question_part_name' => $items['question_part']
                                        )
                                );

                                $correctAnswer = 0;
                                foreach ($questionPartData as $questionPart) {
                                    if ($questionPart['question_part'] == $items['question_part']) {
                                        if ($questionPart['is_correct'] == $items['answer_position']) {
                                            $correctAnswer = 1;
                                        }
                                    }
                                }

                                $data = CHtml::listData($dataObjs, 'question_part_name', 'question_part_id');

                                if (sizeof($data) == 0) {
                                    $model_question_part = new QuestionPart;
                                    $model_question_part->question_id = $question_id;
                                    $model_question_part->question_part_name = $items['question_part'];

                                    if ($model_question_part->save()) {
                                        
                                    } else {
                                        print_r($model_question_part->errors);
                                        die();
                                    }

                                    $question_part_id = $model_question_part->getPrimaryKey();

                                    $model_answer = new Answer;

                                    $model_answer->question_id = $question_id;
                                    $model_answer->question_part_id = $question_part_id;
                                    $model_answer->answer_text_id = $answer_text_id;
                                    $model_answer->is_correct = $correctAnswer;

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die();
                                    }
                                } else {

                                    $qpartid;
                                    foreach ($data as $item) {
                                        $qpartid = $item;
                                    }

                                    $question_part_id = $qpartid;

                                    $model_answer = new Answer;

                                    $model_answer->question_id = $question_id;
                                    $model_answer->question_part_id = $question_part_id;
                                    $model_answer->answer_text_id = $answer_text_id;
                                    $model_answer->is_correct = $correctAnswer;

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die();
                                    }
                                }
                            }
                        }
                        //$multipleChoiceQuestionPartSession = Yii::app()->session['multiple_choice_session'];
                    }

                    //------------------Start Drag & Drop Type B Answer Questions--------------------------
                    else if ($model->question_type == "DRAG_DROP_TYPEB_ANSWER") {
                        $heading_1 = isset($_POST['heading_1']) ? $_POST['heading_1'] : null;
                        $heading_2 = isset($_POST['heading_2']) ? $_POST['heading_2'] : null;

                        if ($heading_1 != null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->question_id = $question_id;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->heading_position = 1;

                            if ($model_heading_1->save()) {
                                
                            } else {
                                print_r($model_heading_1->errors);
                                die();
                            }
                        }

                        if ($heading_2 != null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->question_id = $question_id;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->heading_position = 2;

                            if ($model_heading_2->save()) {
                                
                            } else {
                                print_r($model_heading_2->errors);
                                die();
                            }
                        }

                        $drag_drop_typeB_session = Yii::app()->session['drag_drop_typeb_session'];

                        if (!empty($drag_drop_typeB_session)) {
                            foreach ($drag_drop_typeB_session as $drag_drop_B) {
                                $question_part_model = new QuestionPart;

                                $question_part_model->question_id = $question_id;
                                $question_part_model->question_part_name = $drag_drop_B['question_part'];

                                if ($question_part_model->save()) {
                                    
                                } else {
                                    print_r($question_part_model->errors);
                                    die();
                                }

                                $question_part_id = $question_part_model->getPrimaryKey();

                                if (isset($drag_drop_B['answer1'])) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $drag_drop_B['answer1'];
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die();
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->question_id = $question_id;
                                    $model_answer->question_part_id = $question_part_id;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->is_correct = 1;

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die();
                                    }
                                }
                                if (isset($drag_drop_B['answer2'])) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $drag_drop_B['answer2'];
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die();
                                    }


                                    $model_answer = new Answer;
                                    $model_answer->question_id = $question_id;
                                    $model_answer->question_part_id = $question_part_id;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->is_correct = 1;
                                }

                                if ($model_answer->save()) {
                                    
                                } else {
                                    print_r($model_answer->errors);
                                    die();
                                }
                            }
                        }
                    } else if ($model->question_type == "TRUE_OR_FALSE_ANSWER") {
                        $answer = new Answer;

                        $answer->question_id = $question_id;

                        if (isset($_POST['answer'])) {

                            $is_correct = $_POST['answer'];

                            if ($is_correct == "true") {
                                $answer->is_correct = 1;
                            } else if ($is_correct == "false") {
                                $answer->is_correct = 0;
                            }

                            if ($answer->save()) {
                                
                            } else {
                                print_r($answer->errors);
                                die();
                            }
                        } else {

                            $answer->is_correct = 3;

                            if ($answer->save()) {
                                
                            } else {
                                print_r($answer->errors);
                                die();
                            }
                        }

//                        die();
                    } else if ($model->question_type == "DRAG_DROP_TYPEE_ANSWER") {
                        $heading_1 = $_POST['heading_1'];
                        $heading_2 = $_POST['heading_2'];

                        if ($heading_1 != null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->question_id = $question_id;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->heading_position = 1;

                            if ($model_heading_1->save()) {
                                
                            } else {
                                print_r($model_heading_1->errors);
                                die();
                            }
                        }

                        if ($heading_2 != null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->question_id = $question_id;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->heading_position = 2;

                            if ($model_heading_2->save()) {
                                
                            } else {
                                print_r($model_heading_2->errors);
                                die();
                            }
                        }

                        $dragDropTypeESession = Yii::app()->session['drag_drop_typee_question_part_session'];

                        $other_answers = Yii::app()->session['other_answer_session'];

                        if (!empty($dragDropTypeESession)) {


                            if (!empty($other_answers)) {
                                foreach ($other_answers as $other_answer) {

                                    $model_answer_text = new AnswerText;

                                    $model_answer_text->question_id = $question_id;
                                    $model_answer_text->answer_text = $other_answer['other_answer'];

                                    if ($model_answer_text->save()) {
                                        $other_answer_text_id = $model_answer_text->getPrimaryKey();
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die();
                                    }

                                    $model_other_answer = new Answer;

                                    $model_other_answer->question_id = $question_id;
                                    $model_other_answer->is_correct = 0;
                                    $model_other_answer->answer_text_id = $other_answer_text_id;

                                    if ($model_other_answer->save()) {
                                        
                                    } else {
                                        print_r($model_other_answer->errors);
                                        die();
                                    }
                                }
                            }

                            foreach ($dragDropTypeESession as $item) {
                                $model_question_part = new QuestionPart;

                                $model_question_part->question_id = $question_id;
                                $model_question_part->question_part_name = $item['question_part'];

                                if ($model_question_part->save()) {
                                    
                                } else {
                                    print_r($model_question_part->errors);
                                    die();
                                }

                                $question_part_id = $model_question_part->getPrimaryKey();

                                $model_question_part_text = new QuestionPartText;

                                $model_question_part_text->question_part_id = $question_part_id;
                                $model_question_part_text->question_part_text = $item['question_part_text'];

                                if ($model_question_part_text->save()) {
                                    
                                } else {
                                    print_r($model_question_part_text->errors);
                                    die();
                                }

                                $answer_text = $item['answer'];

                                $model_anser_text = new AnswerText;
                                $model_anser_text->answer_text = $answer_text;
                                $model_anser_text->question_id = $question_id;
                                $answer_text_id;

                                if ($model_anser_text->save()) {
                                    $answer_text_id = $model_anser_text->getPrimaryKey();
                                } else {
                                    print_r($model_anser_text->errors);
                                    die();
                                }




                                $model_answer = new Answer;

                                $model_answer->question_id = $question_id;
                                $model_answer->question_part_id = $question_part_id;
                                $model_answer->answer_text_id = $answer_text_id;
                                $model_answer->is_correct = 1;

                                if ($model_answer->save()) {
                                    
                                } else {
                                    print_r($model_answer->errors);
                                    die();
                                }
                            }
                        }
                    } else if ($model->question_type == "DRAG_DROP_TYPED_ANSWER") {
                        $result_text = $_POST['result_text'];
                        $question_part = $_POST['question_part'];
                        $operator_1 = $_POST['operator_1'];
                        $answer_1 = $_POST['answer_1'];
                        $operator_2 = $_POST['operator_2'];
                        $answer_2 = $_POST['answer_2'];


                        $model_question_part = new QuestionPart;

                        $model_question_part->question_part_name = $question_part;
                        $model_question_part->question_id = $question_id;
                        $question_part_id = null;

                        if ($model_question_part->save()) {
                            $question_part_id = $model_question_part->getPrimaryKey();
                        } else {
                            $model_question_part->addError($model_question_part->question_part_name, "question part cannot be blank");
                            //  print_r($model_question_part->errors);
                            //die();
                        }



                        $model_answer_1_text = new AnswerText;

                        $model_answer_1_text->answer_text = $answer_1;
                        $model_answer_1_text->question_id = $question_id;
                        $answer_1_text_id = null;

                        if ($model_answer_1_text->save()) {
                            $answer_1_text_id = $model_answer_1_text->getPrimaryKey();
                        } else {
                            $model_answer_1_text->addError($model_answer_1_text->answer_text, "Answer text cannot be blank");
                            //print_r($model_answer_1_text->errors);
                            //die();
                        }

                        $model_answer_1 = new Answer;

                        $model_answer_1->question_id = $question_id;
                        $model_answer_1->question_part_id = $question_part_id;
                        $model_answer_1->is_correct = 1;
                        $model_answer_1->answer_text_id = $answer_1_text_id;

                        if ($model_answer_1->save()) {
                            
                        } else {
                            $model_answer_1->addError($model_answer_1->answer_text_id, "Cannot be blank");
//                            print_r($model_answer_1->errors);
//                            die();
                        }

                        $model_answer_2_text = new AnswerText;

                        $model_answer_2_text->answer_text = $answer_2;
                        $model_answer_2_text->question_id = $question_id;
                        $answer_2_text_id = null;

                        if ($model_answer_2_text->save()) {
                            $answer_2_text_id = $model_answer_2_text->getPrimaryKey();
                        } else {
                            $model_answer_2_text->addError($model_answer_2_text->answer_text, "cannot be blank");
//                            print_r($model_answer_2_text->errors);
//                            die();
                        }

                        $model_answer_2 = new Answer;

                        $model_answer_2->question_id = $question_id;
                        $model_answer_2->question_part_id = $question_part_id;
                        $model_answer_2->is_correct = 1;
                        $model_answer_2->answer_text_id = $answer_2_text_id;

                        if ($model_answer_2->save()) {
                            
                        } else {
                            $model_answer_2->addError($model_answer_2->answer_text_id, "cannot be blank");
//                            print_r($model_answer_2->errors);
//                            die();
                        }



                        $model_result_text = new AnswerText;

                        $model_result_text->answer_text = $result_text;
                        $model_result_text->question_id = $question_id;
                        $result_text_id = null;

                        if ($model_result_text->save()) {
                            $result_text_id = $model_result_text->getPrimaryKey();
                        } else {
                            $model_result_text->addError($model_result_text->answer_text, "cannot be balnk");
//                            print_r($model_result_text->errors);
//                            die();
                        }

                        $model_result_text = new Answer;

                        $model_result_text->question_id = $question_id;
                        $model_result_text->is_correct = 1;
                        $model_result_text->answer_text_id = $result_text_id;

                        if ($model_result_text->save()) {
                            
                        } else {
//                            print_r($model_result_text->errors);
//                            die();
                        }


                        $model_operator_1 = new QuestionPartText;

                        $model_operator_1->question_part_id = $question_part_id;
                        $model_operator_1->question_part_text = $operator_1;

                        if ($model_operator_1->save()) {
                            
                        } else {
//                            print_r($model_operator_1->errors);
//                            die();
                        }

                        $model_operator_2 = new QuestionPartText;

                        $model_operator_2->question_part_id = $question_part_id;
                        $model_operator_2->question_part_text = $operator_2;

                        if ($model_operator_2->save()) {
                            
                        } else {
                            $model_operator_2->addError($model_operator_2->question_part_text, "cannot be blank");
//                            print_r($model_operator_2->errors);
//                            die();
                        }



                        $other_answers = Yii::app()->session['other_answer_session'];

                        if (!empty($other_answers)) {
                            foreach ($other_answers as $other_answer) {

                                $model_answer_text = new AnswerText;

                                $model_answer_text->question_id = $question_id;
                                $model_answer_text->answer_text = $other_answer['other_answer'];
                                $other_answer_text_id = null;

                                if ($model_answer_text->save()) {
                                    $other_answer_text_id = $model_answer_text->getPrimaryKey();
                                } else {
//                                    print_r($model_answer_text->errors);
//                                    die();
                                }

                                $model_other_answer = new Answer;

                                $model_other_answer->question_id = $question_id;
                                $model_other_answer->is_correct = 0;
                                $model_other_answer->answer_text_id = $other_answer_text_id;

                                if ($model_other_answer->save()) {
                                    
                                } else {
//                                    print_r($model_other_answer->errors);
//                                    die();
                                }
                            }
                        }
                    } else if ($model->question_type == "HOT_SPOT_ANSWER") {

                        $uploadimages = isset($_FILES['uploadedFile']) ? $_FILES['uploadedFile'] : array();
                        $uploadImageName = isset($uploadimages['name']) ? $uploadimages['name'] : null;
                        $stringCoordinates = $_POST['vall'];

                        $extension = substr($uploadImageName, strrpos($uploadImageName, '.') + 1);
                        $extension = strtolower($extension);

                        if ($extension == "jpg" || $extension == "png") {

                            if ($stringCoordinates != NULL) {
                                //if $stringCoordinates value comes as [Object Element]55,56- 
                                if (strcmp($stringCoordinates[0], '[') == 0) {
                                    $str = substr($stringCoordinates, 23);
                                } else {
                                    $str = $stringCoordinates;
                                }
                            } else {
                                $str = null;
                            }

                            if ($uploadImageName != NULL) {

                                Yii::app()->user->setFlash('error', "attachment cannot be blank");

                                $model = new Hotspot;
                                $model->question_id = $question_id;
                                $model->image_name = $uploadImageName;
                                $model->coordinates = $str;
                                $uploadImageName = $uploadImageName;
                            }

                            if ($model->save()) {
                                $upload_dir = $this->getUploadDir($model->hotspot_id);

                                if (isset($_FILES['uploadedFile'])) {

                                    move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $upload_dir . $uploadImageName);
                                }

                                $user_id = Yii::app()->user->id;

                                $model_question_audit = new Audit;
                                $model_question_audit->user_id = $user_id;
                                $model_question_audit->action_id = $question_id;
                                $model_question_audit->action = 'SAVE';
                                $model_question_audit->action_name = "QUESTION_MANAGEMENT";
                                $model_question_audit->date = date("Y/m/d");
                                $model_question_audit->time = date("h:i:sa");
                                $model_question_audit->status = 1;

                                if ($model_question_audit->save()) {
                                    
                                } else {
                                    print_r($model_exam_audit->errors);
                                }

                                $this->redirect(array('viewHotspot', 'id' => $model->question_id));
                            }
                        } else {
                            echo 'Please upload an Image';
                            die;
                        }
                    } else if ($model->question_type == "ESSAY_ANSWER") {

                        $essayQuestion = new EssayQuestion;
                        $essayQuestion->question_id = $question_id;
                        $essayQuestionType = $_POST['essay_type'];

                        if ($essayQuestionType == 'NORMAL_TYPE') {
                            $essayQuestion->essay_type = "NORMAL";
                        } else if ($essayQuestionType == 'EMAIL_TYPE') {
                            $essayQuestion->essay_type = "EMAIL";
                        }

                        $essayQuestion->preseen_material = 0;


                        //reference tab titles
                        $essayQuestion->reference_material = 0;
//                        for ($i = 1; $i < 16; $i++) {
//                            if (isset($_POST["ref_tab_title_$i"])) {
//                                $tab_title_reference[$i] = $_POST["ref_tab_title_$i"];
//                                if ($tab_title_reference[$i] != "") {
//                                    $essayQuestion->reference_material = 1;
//                                }
//                            }
//                        }

                        if ($essayQuestion->save()) {
                            $essayQuestionId = $essayQuestion->getPrimaryKey();
                        } else {
                            print_r($essayQuestion->errors);
                            die();
                        }

                        //******essay question table data ends********


                        if ($essayQuestionType == 'EMAIL_TYPE') {
                            $emailFromField = $_POST['email_from'];
                            $emailToField = $_POST['email_to'];
                            $emailCcField = $_POST['email_cc'];
                            $emailSubjectField = $_POST['email_subject'];

                            $emailEssayHeader = new EmailEssayHeader;

                            $emailEssayHeader->essay_question_id = $essayQuestionId;
                            $emailEssayHeader->from_field = $emailFromField;
                            $emailEssayHeader->to_field = $emailToField;
                            $emailEssayHeader->cc_field = $emailCcField;
                            $emailEssayHeader->subject_field = $emailSubjectField;
                            $emailEssayHeader->question_id = $question_id;

                            if ($emailEssayHeader->save()) {
                                
                            } else {
                                print_r($emailEssayHeader->errors);
                                die;
                            }
                        }
                        //******email essay header table data ends********
                        //for reference tabs
//                        for ($i = 1; $i < 16; $i++) {
//                            if ($tab_title_reference[$i] != null) {
//                                if (isset($_POST["ref_answer$i"])) {
//                                    $checkbox1 = $_POST["ref_answer$i"];
//                                    if ($checkbox1 == "text_answer$i") {
//                                        $text1 = $_POST["ref_table_formula_$i"];
//                                        if ($text1 != null) {
//                                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
//
//                                            $questionReferenceMaterial_1->question_id = $question_id;
//                                            $questionReferenceMaterial_1->reference_material_text = $text1;
//                                            $questionReferenceMaterial_1->reference_file = null;
//                                            $questionReferenceMaterial_1->reference_tab_position = $i;
//
//                                            if ($questionReferenceMaterial_1->save()) {
//                                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
//                                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;
//
//                                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
//                                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
//                                                if ($model_question_reference_tab_title_1->save()) {
//                                                    
//                                                } else {
//                                                    print_r($model_question_reference_tab_title_1->getErrors());
//                                                    die();
//                                                }
//                                            } else {
//                                                print_r($questionReferenceMaterial_1->errors);
//                                                die;
//                                            }
//                                        }
//                                    } else if ($checkbox1 == "image_answer$i") {
//                                        $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
//
//                                        if ($uploadfile1['name'] != "") {
//                                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
//                                            $questionReferenceMaterial_1->question_id = $question_id;
//                                            $questionReferenceMaterial_1->reference_material_text = null;
//                                            $questionReferenceMaterial_1->reference_file = $uploadfile1['name'];
//                                            $questionReferenceMaterial_1->reference_tab_position = $i;
//
//                                            if ($questionReferenceMaterial_1->save()) {
//                                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
//                                                $upload_dir = $this->getUploadDirReferenceMaterial($question_id, $i);
//
//                                                if (isset($_FILES["ref_file$i"])) {
//                                                    move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
//                                                }
//
//                                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;
//
//                                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
//                                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
//                                                if ($model_question_reference_tab_title_1->save()) {
//                                                    
//                                                } else {
//                                                    print_r($model_question_reference_tab_title_1->getErrors());
//                                                    die();
//                                                }
//                                            } else {
//
//                                                print_r($questionReferenceMaterial_1->errors);
//                                                die;
//                                            }
//                                        }
//                                    }
//                                }
//                            }
//                        }
                    }


                    Yii::app()->session['multiple_choice_answer_session'] = array();
                    Yii::app()->session['short_written_question_part_session'] = array();
                    Yii::app()->session['drag_drop_typeb_session'] = array();

                    $user_id = Yii::app()->user->id;

                    $model_question_audit = new Audit;
                    $model_question_audit->user_id = $user_id;
                    $model_question_audit->action_id = $question_id;
                    $model_question_audit->action = 'SAVE';
                    $model_question_audit->action_name = "QUESTION_MANAGEMENT";
                    $model_question_audit->date = date("Y/m/d");
                    $model_question_audit->time = date("h:i:sa");
                    $model_question_audit->status = 1;

                    if ($model_question_audit->save()) {
                        
                    } else {
                        print_r($model_exam_audit->errors);
                    }


                    $this->redirect(array('view', 'id' => $model->question_id));
                }
            } catch (Exception $e) {
                echo 'exception';
                print_r($e);
                //$dbtransaction->rollback();
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    //to get the reference material directory
    protected function getUploadDirReferenceMaterial($questionid, $tabposisiton) {
        $dir1 = Yii::getPathOfAlias('webroot') . '/images/reference_material/' . $questionid . '/';

        if (!is_dir($dir1)) {
            mkdir($dir1);
        }

        $dir2 = $dir1 . $tabposisiton . '/';

        if (!is_dir($dir2)) {
            mkdir($dir2);
        }

        return $dir2;
    }

    //to get the hotspot image directory
    protected function getUploadDir($hotspotid) {
        $dir = Yii::getPathOfAlias('webroot') . '/images/hotspot_answer_images/' . $hotspotid . '/';
        if (!is_dir($dir)) {
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

        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Question'])) {
            $model->attributes = $_POST['Question'];
            $exhibit_name = "";

            if ($model->question_type != "ESSAY_ANSWER") {
                if (CUploadedFile::getInstance($model, 'exhibit_attachment') != null) {
                    $model->exhibit_attachment = CUploadedFile::getInstance($model, 'exhibit_attachment');
                    $exhibit_name = $model->exhibit_attachment->getName();
                } else {
                    $uploadedExhibit = Question::model()->getQuestionExhibit($model->question_id);
                    $model->exhibit_attachment = $uploadedExhibit;
                }
            }

            if ($model->save()) {
                $question_id = $model->getPrimaryKey();
                if ($exhibit_name != "") {
                    $upload_dir = $this->getUploadDirExhibit($question_id);
                    $model->exhibit_attachment->saveAs($upload_dir . $exhibit_name);
                }

                if ($model->question_type == "SHORT_WRITTEN") {

                    $heading_1 = $_POST['heading_1'];
                    $heading_2 = $_POST['heading_2'];


                    if ($heading_1 != null) {

                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 1';

                        $model_heading_1 = Heading::model()->find($criteria);

//                        Heading::model()->deleteByPk($model_heading_1->heading_id);
//                        $model_heading_1->question_id = $question_id;

                        if ($model_heading_1 == null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->question_id = $id;
                            $model_heading_1->heading_position = 1;
                        } else {
                            $model_heading_1->heading_text = $heading_1;
                        }

//                        $model_heading_1->heading_position = 1;

                        if ($model_heading_1->save()) {
//                            echo 'saved';die();
                        } else {
                            print_r($model_heading_1->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('heading_id')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 1))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }

                    if ($heading_2 != null) {


                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 2';

                        $model_heading_2 = Heading::model()->find($criteria);

//                        Heading::model()->deleteByPk($model_heading_1->heading_id);
//                        $model_heading_1->question_id = $question_id;

                        if ($model_heading_2 == null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->question_id = $id;
                            $model_heading_2->heading_position = 2;
                        } else {
                            $model_heading_2->heading_text = $heading_2;
                        }


//                        $model_heading_2->heading_position = 2;

                        if ($model_heading_2->save()) {
//                             echo 'saved2';die();
                        } else {
                            print_r($model_heading_2->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('heading_id')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 2))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }
//
//                    if ($heading_2 != null) {
//                        $model_heading_2 = new Heading;
//                        $model_heading_2->question_id = $question_id;
//                        $model_heading_2->heading_text = $heading_2;
//                        $model_heading_2->heading_position = 2;
//
//                        if ($model_heading_2->save()) {
//                            
//                        } else {
//                            print_r($model_heading_2->errors);
//                            die();
//                        }
//                    }

                    $shortWrittenQuestionPartSession = Yii::app()->session['short_written_question_part_session'];

                    if (!empty($shortWrittenQuestionPartSession)) {


                        $answers = Yii::app()->db->createCommand()
                                ->select('answer_id')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $answerTexts = Yii::app()->db->createCommand()
                                ->select('answer_text_id')
                                ->from('answer_text')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answerTexts as $answerText) {
                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                        }




                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('question_part_id')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

//                        foreach ($questionPartIds as $questionPartId) {
//                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
//                        }
                        $i = 0;
                        $size = count($questionPartIds);
                        foreach ($shortWrittenQuestionPartSession as $item) {
                            if ($i < $size) {
                                $model_question_part = QuestionPart::model()->findByPk($questionPartIds[$i]['question_part_id']);
                                $i++;
                            } else {
                                $model_question_part = new QuestionPart;
                            }
//                            try{
//                                
//                            }catch(Exception $ce){
//                                
//                            }



                            $model_question_part->question_id = $question_id;
                            $model_question_part->question_part_name = $item['question_part'];

                            if ($model_question_part->save()) {
                                
                            } else {
                                print_r($model_question_part->errors);
                                die();
                            }

                            $question_part_id = $model_question_part->getPrimaryKey();



                            $answer_text = $item['answer'];

                            $model_anser_text = new AnswerText;
                            $model_anser_text->answer_text = $answer_text;
                            $model_anser_text->question_id = $question_id;
                            $answer_text_id;

                            if ($model_anser_text->save()) {
                                $answer_text_id = $model_anser_text->getPrimaryKey();
                            } else {
                                print_r($model_anser_text->errors);
                                die();
                            }


                            $model_answer = new Answer;

                            $model_answer->question_id = $question_id;
                            $model_answer->question_part_id = $question_part_id;
                            $model_answer->answer_text_id = $answer_text_id;
                            $model_answer->is_correct = 1;

                            if ($model_answer->save()) {
                                
                            } else {
                                print_r($model_answer->errors);
                                die();
                            }
                        }
                        for ($x = $i; $x < $size; $x++) {
                            try {
                                QuestionPart::model()->deleteByPk($questionPartIds[$x]['question_part_id']);
                            } catch (Exception $ec) {
                                
                            }
                        }
                    } else {
//                        $answerTexts = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('answer')
//                                ->where('question_id=:question_id', array(':question_id' => $id))
//                                ->queryAll();
//
//                        foreach ($answerTexts as $answerText) {
//                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
//                        }
//
//                        $answers = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('answer')
//                                ->where('question_id=:question_id', array(':question_id' => $id))
//                                ->queryAll();
//
//                        foreach ($answers as $answer) {
//                            Answer::model()->deleteByPk($answer['answer_id']);
//                        }
//
//                        $questionPartIds = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('question_part')
//                                ->where('question_id=:question_id', array(':question_id' => $id))
//                                ->queryAll();
//
//                        foreach ($questionPartIds as $questionPartId) {
//                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
//                        }
                    }
                } else if ($model->question_type == "SINGLE_ANSWER") {
                    if (isset($_POST['text_answer_edit']) && isset($_POST['image_answer_edit'])) {
                        if (isset($_POST['text_answer_edit'])) {

                            if (isset($_POST['answer'])) {
                                foreach ($_POST['answer'] as $key => $value) {
                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('question_id=' . $question_id);
                                    $results = AnswerText::model()->findAll($criteria);

                                    foreach ($results as $single) {
                                        $answer_text_model = AnswerText::model()->findByPk($single->answer_text_id);
                                        $answer_text_model->answer_text = isset($_POST['answer'][$single->answer_text_id]) ? $_POST['answer'][$single->answer_text_id] : null;
                                        $answer_text_model->update();
                                    }

                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('question_id=' . $question_id);
                                    $answer_result_iscorrect = Answer::model()->findAll($criteria);

                                    $count = 0;

                                    foreach ($answer_result_iscorrect as $single_iscorrect) {
                                        if ($single_iscorrect->image_answer == null) {
                                            $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                            $answer_model->is_correct = isset($_POST['correct'][$count]) ? '1' : '0';
                                            $answer_model->update();
                                            $count++;
                                        }
                                    }
                                }

                                if (!empty($_POST['deleted_answer'])) {
                                    foreach ($_POST['deleted_answer'] as $deleted) {
                                        $answer_data = Answer::getAnswersforAnswerTextid($deleted);

                                        foreach ($answer_data as $answer_id) {
                                            Answer::model()->deleteByPk($answer_id->answer_id);
                                        }

                                        foreach ($answer_data as $answer_text_id) {
                                            AnswerText::model()->deleteByPk($answer_text_id->answer_text_id);
                                        }
                                    }
                                }
                            }

                            if (isset($_POST['newanswer'])) {
                                foreach ($_POST['newanswer'] as $key => $newanswer) {
                                    if ($newanswer != null) {

                                        $model_answer_text = new AnswerText;
                                        $model_answer_text->answer_text = $newanswer;
                                        $model_answer_text->question_id = $question_id;

                                        if ($model_answer_text->save()) {
                                            
                                        } else {
                                            print_r($model_answer_text->errors);
                                            die;
                                        }

                                        $model_answer = new Answer;
                                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                        $model_answer->question_id = $question_id;
                                        $model_answer->is_correct = isset($_POST['newcorrect'][$key]) ? '1' : '0';

                                        if ($model_answer->save()) {
                                            
                                        } else {
                                            print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        }

                        if (!empty($_POST['deleted_answer'])) {
                            foreach ($_POST['deleted_answer'] as $deleted) {
                                Answer::model()->deleteByPk($deleted);
                            }
                        }

                        if (isset($_POST['image_answer_edit'])) {
                            $criteria = new CDbCriteria;
                            $criteria->addCondition('question_id=' . $question_id);
                            $answer_result_iscorrect = Answer::model()->findAll($criteria);
                            //  $answer_result_iscorrect = Answer::model()->findImageanswers($question_id);                           
                            $countImg = 0;


                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($answer_result_iscorrect as $image_single_iscorrect) {
                                    if (!in_array($image_single_iscorrect->answer_text_id, $_POST['deleted_answer'])) {
                                        if ($image_single_iscorrect->image_answer != null) {
                                            $image_answer_model = Answer::model()->findByPk($image_single_iscorrect->answer_id);
                                            $image_answer_model->is_correct = isset($_POST['correctimg'][$image_single_iscorrect->answer_id]) ? '1' : '0';
                                            $image_answer_model->update();
                                        }
                                        $countImg++;
                                    }
                                }
                            } else {
                                foreach ($answer_result_iscorrect as $image_single_iscorrect) {
                                    // if (!in_array($image_single_iscorrect->answer_text_id, $_POST['deleted_answer'])) {
                                    if ($image_single_iscorrect->image_answer != null) {
                                        $image_answer_model = Answer::model()->findByPk($image_single_iscorrect->answer_id);
                                        $image_answer_model->is_correct = isset($_POST['correctimg'][$image_single_iscorrect->answer_id]) ? '1' : '0';
                                        $image_answer_model->update();
                                    }
                                    $countImg++;
                                    // }
                                }
                            }

                            if (isset($_FILES['newimageanswer'])) {

                                $images = CUploadedFile::getInstancesByName('newimageanswer');

                                if (isset($images) && count($images) > 0) {
                                    foreach ($images as $key => $pic) {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['imgcorrect'][$key]) ? '1' : '0';
                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/single_answer_images/' . $picname);

                                            //die();
                                        } else {
                                            print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                }
                            }
                        }
                    } else if (isset($_POST['text_answer_edit'])) { //text answer edit of single answer                    
                        if (isset($_POST['answer'])) {
                            foreach ($_POST['answer'] as $key => $value) {

                                $criteria = new CDbCriteria;
                                $criteria->addCondition('question_id=' . $question_id);
                                $results = AnswerText::model()->findAll($criteria);
                                foreach ($results as $single) {
                                    $answer_text_model = AnswerText::model()->findByPk($single->answer_text_id);
                                    $answer_text_model->answer_text = isset($_POST['answer'][$single->answer_text_id]) ? $_POST['answer'][$single->answer_text_id] : null;
                                    $answer_text_model->update();
                                }

                                $criteria = new CDbCriteria;
                                $criteria->addCondition('question_id=' . $question_id);
                                $answer_result_iscorrect = Answer::model()->findAll($criteria);

                                $count = 0;

                                foreach ($answer_result_iscorrect as $key => $single_iscorrect) {

                                    $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                    $answer_model->is_correct = isset($_POST['correct'][$key]) ? '1' : '0';
                                    $answer_model->update();
                                    $count++;
                                }
                            }

                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($_POST['deleted_answer'] as $deleted) {
                                    $answer_data = Answer::getAnswersforAnswerTextid($deleted);


                                    foreach ($answer_data as $answer_id) {
                                        Answer::model()->deleteByPk($answer_id->answer_id);
                                        AnswerText::model()->deleteByPk($answer_id->answer_text_id);
                                    }

//                                        foreach ($answer_data as $answer_text_id) {
//                                            AnswerText::model()->deleteByPk($answer_text_id->answer_text_id);
//                                        }
                                }
                            }
                        }

                        if (isset($_POST['newanswer'])) {
                            foreach ($_POST['newanswer'] as $key => $newanswer) {
                                if ($newanswer != null) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $newanswer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['newcorrect'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        }
                    } // end text answer edit of single answer
                    else if (isset($_POST['image_answer_edit'])) {

                        $criteria = new CDbCriteria;
                        $criteria->addCondition('question_id=' . $question_id);
                        $answer_result_iscorrect = Answer::model()->findAll($criteria);

                        $count = 0;
                        foreach ($answer_result_iscorrect as $single_iscorrect) {
                            $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                            $answer_model->is_correct = isset($_POST['correctimg'][$single_iscorrect->answer_id]) ? '1' : '0';

                            $answer_model->update();
                            $count++;
                        }



                        if (isset($_FILES['newimageanswer'])) {
                            $images = CUploadedFile::getInstancesByName('newimageanswer');

                            if (isset($images) && count($images) > 0) {
                                foreach ($images as $key => $pic) {
                                    $model_answer = new Answer;
                                    $picname = uniqid() . $pic->name;

                                    $model_answer->question_id = $question_id;
                                    $model_answer->image_answer = $picname;
                                    $model_answer->is_correct = isset($_POST['imgcorrect'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/single_answer_images/' . $picname);
                                    } else {
                                        print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        }
                        if (isset($_POST['imageanswer'])) {
                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($_POST['deleted_answer'] as $deleted) {
                                    Answer::model()->deleteByPk($deleted);
                                }
                            }
                        }
                    }

                    // } //end image answer edit of single answer
                } else if ($model->question_type == "MULTIPLE_ANSWER") {
                    if (isset($_POST['text_answer_edit']) && isset($_POST['image_answer_edit'])) {
                        if (isset($_POST['text_answer_edit'])) {
                            if (isset($_POST['answer'])) {

                                foreach ($_POST['answer'] as $key => $value) {

                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('question_id=' . $question_id);
                                    $results = AnswerText::model()->findAll($criteria);


                                    foreach ($results as $single) {

                                        $answer_text_model = AnswerText::model()->findByPk($single->answer_text_id);
                                        $answer_text_model->answer_text = isset($_POST['answer'][$single->answer_text_id]) ? $_POST['answer'][$single->answer_text_id] : null;
                                        $answer_text_model->update();
                                    }


                                    $criteria = new CDbCriteria;
                                    $criteria->addCondition('question_id=' . $question_id);
                                    $answer_result_iscorrect = Answer::model()->findAll($criteria);

                                    $count = 0;

                                    foreach ($answer_result_iscorrect as $single_iscorrect) {

                                        $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                        $answer_model->is_correct = isset($_POST['correct'][$count]) ? '1' : '0';

                                        $answer_model->update();

                                        $count++;
                                    }
                                }

                                if (!empty($_POST['deleted_answer'])) {
                                    foreach ($_POST['deleted_answer'] as $deleted) {

                                        $answer_data = Answer::getAnswersforAnswerTextid($deleted);

                                        foreach ($answer_data as $answer_id) {
                                            Answer::model()->deleteByPk($answer_id->answer_id);
                                        }

                                        foreach ($answer_data as $answer_text_id) {
                                            AnswerText::model()->deleteByPk($answer_text_id->answer_text_id);
                                        }
                                    }
                                }
                            }

                            if (isset($_POST['newanswer'])) {

                                foreach ($_POST['newanswer'] as $key => $newanswer) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $newanswer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['newcorrect'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        }

                        if (isset($_POST['imageanswer'])) {
                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($_POST['deleted_answer'] as $deleted) {
                                    Answer::model()->deleteByPk($deleted);
                                }
                            }
                        }


                        if (isset($_POST['image_answer_edit'])) {

                            // if (isset($_POST['correctimg'])) {

                            $criteria = new CDbCriteria;
                            $criteria->addCondition('question_id=' . $question_id);
                            $answer_result_iscorrect = Answer::model()->findAll($criteria);

                            $countImg = 0;


                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($answer_result_iscorrect as $single_iscorrect) {
                                    if (!in_array($single_iscorrect->answer_text_id, $_POST['deleted_answer'])) {
                                        if ($single_iscorrect->image_answer != null) {
                                            $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                            $answer_model->is_correct = isset($_POST['correctimg'][$single_iscorrect->answer_id]) ? '1' : '0';
                                            $answer_model->update();
                                        }
                                        $countImg++;
                                    }
                                }
                            } else {
                                foreach ($answer_result_iscorrect as $single_iscorrect) {

                                    if ($single_iscorrect->image_answer != null) {
                                        $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                        $answer_model->is_correct = isset($_POST['correctimg'][$single_iscorrect->answer_id]) ? '1' : '0';
                                        $answer_model->update();
                                    }
                                    $countImg++;
                                }
                            }


                            // }




                            if (isset($_FILES['newimageanswer'])) {
                                $images = CUploadedFile::getInstancesByName('newimageanswer');

                                if (isset($images) && count($images) > 0) {

                                    //  if (isset($_POST['imgcorrect'])) {

                                    foreach ($images as $key => $pic) {
                                        $model_answer = new Answer;
                                        $picname = uniqid() . $pic->name;

                                        $model_answer->question_id = $question_id;
                                        $model_answer->image_answer = $picname;
                                        $model_answer->is_correct = isset($_POST['imgcorrect'][$key]) ? '1' : '0';

                                        if ($model_answer->save()) {
                                            $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/multiple-answer-images/' . $picname);
                                        } else {
                                            print_r($model_answer->errors);
                                            die;
                                        }
                                    }
                                    //  }
                                }
                            }
                        }
                    } else if (isset($_POST['text_answer_edit'])) { //text answer edit of single answer
                        if (isset($_POST['answer'])) {

                            foreach ($_POST['answer'] as $key => $value) {

                                $criteria = new CDbCriteria;
                                $criteria->addCondition('question_id=' . $question_id);
                                $results = AnswerText::model()->findAll($criteria);


                                foreach ($results as $single) {

                                    $answer_text_model = AnswerText::model()->findByPk($single->answer_text_id);
                                    $answer_text_model->answer_text = isset($_POST['answer'][$single->answer_text_id]) ? $_POST['answer'][$single->answer_text_id] : null;
                                    $answer_text_model->update();
                                }

                                $criteria = new CDbCriteria;
                                $criteria->addCondition('question_id=' . $question_id);
                                $answer_result_iscorrect = Answer::model()->findAll($criteria);

                                $count = 0;

                                foreach ($answer_result_iscorrect as $single_iscorrect) {
                                    if ($single_iscorrect->image_answer == null) {
                                        $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                                        $answer_model->is_correct = isset($_POST['correct'][$count]) ? '1' : '0';
                                        $answer_model->update();
                                        $count++;
                                    }
                                }
                            }

                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($_POST['deleted_answer'] as $deleted) {
                                    $answer_data = Answer::getAnswersforAnswerTextid($deleted);

                                    foreach ($answer_data as $answer_id) {
                                        Answer::model()->deleteByPk($answer_id->answer_id);
                                    }

                                    foreach ($answer_data as $answer_text_id) {
                                        AnswerText::model()->deleteByPk($answer_text_id->answer_text_id);
                                    }
                                }
                            }
                        }

                        if (isset($_POST['newanswer'])) {
                            foreach ($_POST['newanswer'] as $key => $newanswer) {
                                if ($newanswer != null) {
                                    $model_answer_text = new AnswerText;
                                    $model_answer_text->answer_text = $newanswer;
                                    $model_answer_text->question_id = $question_id;

                                    if ($model_answer_text->save()) {
                                        
                                    } else {
                                        print_r($model_answer_text->errors);
                                        die;
                                    }

                                    $model_answer = new Answer;
                                    $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                    $model_answer->question_id = $question_id;
                                    $model_answer->is_correct = isset($_POST['newcorrect'][$key]) ? '1' : '0';

                                    if ($model_answer->save()) {
                                        
                                    } else {
                                        print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        }
                    } // end text answer edit of single answer
                    else if (isset($_POST['image_answer_edit'])) {

                        $criteria = new CDbCriteria;
                        $criteria->addCondition('question_id=' . $question_id);
                        $answer_result_iscorrect = Answer::model()->findAll($criteria);

                        $count = 0;
                        foreach ($answer_result_iscorrect as $single_iscorrect) {
                            $answer_model = Answer::model()->findByPk($single_iscorrect->answer_id);
                            $answer_model->is_correct = isset($_POST['correctimg'][$single_iscorrect->answer_id]) ? '1' : '0';

                            $answer_model->update();
                            $count++;
                        }

                        if (isset($_FILES['newimageanswer'])) {

                            $images = CUploadedFile::getInstancesByName('newimageanswer');

                            if (isset($images) && count($images) > 0) {
                                foreach ($images as $key => $pic) {
                                    $model_answer = new Answer;
                                    $picname = uniqid() . $pic->name;

                                    $model_answer->question_id = $question_id;
                                    $model_answer->image_answer = $picname;
                                    $model_answer->is_correct = isset($_POST['imgcorrect'][$key]) ? '1' : '0';
                                    //print_r($model_answer->is_correct); die;
                                    if ($model_answer->save()) {
                                        $pic->saveAs(Yii::getPathOfAlias('webroot') . '/images/multiple-answer-images/' . $picname);

                                        //die();
                                    } else {
                                        print_r($model_answer->errors);
                                        die;
                                    }
                                }
                            }
                        }
                        if (isset($_POST['imageanswer'])) {
                            if (!empty($_POST['deleted_answer'])) {
                                foreach ($_POST['deleted_answer'] as $deleted) {
                                    Answer::model()->deleteByPk($deleted);
                                }
                            }
                        }
                    }
                } else if ($model->question_type == "DRAG_DROP_TYPEA_ANSWER") {

                    $dragDropTypeAQuestionPartSession = Yii::app()->session['drag_drop_typea_session'];

                    if (!empty($dragDropTypeAQuestionPartSession)) {

                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

//                        print_r($answers);

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $answerTexts = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer_text')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answerTexts as $answerText) {
                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                        }

                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {
                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }



                        foreach ($dragDropTypeAQuestionPartSession as $item) {
                            $model_question_part = new QuestionPart;

                            $model_question_part->question_id = $question_id;
                            $model_question_part->question_part_name = $item['question_part'];

                            if ($model_question_part->save()) {
                                
                            } else {
                                print_r($model_question_part->errors);
                                die();
                            }

                            $question_part_id = $model_question_part->getPrimaryKey();

                            $answer_text = $item['answer'];

                            $model_anser_text = new AnswerText;
                            $model_anser_text->answer_text = $answer_text;
                            $model_anser_text->question_id = $question_id;
                            $answer_text_id;

                            if ($model_anser_text->save()) {
                                $answer_text_id = $model_anser_text->getPrimaryKey();
                            } else {
                                print_r($model_anser_text->errors);
                                die();
                            }


                            $model_answer = new Answer;

                            $model_answer->question_id = $question_id;
                            $model_answer->question_part_id = $question_part_id;
                            $model_answer->answer_text_id = $answer_text_id;
                            $model_answer->is_correct = 1;

                            if ($model_answer->save()) {
                                
                            } else {
                                print_r($model_answer->errors);
                                die();
                            }
                        }
                    } else {
                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {
                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }
                    }
                }


                // ---------- start edit DRAG_DROP_TYPEB_ANSWER ------------------
                else if ($model->question_type == "DRAG_DROP_TYPEB_ANSWER") {



                    $drag_drop_typeB_session = Yii::app()->session['drag_drop_typeb_session'];
//                    if(isset($_POST['heading_1'])){
//                        $heading_1 = $_POST['heading_1'];
//                    }else{
//                        $heading_1 = null;
//                    }
//                    
//                    if(isset($_POST['heading_2'])){
//                        $heading_2 = $_POST['heading_2'];
//                    }else{
//                        $heading_2 = null;
//                    }
//                    
//                    
//
//                    if ($heading_1 != null) {
//
//
//                        $criteria = new CDbCriteria;
//                        $criteria->condition = "question_id= " . $question_id;
//                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 1';
//
//                        $model_heading_1 = Heading::model()->find($criteria);
//
////                        Heading::model()->deleteByPk($model_heading_1->heading_id);
////                        $model_heading_1->question_id = $question_id;
//
//                        if ($model_heading_1 == null) {
//                            $model_heading_1 = new Heading;
//                            $model_heading_1->heading_text = $heading_1;
//                            $model_heading_1->question_id = $id;
//                            $model_heading_1->heading_position = 1;
//                        } else {
//                            $model_heading_1->heading_text = $heading_1;
//                        }
//
////                        $model_heading_1->heading_position = 1;
//
//                        if ($model_heading_1->save()) {
////                            echo 'saved';die();
//                        } else {
//                            print_r($model_heading_1->errors);
//                            die();
//                        }
//                    } else {
//                        $headings = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('heading')
//                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 1))
//                                ->queryAll();
//
//                        foreach ($headings as $heading) {
//                            Heading::model()->deleteByPk($heading['heading_id']);
//                        }
//                    }
//
//                    if ($heading_2 != null) {
//
//
//                        $criteria = new CDbCriteria;
//                        $criteria->condition = "question_id= " . $question_id;
//                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 2';
//
//                        $model_heading_2 = Heading::model()->find($criteria);
//
////                        Heading::model()->deleteByPk($model_heading_1->heading_id);
////                        $model_heading_1->question_id = $question_id;
//
//                        if ($model_heading_2 == null) {
//                            $model_heading_2 = new Heading;
//                            $model_heading_2->heading_text = $heading_2;
//                            $model_heading_2->question_id = $id;
//                            $model_heading_2->heading_position = 2;
//                        } else {
//                            $model_heading_2->heading_text = $heading_2;
//                        }
//
//
////                        $model_heading_2->heading_position = 2;
//
//                        if ($model_heading_2->save()) {
////                             echo 'saved2';die();
//                        } else {
//                            print_r($model_heading_2->errors);
//                            die();
//                        }
//                    } else {
//                        $headings = Yii::app()->db->createCommand()
//                                ->select('*')
//                                ->from('heading')
//                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 2))
//                                ->queryAll();
//
//                        foreach ($headings as $heading) {
//                            Heading::model()->deleteByPk($heading['heading_id']);
//                        }
//                    }
//                    
//                    
                    if (!empty($drag_drop_typeB_session)) {
                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $answerTexts = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer_text')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        //var_dump($answerTexts);die;

                        foreach ($answerTexts as $answerText) {
                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                        }

                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {
                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }


                        //   var_dump($drag_drop_typeB_session);die;

                        foreach ($drag_drop_typeB_session as $drag_drop_B) {
                            $question_part_model = new QuestionPart;

                            $question_part_model->question_id = $question_id;
                            $question_part_model->question_part_name = $drag_drop_B['question_part'];

                            if ($question_part_model->save()) {
                                
                            } else {
                                print_r($question_part_model->errors);
                                die();
                            }

                            $question_part_id = $question_part_model->getPrimaryKey();

                            if (isset($drag_drop_B['answer1'])) {
                                $model_answer_text = new AnswerText;
                                $model_answer_text->answer_text = $drag_drop_B['answer1'];
                                $model_answer_text->question_id = $question_id;

                                if ($model_answer_text->save()) {
                                    
                                } else {
                                    print_r($model_answer_text->errors);
                                    die();
                                }

                                $model_answer = new Answer;
                                $model_answer->question_id = $question_id;
                                $model_answer->question_part_id = $question_part_id;
                                $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                $model_answer->is_correct = 1;

                                if ($model_answer->save()) {
                                    
                                } else {
                                    print_r($model_answer->errors);
                                    die();
                                }
                            }
                            if (isset($drag_drop_B['answer2'])) {
                                $model_answer_text = new AnswerText;
                                $model_answer_text->answer_text = $drag_drop_B['answer2'];
                                $model_answer_text->question_id = $question_id;

                                if ($model_answer_text->save()) {
                                    
                                } else {
                                    print_r($model_answer_text->errors);
                                    die();
                                }


                                $model_answer = new Answer;
                                $model_answer->question_id = $question_id;
                                $model_answer->question_part_id = $question_part_id;
                                $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
                                $model_answer->is_correct = 1;
                            }

                            if ($model_answer->save()) {
                                
                            } else {
                                print_r($model_answer->errors);
                                die();
                            }

                            $heading_results = Yii::app()->db->createCommand()
                                    ->select('heading_id')
                                    ->from('heading')
                                    ->where('question_id=:question_id AND heading_position = 1', array(':question_id' => $id))
                                    ->queryAll();

                            //var_dump($_POST['heading_2']);die;
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id.'AND heading_position = 1');
//                            $heading_results = Heading::model()->findAll($criteria);
                            if ($heading_results != null) {

                                $heading = Heading::model()->findByPk($heading_results[0]['heading_id']);
                                $heading->heading_text = isset($_POST['heading_1']) ? $_POST['heading_1'] : null;
                                $heading->update();
                            } else {
                                if (isset($_POST['heading_1']) && $_POST['heading_1'] != null) {
                                    $model_heading_1 = new Heading;
                                    $model_heading_1->heading_text = isset($_POST['heading_1']) ? $_POST['heading_1'] : null;
                                    $model_heading_1->question_id = $id;
                                    $model_heading_1->heading_position = 1;
                                    if ($model_heading_1->save()) {
                                        
                                    } else {
                                        print_r($model_heading_1->errors);
                                        die();
                                    }
                                }
                            }
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id.'AND heading_position = 2');
//                            $heading_results = Heading::model()->findAll($criteria);
                            $heading_results2 = Yii::app()->db->createCommand()
                                    ->select('heading_id')
                                    ->from('heading')
                                    ->where('question_id=:question_id AND heading_position = 2', array(':question_id' => $id))
                                    ->queryAll();

                            if ($heading_results2 != null) {

                                $heading = Heading::model()->findByPk($heading_results2[0]['heading_id']);
                                $heading->heading_text = isset($_POST['heading_2']) ? $_POST['heading_2'] : null;
                                $heading->update();
                            } else {
                                if (isset($_POST['heading_2']) && $_POST['heading_2'] != null) {
                                    $model_heading_2 = new Heading;
                                    $model_heading_2->heading_text = isset($_POST['heading_2']) ? $_POST['heading_2'] : null;
                                    $model_heading_2->question_id = $id;
                                    $model_heading_2->heading_position = 2;
                                    if ($model_heading_2->save()) {
                                        
                                    } else {
                                        print_r($model_heading_2->errors);
                                        die();
                                    }
                                }
                            }
                        }
                    } else {
                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {
                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }
                    }


//
//                    var_dump($drag_drop_typeB_session);
//                    die;
//                    foreach ($_POST['answer'] as $key => $value) {
//                        if ($key != 'null') {
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $answer_results = AnswerText::model()->findAll($criteria);
//
//                            foreach ($answer_results as $drag_drop_b) {
//                                $answer_text_model = AnswerText::model()->findByPk($drag_drop_b->answer_text_id);
//                                $answer_text_model->answer_text = isset($_POST['answer'][$drag_drop_b->answer_text_id]) ? $_POST['answer'][$drag_drop_b->answer_text_id] : null;
//                                $answer_text_model->update();
//                            }
//
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $question_part_results = QuestionPart::model()->findAll($criteria);
//
//                            foreach ($question_part_results as $ques_part) {
//                                $question_part_model = QuestionPart::model()->findByPk($ques_part->question_part_id);
//                                $question_part_model->question_part_name = isset($_POST['question_part'][$ques_part->question_part_id]) ? $_POST['question_part'][$ques_part->question_part_id] : null;
//                                $question_part_model->update();
//                            }
//
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $heading_results = Heading::model()->findAll($criteria);
//
//                            foreach ($heading_results as $heading) {
//                                $heading = Heading::model()->findByPk($heading->heading_id);
//                                $heading->heading_text = isset($_POST['heading'][$heading->heading_id]) ? $_POST['heading'][$heading->heading_id] : null;
//                                $heading->update();
//                            }
//                        }
//                    }
//                    $drag_drop_typeB_session = Yii::app()->session['drag_drop_typeb_session'];
//
//                    if (!empty($drag_drop_typeB_session)) {
//                        foreach ($drag_drop_typeB_session as $drag_drop_B) {
//                            $question_part_model = new QuestionPart;
//
//                            $question_part_model->question_id = $question_id;
//                            $question_part_model->question_part_name = $drag_drop_B['question_part'];
//
//                            if ($question_part_model->save()) {
//                                
//                            } else {
//                                print_r($question_part_model->errors);
//                                die();
//                            }
//
//                            $question_part_id = $question_part_model->getPrimaryKey();
//
//                            if (isset($drag_drop_B['answer1'])) {
//                                $model_answer_text = new AnswerText;
//                                $model_answer_text->answer_text = $drag_drop_B['answer1'];
//                                $model_answer_text->question_id = $question_id;
//
//                                if ($model_answer_text->save()) {
//                                    
//                                } else {
//                                    print_r($model_answer_text->errors);
//                                    die();
//                                }
//
//                                $model_answer = new Answer;
//                                $model_answer->question_id = $question_id;
//                                $model_answer->question_part_id = $question_part_id;
//                                $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
//                                $model_answer->is_correct = 1;
//
//                                if ($model_answer->save()) {
//                                    
//                                } else {
//                                    print_r($model_answer->errors);
//                                    die();
//                                }
//                            }
//                            if (isset($drag_drop_B['answer2'])) {
//                                $model_answer_text = new AnswerText;
//                                $model_answer_text->answer_text = $drag_drop_B['answer2'];
//                                $model_answer_text->question_id = $question_id;
//
//                                if ($model_answer_text->save()) {
//                                    
//                                } else {
//                                    print_r($model_answer_text->errors);
//                                    die();
//                                }
//
//
//                                $model_answer = new Answer;
//                                $model_answer->question_id = $question_id;
//                                $model_answer->question_part_id = $question_part_id;
//                                $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
//                                $model_answer->is_correct = 1;
//                            }
//
//                            if ($model_answer->save()) {
//                                
//                            } else {
//                                print_r($model_answer->errors);
//                                die();
//                            }
//                        }
//                    }
//
//
//                    foreach ($_POST['answer'] as $key => $value) {
//                        if ($key != 'null') {
//                            $drag_drop_typeB_session = Yii::app()->session['drag_drop_typeb_session'];
//
//                            if (!empty($drag_drop_typeB_session)) {
//                                foreach ($drag_drop_typeB_session as $drag_drop_B) {
//                                    $question_part_model = new QuestionPart;
//
//                                    $question_part_model->question_id = $question_id;
//                                    $question_part_model->question_part_name = $drag_drop_B['question_part'];
//
//                                    if ($question_part_model->save()) {
//                                        
//                                    } else {
//                                        print_r($question_part_model->errors);
//                                        die();
//                                    }
//
//                                    $question_part_id = $question_part_model->getPrimaryKey();
//
//                                    if (isset($drag_drop_B['answer1'])) {
//                                        $model_answer_text = new AnswerText;
//                                        $model_answer_text->answer_text = $drag_drop_B['answer1'];
//                                        $model_answer_text->question_id = $question_id;
//
//                                        if ($model_answer_text->save()) {
//                                            
//                                        } else {
//                                            print_r($model_answer_text->errors);
//                                            die();
//                                        }
//
//                                        $model_answer = new Answer;
//                                        $model_answer->question_id = $question_id;
//                                        $model_answer->question_part_id = $question_part_id;
//                                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
//                                        $model_answer->is_correct = 1;
//
//                                        if ($model_answer->save()) {
//                                            
//                                        } else {
//                                            print_r($model_answer->errors);
//                                            die();
//                                        }
//                                    }
//                                    if (isset($drag_drop_B['answer2'])) {
//                                        $model_answer_text = new AnswerText;
//                                        $model_answer_text->answer_text = $drag_drop_B['answer2'];
//                                        $model_answer_text->question_id = $question_id;
//
//                                        if ($model_answer_text->save()) {
//                                            
//                                        } else {
//                                            print_r($model_answer_text->errors);
//                                            die();
//                                        }
//
//
//                                        $model_answer = new Answer;
//                                        $model_answer->question_id = $question_id;
//                                        $model_answer->question_part_id = $question_part_id;
//                                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();
//                                        $model_answer->is_correct = 1;
//                                    }
//
//                                    if ($model_answer->save()) {
//                                        
//                                    } else {
//                                        print_r($model_answer->errors);
//                                        die();
//                                    }
//                                }
//                            }
//                        } elseif (!empty($_POST['deleted_answer']) && isset($_POST['deleted_answer'])) {
//                            foreach ($_POST['deleted_answer'] as $deleted) {
//
//                                $answer_text_id = Answer::getAnswersforQuestionPartid($deleted);
//
//                                foreach ($answer_text_id as $answer_id) {
//                                    Answer::model()->deleteByPk($answer_id->answer_id);
//                                }
//
//                                foreach ($answer_text_id as $answer_text) {
//                                    AnswerText::model()->deleteByPk($answer_text->answer_text_id);
//                                }
//
//                                QuestionPart::model()->deleteByPk($deleted);
//                            }
//                        } else {
//
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $answer_results = AnswerText::model()->findAll($criteria);
//
//                            foreach ($answer_results as $drag_drop_b) {
//                                $answer_text_model = AnswerText::model()->findByPk($drag_drop_b->answer_text_id);
//                                $answer_text_model->answer_text = isset($_POST['answer'][$drag_drop_b->answer_text_id]) ? $_POST['answer'][$drag_drop_b->answer_text_id] : null;
//                                $answer_text_model->update();
//                            }
//
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $question_part_results = QuestionPart::model()->findAll($criteria);
//
//                            foreach ($question_part_results as $ques_part) {
//                                $question_part_model = QuestionPart::model()->findByPk($ques_part->question_part_id);
//                                $question_part_model->question_part_name = isset($_POST['question_part'][$ques_part->question_part_id]) ? $_POST['question_part'][$ques_part->question_part_id] : null;
//                                $question_part_model->update();
//                            }
//
//                            $criteria = new CDbCriteria;
//                            $criteria->addCondition('question_id=' . $question_id);
//                            $heading_results = Heading::model()->findAll($criteria);
//
//                            foreach ($heading_results as $heading) {
//                                $heading = Heading::model()->findByPk($heading->heading_id);
//                                $heading->heading_text = isset($_POST['heading'][$heading->heading_id]) ? $_POST['heading'][$heading->heading_id] : null;
//                                $heading->update();
//                            }
//                        }
//                    }
                }
                // ---------- end edit DRAG_DROP_TYPEB_ANSWER ------------------
                // ---------- start edit DRAG_DROP_TYPEC_ANSWER ------------------
                else if ($model->question_type == "DRAG_DROP_TYPEC_ANSWER") {
//                    echo "<pre>";
//                    print_r($_POST);
//                    die();

                    $saved_answers_ids = array();
                    $tc_question_id = $model->question_id;
                    $tc_max_no_of_answers = $_POST['max_no_of_answers'];
                    $tc_max_no_of_question_parts = $_POST['max_no_of_question_parts'];
                    $existing_answers_data = Answer::model()->getAnwersForQuestion($question_id);
                    $existing_question_parts_data = QuestionPart::model()->getQuestionPartsOfQuestion($tc_question_id);
                    $existing_answer_text_data = AnswerText::model()->getAnswerTextForQuestion($tc_question_id);

                    //save all new answer
                    for ($i = 1; $i <= $tc_max_no_of_answers; $i++) {
                        $answer_tb_name = 'answer_' . $i;
                        if (isset($_POST[$answer_tb_name]) && $_POST[$answer_tb_name] != "") {
                            $tc_answer_text_model = new AnswerText;
                            $tc_answer_text_model->answer_text = $_POST[$answer_tb_name];
                            $tc_answer_text_model->question_id = $tc_question_id;
                            $tc_answer_text_model->save();

                            $saved_answers_ids[$answer_tb_name] = $tc_answer_text_model->getPrimaryKey();
                        }
                    }

                    //update all existing answer
                    foreach ($existing_answer_text_data as $existing_answer_text) {
                        $e_a_tb_name = 'existanswer_' . $existing_answer_text->answer_text_id;
                        if (isset($_POST[$e_a_tb_name])) {
                            $tc_model_answer_text = AnswerText::model()->getAnswerText($existing_answer_text->answer_text_id);
                            $tc_model_answer_text->answer_text = $_POST[$e_a_tb_name];
                            $tc_model_answer_text->update();
                            $saved_answers_ids[$e_a_tb_name] = $existing_answer_text->answer_text_id;
                        }
                    }

                    //save all new question parts
                    for ($i = 1; $i <= $tc_max_no_of_answers; $i++) {
                        $question_tb_name = 'question_' . $i;
                        $selectanswer_name = 'selectanswer_' . $i;
                        if (isset($_POST[$question_tb_name]) && $_POST[$question_tb_name] != "") {                                                           //save question part
                            $tc_model_question_part = new QuestionPart;
                            $tc_model_question_part->question_part_name = $_POST[$question_tb_name];
                            $tc_model_question_part->question_id = $tc_question_id;
                            if ($tc_model_question_part->save()) {
                                $tc_question_part_id = $tc_model_question_part->question_part_id;
                                $tc_model_answer = new Answer;
                                $tc_model_answer->question_id = $tc_question_id;
                                $tc_model_answer->question_part_id = $tc_question_part_id;
                                $tc_model_answer->is_correct = 1;
                                $tc_model_answer->answer_text_id = $saved_answers_ids[$_POST[$selectanswer_name]];
                                $tc_model_answer->save();
                            }
                        }
                    }

                    //update existing question parts
                    foreach ($existing_question_parts_data as $existing_question_part) {
                        $question_part_id = $existing_question_part['question_part_id'];
                        $exsist_answer_data = Answer::model()->getAnswerForQuestionPart($question_part_id);
                        $tc_exsistquestion_tb_name = 'exsistquestion_' . $question_part_id;
                        if (isset($_POST['exsistselectanswer_' . $question_part_id])) {
                            $tc_new_answer_tb_name = $_POST['exsistselectanswer_' . $question_part_id];

                            if ($exsist_answer_data->answerText->answer_text_id != $saved_answers_ids[$tc_new_answer_tb_name]) {
                                $exsist_answer_data->answer_text_id = $saved_answers_ids[$tc_new_answer_tb_name];
                                $exsist_answer_data->update();
                            }
                        }
                    }

                    //update existing question part text
                    foreach ($existing_question_parts_data as $existing_question_part) {
                        $question_part_id = $existing_question_part['question_part_id'];
                        $tc_exsistquestion_tb_name = 'exsistquestion_' . $question_part_id;
                        if (isset($_POST[$tc_exsistquestion_tb_name])) {
                            $question_part_model = QuestionPart::model()->findByPk($question_part_id);
                            $question_part_model->question_part_name = $_POST[$tc_exsistquestion_tb_name];
                            $question_part_model->update();
                        }
                    }

                    //delete existing removed question parts
                    $deleted_question_parts_string = $_POST['deleted_question_parts'];
                    $deleted_question_parts = explode(",", $deleted_question_parts_string);
                    foreach ($deleted_question_parts as $deleted_question_part_id) {
                        if ($deleted_question_part_id != "") {
                            Answer::model()->deleteAnswerByQuestionPartID($deleted_question_part_id);
                            QuestionPart::model()->deleteQuestionPart($deleted_question_part_id);
                        }
                    }

                    //delete existing removed answer
                    $deleted_existing_answers_string = $_POST['deleted_existing_answers'];
                    $deleted_existing_answers = explode(",", $deleted_existing_answers_string);
                    foreach ($deleted_existing_answers as $deleted_answer_id) {
                        if ($deleted_answer_id != "") {
                            AnswerText::model()->deleteAnswerText($deleted_answer_id);
                        }
                    }
                } else if ($model->question_type == "TRUE_OR_FALSE_ANSWER") {

                    $answers = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('answer')
                            ->where('question_id=:question_id', array(':question_id' => $id))
                            ->queryAll();

                    foreach ($answers as $answer) {
                        Answer::model()->deleteByPk($answer['answer_id']);
                    }

                    $answer = new Answer;

                    $answer->question_id = $question_id;

                    if (isset($_POST['answer'])) {

                        $is_correct = $_POST['answer'];

                        if ($is_correct == "true") {
                            $answer->is_correct = 1;
                        } else if ($is_correct == "false") {
                            $answer->is_correct = 0;
                        }

                        if ($answer->save()) {
                            
                        } else {
                            print_r($answer->errors);
                            die();
                        }
                    } else {

                        $answer->is_correct = 3;

                        if ($answer->save()) {
                            
                        } else {
                            print_r($answer->errors);
                            die();
                        }
                    }

//                    $is_correct = $_POST['answer'];
//
//                    if ($is_correct == "true") {
//                        $answer->is_correct = 1;
//                    } else if ($is_correct == "false") {
//                        $answer->is_correct = 0;
//                    }
//
//                    if ($answer->save()) {
//                        
//                    } else {
//                        print_r($answer->errors);
//                        die();
//                    }
                } else if ($model->question_type == "DRAG_DROP_TYPEE_ANSWER") {
                    $heading_1 = $_POST['heading_1'];
                    $heading_2 = $_POST['heading_2'];

                    if ($heading_1 != null) {


                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 1';

                        $model_heading_1 = Heading::model()->find($criteria);

//                        Heading::model()->deleteByPk($model_heading_1->heading_id);
//                        $model_heading_1->question_id = $question_id;

                        if ($model_heading_1 == null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->question_id = $id;
                            $model_heading_1->heading_position = 1;
                        } else {
                            $model_heading_1->heading_text = $heading_1;
                        }

//                        $model_heading_1->heading_position = 1;

                        if ($model_heading_1->save()) {
//                            echo 'saved';die();
                        } else {
                            print_r($model_heading_1->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 1))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }

                    if ($heading_2 != null) {


                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 2';

                        $model_heading_2 = Heading::model()->find($criteria);

//                        Heading::model()->deleteByPk($model_heading_1->heading_id);
//                        $model_heading_1->question_id = $question_id;

                        if ($model_heading_2 == null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->question_id = $id;
                            $model_heading_2->heading_position = 2;
                        } else {
                            $model_heading_2->heading_text = $heading_2;
                        }


//                        $model_heading_2->heading_position = 2;

                        if ($model_heading_2->save()) {
//                             echo 'saved2';die();
                        } else {
                            print_r($model_heading_2->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 2))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }
//
//                    if ($heading_2 != null) {
//                        $model_heading_2 = new Heading;
//                        $model_heading_2->question_id = $question_id;
//                        $model_heading_2->heading_text = $heading_2;
//                        $model_heading_2->heading_position = 2;
//
//                        if ($model_heading_2->save()) {
//                            
//                        } else {
//                            print_r($model_heading_2->errors);
//                            die();
//                        }
//                    }





                    $Session = Yii::app()->session['drag_drop_typee_question_part_session'];

                    if (!empty($Session)) {


                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $answerTexts = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answerTexts as $answerText) {
                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                        }




                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {

//                            $questionPartTextIds = Yii::app()->db->createCommand()
//                                    ->select('*')
//                                    ->from('question_part_text')
//                                    ->where('question_part_id=:question_part_id', array(':question_part_id' => $questionPartId['question_part_id']))
//                                    ->queryAll();
//
//                            foreach ($questionPartTextIds as $questionPartTextId) {
//                                QuestionPartText::model()->deleteByPk($questionPartTextId['question_part_text_id']);
//                            }

                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }

                        foreach ($Session as $item) {
                            $model_question_part = new QuestionPart;

                            $model_question_part->question_id = $question_id;
                            $model_question_part->question_part_name = $item['question_part'];

                            if ($model_question_part->save()) {
                                
                            } else {
                                print_r($model_question_part->errors);
                                die();
                            }

                            $question_part_id = $model_question_part->getPrimaryKey();

                            $questionPartTexts = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('question_part_text')
                                    ->where('question_part_id=:question_part_id', array(':question_part_id' => $question_part_id))
                                    ->queryAll();

                            foreach ($questionPartTexts as $questionPartText) {
                                QuestionPartText::model()->deleteByPk($questionPartTexts['question_part_text_id']);
                            }

                            $model_question_part_text = new QuestionPartText;

                            $model_question_part_text->question_part_id = $question_part_id;
                            $model_question_part_text->question_part_text = $item['question_part_text'];

                            if ($model_question_part_text->save()) {
                                
                            } else {
                                print_r($model_question_part_text->errors);
                                die();
                            }

                            $answer_text = $item['answer'];

                            $model_anser_text = new AnswerText;
                            $model_anser_text->answer_text = $answer_text;
                            $model_anser_text->question_id = $question_id;
                            $answer_text_id;

                            if ($model_anser_text->save()) {
                                $answer_text_id = $model_anser_text->getPrimaryKey();
                            } else {
                                print_r($model_anser_text->errors);
                                die();
                            }


                            $model_answer = new Answer;

                            $model_answer->question_id = $question_id;
                            $model_answer->question_part_id = $question_part_id;
                            $model_answer->answer_text_id = $answer_text_id;
                            $model_answer->is_correct = 1;

                            if ($model_answer->save()) {
                                
                            } else {
                                print_r($model_answer->errors);
                                die();
                            }
                        }
                    } else {
                        $answerTexts = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answerTexts as $answerText) {
                            AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                        }

                        $answers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($answers as $answer) {
                            Answer::model()->deleteByPk($answer['answer_id']);
                        }

                        $questionPartIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part')
                                ->where('question_id=:question_id', array(':question_id' => $id))
                                ->queryAll();

                        foreach ($questionPartIds as $questionPartId) {

                            $questionPartTextIds = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('question_part_text')
                                    ->where('question_part_id=:question_part_id', array(':question_part_id' => $questionPartId['question_part_id']))
                                    ->queryAll();

                            foreach ($questionPartTextIds as $questionPartTextId) {
                                QuestionPartText::model()->deleteByPk($questionPartTextId['question_part_text_id']);
                            }

                            QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                        }
                    }


                    $other_answers = Yii::app()->session['other_answer_session'];


                    if (!empty($other_answers)) {

                        $otheranswers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id AND is_correct=:is_correct', array(':question_id' => $id, ':is_correct' => 0))
                                ->queryAll();

                        foreach ($otheranswers as $otheranswer) {
                            Answer::model()->deleteByPk($otheranswer['answer_id']);
                        }

                        foreach ($other_answers as $other_answer) {

                            $model_answer_text = new AnswerText;

                            $model_answer_text->question_id = $question_id;
                            $model_answer_text->answer_text = $other_answer['other_answer'];

                            if ($model_answer_text->save()) {
                                $other_answer_text_id = $model_answer_text->getPrimaryKey();
                            } else {
                                print_r($model_answer_text->errors);
                                die();
                            }

                            $model_other_answer = new Answer;

                            $model_other_answer->question_id = $question_id;
                            $model_other_answer->is_correct = 0;
                            $model_other_answer->answer_text_id = $other_answer_text_id;

                            if ($model_other_answer->save()) {
                                
                            } else {
                                print_r($model_other_answer->errors);
                                die();
                            }
                        }
                    } else {
                        $otheranswers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id AND is_correct=:is_correct', array(':question_id' => $id, ':is_correct' => 0))
                                ->queryAll();

                        foreach ($otheranswers as $otheranswer) {
                            Answer::model()->deleteByPk($otheranswer['answer_id']);
                        }
                    }
                } else if ($model->question_type == "DRAG_DROP_TYPED_ANSWER") {
                    $result_text = $_POST['result_text'];
                    $question_part = $_POST['question_part'];
                    $operator_1 = $_POST['operator_1'];
                    $answer_1 = $_POST['answer_1'];
                    $operator_2 = $_POST['operator_2'];
                    $answer_2 = $_POST['answer_2'];


                    $answers = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('answer')
                            ->where('question_id=:question_id', array(':question_id' => $id))
                            ->queryAll();

                    foreach ($answers as $answer) {
                        Answer::model()->deleteByPk($answer['answer_id']);
                    }

                    $answerTexts = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('answer')
                            ->where('question_id=:question_id', array(':question_id' => $id))
                            ->queryAll();

                    foreach ($answerTexts as $answerText) {
                        AnswerText::model()->deleteByPk($answerText['answer_text_id']);
                    }

                    $questionPartIds = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('question_part')
                            ->where('question_id=:question_id', array(':question_id' => $id))
                            ->queryAll();

                    foreach ($questionPartIds as $questionPartId) {

                        $questionPartTextIds = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('question_part_text')
                                ->where('question_part_id=:question_part_id', array(':question_part_id' => $questionPartId['question_part_id']))
                                ->queryAll();

                        foreach ($questionPartTextIds as $questionPartTextId) {
                            QuestionPartText::model()->deleteByPk($questionPartTextId['question_part_text_id']);
                        }

                        QuestionPart::model()->deleteByPk($questionPartId['question_part_id']);
                    }

                    $model_question_part = new QuestionPart;

                    $model_question_part->question_part_name = $question_part;
                    $model_question_part->question_id = $question_id;

                    if ($model_question_part->save()) {
                        $question_part_id = $model_question_part->getPrimaryKey();
                    } else {
                        print_r($model_question_part->errors);
                        die();
                    }



                    $model_answer_1_text = new AnswerText;

                    $model_answer_1_text->answer_text = $answer_1;
                    $model_answer_1_text->question_id = $question_id;

                    if ($model_answer_1_text->save()) {
                        $answer_1_text_id = $model_answer_1_text->getPrimaryKey();
                    } else {
                        print_r($model_answer_1_text->errors);
                        die();
                    }

                    $model_answer_1 = new Answer;

                    $model_answer_1->question_id = $question_id;
                    $model_answer_1->question_part_id = $question_part_id;
                    $model_answer_1->is_correct = 1;
                    $model_answer_1->answer_text_id = $answer_1_text_id;

                    if ($model_answer_1->save()) {
                        
                    } else {
                        print_r($model_answer_1->errors);
                        die();
                    }

                    $model_answer_2_text = new AnswerText;

                    $model_answer_2_text->answer_text = $answer_2;
                    $model_answer_2_text->question_id = $question_id;

                    if ($model_answer_2_text->save()) {
                        $answer_2_text_id = $model_answer_2_text->getPrimaryKey();
                    } else {
                        print_r($model_answer_2_text->errors);
                        die();
                    }

                    $model_answer_2 = new Answer;

                    $model_answer_2->question_id = $question_id;
                    $model_answer_2->question_part_id = $question_part_id;
                    $model_answer_2->is_correct = 1;
                    $model_answer_2->answer_text_id = $answer_2_text_id;

                    if ($model_answer_2->save()) {
                        
                    } else {
                        print_r($model_answer_2->errors);
                        die();
                    }



                    $model_result_text = new AnswerText;

                    $model_result_text->answer_text = $result_text;
                    $model_result_text->question_id = $question_id;

                    if ($model_result_text->save()) {
                        $result_text_id = $model_result_text->getPrimaryKey();
                    } else {
                        print_r($model_result_text->errors);
                        die();
                    }

                    $model_result_text = new Answer;

                    $model_result_text->question_id = $question_id;
                    $model_result_text->is_correct = 1;
                    $model_result_text->answer_text_id = $result_text_id;

                    if ($model_result_text->save()) {
                        
                    } else {
                        print_r($model_result_text->errors);
                        die();
                    }


                    $model_operator_1 = new QuestionPartText;

                    $model_operator_1->question_part_id = $question_part_id;
                    $model_operator_1->question_part_text = $operator_1;

                    if ($model_operator_1->save()) {
                        
                    } else {
                        print_r($model_operator_1->errors);
                        die();
                    }

                    $model_operator_2 = new QuestionPartText;

                    $model_operator_2->question_part_id = $question_part_id;
                    $model_operator_2->question_part_text = $operator_2;

                    if ($model_operator_2->save()) {
                        
                    } else {
                        print_r($model_operator_2->errors);
                        die();
                    }

                    $other_answers = Yii::app()->session['other_answer_session'];


                    if (!empty($other_answers)) {

                        $otheranswers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id AND is_correct=:is_correct', array(':question_id' => $id, ':is_correct' => 0))
                                ->queryAll();

                        foreach ($otheranswers as $otheranswer) {
                            Answer::model()->deleteByPk($otheranswer['answer_id']);
                        }

                        foreach ($other_answers as $other_answer) {

                            $model_answer_text = new AnswerText;

                            $model_answer_text->question_id = $question_id;
                            $model_answer_text->answer_text = $other_answer['other_answer'];

                            if ($model_answer_text->save()) {
                                $other_answer_text_id = $model_answer_text->getPrimaryKey();
                            } else {
                                print_r($model_answer_text->errors);
                                die();
                            }

                            $model_other_answer = new Answer;

                            $model_other_answer->question_id = $question_id;
                            $model_other_answer->is_correct = 0;
                            $model_other_answer->answer_text_id = $other_answer_text_id;

                            if ($model_other_answer->save()) {
                                
                            } else {
                                print_r($model_other_answer->errors);
                                die();
                            }
                        }
                    } else {
                        $otheranswers = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('answer')
                                ->where('question_id=:question_id AND is_correct=:is_correct', array(':question_id' => $id, ':is_correct' => 0))
                                ->queryAll();

                        foreach ($otheranswers as $otheranswer) {
                            Answer::model()->deleteByPk($otheranswer['answer_id']);
                        }
                    }
                } else if ($model->question_type == "MULTIPLE_CHOICE_ANSWER") {

                    $heading_1 = $_POST['heading_1'];
                    $heading_2 = $_POST['heading_2'];

                    if ($heading_1 != null) {


                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 1';

                        $model_heading_1 = Heading::model()->find($criteria);

                        if ($model_heading_1 == null) {
                            $model_heading_1 = new Heading;
                            $model_heading_1->heading_text = $heading_1;
                            $model_heading_1->question_id = $id;
                            $model_heading_1->heading_position = 1;
                        } else {
                            $model_heading_1->heading_text = $heading_1;
                        }


                        if ($model_heading_1->save()) {
                            
                        } else {
                            print_r($model_heading_1->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 1))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }

                    if ($heading_2 != null) {
                        $criteria = new CDbCriteria;
                        $criteria->condition = "question_id= " . $question_id;
                        $criteria->condition = 'question_id = ' . $question_id . ' AND heading_position = 2';

                        $model_heading_2 = Heading::model()->find($criteria);

                        if ($model_heading_2 == null) {
                            $model_heading_2 = new Heading;
                            $model_heading_2->heading_text = $heading_2;
                            $model_heading_2->question_id = $id;
                            $model_heading_2->heading_position = 2;
                        } else {
                            $model_heading_2->heading_text = $heading_2;
                        }
                        if ($model_heading_2->save()) {
                            
                        } else {
                            print_r($model_heading_2->errors);
                            die();
                        }
                    } else {
                        $headings = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('heading')
                                ->where('question_id=:question_id AND heading_position=:heading_position ', array(':question_id' => $id, ':heading_position' => 2))
                                ->queryAll();

                        foreach ($headings as $heading) {
                            Heading::model()->deleteByPk($heading['heading_id']);
                        }
                    }

                    //posted session data
                    $questionPartData = Yii::app()->session['multiple_choice_answer_session'];
                    $newQuestionPartData = Yii::app()->session['multiple_choice_session']; //when adding a new question part

                    $questionPartIndex = 0;
                    foreach ($questionPartData as $questionPart) {
                        if (isset($questionPart[0]['is_correct'])) {
                            if (is_numeric($questionPart[0]['is_correct'])) {
                                //a change has been done to the question part
                                //delete existing data
                                $answers_data = Answer::model()->findAllByAttributes(array('question_id' => $question_id, 'question_part_id' => $questionPart[0]['question_part_id']));
                                if (!empty($answers_data)) {
                                    foreach ($answers_data as $answer_data) {
                                        $answer_text_data_id = $answer_data->answer_text_id;
                                        if (!empty($answer_data)) {
                                            Answer::model()->deleteByPk($answer_data->answer_id);
                                            AnswerText::model()->deleteByPk($answer_text_data_id);
                                        }
                                    }
                                }


                                //save updated data
                                $question_part_model = QuestionPart::model()->findByPk($questionPart[0]['question_part_id']);
                                $question_part_model->question_part_name = $questionPart[0]['question_part'];
                                if ($question_part_model->save()) {

                                    //add answer data
                                    foreach ($questionPart as $questionPartAnswer) {
                                        //add answer text data
                                        $answer_text_model = new AnswerText;
                                        $answer_text_model->answer_text = $questionPartAnswer['answer_text'];
                                        $answer_text_model->question_id = $question_id;
                                        if ($answer_text_model->save()) {
                                            $answer_text_model_id = $answer_text_model->answer_text_id;

                                            //save answer data
                                            $answer_model = new Answer;
                                            $answer_model->question_id = $question_id;
                                            $answer_model->question_part_id = $questionPartAnswer['question_part_id'];
                                            $answer_model->answer_text_id = $answer_text_model_id;
                                            $is_correct_answer = 0;
                                            if (($questionPartAnswer['answer_position']) == ($questionPartAnswer['is_correct'])) {
                                                $is_correct_answer = 1;
                                            }
                                            $answer_model->is_correct = $is_correct_answer;
                                            if ($answer_model->save()) {
                                                
                                            } else {
                                                var_dump($answer_model->getErrors());
                                                die;
                                            }
                                        } else {
                                            var_dump($answer_text_model->getErrors());
                                            die;
                                        }
                                    }
                                }
                            } else {
                                //no change has done
                                //has a boolean value instead of a numeric value
                                if (!isset($questionPart[0]['question_part_id'])) {
                                    //add a new question part
                                    $question_part_model = new QuestionPart;
                                    $question_part_model->question_part_name = $questionPart[0]['question_part'];
                                    $question_part_model->question_id = $question_id;
                                    if ($question_part_model->save()) {
                                        $questionPartModelId = $question_part_model->question_part_id;

                                        //add answer data
                                        foreach ($questionPart as $questionPartAnswer) {
                                            //add answer text data
                                            $answer_text_model = new AnswerText;
                                            $answer_text_model->answer_text = $questionPartAnswer['answer_text'];
                                            $answer_text_model->question_id = $question_id;
                                            if ($answer_text_model->save()) {
                                                $answer_text_model_id = $answer_text_model->answer_text_id;

                                                //save answer data
                                                $answer_model = new Answer;
                                                $answer_model->question_id = $question_id;
                                                $answer_model->question_part_id = $questionPartModelId;
                                                $answer_model->answer_text_id = $answer_text_model_id;
                                                $is_correct_answer = 0;
                                                if (($questionPartAnswer['answer_position']) == ($newQuestionPartData[$questionPartIndex]['is_correct'])) {
                                                    $is_correct_answer = 1;
                                                }
                                                $answer_model->is_correct = $is_correct_answer;
                                                if ($answer_model->save()) {
                                                    
                                                } else {
                                                    var_dump($answer_model->getErrors());
                                                    die;
                                                }
                                            } else {
                                                var_dump($answer_text_model->getErrors());
                                                die;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $questionPartIndex++;
                    }
                } else if ($model->question_type == "HOT_SPOT_ANSWER") {
                    //$upload_images = CUploadedFile::getInstanceByName('uploadedFile');                    

                    $uploadimages = isset($_FILES['uploadedFile']) ? $_FILES['uploadedFile'] : array();
                    $uploadImageName = isset($uploadimages['name']) ? $uploadimages['name'] : null;
                    $stringCoordinates = $_POST['val'];


                    if ($stringCoordinates != NULL) {
                        //if $stringCoordinates value comes as [Object Element]55,56- 
                        if (strcmp($stringCoordinates[0], '[') == 0) {
                            $str = substr($stringCoordinates, 23);
                        } else {
                            $str = $stringCoordinates;
                        }
                    } else {
                        $str = null;
                    }

                    $answer = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('hotspot')
                            ->where('question_id=:question_id', array(':question_id' => $model->question_id))
                            ->queryAll();


                    if (!empty($answer)) {


                        if ($uploadImageName != NULL) {

                            $model = Hotspot::model()->findByPk($answer[0]['hotspot_id']);
                            $model->question_id = $question_id;
                            $model->image_name = $uploadImageName;
                            $model->coordinates = $str;

                            if ($model->save()) {
                                $upload_dir = $this->getUploadDir($model->hotspot_id);
                                // echo $upload_dir;die();

                                if (isset($_FILES['uploadedFile'])) {
//                                    $pic->saveAs($upload_dir . $uploadImageName);
                                    move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $upload_dir . $uploadImageName);
                                }

                                $user_id = Yii::app()->user->id;

                                $model_question_audit = new Audit;
                                $model_question_audit->user_id = $user_id;
                                $model_question_audit->action_id = $question_id;
                                $model_question_audit->action = 'EDIT';
                                $model_question_audit->action_name = "QUESTION_MANAGEMENT";
                                $model_question_audit->date = date("Y/m/d");
                                $model_question_audit->time = date("h:i:sa");
                                $model_question_audit->status = 1;

                                if ($model_question_audit->save()) {
                                    
                                } else {
                                    print_r($model_exam_audit->errors);
                                }



                                $this->redirect(array('viewHotspot', 'id' => $model->question_id));
                            }
                        } else if ($stringCoordinates != NULL) {

                            $model = Hotspot::model()->findByPk($answer[0]['hotspot_id']);
                            $model->question_id = $question_id;
                            $model->coordinates = $str;

                            if ($model->save()) {
                                $this->redirect(array('viewHotspot', 'id' => $model->question_id));
                            }
                        } else {
                            $this->redirect(array('viewHotspot', 'id' => $model->question_id));
                        }
                    } else {

                        $uploadimages = isset($_FILES['uploadedFile']) ? $_FILES['uploadedFile'] : array();
                        $uploadImageName = isset($uploadimages['name']) ? $uploadimages['name'] : null;

                        $stringCoordinates = $_POST['val'];

                        $extension = substr($uploadImageName, strrpos($uploadImageName, '.') + 1);
                        $extension = strtolower($extension);

                        if ($extension == "jpg" || $extension == "png") {

                            if ($stringCoordinates != NULL) {
                                //if $stringCoordinates value comes as [Object Element]55,56- 
                                if (strcmp($stringCoordinates[0], '[') == 0) {
                                    $str = substr($stringCoordinates, 23);
                                } else {
                                    $str = $stringCoordinates;
                                }
                            } else {
                                $str = null;
                            }

                            if ($uploadImageName != NULL) {

                                Yii::app()->user->setFlash('error', "attachment cannot be blank");

                                $model = new Hotspot;
                                $model->question_id = $question_id;
                                $model->image_name = $uploadImageName;
                                $model->coordinates = $str;
                                $uploadImageName = $uploadImageName;
                            }

                            if ($model->save()) {
                                $upload_dir = $this->getUploadDir($model->hotspot_id);
                                // echo $upload_dir;die();

                                if (isset($_FILES['uploadedFile'])) {
//                                    $pic->saveAs($upload_dir . $uploadImageName);
                                    move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $upload_dir . $uploadImageName);
                                }

                                $user_id = Yii::app()->user->id;

                                $model_question_audit = new Audit;
                                $model_question_audit->user_id = $user_id;
                                $model_question_audit->action_id = $question_id;
                                $model_question_audit->action = 'EDIT';
                                $model_question_audit->action_name = "QUESTION_MANAGEMENT";
                                $model_question_audit->date = date("Y/m/d");
                                $model_question_audit->time = date("h:i:sa");
                                $model_question_audit->status = 1;

                                if ($model_question_audit->save()) {
                                    
                                } else {
                                    print_r($model_exam_audit->errors);
                                }

                                $this->redirect(array('viewHotspot', 'id' => $model->question_id));
                            }
                        } else {
                            echo 'Please upload an Image';
                            die;
                        }
                    }
                } else if ($model->question_type == "ESSAY_ANSWER") {

                    $essayQuestion = EssayQuestion::model()->getEssayQuestionDetailsById($model->question_id);

                    $essayQuestionAttributes = EssayQuestion::model()->findByPk($essayQuestion['essay_question_id']);

                    $essayQuestionAttributes->reference_material = 0;
                    //get the tab titles
//                    for ($i = 1; $i < 16; $i++) {
//                        if (isset($_POST["ref_tab_title_$i"])) {
//                            $tab_title_reference[$i] = $_POST["ref_tab_title_$i"];
//                            if ($tab_title_reference[$i] != null || $tab_title_reference[$i] != "") {
//                                $essayQuestionAttributes->reference_material = 1;
//                            }
//                        }
//                    }

                    $answer_reference1 = QuestionReferenceMaterials::model()->findAllByAttributes(array('question_id' => $model->question_id));


                    if ($essayQuestionAttributes->update()) {
                        
                    } else {
                        print_r($essayQuestionAttributes->erroes);
                        die;
                    }

                    $emailHeader = EmailEssayHeader::model()->getEmailEssayHeaderDetailsByQuestionId($model->question_id);
                    $eamilHeaderDetail = null;
                    if (!empty($emailHeader)) {
                        $eamilHeaderDetail = EmailEssayHeader::model()->findByPk($emailHeader['email_essay_header_id']);
                    }
                    if ($eamilHeaderDetail != null) {

                        $emailFromField = $_POST['email_from'];
                        $emailToField = $_POST['email_to'];
                        $emailCcField = $_POST['email_cc'];
                        $emailSubjectField = $_POST['email_subject'];

                        $eamilHeaderDetail->from_field = $emailFromField;
                        $eamilHeaderDetail->to_field = $emailToField;
                        $eamilHeaderDetail->cc_field = $emailCcField;
                        $eamilHeaderDetail->subject_field = $emailSubjectField;
                        $eamilHeaderDetail->question_id = $question_id;

                        if ($eamilHeaderDetail->update()) {
                            
                        } else {
                            print_r($eamilHeaderDetail->errors);
                            die;
                        }
                    }

                    //delete the existing data
//                    $table_formula = QuestionReferenceMaterials::model()->findAllByAttributes(array('question_id' => $model->question_id));
//                    foreach ($table_formula as $table_formula_data) {
//                        $table_formula_tab = QuestionReferenceMaterialTabs::model()->findByAttributes(array('question_reference_material_id' => $table_formula_data->question_reference_material_id));
//                        if (isset($table_formula_tab)) {
//                            QuestionReferenceMaterialTabs::model()->deleteByPk($table_formula_tab->question_reference_material_tab_id);
//                            QuestionReferenceMaterials::model()->deleteByPk($table_formula_data->question_reference_material_id);
//                        }
//                    }
//                    for ($i = 1; $i < 16; $i++) {
//                        if ($tab_title_reference[$i] != null) {
//                            if (isset($_POST["ref_answer$i"])) {
//                                $checkbox1 = $_POST["ref_answer$i"];
//                                if ($checkbox1 == "text_answer$i") {
//                                    $text1 = $_POST["ref_table_formula_$i"];
//                                    if ($text1 != null) {
//                                        $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
//
//                                        $questionReferenceMaterial_1->question_id = $question_id;
//                                        $questionReferenceMaterial_1->reference_material_text = $text1;
//                                        $questionReferenceMaterial_1->reference_file = null;
//                                        $questionReferenceMaterial_1->reference_tab_position = $i;
//
//                                        if ($questionReferenceMaterial_1->save()) {
//                                            $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
//                                            $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;
//
//                                            $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
//                                            $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
//                                            if ($model_question_reference_tab_title_1->save()) {
//                                                
//                                            } else {
//                                                print_r($model_question_reference_tab_title_1->getErrors());
//                                                die();
//                                            }
//                                        } else {
//                                            print_r($questionReferenceMaterial_1->errors);
//                                            die;
//                                        }
//                                    }
//                                } else if ($checkbox1 == "image_answer$i") {
//                                    $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
//
//                                    if ($uploadfile1['name'] != "") {
//                                        $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
//                                        $questionReferenceMaterial_1->question_id = $question_id;
//                                        $questionReferenceMaterial_1->reference_material_text = null;
//                                        $questionReferenceMaterial_1->reference_file = $uploadfile1['name'];
//                                        $questionReferenceMaterial_1->reference_tab_position = $i;
//
//                                        if ($questionReferenceMaterial_1->save()) {
//                                            $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
//                                            $upload_dir = $this->getUploadDirReferenceMaterial($question_id, $i);
//
//                                            if (isset($_FILES["ref_file$i"])) {
//                                                move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
//                                            }
//
//                                            $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;
//
//                                            $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
//                                            $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
//                                            if ($model_question_reference_tab_title_1->save()) {
//                                                
//                                            } else {
//                                                print_r($model_question_reference_tab_title_1->getErrors());
//                                                die();
//                                            }
//                                        } else {
//
//                                            print_r($questionReferenceMaterial_1->errors);
//                                            die;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
                }



                $user_id = Yii::app()->user->id;

                $model_question_audit = new Audit;
                $model_question_audit->user_id = $user_id;
                $model_question_audit->action_id = $question_id;
                $model_question_audit->action = 'EDIT';
                $model_question_audit->action_name = "QUESTION_MANAGEMENT";
                $model_question_audit->date = date("Y/m/d");
                $model_question_audit->time = date("h:i:sa");
                $model_question_audit->status = 1;

                if ($model_question_audit->save()) {
                    
                } else {
                    print_r($model_exam_audit->errors);
                }
            }




            //------END OF HOTSPOT QUESTION UPDATE----------

            $this->redirect(array('view', 'id' => $model->question_id));
        } else {
            var_dump($model->getErrors());
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
        $model = new Question('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Question']))
            $model->attributes = $_GET['Question'];

        $this->render('index', array(
            'model' => $model,
        ));
//        $dataProvider = new CActiveDataProvider('Question');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Question('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Question']))
            $model->attributes = $_GET['Question'];

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
        $model = Question::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'question-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAnswerForms() {
        Yii::app()->clientScript->scriptMap = array('jquery.js' => false);
        if (isset($_POST['question_type'])) {
            if ($_POST['question_type'] == 'SINGLE_ANSWER') {
//                Yii::app()->session['single_answer_session'] = array();
//for ($count = 1; $count <= 20; $count++) {
                echo $this->renderPartial('_single_answer_qs_form', false, false);
//, array(
//                        'count' => $count,
//                        'answer' => null,
//                        'edit' => null,
//                            ), false, true);
//}
            }if ($_POST['question_type'] == 'MULTIPLE_ANSWER') {
                echo $this->renderpartial('_multiple_answer_qs_form', false, false);
            }
            if ($_POST['question_type'] == 'SHORT_WRITTEN') {
//                $this->renderpartial('_short_written_answer_qs_form');
                Yii::app()->session['short_written_question_part_session'] = array();

                $output = null;
                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderPartial('_short_written_answer_qs_form', array(
                        'count' => $count,
                        'edit' => null,
                        'question_part' => null,
                        'answer' => null,
                        'heading_1' => null,
                        'heading_2' => null,
                        'part_count' => null,
                        'question_id' => null,
                            ), true, $process);
                }
                echo $output;
            }
            if ($_POST['question_type'] == 'MULTIPLE_CHOICE_ANSWER') {
                Yii::app()->session['multiple_choice_session'] = array();

                Yii::app()->session['multiple_choice_answer_session'] = array();

                $output = null;
                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderPartial('_multiple_choice_answer_qs_form', array(
                        'count' => $count,
                        'edit' => null,
                        'question_part' => null,
                        'answer' => null,
                        'heading_1' => null,
                        'heading_2' => null,
                            ), true, $process);
                }
                echo $output;
            }
            if ($_POST['question_type'] == 'DRAG_DROP_TYPEA_ANSWER') {
                Yii::app()->session['drag_drop_typea_session'] = array();

                $output = null;
                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderPartial('_drag_drop_typea_answer_qs_form', array(
                        'count' => $count,
                        'edit' => null,
                        'question_part' => null,
                        'answer' => null,
                        'heading_1' => null,
                        'heading_2' => null,
                            ), true, $process);
                }
                echo $output;
//                $this->renderpartial('_drag_drop_typea_answer_qs_form');
            }
            if ($_POST['question_type'] == 'DRAG_DROP_TYPEB_ANSWER') {
                Yii::app()->session['drag_drop_typeb_session'] = array();

                $output = null;
                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderpartial('_drag_drop_typeb_answer_qs_form', array(
                        'count' => $count,
                        'heading_1' => null,
                        'heading_2' => null,
                        'edit' => null,
                        'question_part' => null,
                        'answer' => null,
                            ), true, $process);
                }
                echo $output;
            }
            if ($_POST['question_type'] == 'DRAG_DROP_TYPEC_ANSWER') {
                $this->renderpartial('_drag_drop_typec_answer_qs_form', array('type' => 'insert'));
            }
            if ($_POST['question_type'] == 'DRAG_DROP_TYPED_ANSWER') {
                $this->renderpartial('_drag_drop_typed_answer_qs_form', array(
                    'edit' => null,
                    'result_text' => null,
                    'question_part' => null,
                    'operator_1' => null,
                    'operator_2' => null,
                    'answer_1' => null,
                    'answer_2' => null,
                ));

                Yii::app()->session['other_answer_session'] = array();

                echo '<br/>';

                $output = null;
                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderPartial('_other_answer_form', array(
                        'count' => $count,
                        'edit' => null,
                        'question_part_count' => null,
                        'other_answer' => null,
                        'question_type' => 'drag_drop_typed'
                            ), true, $process);
                }
                echo $output;
            }
            if ($_POST['question_type'] == 'DRAG_DROP_TYPEE_ANSWER') {
//                $this->renderpartial('_drag_drop_typee_answer_qs_form');
                Yii::app()->session['drag_drop_typee_question_part_session'] = array();

                $output = null;
                for ($count = 1; $count <= 20; $count++) {
                    $output .= $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                        'count' => $count,
                        'edit' => null,
                        'question_part' => null,
                        'question_part_text' => null,
                        'answer' => null,
                        'heading_1' => null,
                        'heading_2' => null,
                            ), true);
                }

                Yii::app()->session['other_answer_session'] = array();

                $process = false;
                for ($count = 1; $count <= 20; $count++) {
                    $process = ($count == 19) ? true : false;
                    $output .= $this->renderPartial('_other_answer_form', array(
                        'count' => $count,
                        'edit' => null,
                        'other_answer' => null,
                        'question_type' => 'drag_drop_typee'
                            ), true, $process);
                }
                echo $output;
            }

            if ($_POST['question_type'] == 'TRUE_OR_FALSE_ANSWER') {
                $this->renderpartial('_true_or_false_qs_form', array(
                    'is_true' => null
                ));
            }

            if ($_POST['question_type'] == 'HOT_SPOT_ANSWER') {
                $this->renderpartial('_hot_spot_qs_form');
            }

            if ($_POST['question_type'] == 'ESSAY_ANSWER') {
                $this->renderpartial('_essay_answer_qs_form', array(), false, true);
            }
        }
    }

    public function actionSingleAnswerLoad() {

//print_r($_POST);
        $count = $_POST['count'];

//$single_answer_session = Yii::app()->session['single_answer_session'];

        if ($_POST['answer_' . $count] == NULL) {

            $status = "fail";
        } else {

//$single_answer_session[] = $_POST['answer_' . $count];
//Yii::app()->session['single_answer_session'] = $single_answer_session;

            $status = "success";
//print_r($single_answer_session); 
        }

        echo CJSON::encode(array(
            'status' => $status,
        ));
    }

    public function actionSuspend() {
        $question_id = $_POST['question_id'];
        $model = Question::model()->findByPk($question_id);

        $model->status = 0;

        Question::model()->updateByPk($question_id, array(
            'status' => 0
        ));

        $status = "success";
        $message = "";

        $exams = ExamQuestion::model()->getExamDetailsForSuspend($question_id);

        if (!empty($exams)) {

            $message = "These questions are already include in these papers. <br /> <table><tr><th style='text-align:left'>Exam ID &nbsp;&nbsp;</th><th style='text-align:left'>Exam Name &nbsp;&nbsp;</th></tr>";

            foreach ($exams as $data) {
                $message.="<tr><td>" . $data['exam_id'] . "</td><td style='text-align:left'>" . $data['exam_name'] . "</td></tr>";
            }

            $message.="</table>";
        } else {
            $message = "This question is not included in any papers";
        }

        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message
        ));
    }

    public function actionReactivate() {
        $question_id = $_POST['question_id'];
        $model = Question::model()->findByPk($question_id);

        $model->status = 1;

        Question::model()->updateByPk($question_id, array(
            'status' => 1
        ));

        $status = "success";


        $message = "";

        $exams = ExamQuestion::model()->getExamDetailsForSuspend($question_id);

        if (!empty($exams)) {

            $message = "These questions are already include in these papers. <br /> <table><tr><th style='text-align:left'>Exam ID &nbsp;&nbsp;</th><th style='text-align:left'>Exam Name &nbsp;&nbsp;</th></tr>";

            foreach ($exams as $data) {
                $message.="<tr><td>" . $data['exam_id'] . "</td><td style='text-align:left'>" . $data['exam_name'] . "</td></tr>";
            }

            $message.="</table>";
        } else {
            $message = "This question is not included in any papers";
        }

        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message
        ));
    }

    public function actionApprove() {
        $this->render('view_unapproved_questions');
    }

    public function actionShowUnapprovedQuestions() {
        $unapproved_questions = array();

        if (isset($_POST['lecturer_code']) && $_POST['lecturer_code'] != null) {
            $status = "success";
            $lecturer_code = $_POST['lecturer_code'];

            $user_id = Lecturer::getUserIdByLecturerCode($lecturer_code);
            $lecturer_id = Lecturer::getLecturerIdByUserId($user_id);
            $unapproved_questions = Question::model()->getUnApprovedQuestionsByUserId($user_id);
            $this->renderPartial('unapproved_questions_table_form', array(
                'questions' => $unapproved_questions,
                'lecturer_id' => $lecturer_id
                    ), false, true);
        } else {
            $status = "fail";
        }
    }

    public function actionApproveQuestion() {
        $question_id = $_POST['question_id'];
        $model = Question::model()->findByPk($question_id);

        $model->approved = 1;

        Question::model()->updateByPk($question_id, array(
            'approved' => 1
        ));

        $status = "success";

        echo CJSON::encode(array(
            'status' => $status,
            'question_id' => $question_id
        ));
    }

    public function actionDisapproveQuestion() {
        $question_id = $_POST['question_id'];
        $model = Question::model()->findByPk($question_id);

        $model->approved = 0;

        Question::model()->updateByPk($question_id, array(
            'approved' => 0
        ));

        $status = "success";

        echo CJSON::encode(array(
            'status' => $status,
            'question_id' => $question_id
        ));
    }

    public function actionViewQuestion() {
        $questionId = Yii::app()->request->getQuery('question_id', -1);
        $this->render('_viewQuestionDialog', array('question_id' => $questionId));
    }

    public function actionBulkupload() {
        $this->render('bulkupload');
    }

    public function actionSingleanswerbulk() {
        $this->render('singleanswerbulk');
    }

    public function actionCreateSingleAnswerBulk() {
        if ($_FILES['single_bulk']['name'] != '') {
            $single_answer_file = CUploadedFile::getInstanceByName('single_bulk');
            $upload_file_name = uniqid() . $single_answer_file->name;
            $extension = substr($upload_file_name, strrpos($upload_file_name, '.') + 1);

            if ($extension == "xls") {

                $single_answer_file->saveAs(Yii::getPathOfAlias('webroot') . '/bulkuploads/single_answer_questions/' . $upload_file_name);

                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                $data->read(Yii::getPathOfAlias('webroot') . '/bulkuploads/single_answer_questions/' . $upload_file_name);

                for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
                    if (!isset($data->sheets[0]["cells"][$x][1])) {
                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][6];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][7];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    } else {
                        $model_question = new Question;

                        $model_question->subject_area_id = $data->sheets[0]["cells"][$x][1];
                        $model_question->question_type = 'SINGLE_ANSWER';
                        $model_question->question_text = $data->sheets[0]["cells"][$x][2];
                        $model_question->number_of_marks = $data->sheets[0]["cells"][$x][3];
                        $model_question->exclude_from_dynamic = $data->sheets[0]["cells"][$x][4];
                        $model_question->status = 1;
                        $model_question->author_id = Yii::app()->user->getId();
                        $model_question->approved = 0;
                        $model_question->date_created = date("Y/m/d");
                        $model_question->question_logic = isset($data->sheets[0]["cells"][$x][5]) ? $data->sheets[0]["cells"][$x][5] : null;

                        $model_question->save();

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][6];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][7];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    }
                }

                $this->redirect(array('view', 'id' => $model_question->question_id));
            } else {
                echo 'Please upload files which has the extension of .xls';
                die;
            }
        } else {
            echo 'file is not set';
            die;
        }
    }

    public function actionMultipleanswerbulk() {
        $this->render('multipleanswerbulk');
    }

    public function actionCreateMultipleAnswerBulk() {

        if ($_FILES['multiple_bulk']['name'] != '') {
            $single_answer_file = CUploadedFile::getInstanceByName('multiple_bulk');
            $upload_file_name = uniqid() . $single_answer_file->name;
            $extension = substr($upload_file_name, strrpos($upload_file_name, '.') + 1);

            if ($extension == "xls") {

                $single_answer_file->saveAs(Yii::getPathOfAlias('webroot') . '/bulkuploads/multiple_answer_questions/' . $upload_file_name);

                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                $data->read(Yii::getPathOfAlias('webroot') . '/bulkuploads/multiple_answer_questions/' . $upload_file_name);

                for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
                    if (!isset($data->sheets[0]["cells"][$x][1])) {
                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][6];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][7];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    } else {
                        $model_question = new Question;

                        $model_question->subject_area_id = $data->sheets[0]["cells"][$x][1];
                        $model_question->question_type = 'MULTIPLE_ANSWER';
                        $model_question->question_text = $data->sheets[0]["cells"][$x][2];
                        $model_question->number_of_marks = $data->sheets[0]["cells"][$x][3];
                        $model_question->exclude_from_dynamic = $data->sheets[0]["cells"][$x][4];
                        $model_question->status = 1;
                        $model_question->author_id = Yii::app()->user->getId();
                        $model_question->approved = 0;
                        $model_question->date_created = date("Y/m/d");
                        $model_question->question_logic = isset($data->sheets[0]["cells"][$x][5]) ? $data->sheets[0]["cells"][$x][5] : null;

                        $model_question->save();

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][6];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][7];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    }
                }

                $this->redirect(array('view', 'id' => $model_question->question_id));
            } else {
                echo 'Please upload files which has the extension of .xls';
                die;
            }
        } else {
            echo 'file is not set';
            die;
        }
    }

    public function actionShortwrittenbulk() {
        $this->render('shortwrittenbulk');
    }

    public function actionCreateShortWrittenAnswerBulk() {
        if ($_FILES['shortwritten_bulk']['name'] != '') {
            $single_answer_file = CUploadedFile::getInstanceByName('shortwritten_bulk');
            $upload_file_name = uniqid() . $single_answer_file->name;
            $extension = substr($upload_file_name, strrpos($upload_file_name, '.') + 1);

            if ($extension == "xls") {

                $single_answer_file->saveAs(Yii::getPathOfAlias('webroot') . '/bulkuploads/short_written_answer_questions/' . $upload_file_name);

                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                $data->read(Yii::getPathOfAlias('webroot') . '/bulkuploads/short_written_answer_questions/' . $upload_file_name);

                for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
                    if (!isset($data->sheets[0]["cells"][$x][1])) {
                        $model_question_part = new QuestionPart;

                        $model_question_part->question_id = $model_question->getPrimaryKey();
                        $model_question_part->question_part_name = $data->sheets[0]["cells"][$x][8];

                        $model_question_part->save();

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][9];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->question_part_id = $model_question_part->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][10];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    } else {
                        $model_question = new Question;

                        $model_question->subject_area_id = $data->sheets[0]["cells"][$x][1];
                        $model_question->question_type = 'SHORT_WRITTEN';
                        $model_question->question_text = $data->sheets[0]["cells"][$x][4];
                        $model_question->number_of_marks = $data->sheets[0]["cells"][$x][5];
                        $model_question->exclude_from_dynamic = $data->sheets[0]["cells"][$x][6];
                        $model_question->status = 1;
                        $model_question->author_id = Yii::app()->user->getId();
                        $model_question->approved = 0;
                        $model_question->date_created = date("Y/m/d");
                        $model_question->question_logic = isset($data->sheets[0]["cells"][$x][7]) ? $data->sheets[0]["cells"][$x][7] : null;

                        $model_question->save();

                        $heading_position_count = 1;

                        for ($i = 2; $i <= 3; $i++) {
                            $model_heading = new Heading;

                            $model_heading->question_id = $model_question->getPrimaryKey();
                            $model_heading->heading_text = $data->sheets[0]["cells"][$x][$i];
                            $model_heading->heading_position = $heading_position_count;
                            $model_heading->save();

                            $heading_position_count++;
                        }


                        $model_question_part = new QuestionPart;

                        $model_question_part->question_id = $model_question->getPrimaryKey();
                        $model_question_part->question_part_name = $data->sheets[0]["cells"][$x][8];

                        $model_question_part->save();

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][9];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->question_part_id = $model_question_part->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][10];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    }
                }

                $this->redirect(array('view', 'id' => $model_question->question_id));
            } else {
                echo 'Please upload files which has the extension of .xls';
                die;
            }
        } else {
            echo 'file is not set';
            die;
        }
    }

    public function actionMultiplechoicebulk() {
        $this->render('multiplechoicebulk');
    }

    public function actionCreateMultipleChoiceBulk() {
        if ($_FILES['multiplechoice_bulk']['name'] != '') {
            $single_answer_file = CUploadedFile::getInstanceByName('multiplechoice_bulk');
            $upload_file_name = uniqid() . $single_answer_file->name;
            $extension = substr($upload_file_name, strrpos($upload_file_name, '.') + 1);

            if ($extension == "xls") {

                $single_answer_file->saveAs(Yii::getPathOfAlias('webroot') . '/bulkuploads/multiple_choice_answer_questions/' . $upload_file_name);

                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                $data->read(Yii::getPathOfAlias('webroot') . '/bulkuploads/multiple_choice_answer_questions/' . $upload_file_name);

                for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
                    if (!isset($data->sheets[0]["cells"][$x][1])) {

                        if (!isset($data->sheets[0]["cells"][$x][1]) && isset($data->sheets[0]["cells"][$x][8])) {
                            $model_question_part = new QuestionPart;

                            $model_question_part->question_id = $model_question->getPrimaryKey();
                            $model_question_part->question_part_name = $data->sheets[0]["cells"][$x][8];

                            $model_question_part->save();
                        }

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][9];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->question_part_id = $model_question_part->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][10];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    } else {
                        $model_question = new Question;

                        $model_question->subject_area_id = $data->sheets[0]["cells"][$x][1];
                        $model_question->question_type = 'MULTIPLE_CHOICE_ANSWER';
                        $model_question->question_text = $data->sheets[0]["cells"][$x][4];
                        $model_question->number_of_marks = $data->sheets[0]["cells"][$x][5];
                        $model_question->exclude_from_dynamic = $data->sheets[0]["cells"][$x][6];
                        $model_question->status = 1;
                        $model_question->author_id = Yii::app()->user->getId();
                        $model_question->approved = 0;
                        $model_question->date_created = date("Y/m/d");
                        $model_question->question_logic = isset($data->sheets[0]["cells"][$x][7]) ? $data->sheets[0]["cells"][$x][7] : null;

                        $model_question->save();

                        $heading_position_count = 1;

                        for ($i = 2; $i <= 3; $i++) {
                            $model_heading = new Heading;

                            $model_heading->question_id = $model_question->getPrimaryKey();
                            $model_heading->heading_text = $data->sheets[0]["cells"][$x][$i];
                            $model_heading->heading_position = $heading_position_count;
                            $model_heading->save();

                            $heading_position_count++;
                        }


                        $model_question_part = new QuestionPart;

                        $model_question_part->question_id = $model_question->getPrimaryKey();
                        $model_question_part->question_part_name = $data->sheets[0]["cells"][$x][8];

                        $model_question_part->save();

                        $model_answer_text = new AnswerText;

                        $model_answer_text->question_id = $model_question->getPrimaryKey();
                        $model_answer_text->answer_text = $data->sheets[0]["cells"][$x][9];

                        $model_answer_text->save();

                        $model_answer = new Answer;

                        $model_answer->question_id = $model_question->getPrimaryKey();
                        $model_answer->question_part_id = $model_question_part->getPrimaryKey();
                        $model_answer->is_correct = $data->sheets[0]["cells"][$x][10];
                        $model_answer->answer_text_id = $model_answer_text->getPrimaryKey();

                        $model_answer->save();
                    }
                }

                $this->redirect(array('view', 'id' => $model_question->question_id));
            } else {
                echo 'Please upload files which has the extension of .xls';
                die;
            }
        } else {
            echo 'File not set!';
        }
    }

    function actionSendMail() {

        $user_id = $_POST['userid'];
        $lec_id = $_POST['lecturerid'];
        $lec_code = Lecturer::model()->getLecturerCode($lec_id);

        $user_data = User::getUserInfoById($user_id);

        $dissaproveQid = Question::model()->getDissaprovedQuestions($user_id);

        if (!empty($dissaproveQid)) {

            $messageString = "";

            foreach ($dissaproveQid as $qid) {
                if ($qid['approved'] == 0) {
                    $messageString .= $qid['question_id'] . " , ";
                }
            }

            $subject = "LearnCIMA dis-approve questions";
            $email_admin = "chamathariyawansa@gmail.com";
            $email_lec = $user_data['email'];
            $message = "These questions are dis-approved by the admin of LearnCIMA.\n\n<br /><br />
                    Lecturer id   : " . $lec_id . "\n<br />
                    Lecturer code : " . $lec_code . "\n<br />   
                    Lecturer name : " . $user_data['first_name'] . " " . $user_data['last_name'] . "\n\n<br /><br />
                    Question ID's \n<br /><br />" . $messageString;

            sendEmail($subject, $message, $email_admin);
            sendEmail($subject, $message, $email_lec);


            $status = 'success';
        } else {
            $status = 'fail';
        }

        echo CJSON::encode(array(
            'status' => $status,
        ));
    }

    function actionReviewQuestion() {
        if (isset($_POST['Question'])) {
            $qtype = $_POST['question_type'];
            $qtext = $_POST['Question']['question_text'];
            $questions = "";

            if ($qtype == "SINGLE_ANSWER") {
                $up = $_POST['update_ff'];

                if ($up != 'UPDATE') {
                    $answer_details = $_POST['answer'];
                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype, 'qtext' => $qtext,
                        'answer_details' => $answer_details,
                        'newanswer_details' => null), TRUE, FALSE);
                } else {
                    $ans_details = array();
                    if (isset($_POST['deleted_answer'])) {
                        $answer_details = $_POST['answer'];
                        $deletedans = $_POST['deleted_answer'];
                        foreach ($deletedans as $key => $val) {
                            $s[$val] = "";
                        }

                        foreach ($answer_details as $key => $ans) {
                            if (!array_key_exists($key, $s)) {
                                $ans_details[] = $ans;
                            }
                        }
                        $answer_details = $ans_details;
                    } else {
                        $answer_details = $_POST['answer'];
                    }

                    $newanswers = null;

                    if (isset($_POST['newanswer'])) {
                        $newanswers = $_POST['newanswer'];
                    }

                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype, 'qtext' => $qtext,
                        'answer_details' => $answer_details,
                        'newanswer_details' => $newanswers), TRUE, FALSE);
                }
            } else if ($qtype == "MULTIPLE_ANSWER") {
                $up = $_POST['update_ff'];
                if ($up != 'UPDATE') {
                    $answer_details = $_POST['answer'];

                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype, 'qtext' => $qtext,
                        'answer_details' => $answer_details,
                        'newanswer_details' => null), TRUE, FALSE);
                } else {
                    $ans_details = array();
                    if (isset($_POST['deleted_answer'])) {
                        $answer_details = $_POST['answer'];
                        $deletedans = $_POST['deleted_answer'];
                        foreach ($deletedans as $key => $val) {
                            $s[$val] = "";
                        }

                        foreach ($answer_details as $key => $ans) {
                            if (!array_key_exists($key, $s)) {
                                $ans_details[] = $ans;
                            }
                        }
                        $answer_details = $ans_details;
                    } else {
                        $answer_details = $_POST['answer'];
                    }
                    $newanswers = null;

                    if (isset($_POST['newanswer'])) {
                        $newanswers = $_POST['newanswer'];
                    }
                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype, 'qtext' => $qtext,
                        'answer_details' => $answer_details,
                        'newanswer_details' => $newanswers), TRUE, FALSE);
                }
            } else if ($qtype == 'SHORT_WRITTEN') {

                $heading_1 = $_POST['heading_1'];
                $heading_2 = $_POST['heading_2'];

                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                    'qtext' => $qtext,
                    //'answer_details' => $answer_details,
                    'heading_1' => $heading_1,
                    'heading_2' => $heading_2), TRUE, FALSE);
            } else if ($qtype == 'TRUE_OR_FALSE_ANSWER') {
                if (isset($_POST['answer'])) {
                    $answer_details = $_POST['answer'];
                } else {
                    $answer_details = null;
                }
                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype, 'qtext' => $qtext,
                    'answer_details' => $answer_details), TRUE, FALSE);
            } else if ($qtype == 'DRAG_DROP_TYPEA_ANSWER') {



                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                    'qtext' => $qtext,
                        ), TRUE, FALSE);
            } else if ($qtype == 'DRAG_DROP_TYPEB_ANSWER') {

                $up = $_POST['update_ff'];

                if ($up == 'UPDATE') {

                    $qid = $_POST['qid'];
                    $upheading = array();
                    $answertxt = array();
                    $qpart = array();

                    $criteria = new CDbCriteria;
                    $criteria->addCondition('question_id=' . $qid);
                    $heading_results = Heading::model()->findAll($criteria);

                    foreach ($heading_results as $key => $heading) {
                        $heading = Heading::model()->findByPk($heading->heading_id);
                        $heading->heading_text = isset($_POST['heading'][$heading->heading_id]) ? $_POST['heading'][$heading->heading_id] : null;
                        $upheading[$key] = $heading->heading_text;
                    }
                    $heading_1 = null;
                    $heading_2 = null;
                    if (isset($_POST['heading'])) {
                        $upheadingdata = $_POST['heading'];
                        $heading_1 = $upheading[0];
                        $heading_2 = $upheading[1];
                    } else if (isset($_POST['heading_1']) && isset($_POST['heading_1'])) {
                        $heading_1 = $_POST['heading_1'];
                        $heading_2 = $_POST['heading_2'];
                    }



                    $qpart = $_POST['question_part'];
                    $answertxt = $_POST['answer'];
                    $answertxts = null;

                    if (isset($_POST['deleted_answer'])) {
                        $deleteAnswer = $_POST['deleted_answer'];
                    } else {
                        $deleteAnswer = null;
                        $qparts = $qpart;
                        $answertxts = $answertxt;
                    }

                    foreach ($qpart as $key => $value) {
                        if ($deleteAnswer != null) {
                            if (!in_array($key, $deleteAnswer)) {
                                $qparts[] = $value;
                                $answertxtid = Answer::model()->getAnswersByQuestionPartId($key);

                                foreach ($answertxtid as $ans) {
                                    if (array_key_exists($ans['answer_text_id'], $answertxt)) {
                                        $answertxts[] = $answertxt[$ans['answer_text_id']];
                                    }
                                }
                            }
                        }
                    }



                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                        'qtext' => $qtext,
                        'heading_1' => $heading_1,
                        'heading_2' => $heading_2,
                        'ans_text' => $answertxts,
                        //  'deleteAnswer' => $deleteAnswer,
                        'qpart' => $qparts), TRUE, FALSE);
                } else {
                    $heading_1 = $_POST['heading_1'];
                    $heading_2 = $_POST['heading_2'];

                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                        'qtext' => $qtext,
                        'ans_text' => null,
                        'heading_1' => $heading_1,
                        'heading_2' => $heading_2), TRUE, FALSE);
                }
            } else if ($qtype == 'DRAG_DROP_TYPEC_ANSWER') {

                $up = $_POST['update_ff'];

                $tc_max_no_of_answers = $_POST['max_no_of_answers'];
                $tc_max_no_of_question_parts = $_POST['max_no_of_question_parts'];

                if ($up == 'UPDATE') {
                    $qid = $_POST['qid'];
                    $answertxt = array();
                    $answer_details = array();
                    $qpart = array();
                    $existing_answer_text_data = AnswerText::model()->getAnswerTextForQuestion($qid);
                    $existing_question_parts_data = QuestionPart::model()->getQuestionPartsOfQuestion($qid);

                    $deleted_question_parts_string = $_POST['deleted_question_parts'];
                    $deleted_question_parts = explode(",", $deleted_question_parts_string);

                    foreach ($existing_answer_text_data as $key => $existing_answer_text) {
                        $e_a_tb_name = 'existanswer_' . $existing_answer_text->answer_text_id;
                        if (isset($_POST[$e_a_tb_name])) {
                            $tc_model_answer_text = AnswerText::model()->getAnswerText($existing_answer_text->answer_text_id);
                            $tc_model_answer_text->answer_text = $_POST[$e_a_tb_name];
                            $answertxt[$key] = $tc_model_answer_text->answer_text;
                        }
                    }

                    for ($i = 0; $i < $tc_max_no_of_answers; $i++) {
                        $answer_tb_name = 'answer_' . $i;
                        if (isset($_POST[$answer_tb_name]) && $_POST[$answer_tb_name] != "") {
                            $answer_details['answers'][] = $_POST[$answer_tb_name];
                        }
                    }

                    for ($i = 1; $i <= $tc_max_no_of_question_parts; $i++) {
                        $question_tb_name = 'question_' . $i;
                        $selectanswer_name = 'selectanswer_' . $i;

                        if (isset($_POST[$question_tb_name]) && $_POST[$question_tb_name] != "") {
                            $answer_details['question_part'][] = $_POST[$question_tb_name];
                        }
                    }

                    foreach ($existing_question_parts_data as $key => $existing_question_part) {
                        $question_part_id = $existing_question_part['question_part_id'];

                        if (!in_array($question_part_id, $deleted_question_parts)) {
                            $tc_exsistquestion_tb_name = 'exsistquestion_' . $question_part_id;
                            if (isset($_POST[$tc_exsistquestion_tb_name])) {
                                $question_part_model = QuestionPart::model()->findByPk($question_part_id);
                                $question_part_model->question_part_name = $_POST[$tc_exsistquestion_tb_name];
                                $qpart[$key] = $question_part_model->question_part_name;
                            }
                        }
                    }

                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                        'qtext' => $qtext,
                        'answer_text' => $answertxt,
                        'newans_text' => $answer_details,
                        'qpart' => $qpart
                            ), TRUE, FALSE);
                } else {

                    for ($i = 1; $i <= $tc_max_no_of_answers; $i++) {
                        $answer_tb_name = 'answer_' . $i;
                        if (isset($_POST[$answer_tb_name]) && $_POST[$answer_tb_name] != "") {

                            $answer_details['answers'][] = $_POST[$answer_tb_name];
                        }
                    }

                    for ($i = 1; $i <= $tc_max_no_of_question_parts; $i++) {
                        $question_tb_name = 'question_' . $i;
                        $selectanswer_name = 'selectanswer_' . $i;


                        if (isset($_POST[$question_tb_name]) && $_POST[$question_tb_name] != "") {
                            $answer_details['question_part'][] = $_POST[$question_tb_name];
// $answer_details['selected_answer'][] = $_POST[$selectanswer_name];
                        }
                    }


                    $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                        'qtext' => $qtext,
                        'answer_details' => $answer_details,
                        'answer_text' => null,
                            ), TRUE, FALSE);
                }
            } else if ($qtype == 'DRAG_DROP_TYPED_ANSWER') {
                $result_text = $_POST['result_text'];
                $question_part = $_POST['question_part'];
                $operator_1 = $_POST['operator_1'];
                $answer_1 = $_POST['answer_1'];
                $operator_2 = $_POST['operator_2'];
                $answer_2 = $_POST['answer_2'];


                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                    'qtext' => $qtext,
                    'result_text' => $result_text,
                    'question_part' => $question_part,
                    'operator_1' => $operator_1,
                    'answer_1' => $answer_1,
                    'operator_2' => $operator_2,
                    'answer_2' => $answer_2
                        ), TRUE, FALSE);
            } else if ($qtype == 'DRAG_DROP_TYPEE_ANSWER') {
                $heading_1 = $_POST['heading_1'];
                $heading_2 = $_POST['heading_2'];

                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                    'qtext' => $qtext,
                    //'answer_details' => $answer_details,
                    'heading_1' => $heading_1,
                    'heading_2' => $heading_2), TRUE, FALSE);
            } else if ($qtype == 'MULTIPLE_CHOICE_ANSWER') {

                $heading_1 = $_POST['heading_1'];
                $heading_2 = $_POST['heading_2'];

                $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                    'qtext' => $qtext,
                    //'answer_details' => $answer_details,
                    'heading_1' => $heading_1,
                    'heading_2' => $heading_2), TRUE, FALSE);
            } else if ($qtype == 'ESSAY_ANSWER') {

//echo isset($_POST['essay_type']);die;
                $essay_type = "";
                if (isset($_POST['essay_type'])) {
                    if (($_POST['essay_type'])) {
                        $essay_type = $_POST['essay_type'];
                    } else {

                        $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                            'qtext' => $qtext,
                            'ess_type' => "",
                                ), TRUE, FALSE);
                    }

                    if ($essay_type == 'EMAIL_TYPE') {

                        $email_from = $_POST['email_from'];
                        $email_to = $_POST['email_to'];
                        $email_cc = $_POST['email_cc'];
                        $email_subject = $_POST['email_subject'];

                        $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                            'qtext' => $qtext,
                            'ess_type' => $essay_type,
                            'email_from' => $email_from,
                            'email_to' => $email_to,
                            'email_cc' => $email_cc,
                            'email_subject' => $email_subject,
                                ), TRUE, FALSE);
                    } else if ($essay_type == 'NORMAL_TYPE') {
                        $questions = $this->renderPartial('_preview_question', array('qtype' => $qtype,
                            'qtext' => $qtext,
                            'ess_type' => $essay_type
                                ), TRUE, FALSE);
                    }
                }
            }



            $status = 'success';
            echo CJSON::encode(array(
                'status' => $status,
                'qoutput' => $questions,
                    //'answeroutput' => $answeroutput,
            ));
        } else {
            echo 'not set';
        }
    }

    public function actionGetEssayType() {
        $essay_type = $_POST['essay_type'];

        if ($essay_type == 'NORMAL_TYPE' && $essay_type != "") {
            $this->renderpartial('_normal_essay_type_qs_form');
        } else if ($essay_type == 'EMAIL_TYPE' && $essay_type != "") {
            $this->renderpartial('_email_essay_type_qs_form');
        }
    }

    public function actionDragDropTypeB() {

        if (!empty($_POST['question_part']) && !empty($_POST['answer1']) && !empty($_POST['answer2'])) {

            $message = '';
            $session = $_POST['session_name'];
            $question_part = $_POST['question_part'];
            $answer1 = $_POST['answer1'];
            $answer2 = $_POST['answer2'];
            $count = $_POST['count'];
            $up = $_POST['up'];

            $drag_drop_b_session = Yii::app()->session[$session];

//            var_dump($drag_drop_b_session);die;

            $status = "success";

            if ($status == "success") {
                if ($drag_drop_b_session == NULL) {

                    $drag_drop_b_session = array();
                    $drag_drop_b_session[] = array(
                        "question_part" => $question_part,
                        "answer1" => $answer1,
                        "answer2" => $answer2,
                        "position" => $count
                    );
                    $status = "success";
                    $message = "Question Part Area Added Successfully";
                } else {
                    $item_found = false;

                    foreach ($drag_drop_b_session as $item) {
                        if ($item['question_part'] == $question_part && $item['answer1'] == $answer1 && $item['answer2'] == $answer2) {
                            $item_found = true;
                        }
                    }

                    if ($item_found) {

                        $status = "fail";
                        $message = "Question Part Already Exists!";
                    } else {
                        $change = FALSE;

                        foreach ($drag_drop_b_session as $key => $item) {
                            if ($item['position'] == $count) {//                                
                                $drag_drop_b_session[$key] = array("question_part" => $question_part,
                                    "answer1" => $answer1,
                                    "answer2" => $answer2,
                                    "position" => $count);

                                $change = TRUE;
                            }
                        }

                        if ($change === FALSE) {
                            if (isset($drag_drop_b_session[$count - 1])) {

                                $drag_drop_b_session[$count - 1] = array("question_part" => $question_part,
                                    "answer1" => $answer1,
                                    "answer2" => $answer2,
                                    "position" => $count);
                            } else {
                                $drag_drop_b_session[] = array("question_part" => $question_part,
                                    "answer1" => $answer1,
                                    "answer2" => $answer2,
                                    "position" => $count);
                            }
                        }
                        $status = "success";
                        $message = "Question Part Area Added";
                    }
                }

                Yii::app()->session[$session] = $drag_drop_b_session;

//print_r( Yii::app()->session[$session]);die;
            } else {
                
            }
        } else {
            $message = array();
            if ($_POST['question_part'] == NULL) {
                $message[] = "Question part is not set";
            }
            if ($_POST['answer1'] == NULL) {
                $message[] = "Answer 1 is not set";
            }
            if ($_POST['answer2'] == NULL) {
                $message[] = "Answer 2 is not set";
            }
            $status = "fail";
        }

        echo CJSON::encode(array(
            'status' => $status,
            'message' => $message
                )
        );
    }

    public function actionRemoveDragDropTypeB() {
        if (isset($_POST) && isset($_POST['count'])) {
            $count = $_POST['count'];

            if ($count != NULL) {
                $session_name = $_POST['session_name'];
                $Session = Yii::app()->session[$session_name];

                if ($Session != null) {
                    $i = 0;

                    foreach ($Session as $item) {
                        if ($item['position'] == $count) {
                            unset($Session[$i]);
                            $Session = array_values($Session);
                        }
                        $i++;
                    }
                } else {
                    $Session = array();
                }

//var_dump(Yii::app()->session[$session_name]);die;
                Yii::app()->session[$session_name] = $Session;

                $status = "success";
                $message = "Question Part Successfully Removed";
            } else {
                $status = "fail";
                $message = "Select a Question Part before proceeding";
            }
            echo CJSON::encode(array(
                'status' => $status,
                'message' => $message,
                'count' => $count
            ));
        } else {
            echo "{'status':'error','message':'Invalid request'}";
        }
    }

    public static function getShortWrtnCount() {
        return count(Yii::app()->session['short_written_question_part_session']);
    }

    public function actionViewExample() {
        $qType = $_POST['question_type'];
        $status = "success";

        $questions = $this->renderPartial('_view_example', array('qtype' => $qType), TRUE, FALSE);


        echo CJSON::encode(array(
            'status' => $status,
            'qoutput' => $questions,
                //'answeroutput' => $answeroutput,
        ));
    }

    public function actionQuestionStatistics() {
        $this->render('question_statistics');
    }

    public function actionLoadlevels() {
        $course_id = $_POST['course_id'];
        $levels = Level::model()->getLevelsForCourse($course_id);
        $first_option_set = 0;
        if (count($levels) > 0) {
            if ($first_option_set == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Level', true);
                $first_option_set = 1;
            }

            foreach ($levels as $level) {
                echo CHtml::tag('option', array('value' => $level->level_id), CHtml::encode($level->level_name), true);
            }
        } else {
            echo "<option value=''>Select Level</option>";
        }
    }

    public function actionLoadSubjects() {
        $level_id = $_POST['level_id'];
        $subjectList = Subject::model()->getSubjectsForLevel($level_id);
        $first_option_set = 0;
        if (count($subjectList) > 0) {
            if ($first_option_set == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Subject', true);
                $first_option_set = 1;
            }
            foreach ($subjectList as $subject)
                echo CHtml::tag('option', array('value' => $subject->subject_id), CHtml::encode($subject->subject_name), true);
        } else {
            echo "<option value=''>Select Subject</option>";
        }
    }

    public function actionLoadSubjectAreas() {
        $subject_id = $_POST['subject_id'];
        $subjectAreaList = SubjectArea::model()->getSubjectAreasForSubject($subject_id);
        $first_option_set = 0;
        if (count($subjectAreaList) > 0) {
            if ($first_option_set == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Subject Area', true);
                $first_option_set = 1;
            }
            foreach ($subjectAreaList as $subjectArea)
                echo CHtml::tag('option', array('value' => $subjectArea->subject_area_id), CHtml::encode($subjectArea->subject_area_name), true);
        } else {
            echo "<option value=''>Select Subject Area</option>";
        }
    }

    public function actionLoadQuestions() {
        $subjectAreaID = $_POST['subject_area_id'];
        $questionList = Question::model()->getQuestionsForSubjectArea($subjectAreaID);
        $first_option_set = 0;
        if (count($questionList) > 0) {
            if ($first_option_set == 0) {
                echo CHtml::tag('option', array('value' => ''), 'Select Question', true);
                $first_option_set = 1;
            }
            foreach ($questionList as $question)
                echo CHtml::tag('option', array('value' => $question->question_id), CHtml::encode($question->question_id), true);
        } else {
            echo "<option value=''>Select Question</option>";
        }
    }

    public function actionLoadQuestionAndAnswer() {
        $returnArray = array();

        $question_id = $_POST['question_id'];

        $question = Question::model()->getQuestionObj($question_id);
        $answers = Answer::model()->getAnwersForQuestion($question_id);

        $returnArray['times_appeared'] = PaperQuestion::model()->getNoOfTimesAppeared($question_id);
        $returnArray['times_attempted'] = PaperQuestion::model()->getNoOfTimesAttempted($question_id);
        $returnArray['average_time_for_question'] = round(PaperQuestion::model()->averageTimeForQuestion($question_id), 2);
        $returnArray['no_of_marked'] = PaperQuestion::model()->getNoOfMarked($question_id);
        $returnArray['minimum_time_for_question'] = round(PaperQuestion::model()->minimumTimeForQuestion($question_id), 2);
        $returnArray['maximum_time_for_question'] = round(PaperQuestion::model()->maximumTimeForQuestion($question_id), 2);
        $returnArray['no_of_correct_attempts'] = FinalResult::model()->noOfCorrectAttempts($question_id);
        $returnArray['no_of_incorrect_attempts'] = FinalResult::model()->noOfInCorrectAttempts($question_id);

//        $question_count=$question_count->qcount;
//        echo $question_count;die();
        $returnArray['answer_html'] = $this->renderPartial('_display_question_and_answer', array('question' => $question, 'answers' => $answers), true);
//print_r($returnArray['answer_html']);die();        
        echo CJSON::encode($returnArray);
    }

    public function actionViewReferenceMaterial($id) {
        $this->render('reference_material', array('id' => $id));
    }

    public function actionSetReferenceMaterial() {
        $question_id = $_POST['question_id'];

        $essayQuestionDetails = EssayQuestion::model()->getEssayQuestionDetailsByQId($question_id);
        $essayQuestion = new EssayQuestion;
        $essayQuestion = EssayQuestion::model()->findByPk($essayQuestionDetails['essay_question_id']);
        $essayQuestion->question_id = $question_id;
        $essayQuestion->preseen_material = 0;

        //reference tab titles
        $essayQuestion->reference_material = 0;
        for ($i = 1; $i < 16; $i++) {
            if (isset($_POST["ref_tab_title_$i"])) {
                $tab_title_reference[$i] = $_POST["ref_tab_title_$i"];
                if ($tab_title_reference[$i] != "") {
                    $essayQuestion->reference_material = 1;
                }
            }
        }

        if ($essayQuestion->update()) {
            $essayQuestionId = $essayQuestion->getPrimaryKey();
        } else {
            print_r($essayQuestion->errors);
            die();
        }

        //for reference tabs
        for ($i = 1; $i < 16; $i++) {
            if ($tab_title_reference[$i] != null) {
                if (isset($_POST["ref_answer$i"])) {
                    $checkbox1 = $_POST["ref_answer$i"];
                    if ($checkbox1 == "text_answer$i") {
                        $text1 = $_POST["ref_table_formula_$i"];
                        if ($text1 != null) {
                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;

                            $questionReferenceMaterial_1->question_id = $question_id;
                            $questionReferenceMaterial_1->reference_material_text = $text1;
                            $questionReferenceMaterial_1->reference_file = null;
                            $questionReferenceMaterial_1->reference_tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;

                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {
                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    } else if ($checkbox1 == "image_answer$i") {
                        $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();

                        if ($uploadfile1['name'] != "") {
                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
                            $questionReferenceMaterial_1->question_id = $question_id;
                            $questionReferenceMaterial_1->reference_material_text = null;
                            $questionReferenceMaterial_1->reference_file = $uploadfile1['name'];
                            $questionReferenceMaterial_1->reference_tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $upload_dir = $this->getUploadDirReferenceMaterial($question_id, $i);

                                if (isset($_FILES["ref_file$i"])) {
                                    move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
                                }

                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;

                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {

                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    }
                }
            }
        }

        $this->redirect(array('view', 'id' => $question_id));
    }

    public function actionViewUpdateReferenceMaterial($id) {
        $this->render('edit_reference_material', array('id' => $id));
    }

    public function actionUpdateReferenceMaterial() {
        $question_id = $_POST['question_id'];
        $essayQuestionDetails = EssayQuestion::model()->getEssayQuestionDetailsByQId($question_id);

        $essayQuestion = new EssayQuestion;
        $essayQuestion = EssayQuestion::model()->findByPk($essayQuestionDetails['essay_question_id']);
        $essayQuestion->question_id = $question_id;


        $essayQuestion->reference_material = 0;
        for ($i = 1; $i < 16; $i++) {
            if (isset($_POST["ref_tab_title_$i"])) {
                $tab_title_reference[$i] = $_POST["ref_tab_title_$i"];
                if ($tab_title_reference[$i] != "") {
                    $essayQuestion->reference_material = 1;
                }
            }
        }

        if ($essayQuestion->update()) {
            $essayQuestionId = $essayQuestion->getPrimaryKey();
        } else {
            print_r($essayQuestion->errors);
            die();
        }

        $uploadfile = array();
        for ($i = 1; $i < 16; $i++) {
            $uploadfile[$i] = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
        }


        //delete the existing data
        $table_formula = QuestionReferenceMaterials::model()->findAllByAttributes(array('question_id' => $question_id));
        if (!empty($table_formula)) {
            foreach ($table_formula as $table_formula_data) {
                if (!empty($table_formula_data)) {
                    $tab_position = $table_formula_data->reference_tab_position;
                    if ($_POST["ref_answer$tab_position"] == "image_answer$tab_position") {
                        if ($uploadfile[$tab_position]['name'] != "") {
                            $table_formula_tab = QuestionReferenceMaterialTabs::model()->findByAttributes(array('question_reference_material_id' => $table_formula_data->question_reference_material_id));
                            QuestionReferenceMaterialTabs::model()->deleteByPk($table_formula_tab->question_reference_material_tab_id);
                            QuestionReferenceMaterials::model()->deleteByPk($table_formula_data->question_reference_material_id);
                        }
                    } else {
                        $table_formula_tab = QuestionReferenceMaterialTabs::model()->findByAttributes(array('question_reference_material_id' => $table_formula_data->question_reference_material_id));
                        QuestionReferenceMaterialTabs::model()->deleteByPk($table_formula_tab->question_reference_material_tab_id);
                        QuestionReferenceMaterials::model()->deleteByPk($table_formula_data->question_reference_material_id);
                    }
                }
            }
        }


        for ($i = 1; $i < 16; $i++) {
            $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();
            if ($tab_title_reference[$i] != null) {
                if (isset($_POST["ref_answer$i"])) {
                    $checkbox1 = $_POST["ref_answer$i"];
                    if ($checkbox1 == "text_answer$i") {
                        $text1 = $_POST["ref_table_formula_$i"];
                        if ($text1 != null) {
                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;

                            $questionReferenceMaterial_1->question_id = $question_id;
                            $questionReferenceMaterial_1->reference_material_text = $text1;
                            $questionReferenceMaterial_1->reference_file = null;
                            $questionReferenceMaterial_1->reference_tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;

                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {
                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    } else if ($checkbox1 == "image_answer$i") {
                        $uploadfile1 = isset($_FILES["ref_file$i"]) ? $_FILES["ref_file$i"] : array();

                        if ($uploadfile1['name'] != "") {
                            $questionReferenceMaterial_1 = new QuestionReferenceMaterials;
                            $questionReferenceMaterial_1->question_id = $question_id;
                            $questionReferenceMaterial_1->reference_material_text = null;
                            $questionReferenceMaterial_1->reference_file = $uploadfile1['name'];
                            $questionReferenceMaterial_1->reference_tab_position = $i;

                            if ($questionReferenceMaterial_1->save()) {
                                $questionReferenceMaterial_1_id = $questionReferenceMaterial_1->getPrimaryKey();
                                $upload_dir = $this->getUploadDirReferenceMaterial($question_id, $i);

                                if (isset($_FILES["ref_file$i"])) {
                                    move_uploaded_file($_FILES["ref_file$i"]['tmp_name'], $upload_dir . $uploadfile1['name']);
                                }

                                $model_question_reference_tab_title_1 = new QuestionReferenceMaterialTabs;

                                $model_question_reference_tab_title_1->question_reference_material_id = $questionReferenceMaterial_1_id;
                                $model_question_reference_tab_title_1->reference_tab_title = $tab_title_reference[$i];
                                if ($model_question_reference_tab_title_1->save()) {
                                    
                                } else {
                                    print_r($model_question_reference_tab_title_1->getErrors());
                                    die();
                                }
                            } else {

                                print_r($questionReferenceMaterial_1->errors);
                                die;
                            }
                        }
                    }
                }
            }
        }

        $this->redirect(array('view', 'id' => $question_id));
    }

}
