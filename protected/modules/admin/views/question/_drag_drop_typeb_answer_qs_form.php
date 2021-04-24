<script type="text/javascript">
    var k=0; 
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }
    
    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";     
    }
    
    var deleteCount=0;
</script>

<?php
if ($count == 1) {
    ?>
    <h4>Drag Drop Type B Question</h4>
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
        ?>Heading 2 <textarea id="heading_2" name="heading_2" placeholder="Heading 2" ><?php echo $heading_2; ?></textarea><br/><br/><?php
    }
}
?>

<?php
if ($edit == null) {
    ?><div id="drag_drop_type_b_<?php echo $count ?>" class="well span9 no-left-margin" style="display: none"><?php
} else {
    ?><div id="drag_drop_type_b_<?php echo $count ?>" class="well span9 no-left-margin" style="display: block"><?php
}
?>

        <div class="control-group">
            <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($question_part == null) {
                ?><textarea id="question_part_<?php echo $count ?>" name="question_part[<?php echo 'null'; ?>]" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="question_part_<?php echo $count ?>" name="question_part[<?php echo $questio_part_id; ?>]" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"><?php echo $question_part; ?></textarea><?php
        }
            ?>
        </div>

        <div class="control-group">
            <?php echo 'Answer 1'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($answer == null) {
                ?><textarea id="answer1_<?php echo $count ?>" name="answer[<?php echo 'null' ?>]" placeholder="Answer 1" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
            $answer_count = count($answer);
            for ($c = 0; $c < $answer_count - 1; $c++) {
                    ?>
                    <textarea id="answer1_<?php echo $count ?>" name="answer[<?php echo $answer[$c]; ?>]" placeholder="Answer 1" oninput="onInputChange('<?php echo $count ?>')"><?php echo AnswerText::getAnswerTextById($answer[$c]); ?></textarea><?php
        }
    }
            ?>

        </div>

        <div class="control-group">
            <?php echo 'Answer 2'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($answer == null) {
                ?><textarea id="answer2_<?php echo $count ?>" name="answer[<?php echo 'null'; ?>]" placeholder="Answer 2" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {

            for ($c = 1; $c < $answer_count; $c++) {
                    ?><textarea id="answer2_<?php echo $count ?>" name="answer[<?php echo $answer[$c]; ?>]"  placeholder="Answer 1" oninput="onInputChange('<?php echo $count ?>')"><?php echo AnswerText::getAnswerTextById($answer[$c]); ?></textarea><?php
        }
    }
            ?>

        </div>

        <input type="hidden" id="qparts" value="<?php echo $question_part; ?>" />


        <div class="control-group">
            <?php
            $nextcount = $count + 1;

            if ($question_part == null) {

                echo CHtml::ajaxButton('Add Question Part', CController::createUrl('Question/DragDropTypeB'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part_count' => 'js:document.getElementById("question_part_count").value',
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'answer1' => 'js:answer1_' . $count . '.value',
                        'answer2' => 'js:answer2_' . $count . '.value',
                        'count' => $count,
                        'up' => 'js:document.getElementById("update_ff").value',
                        'session_name' => 'drag_drop_typeb_session'
                    ),
                    'success' => 'function(data){
                                    if(data.status == "success")
                                    {
                                        document.getElementById("drag_drop_type_b_' . $nextcount . '").style.display = "block";
                                        document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                            

                                        
                                        document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                        
                                        document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                        document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                        document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                        document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    }else if(data.status == "success2"){
                                        document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                        document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                        
                                        document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                            document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                        document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                        document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    }
                                    
                                    else if(data.status == "fail")
                                    {                                      
                                       document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data.message;
                                       document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                    }
                                  }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'add_question_part_' . $count,
                    'name' => 'add_question_part_' . $count,
                    'class' => 'bluebtn',
                ));


                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('Question/removeDragDropTypeB'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'drag_drop_typeb_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    deleteCount++;
                                    var x = document.getElementById("qparts");
                                    RemoveText(x.value);
                                    
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                       
                                    document.getElementById("drag_drop_type_b_' . $count . '").style.display="none";
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("answer1_' . $count . '").value="";
                                    document.getElementById("answer2_' . $count . '").value="";
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                   
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                        document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("add_question_part_' . $count . '").disabled = false;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                               }else{
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'remove_question_part_' . $count,
                    'name' => 'remove_question_part_' . $count,
                    'class' => 'greybtn',
                    'disabled' => 'true'
                        )
                );
            } else {
                echo CHtml::ajaxButton('Save Question Part', CController::createUrl('Question/DragDropTypeB'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part_count' => 'js:document.getElementById("question_part_count").value',
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'answer1' => 'js:answer1_' . $count . '.value',
                        'answer2' => 'js:answer2_' . $count . '.value',
                        'count' => $count,
                        'up' => 'js:document.getElementById("update_ff").value',
                        'session_name' => 'drag_drop_typeb_session'
                    ),
                    'success' => 'function(data){
                                    if(data.status == "success")
                                    {
                                        document.getElementById("drag_drop_type_b_' . $nextcount . '").style.display = "block";
                                        document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                            

                                        
                                        document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                        
                                        document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                            document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                    }else if(data.status == "success2"){
                                        document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                        document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                        
                                        document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                            document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                    }
                                    
                                    else if(data.status == "fail")
                                    {                                      
                                       document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data.message;
                                       document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                    }
                                  }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'add_question_part_' . $count,
                    'name' => 'add_question_part_' . $count,
                    'class' => 'greybtn',
                    'disabled' => 'true'
                ));


                echo '&nbsp;';


                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('Question/removeDragDropTypeB'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'drag_drop_typeb_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    deleteCount++;                                    
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                       
                                    document.getElementById("drag_drop_type_b_' . $count . '").style.display="none";
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("answer1_' . $count . '").value="";
                                    document.getElementById("answer2_' . $count . '").value="";
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                   
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("add_question_part_' . $count . '").disabled = false;
                               }else{
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'remove_question_part_' . $count,
                    'name' => 'remove_question_part_' . $count,
                    'class' => 'bluebtn',
                        )
                );
            }
            ?>
        </div>


    </div>
    <div class="span8 no-left-margin" style="display:none" id="dragDropTypeAErrorDisplayRow_<?php echo $count ?>">
        <label id="dragDropTypeAErrorDisplay_<?php echo $count ?>" class="error"></label>
    </div>
    <script>
        document.getElementById("drag_drop_type_b_1").style.display = "block";
    </script> 
    <script type="text/javascript">
        var deleteCount=0;
        function RemoveText(ques_part_id)
        {
            $("#removed_answersb").append('<input type="hidden" name="deleted_answer[]"  value="' + ques_part_id +'"/>');            
            // document.getElementById(div_id).style.display = "none";
            //deleteCount++;
           
        }

    </script>


    <script type="text/javascript">
        var error=0;       

        function checkDragnDropType_B(){             
            var newElement = deleteCount + 1;            

            var qpart = "question_part_"+newElement;
            var ans1 = "answer1_"+newElement;
            var ans2 = "answer2_"+newElement;
            
            //  var headingElement_1 = document.getElementById("heading_1");
            //  var headingElement_2 = document.getElementById("heading_2");                
            var qpartElement = document.getElementById(qpart);
            var answerElement1 = document.getElementById(ans1);
            var answerElement2 = document.getElementById(ans2);
            
            //   error = checkElement(headingElement_1);
            //   error = checkElement(headingElement_2);
            error = checkElement(qpartElement);
            error = checkElement(answerElement1);
            error = checkElement(answerElement2);           
            
            if(error==1){
                alert("Please enter answer");
                return false;
            }else{
                return true;
            }                       
        }
        function onInputChange(no){
            document.getElementById("add_question_part_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_question_part_"+no).className = "greybtn";//.attr('class', 'greybtn');
            document.getElementById("add_question_part_"+no).value = "Add Question Part";
            document.getElementById("add_question_part_"+no).disabled = false;
        }
    </script>
