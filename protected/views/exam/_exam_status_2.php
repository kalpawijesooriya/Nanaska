<?php Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false); ?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles.css');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (count($exam_questions) % 3 === 2) {
    $append_string = '<td></td></tr>';
} else if (count($exam_questions) % 3 === 1) {
    $append_string = '<td></td><td></td></tr>';
} else {
    $append_string = '';
}
?>

<h4>Review Questions</h4>
<div class="wrapper wrapper-side-margined-table exam-status" id="div-exam-status">

    <br /><br /><br />
    <table class="table table-bordered" align="center">
        <?php
        foreach ($exam_questions as $key => $question) {
            if ($question['question_number'] % 3 === 1) {
                echo '<tr>';
            }
            ?>
            <td class="td-exam-question">
                <span class="span-question span-question-flag">
                    <?php
                    if ($question['flag'] !== 0) {
                        echo '<i class="icon-flag"></i>';
                    } else {
                        echo '<i class="icon-flag icon-white"></i>';
                    }
                    ?>
                </span>
                <span class="span-question">


                    <?php
                    echo CHtml::ajaxLink('Question ' . $question['question_number'], array('exam/viewQuestion'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'data' => array(
                            'question_id' => $question['question_id'],
                            'question_num' => $question['question_number']
                        ),
//                        'update' => '#panel-body',
                        'success' => 'js:function(data){
                            showElementsInFooter();
                            $("#question_number_count").val(data.next_question_number);                            
                           
                            if(data.previous_question_number_count == 0){
                                $("#previous").prop("disabled",true);
                            }else{
                                $("#previous").prop("disabled",false);
                            }
                            if(data.next_question_number > data.no_of_questions)
                            {
                                $("#next_button").prop("disabled",true);
                            } else{
                                $("#next_button").prop("disabled",false);
                            }
                            if(data.flag_value == 1)
                            {
                                $("#flag").prop("checked", true);
                            }
                            if(data.flag_value == 0)
                            {
                                $("#flag").prop("checked", false);
                            }
                            $("#previous_question_number_count").val(data.previous_question_number_count);
                            
//                            showElementsInFooter();
                           // $("#panel-body").innerHtml(data.exam_question);
                            document.getElementById("panel-body").innerHTML = data.exam_question;
                            $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                            $("#session").html(JSON.stringify(data.session));
                        }'
                            ), array(
                        'id' => 'question-' . uniqid()
//                                'id'=>  rand(999, 99999999)
                    ));
                    ?>
                </span>
                <span class="span-question span-question-status">
                    <?php
                    if (Util::is_element_empty($question['answer_id'])) {
                        echo 'Incomplete';
                    }
                    ?>
                </span>
            </td>
            <?php
            if ($question['question_number'] % 3 === 0) {
                echo '</tr>';
            }
        }
        echo $append_string;
        ?>
    </table>

</div>

<div id="btn-end" class="wrapper wrapper-side-margined wrapper-top-margined">

    <?php
    echo CHtml::ajaxButton('End Exam', Yii::app()->createUrl('Exam/endExam'), array(
        'type' => 'POST',
        'dataType' => 'json',
        'data' => array(
            'exam_id' => $exam_id,
            'total_exam_time' => 'hhdfhdfhf',
        ),
        'error' => 'js:function(xhr, status, error){
        }',
        'success' => 'js:function(data){
                                      if(data.status="success"){
                                        document.location.href = data.redirect_url; 
                                      }
                                    }'
            ), array(
        'confirm' => 'Are you sure you want to end the exam?',
        'class' => 'btn-large btn-block button button-news',
        'id' => 'exam-status'
    ));
    ?>

    <!--    <button id="exam-end-btn" class="button">End Exam</button>-->

</div>
