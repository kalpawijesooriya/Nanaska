<?php
    $this->breadcrumbs=array(
            'Feedback for the Question',
    );
    ?>
    <div id="dialog_data" class="container">
    <div class="span12">
           
    <div class="span8" style="margin-left: -5px">
    <h2 class="light_heading">Feedback for Essay Question</h2>
    </div>
    <?php
    $question_model = Question::model()->findByPk($question_id);
    $feedback_details = EssayExamFeedback::model()->getFeedbackDetails($take_id, $question_id);
    ?>
        
    <div class="span8" style="margin-left: -5px">
    <h5>Allocated Marks for the Question: <?php echo $question_model->number_of_marks ?></h5>
    <br/>
    <h5>Question Text</h5>
    <div class="well" style="word-wrap: break-word"><?php echo $question_model->question_text;?></div>
    </div>
    <br/>
    <div class="span8" style="margin-left: -5px">
    <h5>Answer</h5>
    <div class="well" style="word-wrap: break-word"><?php echo PaperQuestion::model()->getAnswerForTheQuestion($take_id, $question_id);?></div>
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
            <td><?php echo $feedback_details['business_type_comment'];?></td>
            <td><?php echo $feedback_details['accounting_type_comment'];?></td>
            <td><?php echo $feedback_details['leadership_type_comment'];?></td>
            <td><?php echo $feedback_details['people_type_comment'];?></td>    
        </tr>
        <tr>
            <td><b>Marks</b></td>
            <td><?php echo $feedback_details['business_type_mark'];?></td>
            <td><?php echo $feedback_details['accounting_type_mark'];?></td>
            <td><?php echo $feedback_details['leadership_type_mark'];?></td>
            <td><?php echo $feedback_details['people_type_mark'];?></td>    
        </tr>
        <tr>
            <td><b>Overall Comment</b></td>
            <td colspan="4"><?php echo $feedback_details['overall_comment'];?></td>
                
        </tr>
        
    </table>
    </div>
    </div>
        </div>
    