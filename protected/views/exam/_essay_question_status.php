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
            //echo '<i class="icon-flag"></i>';
        } else {
            //echo '<i class="icon-flag icon-white"></i>';
        }
        ?>
    </span>

    <span class="span-question">
        
        <?php
        if ($time_status == Consts::STATUS_TIME_REMAINS) {
            echo CHtml::ajaxLink('Question ' . $data['question_number'], array('exam/viewEssayQuestion'), array(
                'type' => 'POST',
                'dataType' => 'json',
                //'onClick' => 'js:showElementsInFooter(), js:showElementsInHeader()',
                'data' => array(
                    'question_id' => $data['question_id'],
                    'question_num' => $data['question_number']
                ),
                //'update' => '#panel-body',
                'beforeSend' => 'function(jqXHR, settings){ 
                            var isIn = isQuestionNoInSection('.$data["question_number"].');
                            if(isIn == 1){
                              jqXHR.abort();                            
                                var sectionNumber = localStorage.getItem("sectionNumForNextbtn");
                              
                                var unAnswered = getUnansweredQuestions(sectionNumber, session);
                                var messageConfirm = "";
                                
                                if(unAnswered == 0){
                                    messageConfirm = "You have chosen to end the current section. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                                }else{
                                    messageConfirm = "You have chosen to end the current section, but have "+unAnswered+" incomplete question. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                                }
                                
                                bootbox.confirm({
                                    title: "End Section",
                                    message: messageConfirm,
                                    callback: function (result) {
                                        if (result === true) {
                                           viewUnansweredQuestionConfirmed('.$data['question_id'].','.$data["question_number"].');
                                        }
                                    }
                                });
                            }else if(isIn == 2){
                                bootbox.alert("You cannot go back to previous sections.");
                                jqXHR.abort();
                            }
                }',
                'success' => 'js:function(data){
                            $("#tinymce-div").show();
                            tinyMCE.activeEditor.setContent(data.answer); 
                            $("#question_number_for_time").val(data.next_question_number-1);
                          
                             var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                            latestSection = parseInt(sectionNumberForNext); //current section number                                    
                            var numofSections = localStorage.getItem("numberOfSections");                                    
                           $("#view-question-num").text("Section "+(latestSection)+" of "+numofSections);
                           $("#view-question-num").show();
                           
                            if(data.next_question_number <= data.no_of_questions)
                            {
                                $("#next_button").removeAttr("disabled");                                                        
                            }
                            if(data.previous_question_number_count == 0)
                            {
                                $("#previous").prop("disabled",true);
                            }
                            
                            localStorage.setItem("storedQuestionNum", data.next_question_number);
                            localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                            document.getElementById("question-body").innerHTML = data.exam_question; 
                            //document.getElementById("session").innerHTML = JSON.stringify(data.session);
                            $("#panel-body").scrollTop(0);
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


