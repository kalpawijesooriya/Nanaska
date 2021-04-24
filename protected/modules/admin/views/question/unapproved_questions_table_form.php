<div class="control-group">
    <strong>Lecturer Code&nbsp;&nbsp;</strong>
    <?php
    echo Lecturer::model()->getLecturerCode($lecturer_id);
    ?>
</div>

<div class="control-group">
    <strong>Lecturer Name&nbsp;&nbsp;</strong>

    <?php
    $user_id = Lecturer::getUserIdByLecturerId($lecturer_id);

    $user_data = User::getUserInfoById($user_id);

    echo $user_data['first_name'] . " " . $user_data['last_name'];
    ?>
</div>

<div class="control-group">
    <?php
    echo CHtml::ajaxButton('Send Mail', CController::createUrl('Question/sendMail'), array(
        'type' => 'POST', //request type
        'dataType' => 'json',
        'data' => array(
            //'question_id' => $question['question_id']
            'userid' => $user_id,
            'lecturerid' => $lecturer_id,
        ),
        'beforeSend' => 'function(){
                document.getElementById("emailsuccess-message").innerHTML ="";
                document.getElementById("emailerror-message").innerHTML = "";
                $("#loading").addClass("loading");}',
        'complete' => 'function(){                
                 $("#loading").removeClass("loading");}',
        'success' => 'function(data){ 
                        if(data.status=="success"){
                            document.getElementById("emailsuccess-message").innerHTML = "Email successfully sent";
                        }else{
                            document.getElementById("emailerror-message").innerHTML = "no data to send an email";
                        }
                    }'
            ), array(
        'id' => 'sendmail_btn' . $lecturer_id,
        'class' => 'tinybluebtn',
            )
    );
    ?>

</div>

<div id="loading">
    
</div>

<div class="control-group">
    <p id="emailsuccess-message" style="color: green"></p>
    <p id="emailerror-message" style="color: red"></p>  
</div>


<br/>


<table class="table table-bordered">
    <tr>
        <th width="200">Question ID</th>
        <th width="200">Type</th>
        <th width="200">Date Created</th>
        <th width="200">Action</th>
        <th width="200">Status</th>
    </tr>
    <?php
    if ($questions != null) {
        foreach ($questions as $question) {
            echo '<tr height="30px">';
            echo '<td><center>';
            echo CHtml::link($question['question_id'], array('question/viewQuestion', 'question_id' => $question['question_id']), array('target' => '_blank'));

            echo '</td></center>';
            echo '<td><center>';
            echo Question::model()->getQuestionTypeLabel($question['question_type']);
            echo '</td></center>';
            echo '<td><center>';
            echo $question['date_created'];
            echo '</td></center>';
            echo '<td width="300px"><center>';

            echo CHtml::ajaxButton('Approve', CController::createUrl('Question/approveQuestion'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array(
                    'question_id' => $question['question_id']
                ),
                'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("action_"+data.question_id).innerHTML  = "Approved";
            }
                                    }'
                    ), array(
                'id' => 'approve_' . $question['question_id'],
                'name' => 'approve_' . $question['question_id'],
                'class' => 'bluebtnsmall',
                    )
            );

            echo CHtml::ajaxButton('Dis-Approve', CController::createUrl('Question/disapproveQuestion'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array(
                    'question_id' => $question['question_id']
                ),
                'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("action_"+data.question_id).innerHTML  = "Dis-Approved";
            }
                                    }'
                    ), array(
                'id' => 'disapprove_' . $question['question_id'],
                'name' => 'disapprove_' . $question['question_id'],
                'class' => 'greybtnsmall',
                    )
            );

            echo '</td></center>';
            echo '<td><center>';
            ?>

            <?php
            if ($question['approved'] == 0) {
                ?>

                <b id="action_<?php echo $question['question_id']; ?>">

                    Unapproved
                </b>

                <?php
            } else {
                ?>
                <b id="action_<?php echo $question['question_id']; ?>">

                    Approved
                </b>  

                <?php
            }
            ?>

            <?php
            echo '</td></center>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="5"><center>';
        echo 'No Unapproved Questions For the Selected Lecturer';
        echo '</td></center>';
        echo '</tr>';
    }
    ?>    

</table>

