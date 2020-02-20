<script>
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }
</script>

<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("exam_management") == 1) {

    $this->breadcrumbs=array(
            'Answer for Question',
    );
    ?>
    <div class="span8" style="margin-left: -5px">
    <h2 class="light_heading">Mark Essay Question <?php echo $question_id; ?></h2>
    </div>
    
    <input type="hidden" id="question_id" value="<?php echo $question_id; ?>">
    <input type="hidden" id="take_id" value="<?php echo $take_id; ?>">
    <?php
    $question_model = Question::model()->findByPk($question_id);
    $feedback_details = EssayExamFeedback::model()->getFeedbackDetails($take_id, $question_id);
    ?>
    <input type="hidden" id="marks_per_question" value="<?php echo $question_model->number_of_marks; ?>">
    
    <div class="span8" style="margin-left: -5px">
    <h5>Allocated Marks for the Question: <?php echo $question_model->number_of_marks ?></h5>
    <br/>
    <h5>Question Text</h5>
    <div class="well" style="word-wrap: break-word"><?php echo $question_model->question_text; ?></div>
    </div>
    <br/>
    <div class="span8" style="margin-left: -5px">
    <h5>Answer</h5>
    <div class="well" style="word-wrap: break-word"><?php echo PaperQuestion::model()->getAnswerForTheQuestion($take_id, $question_id); ?></div>
    </div>
    <br/>
    <div class="span8" style="margin-left: -5px">
    <h5>Feedback</h5>
    <table class="table">
        <tr>
            <td></td>
            <td><b>Technical Skills</b></td>
            <td><b>Business Skills</b></td>
            <td><b>Peoples Skills</b></td>
            <td><b>Leadership Skills</b></td>    
        </tr>
        <tr>
            <td><b>Comments</b></td>
            <td><textarea id="business_comment" name="business_comment"><?php echo $feedback_details['business_type_comment'];?></textarea></td>
            <td><textarea id="accounting_comment" name="accounting_comment"><?php echo $feedback_details['accounting_type_comment'];?></textarea></td>
            <td><textarea id="leadership_comment" name="leadership_comment"><?php echo $feedback_details['leadership_type_comment'];?></textarea></td>
            <td><textarea id="people_comment" name="people_comment"><?php echo $feedback_details['people_type_comment'];?></textarea></td>    
        </tr>
        <tr>
            <td><b>Marks</b></td>
            <td><input type="text" id="business_mark" name="business_mark" value=<?php echo $feedback_details['business_type_mark'];?>></td>
            <td><input type="text" id="accounting_mark" name="accounting_mark" value=<?php echo $feedback_details['accounting_type_mark'];?>></td>
            <td><input type="text" id="leadership_mark" name="leadership_mark" value=<?php echo $feedback_details['leadership_type_mark'];?>></td>
            <td><input type="text" id="people_mark" name="people_mark" value=<?php echo $feedback_details['people_type_mark'];?>></td>    
        </tr>
        <tr>
            <td><b>Overall Comment</b></td>
            <td colspan="4"><textarea id="overall_comment" name="overall_comment" style="width: 98.5%"><?php echo $feedback_details['overall_comment'];?></textarea></td>
                
        </tr>
        
    </table>
    </div>
    <div class="span8">
    <div class="control-group"><br/>
        <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
    </div>
    </div>
    <div class="span2"  style="margin-left: -5px">
            <?php
            echo CHtml::ajaxbutton('Save Feedback', CController::createUrl('essayAnswer/saveFeedback'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            //'beforeSend' => 'js:tinyMCE.triggerSave()',
            'data' => array(
                'question_id' => 'js:question_id.value',
                'take_id' => 'js:take_id.value',
                'business_comment' => 'js:business_comment.value',
                'accounting_comment' => 'js:accounting_comment.value',
                'leadership_comment' => 'js:leadership_comment.value',
                'people_comment' => 'js:people_comment.value',
                'business_mark' => 'js:business_mark.value',
                'accounting_mark' => 'js:accounting_mark.value',
                'leadership_mark' => 'js:leadership_mark.value',
                'people_mark' => 'js:people_mark.value',
                'overall_comment' => 'js:overall_comment.value',
                'marks_per_question' => 'js:marks_per_question.value',
                
            ),
            'success' => 'function(data){ 

                     if(data[0].status=="success"){
                        removeHighlight("business_mark");
                        removeHighlight("accounting_mark");
                        removeHighlight("leadership_mark");
                        removeHighlight("people_mark");
                        document.getElementById("errorDisplay").innerHTML = "";
                        document.location.href = data[0].redirect_url;
                     }else if(data[0].status=="fail"){
                         document.getElementById("errorDisplay").innerHTML = "";
                        removeHighlight("business_mark");
                        removeHighlight("accounting_mark");
                        removeHighlight("leadership_mark");
                        removeHighlight("people_mark");
                        for(var x=0;x<data[1].length;x++){
                            var element =  data[1][x];
                            hightlightTextBox(element);
                        }

                        for(var x=0;x<data[2].length;x++){
                            var msg =  data[2][x];
                            document.getElementById("errorDisplay").innerHTML=document.getElementById("errorDisplay").innerHTML+msg+"<br />";

                        }

                        document.getElementById("errorDisplay").style.display="block";

                     }
                                        }'
                ), array('class' => 'button button-news',
            'id' => 'save_feedback')
        );
            ?>
        </div>
    
    <?php
    
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
