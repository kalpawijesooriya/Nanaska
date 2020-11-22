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
if ($count == 1) {
    ?>
<div class="span9 no-left-margin">
    <h4 class="light_heading">Add Other Answers</h4>
</div>
    <?php
}
?>


<?php
if ($edit == null) {
    ?><div id="other_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: none"><?php
} else {
    ?><div id="other_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: block"><?php
}
?>

        <div class="control-group">
            <?php echo 'Answer'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($other_answer == null) {
                ?><textarea id="other_answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="other_answer_<?php echo $count ?>"  placeholder="Answer" oninput="onInputChangeSave('<?php echo $count ?>')"><?php echo $other_answer; ?></textarea><?php
        }
            ?>

        </div>
        <div class="control-group">



            <?php
            $nextcount = $count + 1;

            if ($edit == null) {

                if ($question_type == "drag_drop_typed") {
                    echo CHtml::ajaxButton('Add Other Answer', CController::createUrl('QuestionPart/addOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'other_answer' => 'js:other_answer_' . $count . '.value',
                            'count' => $count,
                            'qpart_count' => 'js:document.getElementById("question_part_count").value',
                            'up' => 'js:document.getElementById("update_ff").value',
                            'session_name' => 'other_answer_session',
                            'question_type' => 'drag_drop_typed',
                            'answer_1' => 'js:answer_1.value',
                            'answer_2' => 'js:answer_2.value'
                        ),
                        'success' => 'function(data){ 
                                
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    document.getElementById("other_answer_form_' . $nextcount . '").style.display = "block";
                                    removeHighlight("other_answer_' . $count . '");
  
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                    
                                    
                                    document.getElementById("remove_other_answer_' . $count . '").value = "Remove Other Answer";
                                    
                                    document.getElementById("add_other_answer_' . $count . '").value = "Answer Added";
                                    document.getElementById("add_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = false;
                                    document.getElementById("add_other_answer_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("other_answer_' . $count . '");

                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'add_other_answer_' . $count,
                        'name' => 'add_other_answer_' . $count,
                        'class' => 'bluebtn',
                            )
                    );
                    echo '&nbsp;';
                    echo CHtml::ajaxButton('Remove Other Answer', CController::createUrl('QuestionPart/removeOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'count' => $count,
                            'session_name' => 'other_answer_session',
                        ),
                        'success' => 'function(data){ 
                                
                                if(data.status=="success" || data[0].status=="success2"){                                    
                                    deleteCount++;
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("other_answer_form_' . $count . '").style.display="none"; 
                                    document.getElementById("other_answer_' . $count . '").value=""; 
                                    
                                    document.getElementById("remove_other_answer_' . $count . '").value = "Answer Removed";
                                    
                                    document.getElementById("add_other_answer_' . $count . '").value = "Add Other Answer";
                                    document.getElementById("add_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("add_other_answer_' . $count . '").disabled = false;
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = true;
                               }else{
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'remove_other_answer_' . $count,
                        'name' => 'remove_other_answer_' . $count,
                        'class' => 'greybtn',
                        'disabled' => 'true'
                            )
                    );
                } else if ($question_type == "drag_drop_typee") {
                    echo CHtml::ajaxButton('Add Other Answer', CController::createUrl('QuestionPart/addOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'other_answer' => 'js:other_answer_' . $count . '.value',
                            'up' => 'js:document.getElementById("update_ff").value',
                            'count' => $count,
                            'session_name' => 'other_answer_session',
                            'question_type' => 'drag_drop_typee',
                            'qpart_count' => 'js:document.getElementById("question_part_count").value',
                        ),
                        'success' => 'function(data){ 
                                
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    document.getElementById("other_answer_form_' . $nextcount . '").style.display = "block";
                                   
                                    removeHighlight("other_answer_' . $count . '");
  
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                        
                                    
                                    document.getElementById("remove_other_answer_' . $count . '").value = "Remove Other Answer";
                                    
                                    document.getElementById("add_other_answer_' . $count . '").value = "Answer Added";
                                    document.getElementById("add_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = false;
                                        document.getElementById("add_other_answer_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("other_answer_' . $count . '");

                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'add_other_answer_' . $count,
                        'name' => 'add_other_answer_' . $count,
                        'class' => 'bluebtn',
                            )
                    );

                    echo '&nbsp;';
                    echo CHtml::ajaxButton('Remove Other Answer', CController::createUrl('QuestionPart/removeOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'count' => $count,
                            'session_name' => 'other_answer_session',
                        ),
                        'success' => 'function(data){ 
                                
                                if(data.status=="success" || data[0].status=="success2"){
                                 deleteCount++;
                                    if(data.count == 1){
                                        document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    }else{
                                        document.getElementById("other_answer_form_' . $count . '").style.display="none";
  
                                        document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    }
                                     document.getElementById("other_answer_form_' . $count . '").style.display="none";
  
                                    document.getElementById("other_answer_' . $count . '").value=""; 
                                    
                                    document.getElementById("remove_other_answer_' . $count . '").value = "Answer Removed";
                                    
                                    document.getElementById("add_other_answer_' . $count . '").value = "Add Other Answer";
                                    document.getElementById("add_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("add_other_answer_' . $count . '").disabled = false;
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = true;
                               }else{
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'remove_other_answer_' . $count,
                        'name' => 'remove_other_answer_' . $count,
                        'class' => 'greybtn',
                        'disabled' => 'true'
                            )
                    );
                }
            } else {
                ?>

                <?php
                if ($question_type == "drag_drop_typed") {

                    echo CHtml::ajaxButton('Save Other Answer Part', CController::createUrl('QuestionPart/saveOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'other_answer' => 'js:other_answer_' . $count . '.value',
                            'question_part_count' => 'js:document.getElementById("question_part_count").value',
                            'count' => $count,
                            'session_name' => 'other_answer_session',
                            'question_type' => 'drag_drop_typed',
                        ),
                        'success' => 'function(data){ 
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    removeHighlight("other_answer_' . $count . '");
  
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("save_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("save_other_answer_' . $count . '").disabled = true;
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = false;
                               }else{
                                    removeHighlight("other_answer_' . $count . '");

                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'save_other_answer_' . $count,
                        'name' => 'save_other_answer_' . $count,
                        'class' => 'greybtn',
                        'disabled' => 'true'
                            )
                    );
                } else if ($question_type == "drag_drop_typee") {
                    echo CHtml::ajaxButton('Save Other Answer Part', CController::createUrl('QuestionPart/saveOtherAnswer'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'other_answer' => 'js:other_answer_' . $count . '.value',
                            'count' => $count,
                            'session_name' => 'other_answer_session',
                            'question_type' => 'drag_drop_typee',
                        ),
                        'success' => 'function(data){ 
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    removeHighlight("other_answer_' . $count . '");
  
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("save_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("save_other_answer_' . $count . '").disabled = true;
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = false;
                               }else{
                                    removeHighlight("other_answer_' . $count . '");

                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                            ), array('class' => 'btn btn-checkout',
                        'id' => 'save_other_answer_' . $count,
                        'name' => 'save_other_answer_' . $count,
                        'class' => 'greybtn',
                        'disabled' => 'true'
                            )
                    );
                }

                echo '&nbsp;';
                echo CHtml::ajaxButton('Remove Other Answer', CController::createUrl('QuestionPart/removeOtherAnswer'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'count' => $count,
                        'session_name' => 'other_answer_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success" || data[0].status=="success2"){
                                    deleteCount++;
                                    document.getElementById("other_answer_form_' . $count . '").style.display="none";
  
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("add_other_answer_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_other_answer_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_other_answer_' . $count . '").disabled = true;
                                    document.getElementById("save_other_answer_' . $count . '").disabled = false;
                               }else{
                                    document.getElementById("otherAnswerErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("otherAnswerErrorDisplayRow_' . $count . '").style.display="block";
                                   
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'remove_other_answer_' . $count,
                    'name' => 'remove_other_answer_' . $count,
                    'class' => 'bluebtn',
                        )
                );
            }
            ?>
        </div>
    </div>
    <div class="span9 no-left-margin" id="otherAnswerErrorDisplayRow_<?php echo $count ?>" style="display:none" class="row"><br/>
        <p id="otherAnswerErrorDisplay_<?php echo $count ?>" class="alert alert-danger"></p>
    </div>

    <script>
        document.getElementById("other_answer_form_1").style.display = "block";
        function onInputChange(no){
            document.getElementById("add_other_answer_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_other_answer_"+no).className = "greybtn";//.attr('class', 'greybtn');
            document.getElementById("add_other_answer_"+no).value = "Add Other Answer";
            document.getElementById("add_other_answer_"+no).disabled = false;
            
        }
        function onInputChangeSave(no){
            
            document.getElementById("save_other_answer_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_other_answer_"+no).className = "greybtn";//.attr('class', 'greybtn');
            document.getElementById("save_other_answer_"+no).value = "Save Other Answer Part";
            document.getElementById("save_other_answer_"+no).disabled = false;
        }
    </script>

