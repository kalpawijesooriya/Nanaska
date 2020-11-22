<div class="row" style="margin-left: 0px;">

    <select id="selected_questions_1" name="selected_questions_1" multiple="multiple" style="width:400px;height:100px;">
        <!--<option disabled selected>Selected Questions</option>-->
        <?php
        if ($exam_questions != null) {
            $question_session = Yii::app()->session['question_session'];

            foreach ($exam_questions as $exam_question) {
                echo '<option value=' . $exam_question['question_id'] . '>' . $exam_question['question_id'] . '</option>';

                $question_id = $exam_question['question_id'];
                if ($question_id != null) {
                    if ($question_session == null) {
                        $question_session = array();
                        $question_session[] = $question_id;
                    } else {
                        $item_found = false;
                        foreach ($question_session as $item) {
                            if ($item == $question_id) {
                                $item_found = true;
                            }
                        }
                        if (!$item_found) {
                            $question_session[] = $question_id;
                        }
                    }
                }
            }
            Yii::app()->session['question_session'] = $question_session;
        }
        ?>
    </select>
</div>

<br/>

<div class="row" style="margin-left: 0px;">
    <p style="display:none" id="selectedQuestionErr_1" class="alert alert-danger"/>
</div>

<br/>

<div class="row buttons" style="margin-left: 0px;">
    <?php
    echo CHtml::ajaxSubmitButton('Remove Question', CController::createUrl('Exam/removeQuestionFromExam'), array(
        'type' => 'POST', //request type
        'dataType' => 'json',
        'onclick' => 'js:resetDropDown()',
        'data' => array('question_id' => 'js:selected_questions_1.value'),
        'success' => 'function(data){                                       
                                       if(data.status=="success"){
                                            var questionList = document.getElementById("selected_questions_1");
                                            questionList.remove(questionList.selectedIndex);
                                            removeHighlight("selected_questions_1");
                                            document.getElementById("selectedQuestionErr_1").innerHTML="";
                                            document.getElementById("selectedQuestionErr_1").style.display="none";
                                        }else if(data.status=="fail"){
                                            hightlightTextBox("selected_questions_1");
                                            document.getElementById("selectedQuestionErr_1").style.display="block";
                                            document.getElementById("selectedQuestionErr_1").innerHTML="";
                                            document.getElementById("selectedQuestionErr_1").innerHTML=data.message;
                                        }
                                    }'
            ), array('class' => 'greybtn',
        'id' => 'removeBefore')
    );
    ?>
</div>


<script type="text/javascript">

    function resetDropDown(){  
        var subareaDropdown = document.getElementById("subject_area_id");
        var qTypeDropdown = document.getElementById("question_type");
        
        
        if(subareaDropdown!=null && qTypeDropdown!=null){
            $("#subject_area_id option:eq(0)").attr("selected","selected");   
            $("#question_type option:eq(0)").attr("selected","selected"); 
              
            $.ajax({
                url: '<?php echo CController::createUrl('Exam/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data: {
                    //question_id:question_id
                },
                success: function (data) {
                    $('#question_multiple_select').html(data.output);
                }
            });
              
              
              
        }
    }

</script>
