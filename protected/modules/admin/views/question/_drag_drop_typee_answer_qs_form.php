<script type="text/javascript">
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";        
    }
    
    var qpartTextDeleteCount=0;
    var m=0;
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
if ($edit == null) {
    ?><div id="drag_drop_typee_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: none"><?php
} else {
    ?><div id="drag_drop_typee_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: block"><?php
}
?>



        <div class="control-group">
            <?php echo 'Question Part'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($question_part == null) {
                ?><textarea id="question_part_<?php echo $count ?>"  placeholder="Question Part" oninput="onInputChangeE('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="question_part_<?php echo $count ?>" placeholder="Question Part" oninput="onInputChangeSaveE('<?php echo $count ?>')"><?php echo $question_part; ?></textarea><?php
        }
            ?>

        </div>

        <div class="control-group">
            <?php echo 'Question Part Text'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($question_part == null) {
                ?><textarea id="question_part_text_<?php echo $count ?>" placeholder="Question Part Text" oninput="onInputChangeE('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="question_part_text_<?php echo $count ?>" placeholder="Question Part Text" oninput="onInputChangeSaveE('<?php echo $count ?>')"><?php echo $question_part_text; ?></textarea><?php
        }
            ?>

        </div>

        <div class="control-group">
            <?php echo 'Answer'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($answer == null) {
                ?><textarea id="answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChangeE('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChangeSaveE('<?php echo $count ?>')"><?php echo $answer; ?></textarea><?php
        }
            ?>

        </div>
        <div class="control-group">
            <?php
            $nextcount = $count + 1;

            if ($question_part == null) {
                echo CHtml::ajaxButton('Add Question Part', CController::createUrl('QuestionPart/addQuestionPartForDragDropTypeE'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'qpart_count' => 'js:document.getElementById("question_part_count").value',
                        'up' => 'js:document.getElementById("update_ff").value',
                        'question_part_text' => 'js:question_part_text_' . $count . '.value',
                        'answer' => 'js:answer_' . $count . '.value',
                        'count' => $count,
                        'session_name' => 'drag_drop_typee_question_part_session',
//                        'test' =>'sdsds',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success"){
                                    document.getElementById("drag_drop_typee_answer_form_' . $nextcount . '").style.display = "block";
                                        
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("question_part_text_' . $count . '");
                                    removeHighlight("answer_' . $count . '");
  
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="none";
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                   
                                    document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                    document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                    document.getElementById("add_question_part_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("question_part_text_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
                        'session_name' => 'drag_drop_typee_question_part_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    qpartTextDeleteCount++;
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("drag_drop_typee_answer_form_' . $count . '").style.display="none";    
                                    
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("question_part_text_' . $count . '").value=""; 
                                    document.getElementById("answer_' . $count . '").value=""; 
                                    
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("add_question_part_' . $count . '").disabled = false;
                               }else{
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
                echo CHtml::ajaxButton('Save Question Part', CController::createUrl('QuestionPart/saveQuestionPartForDragDropTypeE'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'question_part_text' => 'js:question_part_text_' . $count . '.value',
                        'answer' => 'js:answer_' . $count . '.value',
                        'count' => $count,
                        'session_name' => 'drag_drop_typee_question_part_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success"){
//                                    document.getElementById("drag_drop_typee_answer_form_' . $nextcount . '").style.display = "block";
                                        
//                                    alert("Question Part Successfully Saved");
                    
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");
  
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("save_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                        document.getElementById("save_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                               }

                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'save_question_part_' . $count,
                    'name' => 'save_question_part_' . $count,
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
                        'session_name' => 'drag_drop_typee_question_part_session',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    qpartTextDeleteCount++;
                                    document.getElementById("drag_drop_typee_answer_form_' . $count . '").style.display="none";
  
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("save_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("save_question_part_' . $count . '").disabled = false;
                               }else{
                                    document.getElementById("dragDragTypeEErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("dragDragTypeEErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
    <div class="span9 no-left-margin" id="dragDragTypeEErrorDisplayRow_<?php echo $count ?>" style="display:none">
        <label id="dragDragTypeEErrorDisplay_<?php echo $count ?>" class="error"></label>
    </div>

    <script>
        document.getElementById("drag_drop_typee_answer_form_1").style.display = "block";
        function onInputChangeE(no){
            
            document.getElementById("add_question_part_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_question_part_"+no).className = "greybtn";//.attr('class', 'greybtn');save_question_part_
            document.getElementById("add_question_part_"+no).value = "Add Question Part";
            document.getElementById("add_question_part_"+no).disabled = false;
            
        }
        function onInputChangeSaveE(no){
            
            document.getElementById("save_question_part_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_question_part_"+no).className = "greybtn";//.attr('class', 'greybtn');
            document.getElementById("save_question_part_"+no).value = "Save Question Part";
            document.getElementById("save_question_part_"+no).disabled = false;
        }
        function testing(){
            alert('fsdfsf');
        }
    </script>

    <script type="text/javascript">
        var error=0;
        function checkDragnDropType_E(){ 
            
            var element = qpartTextDeleteCount + 1; 
            var otherElement = deleteCount + 1;
            
           // var headingElement_1 = document.getElementById("heading_1");
           // var headingElement_2 = document.getElementById("heading_2");
            var qpartElement = document.getElementById("question_part_"+element);
            var qpartTextElement = document.getElementById("question_part_text_"+element);
            var answerElement2 = document.getElementById("answer_"+element);
            var otherAnswer = document.getElementById("other_answer_"+otherElement);
            
          //  error = checkElement(headingElement_1);
          //  error = checkElement(headingElement_2);
            error = checkElement(qpartElement);
            error = checkElement(qpartTextElement);
            error = checkElement(answerElement2);
            error = checkElement(otherAnswer); 
            
            if(error==1){
                return false;
            }else{
                return true;
            }
        }
        
    </script>