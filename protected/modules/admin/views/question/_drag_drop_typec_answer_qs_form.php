<?php
$max_no_of_answers = 10;
$max_no_of_question_parts = 10;
?>

<script>
    var no_of_answers = 1; //start value of answer row
    var no_of_questions = 1;
    var answer_list = Array();
    var existing_answer_list = {};//for edit
    var existing_select_drop_downs = {};//for edit
    var deleted_answer_in_edit=Array();
    var deleteCount=1;
    var deleteRowCount = 1;
    var deleteExistingAnswer = 1;
    var deleteExistingQuestion = 1;
       

    function displayAnswerRoW() {
        no_of_answers++;        
        document.getElementById('tr' + no_of_answers).style.display = 'block';
    }

    function displayQuestionRow() {
        no_of_questions++;        
        document.getElementById('singlequestion_' + no_of_questions).style.display = 'block';
    }

    function removeAnswerRoW(id) {
        document.getElementById('tr' + id).style.display = 'none';
        var a = document.getElementById('answer_' + id).value = "";
        deleteCount++;
        resetAnswerIfSelected("answer_"+id);        
    }

    function removeExistAnswerRoW(id) {
        document.getElementById('trexsist_' + id).style.display = 'none';
        var value = document.getElementById('existanswer_' + id).value = "";
        deleteExistingAnswer++;
        deletedAnswerList(id);
        resetAnswerIfSelected("existanswer_"+id);        
    }
    
    function resetAnswerIfSelected(removed_answer){
        //alert(existing_select_drop_downs.toString());
        for (var i = 0; i < existing_select_drop_downs.length; i++) {
            //alert(existing_select_drop_downs[i]);
            //alert(existing_select_drop_downs[i]);
            var selectanswer=document.getElementById(existing_select_drop_downs[i]).value;
            //alert(selectanswer+" "+removed_answer);
            if(selectanswer==removed_answer){
                //alert(i+" "+selectanswer+" - "+removed_answer);
                clearSelectBox(existing_select_drop_downs[i]);
            }
        }
    }

    function removeQuestion(question_id) {
        document.getElementById('singlequestion_' + question_id).style.display = 'none';
        var a = document.getElementById('selectanswer_' + question_id).options.length = 0;
        deleteRowCount++;
        document.getElementById('question_' + question_id).value = '';
        
    }
    
    function removeExistingQuestion(question_id) {
        document.getElementById('singleexistingquestion_' + question_id).style.display = 'none';
        deleteExistingQuestion++;
        var a = document.getElementById('exsistselectanswer_' + question_id).options.length = 0;
        deletedQuestionPartList(question_id);
    }

    function loadresults(select_box_id) {
        var temp_select1 = document.getElementById(select_box_id);
        temp_select1.options.length = 0;

        var temp_select = document.getElementById(select_box_id);
        for (var i = 1; i < <?php echo $max_no_of_answers ?>; i++) {
            var answer_value = document.getElementById('answer_' + i).value;
            //alert(answer_value+i);
            if (answer_value != "") {
                var option = document.createElement("option");
                if (i == 1) {
                    var option_empty = document.createElement("option");
                    option_empty.text = "Select Answer";
                    temp_select.add(option_empty);
                }
                option.value = i;
                option.text = answer_value;
                temp_select.add(option);
            }
        }
        
    }

    function loadResultsWithExistingAnswer(select_box_id) {
       
        var temp_select = document.getElementById(select_box_id);
        //var selected_value = temp_select.options[temp_select.selectedIndex].value;
        temp_select.options.length = 0;



        var option_empty = document.createElement("option");
        option_empty.text = "Select Answer";
        temp_select.add(option_empty);

        for (var i = 1; i < <?php echo $max_no_of_answers ?>; i++) {
            var answer_value = document.getElementById('answer_' + i).value;
            if (answer_value != "") {
                var option = document.createElement("option");
                option.value = 'answer_' + i;
                option.text = answer_value;
                temp_select.add(option);
            }
        }


        for (var i = 0; i < existing_answer_list.length; i++) {

            var answer_value = document.getElementById('existanswer_' + existing_answer_list[i][0]).value;
            if (answer_value != "") {
                var option = document.createElement("option");
                option.value = 'existanswer_' + existing_answer_list[i][0];
                option.text = answer_value;
                temp_select.add(option);
            }
        }
        //alert(existing_answer_list.toString());
    }

    function clearSelectBox(select_box_id) {
        var select = document.getElementById(select_box_id);
        select.options.length = 0;
        
        var option = document.createElement("option");
        option.text ="Select Answer";
        select.add(option);        
    }
    
    function updateExsistingAnswerList(){
        
    }
    
    function validateFormTypeC(){
        var error=0;     
     
        if(no_of_answers<deleteCount){
            alert("Please enter answers");
            error=1;
        }else{          
            error=0;
        }
        
        if(no_of_questions<deleteRowCount){
            alert("Please add question parts");
            error = 1;
        }else{
            error =0;
        }
        
        if(document.getElementById("existanswer_count")!=null){
            var existingAnswerCount = document.getElementById("existanswer_count").value;            
           
            if(existingAnswerCount<deleteExistingAnswer && no_of_answers==deleteCount){
                alert("Please enter answers");
                error = 1;
            }else{
                error = 0;
            }
        }
        
        //for existing question parts
        if(document.getElementById("existingQuestionCount")!=null){
            var existingQuestionCount = document.getElementById("existingQuestionCount").value; 
            
            if(existingQuestionCount<deleteExistingQuestion && no_of_questions==deleteRowCount){
                alert("Please add question parts");
                error = 1;
            }else{
                error = 0;
            }
        } 
        
        
        //validate answer
        for (var i = 1; i < <?php echo $max_no_of_answers ?>; i++) {
            var div = document.getElementById("tr"+i);
            var display=div.style.display;
            if(display=='block'){
                var answer_tb=document.getElementById("answer_"+i);
                answer=answer_tb.value;
                if(answer==""){
                    error=1;
                    answer_tb.style.borderColor="red";
                }else{
                    answer_tb.style.borderColor="#cccccc";
                }
            }
        }
        
        //validate new questions
        for (var i = 1; i < <?php echo $max_no_of_question_parts ?>; i++) {
            var div = document.getElementById("singlequestion_"+i);
            var display=div.style.display;
            
            if(display=='block'){
                var question_tb=document.getElementById("question_"+i);
                if(question_tb.value==""){
                    error=1;
                    question_tb.style.borderColor="red";
                }else{
                    question_tb.style.borderColor="#cccccc";
                }
                
                var select=document.getElementById("selectanswer_"+i);
                var selectvalue = select.options[select.selectedIndex].value;
                if(selectvalue=="Select Answer" || selectvalue==""){
                    error=1;
                    select.style.borderColor="red";
                }else{
                    select.style.borderColor="#cccccc";
                }
                
            }
        }
        
        //validate existing questions
        for (var i = 0; i < existing_select_drop_downs.length; i++) {
            //alert(existing_select_drop_downs[i]);
            var question_id=existing_select_drop_downs[i].split("_")[1];
            var div = document.getElementById("singleexistingquestion_"+question_id);
            var display=div.style.display;
            if(display=='block'){
                var question_tb=document.getElementById("exsistquestion_"+question_id);
                if(question_tb.value==""){
                    error=1;
                    question_tb.style.borderColor="red";
                }else{
                    question_tb.style.borderColor="#cccccc";
                }
            }
            
            
            var select=document.getElementById("exsistselectanswer_"+question_id);
            var selectvalue = select.options[select.selectedIndex].value;
            if(selectvalue=="Select Answer" || selectvalue==""){
                error=1;
                select.style.borderColor="red";
            }else{
                select.style.borderColor="#cccccc";
            }
        }
        
        if(error==1){
            return false;
        }else{
            return true;
        }
        //return false;
    }
    
    function deletedAnswerList(deleted_answer_id){
        var deleted_answer_element=document.getElementById("deleted_existing_answers");
        deleted_answer_element.value=deleted_answer_element.value+deleted_answer_id+",";
    }
    
    function deletedQuestionPartList(question_part_id){
        var deleted_question_part_element=document.getElementById("deleted_question_parts");
        deleted_question_part_element.value=deleted_question_part_element.value+question_part_id+",";
    }

</script>

<?php

function displayStyleAnswer($i, $type) {
    if ($i != 1 || $type == 'edit') { //if question edit should not display default empty answer text box 
        return 'display: none';
    } else {
        return 'display: block';
    }
}

function displayStyleQuestion($i, $type) {  //if question edit should not display default empty question part
    if ($i != 1 || $type == 'edit') {
        return 'display: none;';
    } else {
        return 'display: block;';
    }
}
?>
<br/>
<h4 class="light_heading">Drag Drop Type C Question </h4>

<input type="hidden" name="max_no_of_answers" value="<?php echo $max_no_of_answers ?>">
<input type="hidden" name="max_no_of_question_parts" value="<?php echo $max_no_of_question_parts ?>">


<!-- edit answer -->
<?php
$existing_answers_data = array();
if ($type == 'edit') {
    $answers_data = Answer::model()->getAnwersForQuestion($question_id);
    $question_data = QuestionPart::model()->getQuestionPartsOfQuestion($question_id);
    $answer_text_data = AnswerText::model()->getAnswerTextForQuestion($question_id);
    ?>
    <input type="hidden" id="existanswer_count" value="<?php echo sizeof($answer_text_data); ?>">

    <?php
    ?>


    <!-- display existing answers in edit page -->

    <div id="answer_section">
        <?php
        foreach ($answer_text_data as $answer_text) {
            $existing_answers_data[] = array('answer_id' => $answer_text->answer_text_id, 'answer_text' => $answer_text->answer_text);
            ?>
            <div style="width: 700px;margin-bottom: 3px" id="trexsist_<?php echo $answer_text->answer_text_id ?>">
                <div class="drag-drop-type-c-div1">Answer </div>
                <div class="drag-drop-type-c-div2"><textarea name="existanswer_<?php echo $answer_text->answer_text_id ?>" id="existanswer_<?php echo $answer_text->answer_text_id ?>" ><?php echo $answer_text->answer_text ?></textarea></div>
                <div class="drag-drop-type-c-div1"><button type="button" class="greybtn" onclick="removeExistAnswerRoW(<?php echo $answer_text->answer_text_id ?>)" >Remove</button></div>
                <div class="drag-drop-type-c-clear-div"></div>
            </div>
            <?php
        }
        ?>
    </div>


<?php }
?>



<!-- Add new answer -->
<div class="well">
    <div id="answer_section">
        <?php
        for ($i = 1; $i <= $max_no_of_answers; $i++) {
            ?>
            <div style="width: 700px;<?php echo displayStyleAnswer($i, $type) ?>" id="tr<?php echo $i ?>">
                <div class="drag-drop-type-c-div1">Answer </div>
                <div class="drag-drop-type-c-div2"><textarea name="answer_<?php echo $i ?>" id="answer_<?php echo $i ?>" placeholder="Answer <?php //echo $i;           ?>"></textarea></div>
                <div class="drag-drop-type-c-div1"><button class="greybtn" type="button" onclick="removeAnswerRoW(<?php echo $i ?>)" >Remove</button></div>
                <div class="drag-drop-type-c-clear-div"></div>
                <br/>
            </div>

            <?php
        }
        ?>
    </div>


    <!-- remove button for add and edit -->

    <div>
        <button class="bluebtn" type="button" onclick="displayAnswerRoW()" >Add</button>
    </div>
</div>



<h4 class="light_heading">Add Question Part</h4>


<!-- Display existing question parts  -->

<?php
$existing_select_drop_downs = array();
if ($type == 'edit') {
    ?>
    <div class="well"><?php
    $questions_data = QuestionPart::model()->getQuestionPartsOfQuestion($question_id);
    ?>
        <input type="hidden" id="existingQuestionCount" value="<?php echo sizeof($questions_data); ?>">
        <?php
        foreach ($questions_data as $question_data) {
            $question_part_id = $question_data['question_part_id'];
            $answer_data = Answer::model()->getAnswerForQuestionPart($question_part_id);
            $existing_select_drop_downs[] = "exsistselectanswer_" . $question_part_id;
            ?>
            <div style="width: 700px;padding-bottom: 5px;display:block" id="singleexistingquestion_<?php echo $question_part_id ?>" >
                <div style="width: 100%">
                    <div class="drag-drop-type-c-div3">Question part</div>
                    <div class="drag-drop-type-c-div4"><textarea name="exsistquestion_<?php echo $question_part_id ?>" id="exsistquestion_<?php echo $question_part_id ?>" style="width: 220px;"><?php echo $question_data['question_part_name'] ?></textarea></div>
                    <div class="drag-drop-type-c-div5"></div>
                </div>
                <div style="width: 100%">
                    <div class="drag-drop-type-c-div3">Correct Answer</div>
                    <div class="drag-drop-type-c-div4">
                        <select id="exsistselectanswer_<?php echo $question_part_id ?>" name="exsistselectanswer_<?php echo $question_part_id ?>" onfocus="loadResultsWithExistingAnswer(this.id)">
                            <option value="existanswer_<?php echo $answer_data->answerText->answer_text_id ?>" selected="selected"><?php echo $answer_data->answerText->answer_text ?></option>
                        </select> 
                    </div>
                    <div class="drag-drop-type-c-div3">
                        <button type="button" class="greybtn" onclick="removeExistingQuestion(<?php echo $question_part_id ?>)" >Remove</button>
                    </div>
                </div>
                <div class="drag-drop-type-c-clear-div"></div>
            </div>  
            <?php
        }
        ?>
    </div>
    <?php
}
?>



<!-- display new question parts -->
<div class="well">
    <?php
    for ($j = 1; $j <= $max_no_of_question_parts; $j++) {
        ?>
        <div style="width: 700px;padding-bottom: 5px;<?php echo displayStyleQuestion($j, $type); ?>" id="singlequestion_<?php echo $j ?>" >
            <div style="width: 100%">
                <div class="drag-drop-type-c-div3">Question part</div>
                <div class="drag-drop-type-c-div4"><textarea placeholder="Question Part" name="question_<?php echo $j ?>" id="question_<?php echo $j ?>"></textarea></div>
                <div class="drag-drop-type-c-div4"></div>
            </div>
            <!--<div style="clear: both"></div>-->
            <br/>
            <div style="width: 100%">
                <div class="drag-drop-type-c-div3">Correct Answer</div>
                <div class="drag-drop-type-c-div4">
                    <select id="selectanswer_<?php echo $j ?>" name="selectanswer_<?php echo $j ?>" onfocus="loadResultsWithExistingAnswer(this.id)">
                        <option value="">Select Answer</option>
                    </select> 
                </div>
                <div class="drag-drop-type-c-div3">
                    <button class="greybtn" type="button" onclick="removeQuestion(<?php echo $j ?>)" >Remove</button>
                </div>
            </div>
            <div class="drag-drop-type-c-clear-div"></div>
            <br/>
        </div>    
        <?php
    }
    ?>

    <input type="hidden" id="deleted_existing_answers" name="deleted_existing_answers" value="">
    <input type="hidden" id="deleted_question_parts" name="deleted_question_parts" value="">

    <div class="drag-drop-type-c-clear-div"></div>

    <br/>
    <div class="drag-drop-type-c-width1">
        <button class="bluebtn" type="button" onclick="displayQuestionRow()" >Add</button> 
    </div>
</div>

<script>
    //create javascript array with existing answers
    existing_answer_list = [
<?php
$exist_answers_in_array = array();    //avoid duplicate answers
foreach ($existing_answers_data as $existing_answer) {
    if (!in_array($existing_answer['answer_text'], $exist_answers_in_array)) {
        echo "['" . $existing_answer['answer_id'] . "','" . $existing_answer['answer_text'] . "'],";
        $exist_answers_in_array[] = $existing_answer['answer_text'];
    }
}
?>
    ];
    // alert(existing_answer_list.toString());
    
    
    //create javascript array with existing selected answers
    existing_select_drop_downs=[
<?php
foreach ($existing_select_drop_downs as $drop_down) {
    echo "'" . $drop_down . "',";
}
?> 
    ];
    
</script>

