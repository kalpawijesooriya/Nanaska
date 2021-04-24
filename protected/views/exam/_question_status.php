<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="vql">

    <span class="span-question span-question-flag">
        <?php
        if ($data['flag'] !== 0) {
            echo '<i class="icon-flag"></i>';
        } else {
            echo '<i class="icon-flag icon-white"></i>';
        }
        ?>
    </span>

    <span class="span-question">

        <?php
        if ($time_status == Consts::STATUS_TIME_REMAINS) {
            echo CHtml::ajaxLink('Question ' . $data['question_number'], array('exam/viewQuestion'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'onClick' => 'js:showElementsInFooter(), js:showElementsInHeader()',
                'data' => array(
                    'question_id' => $data['question_id'],
                    'question_num' => $data['question_number']
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
                            //alert(data.exam_question);
//                            showElementsInFooter();
                           // $("#panel-body").innerHtml(data.exam_question);
                            document.getElementById("panel-body").innerHTML = data.exam_question;
                            if(data.question_type == "HOT_SPOT_ANSWER"){
                                showImage();
                                
                            }
                            $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                            $("#session").html(JSON.stringify(data.session));
                        }'
                    ), array(
                'id' => 'question-' . uniqid()
//                                'id'=>  rand(999, 99999999)
            ));
        } else {
            echo 'Question ' . $data['question_number'];
        }
        ?>
    </span>

    <span id="span-question-status" class="span-question span-question-status">
        <?php
        if (Util::is_element_empty($data['answer_id'])) {
            echo '<span style="color:red;">Incomplete</span>';
        } else {
            echo '<span style="color:green;">Complete</span>';
        }
        ?>
    </span>

</div>

