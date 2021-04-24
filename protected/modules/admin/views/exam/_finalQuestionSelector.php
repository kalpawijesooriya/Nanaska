<?php
$questions = Question::model()->getQuestionsBySubjectAreaAndQuestionType($subject_area_id, $question_type);
?>
<script type="text/javascript">
    $(function() {
        $("#questions").bind("dblclick", function() {
            //            window.location.href = "index.php?r=admin/question/view&id=" + $(this).text();
            var question_id = this.value;     
            ajaxCall(question_id);
            // $("#mydialog_" + question_id).dialog("open");
            return false;
        });
    });
</script>

<script type="text/javascript">

    function ajaxCall(question_id){
        $.ajax({
            url:'<?php echo CController::createUrl('Exam/renderDialogBoc'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data:{
                question_id:question_id
            },
            success: function(data){
                if(data[0].status=="success"){
                    $("#mydialog_question").dialog("open");                            
                    if(document.getElementById("dialog_data")!=null){
                        $("#dialog_data").remove();
                    }                         
                          
                    $("#mydialog_question").append(data[0].qoutput); 
                }
            }
        });
    }

</script>


<div class="row">

</div>
<span id="question_multiple_select">
    <div class="well">
        <h2 class="light_heading">Select Questions</h2>

        <div class="form-control">

            <select  id="questions" name="questions" multiple="multiple" style="width:400px;height:100px;">

                <?php
                foreach ($questions as $question) {
                    $Qstatus = Question::model()->checkQuestionStatus($question);
                    if ($Qstatus != 0) {
                        echo '<option value=' . $question . '>' . $question . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <label style="display:none" id="questionErr" class="error"></label>

        <div class="form-control">

            <?php
            echo CHtml::ajaxSubmitButton('Add Question', CController::createUrl('Exam/addQuestionToExam'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('question_id' => 'js:questions.value'),
                'success' => 'function(data){                                       
                           if(data.status=="success"){
                                if(data.warning==1){
                                    alert("Warning! The Selected Question is already used in a paper before.");
                                }
                                var questionList = document.getElementById("selected_questions");
                                var option = document.createElement("option");
                                option.text = data.question_id;
                                option.value = data.question_id;
                                questionList.add(option);
                                removeHighlight("questions");
                                document.getElementById("questionErr").innerHTML="";
                                document.getElementById("questionErr").style.display="none";

                           }else if(data.status=="fail"){
                                hightlightTextBox("questions");
                                document.getElementById("questionErr").style.display="block";
                                document.getElementById("questionErr").innerHTML="";
                                document.getElementById("questionErr").innerHTML=data.message;
                            }
                        }'
                    ), array('class' => 'bluebtn', 'id' => uniqid())
            );
            ?>
        </div><br/>

        <div class="form-control">    

            <select id="selected_questions" name="selected_questions" multiple="multiple" style="width:400px;height:100px;">

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

        <label style="display:none" id="selectedQuestionErr" class="error"></label>


        <div class="form-control">
            <?php
            echo CHtml::ajaxSubmitButton('Remove Question', CController::createUrl('Exam/removeQuestionFromExam'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('question_id' => 'js:selected_questions.value'),
                'success' => 'function(data){                                       
                                       if(data.status=="success"){
                                            var questionList = document.getElementById("selected_questions");
                                            questionList.remove(questionList.selectedIndex);
                                            removeHighlight("selected_questions");
                                            document.getElementById("selectedQuestionErr").innerHTML="";
                                            document.getElementById("selectedQuestionErr").style.display="none";
                                        }else if(data.status=="fail"){
                                            hightlightTextBox("selected_questions");
                                            document.getElementById("selectedQuestionErr").style.display="block";
                                            document.getElementById("selectedQuestionErr").innerHTML="";
                                            document.getElementById("selectedQuestionErr").innerHTML=data.message;
                                        }
                                    }'
                    ), array('class' => 'greybtn')
            );
            ?>
        </div>
    </div>
</span>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_question',
    'options' => array(
        'title' => 'Question ',
        'width' => 1000,
        'height' => 500,
        'autoOpen' => false,
        'resizable' => true,
        'modal' => true,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
