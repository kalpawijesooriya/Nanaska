<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("essay_answer_management") == 1) {

    $this->breadcrumbs=array(
            'Answers Script',
    );
    ?>

    <h2 class="light_heading">Answer Script <?php echo $model->take_id; ?></h2><br/>

    <?php
    
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'date',
            'exam_id',
            array('name' => 'Exam Name', 'value' => Exam::model()->getExamName($model->exam_id)),
            array('name' => 'Exam Description', 'value' => CHtml::encode(Exam::model()->getExamDescription($model->exam_id))),
            array('name' => 'Course', 'value' => Exam::model()->getExamCourseName($model->exam_id)),
            array('name' => 'Level', 'value' => Exam::model()->getExamLevelName($model->exam_id)),
            array('name' => 'Subject', 'value' => Exam::model()->getExamSubjectName($model->exam_id)),
            array('name' => 'Student Email', 'value' => Student::model()->getStudentEmailByUserID($model->student->user_id)),
            array('name' => 'Student Name', 'value' => Student::model()->getStudentNameByUserID($model->student->user_id)),
            array('name' => 'Status', 'value' => Take::model()->getMarkOrUnmark($model->status)),
            array('name' => 'Total Marks', 'value' => Take::model()->getResultOfTheTake($model->take_id, $model->status)),

        ),
    ));
    
     
    $examSections = EssayAnswer::model()->getSectionsOfExamByTakeId($model->take_id);
    //var_dump($examSections);die;
    echo '<h3 class="light_heading">Exam Sections</h3>';
    foreach ($examSections as $examSection) {
        echo '<h4>Section ' . $examSection['section_no'] . '</h4>';
        $sectionQuestions = EssayAnswer::model()->getQuestionsOfExamByTakeIdSectionNo($model->take_id, $examSection['section_no']);
        ?>

        <table class="table">
        <tr>
            <td width="300">
            <center><strong>Question ID</strong></center>
            </td>
            <td width="300">
            <center><strong>Question</strong></center>
            </td>
            <td width="300">
            <center><strong>Status</strong></center>
            </td>
            <td width="300">
            <center><strong>Mark</strong></center>
            </td>
            <td width="300">
            <center></center>
            </td>
        </tr>

        <?php
        foreach ($sectionQuestions as $sectionQuestion) {
            $questionData = Question::model()->getQuestion($sectionQuestion['question_id']);
                echo '<tr>';

                    echo '<td width="300">';
                    echo '<center>';
                    echo $sectionQuestion['question_id'];
                    echo '</center>';
                    echo '</td>';

                    echo '<td width="300">';
                    echo '<center>';
                    echo '<input class="bluebtnsmall" type="button" value="View" onclick="openQuestion('.$sectionQuestion['question_id'].')">';
                    echo '</center>';
                    echo '</td>';
                    
                    echo '<td width="300">';
                    echo '<center>';
                    echo $temp_status = EssayAnswer::model()->getStatus($model->take_id, $sectionQuestion['question_id']);
                    echo '</center>';
                    echo '</td>';
                    
                    echo '<td width="300">';
                    echo '<center>';
                    if($temp_status == "Marked"){
                        echo round(EssayAnswer::model()->getMarkForTheQuestion($model->take_id, $sectionQuestion['question_id']), 2).'%';
                    }else{
                        echo 'Pending';
                    }
                    echo '</center>';
                    echo '</td>';
                    
                    echo '<td width="300">';
                    echo '<center>';
                    if($temp_status == "Marked"){
                    echo CHtml::link(CHtml::encode("Re-Mark"), array('essayAnswer/viewIndividualAnswer','take_id' => $model->take_id, 'question_id' => $sectionQuestion['question_id']));
                        }else{
                    echo CHtml::link(CHtml::encode("Mark"), array('essayAnswer/viewIndividualAnswer','take_id' => $model->take_id, 'question_id' => $sectionQuestion['question_id']));
                    }
            
                    echo '</center>';
                    echo '</td>';                    
                    
                echo '</tr>';
        }

        echo '</table>';
        echo '<br/><br/>';
    }
    
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
$questions = EssayAnswer::model()->getQuestionsOfExamByTakeId($model->take_id);
foreach($questions as $question){
?>
    <div id="question_details">
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'question_dialog_'.$question['question_id'],
                'options' => array(
                    'title' => 'Question',
                    'width' => '800',
                    'height' => '500',
                    'autoOpen' => false,
    //            'show' => array(
    //                'effect' => 'toggle',
    //                'duration' => 400,
    //            ),
                    'resizable' => true,
                    'modal' => false,
                    'overlay' => array(
                        'backgroundColor' => '#000',
                        'opacity' => '0.5'
                    ),
                ),
            ));

            echo $this->renderPartial('view_question',array('question_id' => $question['question_id']));
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
    </div>
        <?php
}       
        ?>
<script type="text/javascript">
    function openQuestion(question_no) {
        $("#question_dialog_"+question_no).dialog("open");
        return false;
    }


</script>