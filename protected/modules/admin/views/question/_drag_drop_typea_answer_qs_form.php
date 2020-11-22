<script type="text/javascript">
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
if ($edit == null) {
    ?><div id="drag_drop_typea_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: none"><?php
} else {
    ?><div id="drag_drop_typea_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: block"><?php
}
?>
        <div class="control-group">
            <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($question_part == null) {
                ?><textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="question_part_<?php echo $count ?>"  placeholder="Question Part" oninput="onInputChange('<?php echo $count ?>')"><?php echo $question_part; ?></textarea><?php
        }
            ?>

        </div>
        <div class="control-group">
            <?php echo 'Answer'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($answer == null) {
                ?><textarea id="answer_<?php echo $count ?>"  placeholder="Answer" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChange('<?php echo $count ?>')"><?php echo $answer; ?></textarea><?php
        }
            ?>

        </div>
        <div id="deleted_images"><input type="hidden" name="deleted_img[]" value="dummy_value"></div>
        <div class="control-group">
            <?php
            $nextcount = $count + 1;

            if ($question_part == null) {
                echo CHtml::ajaxButton('Add Question Part', CController::createUrl('QuestionPart/addQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part_count' => 'js:document.getElementById("question_part_count").value',
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'answer' => 'js:answer_' . $count . '.value',
                        'count' => $count,
                        'up' => 'js:document.getElementById("update_ff").value',
                        'session_name' => 'drag_drop_typea_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    document.getElementById("drag_drop_typea_form_' . $nextcount . '").style.display = "block";
                                        
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");
  
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";                                    
                                    document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                    document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                    document.getElementById("add_question_part_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'add_question_part_' . $count,
                    'name' => 'add_question_part_' . $count,
                    'class' => 'bluebtn',
                        )
                );
                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('QuestionPart/removeQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'drag_drop_typea_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"  || data[0].status=="success2"){                                
                                    deleteCount++;
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("drag_drop_typea_form_' . $count . '").style.display="none";
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("answer_' . $count . '").value=""; 
                                    
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
                    'class' => 'greybtn',
                    'disabled' => 'true'
                        )
                );
            } else {
                echo CHtml::ajaxButton('Save Question Part', CController::createUrl('QuestionPart/saveQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'answer' => 'js:answer_' . $count . '.value',
                        'count' => $count,
                        'session_name' => 'drag_drop_typea_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success"  || data[0].status=="success2"){
//                                    document.getElementById("drag_drop_typea_form_' . $nextcount . '").style.display = "block";
                                        
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");  
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDropTypeAErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'add_question_part_' . $count,
                    'name' => 'add_question_part_' . $count,
                    'class' => 'greybtn',
                    'disabled' => 'true'
                        )
                );

                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Question Part', CController::createUrl('QuestionPart/removeQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'drag_drop_typea_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"  || data[0].status=="success2"){
                                    deleteCount++;
                                    document.getElementById("drag_drop_typea_form_' . $count . '").style.display="none";
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("answer_' . $count . '").value="";
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("dragDropTypeAErrorDisplay_' . $count . '").innerHTML="";
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
        document.getElementById("drag_drop_typea_form_1").style.display = "block";
    </script>


    <script type="text/javascript">
        function checkDragnDropType_A(){
            var error =0;
            var elementNum = deleteCount + 1;
           
           
            var qpartElement = document.getElementById("question_part_"+elementNum);
            var answerElement = document.getElementById("answer_"+elementNum);
            
            error = checkElement(qpartElement);
            error = checkElement(answerElement);        
            
            if(error==1){
                alert("Please enter answers");
                return false;
            }else{
                return true;
            }
        }
        
        function checkDragnDropType_A_edit(){    //same function as above but used in update        
           
            var newElement = deleteCount+1;
            var error = 0;
           
            var qpart = "question_part_"+newElement;
            var ans1 = "answer_"+newElement;            
            var qpartCount = document.getElementById("question_part_count").value;
            
            if(qpartCount == deleteCount || qpartCount < deleteCount){
                var qpartElement = document.getElementById(qpart);
                var answerElement1 = document.getElementById(ans1);
             
                error = checkElement(qpartElement);
                error = checkElement(answerElement1);
            }                     
                
            if(error==1){
                alert("Please enter answers");
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