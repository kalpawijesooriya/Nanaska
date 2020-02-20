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
//Yii::app()->clientScript->scriptMap=array('jquery.js'=>false);
if ($count == 1) {
    ?>
    <?php
    if ($heading_1 == null) {
        ?>Heading 1 <textarea  id="heading_1" name="heading_1" placeholder="Heading 1"></textarea><br/><br/><?php
    } else {
        ?>Heading 1 <textarea  id="heading_1" name="heading_1" placeholder="Heading 1"><?php echo $heading_1; ?></textarea><br/><br/><?php
    }
    ?>

    <?php
    if ($heading_2 == null) {
        ?>Heading 2 <textarea  id="heading_2" name="heading_2" placeholder="Heading 2"></textarea><br/><br/><?php
    } else {
        ?>Heading 2 <textarea  id="heading_2" name="heading_2" placeholder="Heading 2"><?php echo $heading_2; ?></textarea><br/><br/><?php
    }
}
?>
<div id="ErrorDisplayRow" style="display:none">
    <label id="ErrorDisplay" class="error"></label>
</div>      


<?php
if ($part_count == null) {
    ?><input type="hidden" name="part_count" id="part_count" value=0><?php
} else {
    ?><input type="hidden" name="part_count" id="part_count" value='<?php echo $part_count; ?>'><?php
}
if ($edit == null) {
    ?><div id="short_written_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: none"><?php
} else {
    ?>
        <div id="short_written_answer_form_<?php echo $count ?>" class="well span9 no-left-margin" style="display: block"><?php
}
?>



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
        <div class="control-group">
            <?php echo 'Answer'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if ($answer == null) {
                ?><textarea id="answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChange('<?php echo $count ?>')"></textarea><?php
        } else {
                ?><textarea id="answer_<?php echo $count ?>" placeholder="Answer" oninput="onInputChange('<?php echo $count ?>')"><?php echo $answer; ?></textarea><?php
        }
            ?>

        </div>
        <div class="control-group">
            <?php
            $nextcount = $count + 1;

            if ($question_part == null) {
                echo CHtml::ajaxButton('Add Question Part', CController::createUrl('QuestionPart/addQuestionPart'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_part' => 'js:question_part_' . $count . '.value',
                        'answer' => 'js:answer_' . $count . '.value',
                        'count' => $count,
                        'session_name' => 'short_written_question_part_session',
                        'up' => 'js:document.getElementById("update_ff").value',
                        'question_part_count' => 'js:document.getElementById("question_part_count").value',
//                        'test' =>'sdsds',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success" || data[0].status=="success2"){
                                    document.getElementById("short_written_answer_form_' . $nextcount . '").style.display = "block";
                                    document.getElementById("part_count").value = parseFloat(document.getElementById("part_count").value)+1;   
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");
  
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                    
                                    document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                                    document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("add_question_part_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
                        'session_name' => 'short_written_question_part_session',
                        'question_id' => $question_id,
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                     document.getElementById("short_written_answer_form_' . $count . '").style.display="none";                                                                             
                                    document.getElementById("part_count").value = parseFloat(document.getElementById("part_count").value)-1; 
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("question_part_' . $count . '").value="";
                                    document.getElementById("answer_' . $count . '").value=""; 
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    document.getElementById("add_question_part_' . $count . '").disabled = false;
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                               }else{
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
                        'session_name' => 'short_written_question_part_session',
                        'up' => 'js:document.getElementById("update_ff").value',
                        'question_part_count' => 'js:document.getElementById("question_part_count").value',
                    ),
                    'success' => 'function(data){ 
                                
                                if(data[0].status=="success"  || data[0].status=="success2"){
//                                    document.getElementById("short_written_answer_form_' . $nextcount . '").style.display = "block";
                                        
//                                    alert("Question Part Successfully Saved");
                    
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");
  
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("add_question_part_' . $count . '").className = "greybtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("add_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").disabled = false;
                                        document.getElementById("remove_question_part_' . $count . '").value = "Remove Question Part";
                                    
                                    document.getElementById("add_question_part_' . $count . '").value = "Question Part Added";
                               }else{
                                    removeHighlight("question_part_' . $count . '");
                                    removeHighlight("answer_' . $count . '");

                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
                        'session_name' => 'short_written_question_part_session',
                        'question_id' => $question_id,
                    ),
                    'success' => 'function(data){ 
                                
                                if(data.status=="success"){
                                    document.getElementById("short_written_answer_form_' . $count . '").style.display="none";
                                    document.getElementById("part_count").value = parseFloat(document.getElementById("part_count").value)-1; 
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="none";
                                    document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";     
                                    document.getElementById("remove_question_part_' . $count . '").disabled = true;
                                    document.getElementById("remove_question_part_' . $count . '").value = "Question Part Removed";
                                    document.getElementById("add_question_part_' . $count . '").disabled = false;
                                    document.getElementById("add_question_part_' . $count . '").value = "Add Question Part";
                                    document.getElementById("add_question_part_' . $count . '").className = "bluebtn";
                                    document.getElementById("remove_question_part_' . $count . '").className = "greybtn";
                               }else{
                                    document.getElementById("shortWrittenErrorDisplay_' . $count . '").innerHTML=data.message;
                                    document.getElementById("shortWrittenErrorDisplayRow_' . $count . '").style.display="block";
                                   
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
    <div class="span8 no-left-margin" id="shortWrittenErrorDisplayRow_<?php echo $count ?>" style="display:none">
        <label id="shortWrittenErrorDisplay_<?php echo $count ?>" class="error"></label>
    </div>

    <script>
        document.getElementById("short_written_answer_form_1").style.display = "block";
    </script>


    <script type="text/javascript">
        function onInputChange(no){
            document.getElementById("add_question_part_"+no).className = "bluebtn";//attr('class', 'bluebtn');
            document.getElementById("remove_question_part_"+no).className = "greybtn";//.attr('class', 'greybtn');
            document.getElementById("add_question_part_"+no).value = "Add Question Part";
            document.getElementById("add_question_part_"+no).disabled = false;
        }
        function checkShortWrittenAnswers(){
            var error = 0;
            //var heading1 = document.getElementById("heading_1");
            // var heading2 = document.getElementById("heading_2");            
            var answer1 = document.getElementById("answer_1");
            var qpart1 = document.getElementById("question_part_1");           
            var count = document.getElementById("part_count");            
           
            if(count.value == "0"){
                error=1;
                document.getElementById("ErrorDisplay").innerHTML="There should be at least one question part";
                document.getElementById("ErrorDisplayRow").style.display="block";
            }
            //            if(heading1.value==""){
            //                error=1;
            //                heading1.style.borderColor="red";
            //            }else{
            //                heading1.style.borderColor="#cccccc";
            //            }
            //            
            //            if(heading2.value==""){
            //                error=1;
            //                heading2.style.borderColor="red";
            //            }else{
            //                heading2.style.borderColor="#cccccc";
            //            }
            
            if(answer1.value==""){
                error=1;
                answer1.style.borderColor="red";
            }else{
                answer1.style.borderColor="#cccccc";
            }
            
            if(qpart1.value==""){
                error=1;
                qpart1.style.borderColor="red";
            }else{
                qpart1.style.borderColor="#cccccc";
            }
            
            if(error==1){
                return false;
            }else{
                return true;
            }
            
            
        } 
    
    </script>
