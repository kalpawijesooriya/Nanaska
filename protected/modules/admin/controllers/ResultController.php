<?php

class ResultController extends Controller {

    public $layout = '/layouts/column2';

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'viewResultPerStudent', 'getResultPerSubject', 'ExportToExcel',
                    'getResultsPerSubjectArea', 'getResultPerBatch','renderBlank','generatePDF'),
                'users' => array('@'),
                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array(),
//                'users' => array('@'),
//                'expression' => '$user->loadUser()->user_type == "LECTURER" || $user->loadUser()->user_type == "SUPERADMIN"',
//            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionViewResultPerStudent() {
        $this->render('results_per_student');
    }

    public function actionViewResultPerExam() {
        $this->render('results_per_exam');
    }

    public function actionViewResultPerSubject() {
        $this->render('results_per_subject');
    }

    public function actionViewResultPerSubjectArea() {
        $this->render('results_per_subject_area');
    }

    public function actionViewResultPerBatch() {
        $this->render('results_per_batch');
    }

    public function actionGetResultPerSubject() {
        $subject_id = $_POST['subject_id'];

        echo $this->renderPartial('subject_results', array('subject_id' => $subject_id), false, true);
    }

    public function actionGeneratePDF(){
        ob_start();
        //$this->renderPartial('_exam_description', array('model' => $model), false, true);
        
        //pdf for result per subject
        if($_POST['pdf_type']=="per_subject"){
            $content = $this->renderPartial('pdf_content_per_subject', 
                    array('subject' => Subject::model()->getSubjectName($_POST['selected_subject']),
                        'level' => Level::model()->getLevelName($_POST['selected_level']),
                        'course' => Course::model()->getCourseName($_POST['selected_course']),
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        if($_POST['pdf_type']=="per_exam"){
            $content = $this->renderPartial('pdf_content_per_exam', 
                    array('subject' => Subject::model()->getSubjectName($_POST['selected_subject']),
                        'level' => Level::model()->getLevelName($_POST['selected_level']),
                        'course' => Course::model()->getCourseName($_POST['selected_course']),
                        'from' => $_POST['selected_from_date'],
                        'to' => $_POST['selected_to_date'],
                        'exam' => Exam::getExamName($_POST['selected_exam']),
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        if($_POST['pdf_type']=="per_subject_area"){
            $content = $this->renderPartial('pdf_content_per_subject_area', 
                    array('subject' => Subject::model()->getSubjectName($_POST['selected_subject']),
                        'level' => Level::model()->getLevelName($_POST['selected_level']),
                        'course' => Course::model()->getCourseName($_POST['selected_course']),
                        'subject_area' => SubjectArea::model()->getSubjectAreaName($_POST['selected_subject_area']),
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        if($_POST['pdf_type']=="per_batch"){
            $content = $this->renderPartial('pdf_content_per_batch', 
                    array('subject' => Subject::model()->getSubjectName($_POST['selected_subject']),
                        'level' => Level::model()->getLevelName($_POST['selected_level']),
                        'course' => Course::model()->getCourseName($_POST['selected_course']),
                        'exam' => Exam::getExamName($_POST['selected_exam']),
                        'sitting'=>  Sitting::model()->getSittingByID($_POST['selected_sitting']),
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        if($_POST['pdf_type']=="per_student"){
            $content = $this->renderPartial('pdf_content_per_student', 
                    array('subject' => Subject::model()->getSubjectName($_POST['selected_subject']),
                        'course' => $_POST['selected_course'],
                        'level' => $_POST['selected_level'],
                        'exam' => Exam::getExamName($_POST['selected_exam']),
                        'take'=> $_POST['selected_take'],
                        'student_email'=> $_POST['selected_student_email'],
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        if($_POST['pdf_type']=="export"){
            $content = $this->renderPartial('pdf_content_export', 
                    array(
                        'exam' => Exam::getExamName($_POST['selected_exam']),
                        'student_email'=> $_POST['selected_student_email'],
                        'results'=>$_POST['pdf_content']
                        ), true);
        }
        
        $content_with_layout=$this->renderPartial('pdf_layout', array('content'=>$content),true);
        
        //$content=$_POST['pdf_content'];
        
        //var_export(htmlentities($content)); die;
        $margins = array(1, 1, 1, 1);
        Yii::import('application.extensions.html2pdf.*');
        require_once('html2pdf.class.php');
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', $margins);
        //$html2pdf->addFont('roboto', '', 'roboto.php');
        $html2pdf->WriteHTML($content_with_layout, false);
        $html2pdf->Output('result_management.pdf', 'D');
    }


    
    public function actionExportToExcel() {
        $this->render('export');
    }

    public function actionGetResultsPerSubjectArea() {
        $subject_area_id = $_POST['subject_area_id'];
        $subject_id = $_POST['subject_id'];

        echo $this->renderPartial('subject_area_results', array('subject_id' => $subject_id, 'subject_area_id' => $subject_area_id), false, true);
    }

    public function actionGetResultPerBatch() {
        $sitting_id = $_POST['sitting_id'];
        $exam_id = $_POST['exam_id'];

        $student = Student::model()->getStudentsBySittingId($sitting_id);

        $passMark = Exam::model()->getPasmark($_POST['exam_id']);
        $passCount = 0;
        $failCount = 0;

        foreach ($student as $student_details) {
            $take_ids[] = Take::model()->getTakeIdsforExamIdandStudentId($exam_id, $student_details['student_id']);
        }
        //var_dump($take_ids); die;

        if (!empty($take_ids)) {
            foreach ($take_ids as $take) {
                if (!empty($take)) {
                    foreach ($take as $take_id) {
                        $exam_id = Take::model()->getExamIdOfTake($take_id['take_id']);
                        $exam_model = new Exam;
                        $exam_model = Exam::model()->findByPk($exam_id);
                        $total_marks = 0;
                        $time_taken = 0;
                        if($exam_model->exam_type == "ESSAY"){
                            $take_model = new Take;
                            $take_model = Take::model()->findByPk($take_id['take_id']);
                            if($take_model->status == 1){
                                $total_marks = Take::model()->getResultOfTheTake($take_id['take_id'], 1);
                                $time_taken = PaperQuestion::model()->getTotalTimeTaken($take_id['take_id']);

                                $take_id_marks[$take_id['take_id']] = $total_marks;
                                $take_id_time_taken[$take_id['take_id']] = $time_taken;

                                if ($passMark <= $total_marks) {
                                    $passCount++;   //number of studens passed the exam
                                } else {
                                    $failCount++;  //number of students failed the exam
                                }
                            }
                        }else{
                            $marks_array = FinalResult::model()->getFinalResultById($take_id['take_id']);
                            
                            foreach ($marks_array as $marks) {
                                $total_marks = $total_marks + $marks['mark'];
                                $time_taken = $time_taken + $marks['time_taken'];
                            }
                            $take_id_marks[$take_id['take_id']] = $total_marks;
                            $take_id_time_taken[$take_id['take_id']] = $time_taken;

                            if ($passMark <= $total_marks) {
                                $passCount++;   //number of studens passed the exam
                            } else {
                                $failCount++;  //number of students failed the exam
                            }
                        }
                            
                        
//                        echo $total_marks ; die;
                        
                    }
                }
            }
            if (isset($take_id_marks)) {
                //maximum, minimum and average marks
                $highest_marks = max($take_id_marks);
                $lowest_marks = min($take_id_marks);
                $average_marks = array_sum($take_id_marks) / count($take_id_marks);

                //maximum, minimum and average time
                $highest_time = max($take_id_time_taken);
                $lowest_time = min($take_id_time_taken);
                $average_time = array_sum($take_id_time_taken) / count($take_id_time_taken);

                echo $this->renderPartial('highest_average_marks', array('passCount'=>$passCount, 'failCount'=>$failCount,'highest_marks' => $highest_marks, 'lowest_marks' => $lowest_marks, 'average_marks' => $average_marks, 'highest_time' => $highest_time, 'lowest_time' => $lowest_time, 'average_time' => $average_time));
            } else {
                echo '<h5>no records found...</h5>';
            }
        }
    }
    
    
    public function actionRenderBlank(){
        $output = $this->renderPartial('_blank_form',"", false, true);
        
         echo CJSON::encode(array(
               // 'status' => $status,
                'output' => $output,
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
