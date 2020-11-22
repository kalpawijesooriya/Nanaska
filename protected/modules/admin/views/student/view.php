<!--<script type="text/javascript" src="<?php //echo Yii::app()->theme->baseUrl;    ?>/js/plugins/DataTables/media/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl;    ?>/js/plugins/DataTables-1.10.5/media/css/jquery.dataTables.min.css" />-->

<link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
<!--<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>-->
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>

<script type="text/javascript">    
    $(document).ready(function() {         
        $('#tabel_summary').DataTable();
        
        $(".odd").css("background-color", "");
            
        $("#tabel_summary_length").wrap("<div class='span6' style='margin-left:0px;'></div>");
        //$('#tabel_summary_wrapper').find('label').wrap('<div class="span2"></div>');
       
    }); 
</script>
<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("student_management") == 1) {

    $this->breadcrumbs = array(
        'Students' => array('index'),
        $model->student_id,
    );

    $this->menu = array(
        array('label' => 'List Student', 'url' => array('index')),
        array('label' => 'Create Student', 'url' => array('create')),
        array('label' => 'Update Student', 'url' => array('update', 'id' => $model->student_id)),
        //	array('label'=>'Delete Student', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->student_id),'confirm'=>'Are you sure you want to delete this item?')),
        array('label' => 'Manage Student', 'url' => array('admin')),
        array('label' => 'Add Preset Exam', 'url' => array('studentExam/presetExam', 'id' => $model->student_id)),
        array('label' => 'Add Dynamic Exam', 'url' => array('studentExam/dynamicExam', 'id' => $model->student_id)),
        array('label' => 'Add Essay Exam', 'url' => array('studentExam/essayExam', 'id' => $model->student_id)),
    );
    ?>

    <h2 class="light_heading">View Student <?php echo $model->student_id; ?></h2><br/>

    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'student_id',
            'user.first_name',
            'user.last_name',
            'user.email',
            'user.address',
            'user.phone_number',
            array('name' => 'Level', 'value' => Level::model()->getLevelName($model->level_id)),
            array('name' => 'Country', 'value' => Country::model()->getCountryByID($model->user->country_id)),
            array('name' => 'Session', 'value' => Sitting::model()->getSittingByID($model->sitting_id)),
            //'user_id',
            //'level_id',
            //'sitting_id',
            'note',
            array('name' => 'Show Exam Breakdown', 'value' => Student::model()->getDisplayOfExamBreakDown($model->show_exam_breakdown)),
            array('name' => 'Student Type', 'value' => Student::model()->getStudentTypeLabel($model->student_type)),
        //        'show_exam_breakdown',
        //'status'
        ),
    ));
    ?>

    <?php
    $examsOfStudent = StudentExam::model()->getExamsOfStudent($model->student_id);
//print_r($examsOfStudent);
    ?>

    <h4 class="light_heading">Scheduled Exams</h4>
    <table border="1">
        <tr>
            <th width="200">Exam Name</th>
            <th width="200">Exam Type</th>
            <th width="200">Subject</th>
            <th width="200">Start Date</th>
            <th width="200">Expiry Date</th>
        <tr>
            <?php
            foreach ($examsOfStudent as $examOfStudent) {
                $examDetails = Exam::getExamInfoById($examOfStudent['exam_id']);
                $subjectDetails = Subject::getSubjectInfoById($examDetails->subject_id);
                echo '<tr>';
                echo '<td><center>';
                echo $examDetails->exam_name;
                echo '</td></center>';
                echo '<td><center>';
                if ($examDetails->exam_type == "DYNAMIC") {
                    echo 'Dynamic';
                } else if ($examDetails->exam_type == "SAMPLE") {
                    echo 'Sample';
                } else if ($examDetails->exam_type == "PRESET") {
                    echo 'Preset';
                } else if ($examDetails->exam_type == "ESSAY") {
                    echo 'Essay';
                }
                echo '</td></center>';
                echo '<td><center>';
                echo $subjectDetails->subject_name;
                echo '</td></center>';
                echo '<td><center>';
                echo $examOfStudent['start_date'];
                echo '</td></center>';
                echo '<td><center>';
                echo $examOfStudent['expiry_date'];
                echo '</td></center>';
                echo '</tr>';
            }
            ?>    

    </table>
    <br/>

    <div style="clear: both; margin-bottom: 30px;">

        <h4 class="light_heading">Exam Summary</h4>

        <?php
        $exam_ids = Take::model()->getExamIdFromStudentId($model->student_id);
        ?>

        <table border="1" id="tabel_summary" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>Subject</th>
                    <th>Date Taken</th>        
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($exam_ids as $exam_id) {
                    $exam_name = Exam::model()->getExamName($exam_id['exam_id']);
                    $subject_id = Exam::model()->getSubjectForExam($exam_id['exam_id']);
                    $date_taken = Take::model()->getDateTaken($exam_id['exam_id']);
                    echo '<tr>';
                    echo '<td>' . $exam_name . '</td>';
                    echo '<td>' . $subject_id . '</td>';
                    echo '<td>' . $date_taken . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
<!--            <p id="status" style="display:inline">
                <?php // echo 'Active<br/><br/>'; ?>
            </p>-->
            <?php
//        foreach ($examsOfStudent as $examOfStudent) {
//            $examDetails = Exam::getExamInfoById($examOfStudent['exam_id']);
//            $subjectDetails = Subject::getSubjectInfoById($examDetails->subject_id);
//            echo '<tr>';
//            echo '<td><center>';
//            echo $examDetails->exam_name;
//            echo '</td></center>';
//            echo '<td><center>';
//            if ($examDetails->exam_type == "DYNAMIC") {
//                echo 'Dynamic';
//            } else if ($examDetails->exam_type == "SAMPLE") {
//                echo 'Sample';
//            } else if ($examDetails->exam_type == "PRESET") {
//                echo 'Preset';
//            }
//            echo '</td></center>';
//            echo '<td><center>';
//            echo $subjectDetails->subject_name;
//            echo '</td></center>';
//            echo '<td><center>';
//            echo $examOfStudent['expiry_date'];
//            echo '</td></center>';
//            echo '</tr>';
//        }
            ?>    

        </table>
        <br/>
    </div>



    <div style="clear: both;">

        <b>Status: </b>
        <?php
        if ($model->status == 1) {
            ?>
            <p id="status" style="display:inline">
                <?php echo 'Active<br/><br/>'; ?>
            </p>
            <?php
            echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Student/suspend'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('student_id' => $model->student_id),
                'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
                    ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:block')
            );
            echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Student/reactivate'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('student_id' => $model->student_id),
                'success' => 'function(data){    
                           
                               document.getElementById("status").innerHTML = "Active<br/><br/>";
                               document.getElementById("reactivateButton").style.display = "none";
                                document.getElementById("suspendButton").style.display = "block";
                                     
                                    }'
                    ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:none')
            );
        } else if ($model->status == 0) {
            ?>
            <p id="status" style="display:inline">
                <?php echo 'In-Active<br/><br/>'; ?>
            </p>
            <?php
            echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Student/reactivate'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('student_id' => $model->student_id),
                'success' => 'function(){                                       
                                      document.getElementById("status").innerHTML = "Active<br/><br/>";
                                      document.getElementById("reactivateButton").style.display = "none";
                            document.getElementById("suspendButton").style.display = "block";
                                 
                                    }'
                    ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:block')
            );
            echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Student/suspend'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('student_id' => $model->student_id),
                'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
                    ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:none')
            );
        }
        ?>
    </div>
    <?php
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
<br />





