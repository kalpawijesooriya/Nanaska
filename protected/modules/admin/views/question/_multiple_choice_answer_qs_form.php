<script type="text/javascript">

    no_of_answers = 1; //start value of answer row  
    function displayAnswerRoW(count, i) {
        var present = false;

        if (i == no_of_answers) {
            present = false;
        } else {
            present = true;
        }

        if (!present) {
            scount = count;
            no_of_answers++;
            document.getElementById('tr' + no_of_answers + '_' + scount).style.display = 'block';
        }
    }


    function displayAnswerRoW2(count, i, index) {
        var present = false;
        var textIndex = 0;

        for (j = 1; j < 11; j++) {
            var check = document.getElementById('answer_' + j + '_' + count);
            if (check) {
                var value = document.getElementById('answer_' + j + '_' + count).value;
                if (value == " ") {
                    present = true;
                    textIndex = j;
                    break;
                }
            }
        }

        if (index == (textIndex - 1)) {
            present = false;
        } else {
            present = true;
        }

        if (!present) {
            scount = count;
            no_of_answers++;
            var x = i + no_of_answers;
            document.getElementById('tr' + x + '_' + scount).style.display = 'block';
        }

    }

    function removeAnswerRoW(id) {
        document.getElementById('tr' + id).style.display = 'none';
        var a = document.getElementById('answer_' + id).value = "";
    }

    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }

    var deleteCount = 0;
    var answerCount = 1;
    var answerCountArray = [];
</script>
<?php
if ($count == 1) {
    ?>

    <?php
    if ($heading_1 == null) {
        ?>Heading 1 <textarea id="heading_1" name="heading_1" placeholder="Heading 1"></textarea><br/><br/><?php
    } else {
        ?>Heading 1 <textarea id="heading_1" name="heading_1" placeholder="Heading 1"><?php echo $heading_1; ?></textarea><br/><br/><?php
    }
    ?>

    <?php
    if ($heading_2 == null) {
        ?>Heading 2 <textarea id="heading_2" name="heading_2" placeholder="Heading 2"></textarea><br/><br/><?php
    } else {
        ?>Heading 2 <textarea id="heading_2" name="heading_2" placeholder="Heading 2"><?php echo $heading_2; ?></textarea><br/><br/><?php
    }
}
?>

<?php
$max_no_of_answers = 10;
$max_no_of_questions = 10;
?>

<input type="hidden" name="max_no_of_answers" value="<?php echo $max_no_of_answers ?>">
<input type="hidden" name="max_no_of_questions" value="<?php echo $max_no_of_questions ?>">

<?php
if ($edit == null) {
    ?>
    <div id="multiple_choice_answer_form_<?php echo $count ?>" class="well" style="display: none">
        <span style="color: red;display: none" id="correct_answer_error_msg_<?php echo $count ?>">Please select correct answer </span>
        <div class="control-group">
            <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($question_part == null) {
                ?><textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
            } else {
                ?><textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"><?php echo $question_part; ?></textarea><?php
            }
            ?>

                        </div>
                        
        <?php
        $max_no_of_answers = 10;
        $max_no_of_questions = 10;
        ?>

                        <input type="hidden" name="max_no_of_answers" value="<?php echo $max_no_of_answers ?>">
                        <input type="hidden" name="max_no_of_questions" value="<?php echo $max_no_of_questions ?>">

                        <div id="answer_section">
            <?php
            for ($i = 1; $i <= $max_no_of_answers; $i++) {
                ?>
                                                <div style="<?php echo Question::displayStyleAnswer($i) ?>" id="tr<?php echo $i ?>_<?php echo $count ?>">                   

                                                    <table>
                                                        <tr id="table_row_<?php echo $i; ?>_<?php echo $count; ?>">
                                                            <td>
                                                                Answer&nbsp;&nbsp;&nbsp;
                                                            </td> 
                                                            <td>
                                                                <textarea placeholder="Answer" name="answer_<?php echo $i ?>_<?php echo $count ?>" id="answer_<?php echo $i ?>_<?php echo $count ?>" value="" onkeyup="//saveText()" oninput="onInputChangeAnswer('<?php echo $i ?>','<?php echo $count ?>')"></textarea>
                                                                &nbsp;&nbsp;&nbsp;
                                                            </td> 
                                                            <td>
                                                                <input type="radio"  name="iscorrect_<?php echo $count ?>" id="iscorrect_<?php echo $i ?>_<?php echo $count ?>" value="yes"/>&nbsp;&nbsp;Correct Answer
                                                                &nbsp;&nbsp;&nbsp;
                                                            </td>
                                                            <td>
                                <?php
                                echo CHtml::ajaxButton('Add', CController::createUrl('QuestionPart/addAnswerToQuestionPart'), array(
                                    'type' => 'POST', //request type
                                    'dataType' => 'json',
                                    'data' => array(
                                        'question_part' => 'js:question_part_' . $count . '.value',
                                        'answer_text' => 'js:answer_' . $i . '_' . $count . '.value',
                                        'is_correct' => 'js:iscorrect_' . $i . '_' . $count . '.checked',
                                        'count' => $count,
                                        'i' => $i,
                                    ),
                                    'success' => 'function(data){ 
                                    if(data.status=="success"){
                                        answerCount++;
                                        displayAnswerRoW(' . $count . ',' . $i . ');
                                        document.getElementById("save_question_part_' . $count . '").disabled=false;
                                        document.getElementById("save_question_part_' . $count . '").className = "bluebtn";
                                       
                                        document.getElementById("questionAnswer_' . $count . '").innerHTML="";
                                        document.getElementById("questionAnswerRow_' . $count . '").style.display="none";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Remove";                                    
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Added";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "greybtn";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinybluebtn";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                    }else if(data.status=="fail"){
                                        document.getElementById("questionAnswer_' . $count . '").innerHTML=data.message;
                                        document.getElementById("questionAnswerRow_' . $count . '").style.display="block";
                                   
                                    }

                                    }'
                                        ), array('class' => 'btn btn-checkout',
                                    'id' => 'add_question_part_answer_' . $i . '_' . $count,
                                    'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                    'class' => 'bluebtn',
                                        )
                                );
                                ?>
                                                            </td> 

                                                            <td>
                                <?php
                                echo CHtml::ajaxButton('Remove', CController::createUrl('QuestionPart/RemoveAnswerToQuestionPart'), array(
                                    'type' => 'POST', //request type
                                    'dataType' => 'json',
                                    'data' => array(
                                        'session_name' => 'multiple_choice_answer_session',
                                        'count' => $count,
                                        'i' => $i,
                                    ),
                                    'success' => 'function(data){ 
                                    if(data.status=="success"){
                                        document.getElementById("table_row_' . $i . '_' . $count . '").style.display="none";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Removed";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Add";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "bluebtn";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinygreybtn";
                                        document.getElementById("tr' . $i . '_' . $count . '").style.display = "none";
                                        document.getElementById("answer_' . $i . '_' . $count . '").value="";
                                        document.getElementById("iscorrect_' . $i . '_' . $count . '").checked = false;
                                    }else if(data.status=="fail"){
                                        
                                   
                                    }

                                    }'
                                        ), array('class' => 'btn btn-checkout',
                                    'id' => 'remove_question_part_answer_' . $i . '_' . $count,
                                    'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                    'class' => 'tinygreybtn',
                                    'disabled' => 'true'
                                        )
                                );
                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>

                <?php
            }
            ?>
                        </div>


                        <div id="questionAnswerRow_<?php echo $count ?>" style="display:none" class="row"><br/>
                            <p id="questionAnswer_<?php echo $count ?>" class="alert alert-danger2"></p>
                        </div>
                        <br/>


                        <div class="control-group">
            <?php
            $nextcount = $count + 1;
            if ($question_part == null) {
                echo CHtml::ajaxButton('Save', CController::createUrl('QuestionPart/addMultipleChoiceQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'count' => $count,
                        'session_name' => 'multiple_choice_session',
                        'option' => 'js:function(){ 
                                var optionVal="Save";
                                if(document.getElementById("save_question_part_' . $count . '").value=="Save"){
                                    optionVal="Save";
                                }else{
                                    optionVal="Add";
                                }
                                return optionVal; }',
                        'is_correct' => 'js:function(){ 
                                var checkVal=0;                               
                                for(i=1;i<11;i++){
                                    var check = document.getElementById("iscorrect_"+i+"_' . $count . '");
                                    if(check){
                                        var index = document.getElementById("iscorrect_"+i+"_' . $count . '").checked;                                    
                                        if(index){
                                            checkVal=i;
                                            break;
                                        }
                                    }
                                }
                                return checkVal; }',
                    ),
                    'success' => 'function(data){ 
                                    if(data[0].status=="success"  || data[0].status=="success2"){
                                        if(document.getElementById("save_question_part_' . $count . '").value=="Save"){
                                            document.getElementById("save_question_part_' . $count . '").value="Add Question Part";
                                        }else if(document.getElementById("save_question_part_' . $count . '").value=="Add Question Part"){
                                            no_of_answers = 1;
                                    
                                            document.getElementById("multiple_choice_answer_form_' . $nextcount . '").style.display = "block";
                                        
                                            removeHighlight("question_part_' . $count . '");
  
                                            document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                            document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                            document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                            document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";                                    
                                            document.getElementById("save_question_part_' . $count . '").value = "Question Part Added";
                                            document.getElementById("save_question_part_' . $count . '").className = "greybtn";
                                            document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                            
                                        }
                                    }else{
                                        if(data[0].message=="option not selected"){
                                            alert("You have not marked any correct answers");
                                        }else{
                                            if(document.getElementById("save_question_part_' . $count . '").value=="Save"){
                                                removeHighlight("question_part_' . $count . '");  
                                            }else {
                                                if(document.getElementById("save_question_part_' . $count . '").value=="Add Question Part"){
                                                    no_of_answers = 1;

                                                    document.getElementById("multiple_choice_answer_form_' . $nextcount . '").style.display = "block";

                                                    removeHighlight("question_part_' . $count . '");

                                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";

                                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                                    document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";                                    
                                                    document.getElementById("save_question_part_' . $count . '").value = "Question Part Added";
                                                    document.getElementById("save_question_part_' . $count . '").className = "greybtn";
                                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                                    }else{
                                                    removeHighlight("question_part_' . $count . '");

                                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";

                                                    for(var x=0;x<data[1].length;x++){
                                                        var element =  data[1][x];
                                                        hightlightTextBox(element);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'save_question_part_' . $count,
                    'name' => 'save_question_part_' . $count,
                    'class' => 'bluebtn',
                        )
                );
                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('QuestionPart/removeMultiChoiceQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'multiple_choice_answer_session',
                    ),
                    'success' => 'function(data){                                
                                if(data.status=="success"){                                
                                    deleteCount++;
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                    
                                    document.getElementById("question_part_' . $count . '").value="";
                                    for(var x=1; x<11; x++){
                                        
                                        try{
                                            document.getElementById("answer_"+x+"_' . $count . '").value="";
                                        }catch(sc){
                                        
                                        }
                                    }
                                   
                                      document.getElementById("multiple_choice_answer_form_' . $count . '").style.display="none";   
                                    
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                  
                                    
                                    
                               }else{
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'remove_question_part_' . $count,
                    'name' => 'remove_question_part_' . $count,
                    'class' => 'greybtn',
                    'disabled' => 'true'
                        )
                );
            }
            ?>
                        </div>
                    </div>

    <?php
} else {
    //update multiple choice questions
    $session_multiChoice = Yii::app()->session['multiple_choice_answer_session'];
    $sizeOfSession = sizeof($session_multiChoice);
    ?>

    <script>
        document.getElementById("multiple_choice_answer_form_<?php echo $sizeOfSession + 1 ?>").style.display = "block";
    </script>

    <div id="multiple_choice_answer_form_<?php echo $count ?>" class="well" style="display: none">

        <?php if (isset($session_multiChoice[$count - 1][$count - 1])) { ?>

                                            <div class="control-group">
                <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"><?php echo isset($session_multiChoice[$count - 1][$count - 1]['question_part']) ? $session_multiChoice[$count - 1][$count - 1]['question_part'] : " "; ?></textarea>
                                            </div> 

                                            <div id="answer_section">
                <?php
                for ($i = 1; $i < 11; $i++) {
                    ?>
                                                                    <div style="<?php echo Question::model()->displayStyleAnswer2($i, sizeof($session_multiChoice[$count - 1])) ?>" id="tr<?php echo $i ?>_<?php echo $count ?>">

                                                                        <table>
                                                                            <tr id="table_row_<?php echo $i; ?>_<?php echo $count ?>">
                                                                                <td>
                                                                                    Answer&nbsp;&nbsp;&nbsp;
                                                                                </td> 

                                                                                <td>
                                                                                    <textarea name="answer_<?php echo $i ?>_<?php echo $count ?>" id="answer_<?php echo $i ?>_<?php echo $count ?>" oninput="onInputChangeAnswer('<?php echo $i ?>','<?php echo $count ?>')"><?php echo isset($session_multiChoice[$count - 1][$i - 1]['answer_text']) ? $session_multiChoice[$count - 1][$i - 1]['answer_text'] : " "; ?></textarea>
                                                                                    &nbsp;&nbsp;&nbsp;
                                                                                </td>

                                                                                <td>
                                    <?php
                                    // echo $session_multiChoice[$count - 1][$i - 1]['is_correct'];

                                    if (isset($session_multiChoice[$count - 1][$i - 1]['is_correct']) == TRUE) {
                                        //print_r($session_multiChoice[$count - 1][$i - 1]);
                                        if ($session_multiChoice[$count - 1][$i - 1]['is_correct'] == "true") {
                                            ?>
                                                                                    <input type="radio"  name="iscorrect_<?php echo $count ?>" id="iscorrect_<?php echo $i ?>_<?php echo $count ?>" onchange="onInputChangeUpdateForm('<?php echo $count ?>')" checked/>&nbsp;&nbsp;Correct Answer
                                                                                                                            &nbsp;&nbsp;&nbsp;

                                        <?php } else { ?>
                                                                                                                            <input type="radio"  name="iscorrect_<?php echo $count ?>" id="iscorrect_<?php echo $i ?>_<?php echo $count ?>" onchange="onInputChangeUpdateForm('<?php echo $count ?>')"/>&nbsp;&nbsp;Correct Answer
                                                                                                                            &nbsp;&nbsp;&nbsp;

                                            <?php
                                        }
                                    } else {
                                        ?>                                        
                                                                                                        <input type="radio"  name="iscorrect_<?php echo $count ?>" id="iscorrect_<?php echo $i ?>_<?php echo $count ?>" onchange="onInputChangeUpdateForm('<?php echo $count ?>')"/>&nbsp;&nbsp;Correct Answer
                                                                                                        &nbsp;&nbsp;&nbsp;

                                    <?php } ?>

                                                                                </td>


                                                                                <td>
                                    <?php
                                    echo CHtml::ajaxButton('Added', CController::createUrl('QuestionPart/addAnswerToQuestionPart'), array(
                                        'type' => 'POST', //request type
                                        'dataType' => 'json',
                                        'data' => array(
                                            'question_part' => 'js:question_part_' . $count . '.value',
                                            'answer_text' => 'js:answer_' . $i . '_' . $count . '.value',
                                            'is_correct' => 'js:iscorrect_' . $i . '_' . $count . '.checked',
                                            'count' => $count,
                                            'question_part_id' => $question_part_id,
                                            'i' => $i,
                                            'session_name' => 'multiple_choice_answer_session',
                                        ),
                                        'success' => 'function(data){ 
                                            if(data.status=="success"){
                                                answerCount++;
                                                
                                                displayAnswerRoW2(' . $count . ',' . sizeof($session_multiChoice[$count - 1]) . ',' . $i . ');
                                       
                                                document.getElementById("questionAnswer_' . $count . '").innerHTML="";
                                                document.getElementById("questionAnswerRow_' . $count . '").style.display="none";
                                                document.getElementById("remove_question_part_' . $count . '").className = "greybtn";     
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Remove";                                    
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Added";
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "greybtn";
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinybluebtn";
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                                document.getElementById("addd_question_part_' . $count . '").className = "bluebtn";
                                                document.getElementById("addd_question_part_' . $count . '").disabled = false;
                                    
                                            }else if(data.status=="fail"){
                                                document.getElementById("questionAnswer_' . $count . '").innerHTML=data.message;
                                                document.getElementById("questionAnswerRow_' . $count . '").style.display="block";
                                            }
                                        }'
                                            ), array('class' => 'btn btn-checkout',
                                        'id' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'class' => 'greybtn',
                                        'disabled' => 'true'
                                            )
                                    );
                                    ?>
                                                                                </td>

                                                                                <td>
                                    <?php
                                    echo CHtml::ajaxButton('Remove', CController::createUrl('QuestionPart/RemoveAnswerToQuestionPart'), array(
                                        'type' => 'POST', //request type
                                        'dataType' => 'json',
                                        'data' => array(
                                            'session_name' => 'multiple_choice_answer_session',
                                            'question_part_id' => $question_part_id,
                                            'count' => $count,
                                            'i' => $i,
                                        ),
                                        'success' => 'function(data){ 
                                            if(data.status=="success"){
                                                
                                                document.getElementById("table_row_' . $i . '_' . $count . '").style.display="none";
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Removed";
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Add";
                                                document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "bluebtn";
                                                document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinygreybtn";
                                                document.getElementById("answer_' . $i . '_' . $count . '").value="";
                                                document.getElementById("iscorrect_' . $i . '_' . $count . '").checked = false;
                                                document.getElementById("addd_question_part_' . $count . '").className = "bluebtn";
                                                document.getElementById("addd_question_part_' . $count . '").disabled = false;
                                                
                                            }

                                        }'
                                            ), array('class' => 'btn btn-checkout',
                                        'id' => 'remove_question_part_answer_' . $i . '_' . $count,
                                        'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'class' => 'tinybluebtn',
                                            )
                                    );
                                    ?>
                                                                                </td>   

                                                                            </tr>
                                                                        </table>

                                                                    </div>

                    <?php
                }
                ?>

                                            </div>

                                            <div id="questionAnswerRow_<?php echo $count ?>" style="display:none" class="row"><br/>
                                                <p id="questionAnswer_<?php echo $count ?>" class="alert alert-danger2"></p>
                                            </div>

                                            <br/>

                                            <div class="control-group">

                <?php
                $nextcount = $count + 1;

                echo CHtml::ajaxButton('Save Question Part', CController::createUrl('QuestionPart/saveQuestionPartForMultipleChoice'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'count' => $count,
                        'question_part_id' => $question_part_id,
                        'session_name' => 'multiple_choice_answer_session',
                        'is_correct' => 'js:function(){ 
                                var checkVal=0;                               
                                for(i=1;i<11;i++){
                                    var check = document.getElementById("iscorrect_"+i+"_' . $count . '");
                                    if(check){
                                        var index = document.getElementById("iscorrect_"+i+"_' . $count . '").checked;                                    
                                        if(index){
                                            checkVal=i;
                                            break;
                                        }
                                    }
                                }
                                return checkVal; }',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success"  || data[0].status=="success2"){
//                                   
                                    removeHighlight("question_part_' . $count . '");
  
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("addd_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("addd_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                     document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                    
                                    document.getElementById("addd_question_part_' . $count . '").value = "Question Part Added";   
                               }else{
                                    if(data[0].message=="option not selected"){
                                        alert("You have not marked any correct answers");
                                    }else{
                                        removeHighlight("question_part_' . $count . '");

                                        document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                        document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";

                                        for(var x=0;x<data[1].length;x++){
                                            var element =  data[1][x];
                                            hightlightTextBox(element);
                                        }
                                    }
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'addd_question_part_' . $count,
                    'name' => 'addd_question_part_' . $count,
                    'class' => 'greybtn',
                    'disabled' => 'true'
                        )
                );
                ?>
                                                
                <?php
                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('QuestionPart/removeMultiChoiceQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'multiple_choice_answer_session',
                        'question_part_id' => $question_part_id,
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    document.getElementById("multiple_choice_answer_form_' . $count . '").style.display="none";
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("addd_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";     
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    document.getElementById("addd_question_part_' . $count . '").disabled = false;
                                    document.getElementById("addd_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("addd_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                               }else{
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'remove_question_part_' . $count,
                    'name' => 'remove_question_part_' . $count,
                    'class' => 'bluebtn'
                        )
                );
                ?>

                                            </div>



        <?php } else {
            ?>


                                            <div class="control-group">
                <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"></textarea>
                                            </div> 

                                            <div id="answer_section">
                <?php
                for ($i = 1; $i <= $max_no_of_answers; $i++) {
                    ?>
                                                                    <div style="<?php echo Question::displayStyleAnswer($i) ?>" id="tr<?php echo $i ?>_<?php echo $count ?>">                   

                                                                        <table>
                                                                            <tr id="table_row_<?php echo $i; ?>_<?php echo $count; ?>">
                                                                                <td>
                                                                                    Answer&nbsp;&nbsp;&nbsp;
                                                                                </td> 
                                                                                <td>
                                                                                    <textarea placeholder="Answer" name="answer_<?php echo $i ?>_<?php echo $count ?>" id="answer_<?php echo $i ?>_<?php echo $count ?>" onkeyup="//saveText()" oninput="onInputChangeAnswer('<?php echo $i ?>','<?php echo $count ?>')"></textarea>
                                                                                    &nbsp;&nbsp;&nbsp;
                                                                                </td> 
                                                                                <td>
                                                                                    <input type="radio"  name="iscorrect_<?php echo $count ?>" id="iscorrect_<?php echo $i ?>_<?php echo $count ?>" value="yes" onchange="onInputChangeUpdateForm('<?php echo $count ?>')"/>&nbsp;&nbsp;Correct Answer
                                                                                    &nbsp;&nbsp;&nbsp;
                                                                                </td>
                                                                                <td>
                                    <?php
                                    echo CHtml::ajaxButton('Add', CController::createUrl('QuestionPart/addAnswerToQuestionPart'), array(
                                        'type' => 'POST', //request type
                                        'dataType' => 'json',
                                        'data' => array(
                                            'question_part' => 'js:question_part_' . $count . '.value',
                                            'question_part_id' => $question_part_id,
                                            'answer_text' => 'js:answer_' . $i . '_' . $count . '.value',
                                            'is_correct' => 'js:iscorrect_' . $i . '_' . $count . '.checked',
                                            'count' => $count,
                                            'i' => $i,
                                        ),
                                        'success' => 'function(data){ 
                                    if(data.status=="success"){
                                        answerCount++;
                                        answerCountArray[' . $count . ']=answerCount;
                                        displayAnswerRoW(' . $count . ',' . $i . ');
                                       document.getElementById("save_question_part_' . $count . '").value = "Save Question Part";
                                        document.getElementById("save_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("save_question_part_' . $count . '").disabled = false;
                                                
                                        document.getElementById("questionAnswer_' . $count . '").innerHTML="";
                                        document.getElementById("questionAnswerRow_' . $count . '").style.display="none";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Remove";                                    
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Added";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "greybtn";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinybluebtn";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                    }else if(data.status=="fail"){
                                        document.getElementById("questionAnswer_' . $count . '").innerHTML=data.message;
                                        document.getElementById("questionAnswerRow_' . $count . '").style.display="block";
                                   
                                    }

                                    }'
                                            ), array('class' => 'btn btn-checkout',
                                        'id' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'class' => 'bluebtn',
                                            )
                                    );
                                    ?>
                                                                                </td> 

                                                                                <td>
                                    <?php
                                    echo CHtml::ajaxButton('Remove', CController::createUrl('QuestionPart/RemoveAnswerToQuestionPart'), array(
                                        'type' => 'POST', //request type
                                        'dataType' => 'json',
                                        'data' => array(
                                            'session_name' => 'multiple_choice_answer_session',
                                            'question_part_id' => $question_part_id,
                                            'count' => $count,
                                            'i' => $i,
                                        ),
                                        'success' => 'function(data){ 
                                    if(data.status=="success"){
                                        document.getElementById("save_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("save_question_part_' . $count . '").disabled = false;
                                        document.getElementById("table_row_' . $i . '_' . $count . '").style.display="none";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").disabled = true;
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").value = "Removed";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").disabled = false;
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").value = "Add";
                                        document.getElementById("add_question_part_answer_' . $i . '_' . $count . '").className = "bluebtn";
                                        document.getElementById("remove_question_part_answer_' . $i . '_' . $count . '").className = "tinygreybtn";
                                        document.getElementById("answer_' . $i . '_' . $count . '").value="";
                                        document.getElementById("iscorrect_' . $i . '_' . $count . '").checked = false;
                                    }else if(data.status=="fail"){
                                        
                                   
                                    }

                                    }'
                                            ), array('class' => 'btn btn-checkout',
                                        'id' => 'remove_question_part_answer_' . $i . '_' . $count,
                                        'name' => 'add_question_part_answer_' . $i . '_' . $count,
                                        'class' => 'tinygreybtn',
                                        'disabled' => 'true'
                                            )
                                    );
                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                    <?php
                }
                ?>
                                            </div>


                                            <div id="questionAnswerRow_<?php echo $count ?>" style="display:none" class="row"><br/>
                                                <p id="questionAnswer_<?php echo $count ?>" class="alert alert-danger2"></p>
                                            </div>
                                            <br/>


                                            <div class="control-group">
                <?php
                $nextcount = $count + 1;
                if ($question_part == null) {
                    echo CHtml::ajaxButton('Save Question Part', CController::createUrl('QuestionPart/addMultipleChoiceQuestionPart'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'question_part' => 'js:question_part_' . $count . '.value',
                            'count' => $count,
                            'session_name' => 'multiple_choice_session',
                            'option' => 'js:function(){ 
                                var optionVal="Save";
                                if(document.getElementById("save_question_part_' . $count . '").value=="Save Question Part"){
                                    optionVal="Save";
                                }else{
                                    optionVal="Add";
                                }
                                return optionVal; }',
                            'is_correct' => 'js:function(){ 
                                var checkVal=0;                               
                                for(i=1;i<11;i++){
                                    var check = document.getElementById("iscorrect_"+i+"_' . $count . '");
                                    if(check){
                                        var index = document.getElementById("iscorrect_"+i+"_' . $count . '").checked;                                    
                                        if(index){
                                            checkVal=i;
                                            break;
                                        }
                                    }
                                }
                                return checkVal; }',
                        ),
                        'success' => 'function(data){ 
                                    if(data[0].status=="success"  || data[0].status=="success2"){
                                        if(document.getElementById("save_question_part_' . $count . '").value=="Save Question Part"){
                                            document.getElementById("save_question_part_' . $count . '").value="Add Question Part";
                                        }else if(document.getElementById("save_question_part_' . $count . '").value=="Add Question Part"){
                                            no_of_answers = 1;
                                    
                                            document.getElementById("multiple_choice_answer_form_' . $nextcount . '").style.display = "block";
                                        
                                            removeHighlight("question_part_' . $count . '");
  
                                            document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                            document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                            document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                            document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";                                    
                                            document.getElementById("save_question_part_' . $count . '").value = "Question Part Added";
                                            document.getElementById("save_question_part_' . $count . '").className = "greybtn";
                                            document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                            
                                        }
                                    }else{
                                        if(data[0].message=="option not selected"){
                                            alert("You have not marked any correct answers");
                                        }else{
                                            if(document.getElementById("save_question_part_' . $count . '").value=="Save Question Part"){
                                            removeHighlight("question_part_' . $count . '");  
                                        
                                                }else {
                                                    if(document.getElementById("save_question_part_' . $count . '").value=="Add Question Part"){
                                                    no_of_answers = 1;
                                    
                                                    document.getElementById("multiple_choice_answer_form_' . $nextcount . '").style.display = "block";
                                        
                                                    removeHighlight("question_part_' . $count . '");

                                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";

                                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                                    document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";                                    
                                                    document.getElementById("save_question_part_' . $count . '").value = "Question Part Added";
                                                    document.getElementById("save_question_part_' . $count . '").className = "greybtn";
                                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                                    }else{
                                                    removeHighlight("question_part_' . $count . '");

                                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";

                                                    for(var x=0;x<data[1].length;x++){
                                                        var element =  data[1][x];
                                                        hightlightTextBox(element);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'save_question_part_' . $count,
                        'name' => 'save_question_part_' . $count,
                        'class' => 'bluebtn',
                            )
                    );
                    echo '&nbsp;';
                    echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('QuestionPart/removeMultiChoiceQuestionPart'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'count' => $count,
                            'question_part_id' => $question_part_id,
                            'session_name' => 'multiple_choice_answer_session',
                        ),
                        'success' => 'function(data){                                
                                if(data.status=="success"){                                
                                    deleteCount++;
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="none";
                                    
                                    document.getElementById("question_part_' . $count . '").value="";
                                    for(var x=1; x<11; x++){
                                        
                                        try{
                                            document.getElementById("answer_"+x+"_' . $count . '").value="";
                                        }catch(sc){
                                        
                                        }
                                    }
                                   
                                      document.getElementById("multiple_choice_answer_form_' . $count . '").style.display="none";   
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    document.getElementById("addd_question_part_' . $count . '").disabled = false;
                                    document.getElementById("addd_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("addd_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                  
                                    
                                    
                               }else{
                                    document.getElementById("multipleChoiceErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("multipleChoiceErrorDisplayRow_' . $count . '").style.display="block";   
                               }
                             }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'remove_question_part_' . $count,
                        'name' => 'remove_question_part_' . $count,
                        'class' => 'greybtn',
                        'disabled' => 'true'
                            )
                    );
                }
                ?>
                                            </div>

        <?php }
        ?>


                    </div>
    <?php
}
?>




<div id="multipleChoiceErrorDisplayRow_<?php echo $count ?>" style="display:none">
    <label id="multipleChoiceErrorDisplay_<?php echo $count ?>" class="error"></label>
</div>

<script>
    document.getElementById("multiple_choice_answer_form_1").style.display = "block";
</script>


<script type="text/javascript">
    function checkMultipleChoice() {
        var element = deleteCount + 1;

        //var headingElement_1 = document.getElementById("heading_1");
        //var headingElement_2 = document.getElementById("heading_2");
        var qpartElement = document.getElementById("question_part_" + element);
        var answerElement1 = document.getElementById("answer_1_" + element);

        //error = checkElement(headingElement_1);
        //error = checkElement(headingElement_2);
        error = checkElement(qpartElement);
        error = checkElement(answerElement1);

        if (error == 1) {
            return false;
        } else {
            return true;
        }

    }
    function onInputChange(no) {
        document.getElementById("save_question_part_" + no).className = "bluebtn";//attr('class', 'bluebtn');
        document.getElementById("remove_question_part_" + no).className = "greybtn";//.attr('class', 'greybtn');
        document.getElementById("save_question_part_" + no).value = "Save";
        document.getElementById("save_question_part_" + no).disabled = false;
    }

    function onInputChangeAnswer(i, no) {
        document.getElementById("add_question_part_answer_" + i + "_" + no).className = "bluebtn";//attr('class', 'bluebtn');
        document.getElementById("remove_question_part_answer_" + i + "_" + no).className = "tinygreybtn";
        document.getElementById("add_question_part_answer_" + i + "_" + no).value = "Add";
        document.getElementById("add_question_part_answer_" + i + "_" + no).disabled = false;
    }
    
    function onInputChangeUpdateForm(no) {
        document.getElementById("addd_question_part_" + no).className = "bluebtn";//attr('class', 'bluebtn');
        document.getElementById("remove_question_part_" + no).className = "greybtn";//.attr('class', 'greybtn');
        document.getElementById("addd_question_part_" + no).value = "Save Question Part";
        document.getElementById("addd_question_part_" + no).disabled = false;
    }
</script>

