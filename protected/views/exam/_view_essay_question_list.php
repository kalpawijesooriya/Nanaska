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
Yii::app()->clientScript->scriptMap = array(
    'jquery.min.js' => false,
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
            echo CHtml::ajaxLink('Question ' . $question['number'], Yii::app()->createUrl('Exam/viewEssayQuestion'), array(
                'type' => 'POST',
                'dataType' => 'json',
                //  'onClick'=>'js:showImage()',
                'data' => array(
                    'question_id' => $question['id'],
                    'question_num' => $question['number']
                ),
                //'update' => '#panel-body',
                'beforeSend' => 'function(jqXHR, settings){ 
                            var isIn = isQuestionNoInSection(' . $question["number"] . ');                               
                            
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
                                           viewUnansweredQuestionConfirmed('.$question['id'].','.$question["number"].');
                                        }
                                    }
                                });
                            }else if(isIn == 2){
                                bootbox.alert("You cannot go back to previous sections.");
                                jqXHR.abort();
                            }
                }',
                'success' => 'function(data){
                    
                            $("#tinymce-div").show();
                            tinyMCE.get("answer").setContent(data.answer);
                            session = JSON.stringify(data.session);
                            $("#question_number_for_time").val(data.next_question_number-1);
                            var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                            latestSection = parseInt(sectionNumberForNext); //current section number                                    
                            var numofSections = localStorage.getItem("numberOfSections");                                    
                            $("#view-question-num").text("Section "+(latestSection)+" of "+numofSections);
                            $("#view-question-num").show();
                           
                            if (data.previous_question_number_count >= 1)
                            {
                                $("#previous").removeAttr("disabled");
                            }
                            
                            if(data.next_question_number <= data.no_of_questions)
                            {
                                $("#next_button").removeAttr("disabled");                                                        
                            }
                            
                            if(data.previous_question_number_count == 0)
                            {
                                $("#previous").prop("disabled",true);
                            }
                            
                           var lastQnumarray = localStorage.getItem("lastQuestionNumArray");
                           
                            localStorage.setItem("storedQuestionNum", data.next_question_number);
                            localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                            document.getElementById("question-body").innerHTML = data.exam_question; 
                            document.getElementById("session").innerHTML = JSON.stringify(data.session);
                            

                            }',
                'error' => 'function(xhr, status, error) {
                    alert(error);

                            }'
                    ), array(
                'id' => 'question-' . uniqid()
            ));
            echo '</li> <br />';
        }
        ?>
    </ul>
</div>
