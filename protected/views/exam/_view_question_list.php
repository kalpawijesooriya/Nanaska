<style>
    #view-question-num{
        display: none;
    }
</style>

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//var_dump($unanswered_questions);die;
Yii::app()->clientScript->scriptMap=array(
                    'jquery.min.js'=>false,
                    'jquery.js' => false,
                ); 
?>
<div class="wrapper-side-margined-list" id="question-list">

    <h2><?php echo $title; ?></h2>
    <br />
    <ul>
        <?php
        foreach ($question_array as $key => $question) {
            echo '<li>';
            echo CHtml::ajaxLink('Question ' . $question['number'], Yii::app()->createUrl('exam/viewQuestion'), array(
                'type' => 'POST',
                'dataType' => 'json',
                //  'onClick'=>'js:showImage()',
                'data' => array(
                    'question_id' => $question['id'],
                    'question_num' => $question['number']
                ),
                'success' => 'function(data){
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
                            $("#panel-body").html(data.exam_question);
                            showElementsInFooter();
                            showElementsInHeader();
                            $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                            if(data.question_type == "HOT_SPOT_ANSWER"){
                           
                                showImage();
                            }
                            
                            $("#session").html(JSON.stringify(data.session));
                            }',
                'error' => 'function(xhr, status, error) {
                    alert(error);
//                                $("#panel-body").append("<div role="alert" class="alert alert-danger fade in">
//                                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
//                                    <strong>Error!</strong> btebterrb
//                                  </div>");
                            }'
                    ), array(
                'id' => 'question-' . uniqid()
            ));
            echo '</li> <br />';
        }
        ?>
    </ul>
</div>
