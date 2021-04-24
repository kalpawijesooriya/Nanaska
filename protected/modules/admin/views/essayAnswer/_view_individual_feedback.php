<?php
    $this->breadcrumbs=array(
            'Feedback for the Question',
    );
    ?>
    <div class="container">
    <div class="span12">
           
    <div class="span8" style="margin-left: -5px">
    <h2 class="light_heading">Feedback for Essay Question <?php echo $question_id; ?></h2>
    </div>
    <?php
    $question_model = Question::model()->findByPk($question_id);
    $feedback_details = EssayExamFeedback::model()->getFeedbackDetails($take_id, $question_id);
    ?>
        
    <div class="span8" style="margin-left: -5px">
    <h5>Allocated Marks for the Question: <?php echo $question_model->number_of_marks ?></h5>
    <br/>
    <h5>Question Text</h5>
    <textarea disabled style="width: 100%; resize: vertical; height: 100px"><?php echo strip_tags($question_model->question_text);?></textarea>
    </div>
    <br/>
    <div class="span8" style="margin-left: -5px">
    <h5>Answer</h5>
    <textarea disabled style="width: 100%; resize: vertical; height: 100px"><?php echo strip_tags(PaperQuestion::model()->getAnswerForTheQuestion($take_id, $question_id));?></textarea>
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
    