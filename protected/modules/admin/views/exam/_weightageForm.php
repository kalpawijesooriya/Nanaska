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
if ($exam_subject_area != null) {
    $subject_area_id = $exam_subject_area['exam_subject_area_details']['subject_area_id'];
    $weightage = $exam_subject_area['exam_subject_area_details']['weightage'];
    $single_answer_weightage = $exam_subject_area['exam_subject_area_details']['single_answer_weightage'];
    $multiple_answer_weightage = $exam_subject_area['exam_subject_area_details']['multiple_answer_weightage'];
    $short_written_answer_weightage = $exam_subject_area['exam_subject_area_details']['short_written_answer_weightage'];
    $drag_drop_typea_answer_weightage = $exam_subject_area['exam_subject_area_details']['drag_drop_typea_answer_weightage'];
    $drag_drop_typeb_answer_weightage = $exam_subject_area['exam_subject_area_details']['drag_drop_typeb_answer_weightage'];
    $drag_drop_typec_answer_weightage = $exam_subject_area['exam_subject_area_details']['drag_drop_typec_answer_weightage'];
    $drag_drop_typed_answer_weightage = $exam_subject_area['exam_subject_area_details']['drag_drop_typed_answer_weightage'];
    $drag_drop_typee_answer_weightage = $exam_subject_area['exam_subject_area_details']['drag_drop_typee_answer_weightage'];
    $multiple_choice_answer_weightage = $exam_subject_area['exam_subject_area_details']['multiple_choice_answer_weightage'];
    $true_or_false_answer_weightage = $exam_subject_area['exam_subject_area_details']['true_or_false_answer_weightage'];
    $hotspot_answer_weightage = $exam_subject_area['exam_subject_area_details']['hotspot_answer_weightage'];
}
?>

<div id="weightage_form_<?php echo $count ?>" style="display:none" class="well">
    <input type="hidden" id="update_ff_<?php echo $count ?>" value="0" />
    <div class="form-control">       
        <?php
        echo 'Subject Area';
        echo '<br>';

        $Criteria = new CDbCriteria();
        $Criteria->condition = "subject_id = " . $subject_id;
        $subjectAreas = SubjectArea::model()->findAll($Criteria);

        $subjectarealist = CHtml::listData($subjectAreas, 'subject_area_id', 'subject_area_name');

//        print_r($subjectarealist);

        if ($exam_subject_area != null) {
            echo CHtml::dropDownList('subject_area_id_' . $count, '', $subjectarealist, array(
                'options' => array($subject_area_id => array('selected' => true)),
                'prompt' => 'Select Subject Area',
                "disabled" => "disabled"
            ));
        } else {
            echo CHtml::dropDownList('subject_area_id_' . $count, '', $subjectarealist, array(
                'prompt' => 'Select Subject Area',
            ));
        }

        echo '<br /><br />';
        ?> 

    </div>
    <div class="form-control">
        <table>
            <tr>
                <td id="dynamic-table-width">Weight-age </td>

                <td>
                    <?php if ($exam_subject_area != null) { ?>
                    <input id="subject_area_weightage_<?php echo $count ?>" name="subject_area_weightage_<?php echo $count ?>" value="<?php echo $weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="subject_area_weightage_<?php echo $count ?>" name="subject_area_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            
        </table>
        
        
        
    </div>    
    <br>

    <h2 class="light_heading"> Question Weightages</h2>

    


    <div class="form-control"> 
        <table>
            <tr>
                <td>
                    Single Answer Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="single_answer_weightage_<?php echo $count ?>" name="single_answer_weightage_<?php echo $count ?>"value="<?php echo $single_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="single_answer_weightage_<?php echo $count ?>" name="single_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Multiple Answer Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="multiple_answer_weightage_<?php echo $count ?>" name="multiple_answer_weightage_<?php echo $count ?>" value="<?php echo $multiple_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="multiple_answer_weightage_<?php echo $count ?>" name="multiple_answer_weightage_<?php echo $count ?>"  placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Short-Written Answer Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="short_written_answer_weightage_<?php echo $count ?>" name="short_written_answer_weightage_<?php echo $count ?>" value="<?php echo $short_written_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="short_written_answer_weightage_<?php echo $count ?>" name="short_written_answer_weightage_<?php echo $count ?>"  placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td id="dynamic-table-height" colspan="2">
                    <b>Drag & Drop Answer Question Weightage</b>
                    <br />
                </td>
            </tr>
            <tr>
                <td>
                    Type A
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="drag_drop_typea_answer_weightage_<?php echo $count ?>" name="drag_drop_typea_answer_weightage_<?php echo $count ?>" value="<?php echo $drag_drop_typea_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="drag_drop_typea_answer_weightage_<?php echo $count ?>" name="drag_drop_typea_answer_weightage_<?php echo $count ?>"  placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Type B
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="drag_drop_typeb_answer_weightage_<?php echo $count ?>" name="drag_drop_typeb_answer_weightage_<?php echo $count ?>" value="<?php echo $drag_drop_typeb_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="drag_drop_typeb_answer_weightage_<?php echo $count ?>" name="drag_drop_typeb_answer_weightage_<?php echo $count ?>"  placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Type C
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="drag_drop_typec_answer_weightage_<?php echo $count ?>" name="drag_drop_typec_answer_weightage_<?php echo $count ?>" value="<?php echo $drag_drop_typec_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="drag_drop_typec_answer_weightage_<?php echo $count ?>" name="drag_drop_typec_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Type D
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="drag_drop_typed_answer_weightage_<?php echo $count ?>" name="drag_drop_typed_answer_weightage_<?php echo $count ?>" value="<?php echo $drag_drop_typed_answer_weightage ?>"placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="drag_drop_typed_answer_weightage_<?php echo $count ?>" name="drag_drop_typed_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Type E
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="drag_drop_typee_answer_weightage_<?php echo $count ?>" name="drag_drop_typee_answer_weightage_<?php echo $count ?>" value="<?php echo $drag_drop_typee_answer_weightage ?>"placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="drag_drop_typee_answer_weightage_<?php echo $count ?>" name="drag_drop_typee_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Multiple Choice Answer Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="multiple_choice_answer_weightage_<?php echo $count ?>" name="multiple_choice_answer_weightage_<?php echo $count ?>" value="<?php echo $multiple_choice_answer_weightage ?>"placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="multiple_choice_answer_weightage_<?php echo $count ?>" name="multiple_choice_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    True Or False Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="true_or_false_answer_weightage_<?php echo $count ?>" name="true_and_false_answer_weightage_<?php echo $count ?>" value="<?php echo $true_or_false_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="true_or_false_answer_weightage_<?php echo $count ?>" name="true_and_false_answer_weightage_<?php echo $count ?>"placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>
            <tr>
                <td>
                    Hot-Spot Question Weightage
                </td>
                <td>
                    <?php if ($exam_subject_area != null) { ?>
                        <input id="hotspot_answer_weightage_<?php echo $count ?>" name="hotspot_answer_weightage_<?php echo $count ?>" value="<?php echo $hotspot_answer_weightage ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } else { ?>
                        <input id="hotspot_answer_weightage_<?php echo $count ?>" name="hotspot_answer_weightage_<?php echo $count ?>" placeholder="Enter Weightage" oninput="changeButton(<?php echo $count ?>)"/><strong>%</strong>
                    <?php } ?> 
                </td>
            </tr>

        </table>
    </div>
    <div class="row"><br/>
        <p style="display:none" id="errorDisplay_<?php echo $count ?>" class="weightage_alert alert-danger"></p>
    </div>
    <br>

    <div class="form-control">
        <!--<button id="" style="width: 500px">+</button>-->

        <?php
        $nextcount = $count + 1;

//        if($nextcount!=$numberOfSubjectAreas){


        if ($exam_subject_area == null) {
            echo CHtml::ajaxButton('Add Weightages', CController::createUrl('ExamSubjectArea/addSubjectArea'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('subject_area_id' => 'js:subject_area_id_' . $count . '.value',
                    'subject_area_weight' => 'js:subject_area_weightage_' . $count . '.value',
                    'single_answer_question_weight' => 'js:single_answer_weightage_' . $count . '.value',
                    'multiple_answer_question_weight' => 'js:multiple_answer_weightage_' . $count . '.value',
                    'short_written_answer_question_weight' => 'js:short_written_answer_weightage_' . $count . '.value',
                    'drag_drop_typea_answer_question_weight' => 'js:drag_drop_typea_answer_weightage_' . $count . '.value',
                    'drag_drop_typeb_answer_question_weight' => 'js:drag_drop_typeb_answer_weightage_' . $count . '.value',
                    'drag_drop_typec_answer_question_weight' => 'js:drag_drop_typec_answer_weightage_' . $count . '.value',
                    'drag_drop_typed_answer_question_weight' => 'js:drag_drop_typed_answer_weightage_' . $count . '.value',
                    'drag_drop_typee_answer_question_weight' => 'js:drag_drop_typee_answer_weightage_' . $count . '.value',
                    'multiple_choice_answer_question_weight' => 'js:multiple_choice_answer_weightage_' . $count . '.value',
                    'true_or_false_answer_question_weight' => 'js:true_or_false_answer_weightage_' . $count . '.value',
                    'hotspot_answer_question_weight' => 'js:hotspot_answer_weightage_' . $count . '.value',
                    'count' => $count,
                    'number_of_questions' => 'js:number_of_questions.value',
                    'update' => 'js:update_ff_' . $count . '.value',
                ),
                'success' => 'function(data){ 
                               if(data[0].status=="success"){
                                    document.getElementById("weightage_form_' . $nextcount . '").style.display = "block";
                                        
                                    removeHighlight("subject_area_id_' . $count . '");
                                    removeHighlight("subject_area_weightage_' . $count . '");
                                    removeHighlight("single_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_answer_weightage_' . $count . '");
                                    removeHighlight("short_written_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typea_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typeb_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typec_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typed_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typee_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_choice_answer_weightage_' . $count . '");
                                    removeHighlight("true_or_false_answer_weightage_' . $count . '");
                                    removeHighlight("hotspot_answer_weightage_' . $count . '");    
                                        
                                    document.getElementById("errorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("errorDisplay_' . $count . '").style.display="none";
                                        
                                    document.getElementById("remove_weightage_' . $count . '").disabled = false;
                                    document.getElementById("remove_weightage_' . $count . '").value = "Remove Subject Area";                   
                                    document.getElementById("remove_weightage_' . $count . '").className = "bluebtn";
                                    document.getElementById("add_weightage_' . $count . '").disabled = true;
                                    document.getElementById("add_weightage_' . $count . '").value = "Weightage Added";
                                    document.getElementById("add_weightage_' . $count . '").className = "greybtn";
                                    document.getElementById("subject_area_id_' . $count . '").disabled = true;
                                    document.getElementById("update_ff_' . $count . '").value = "1";
                               }else{
                                    removeHighlight("subject_area_id_' . $count . '");
                                    removeHighlight("subject_area_weightage_' . $count . '");
                                    removeHighlight("single_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_answer_weightage_' . $count . '");
                                    removeHighlight("short_written_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typea_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typeb_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typec_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typed_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typee_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_choice_answer_weightage_' . $count . '");
                                    removeHighlight("true_or_false_answer_weightage_' . $count . '");
                                    removeHighlight("hotspot_answer_weightage_' . $count . '");

                                    document.getElementById("errorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("errorDisplay_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                                    for(var y=0;y<data[2].length;y++){
                                        var element =  data[2][y];
                                        hightlightTextBox(element);
                                    }
                                    
                               }
                                
                                
                                    }'
                    ), array(
//                        'class' => 'btn btn-checkout',
                'class' => 'bluebtn',
                'id' => 'add_weightage_' . $count,
                'name' => 'add_weightage_' . $count,
                    )
            );
            ?>&nbsp;&nbsp;<?php
            echo CHtml::ajaxButton('Remove Subject Area', CController::createUrl('ExamSubjectArea/removeSubjectArea'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('subject_area_id' => 'js:subject_area_id_' . $count . '.value',
                    'exam_id' => $exam_id,
                    //'count' => $count
                ),
                'success' => 'function(data){ 
                                   if(data.status=="success"){
                                        
                                        document.getElementById("weightage_form_' . $count . '").style.display="none";
                                            
                                        document.getElementById("errorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("errorDisplay_' . $count . '").style.display="none";
                                        document.getElementById("remove_weightage_' . $count . '").disabled = true;
                                        document.getElementById("remove_weightage_' . $count . '").value = "Remove Subject Area";                   
                                        
                                        document.getElementById("add_weightage_' . $count . '").disabled = false;
                                        document.getElementById("add_weightage_' . $count . '").value = "Add Weightages";
                                        document.getElementById("add_weightage_' . $count . '").className = "bluebtn";
                                        document.getElementById("subject_area_id_' . $count . '").disabled = false;
                                        document.getElementById("update_ff_' . $count . '").value = "0";
                                   }else{
                                        document.getElementById("errorDisplay_' . $count . '").innerHTML=data[0].message;
                                        document.getElementById("errorDisplay_' . $count . '").style.display="block";
                                   }
                                        }'
                    ), array(
    //                        'class' => 'btn btn-checkout',
                'class' => 'greybtn',
                'id' => 'remove_weightage_' . $count,
                'name' => 'remove_weightage_' . $count,
                'disabled' => 'true'
                    )
            );
        } else {
            echo CHtml::ajaxButton('Weightage Added', CController::createUrl('ExamSubjectArea/saveSubjectArea'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('subject_area_id' => 'js:subject_area_id_' . $count . '.value',
                    'subject_area_weight' => 'js:subject_area_weightage_' . $count . '.value',
                    'single_answer_question_weight' => 'js:single_answer_weightage_' . $count . '.value',
                    'multiple_answer_question_weight' => 'js:multiple_answer_weightage_' . $count . '.value',
                    'short_written_answer_question_weight' => 'js:short_written_answer_weightage_' . $count . '.value',
                    'drag_drop_typea_answer_question_weight' => 'js:drag_drop_typea_answer_weightage_' . $count . '.value',
                    'drag_drop_typeb_answer_question_weight' => 'js:drag_drop_typeb_answer_weightage_' . $count . '.value',
                    'drag_drop_typec_answer_question_weight' => 'js:drag_drop_typec_answer_weightage_' . $count . '.value',
                    'drag_drop_typed_answer_question_weight' => 'js:drag_drop_typed_answer_weightage_' . $count . '.value',
                    'drag_drop_typee_answer_question_weight' => 'js:drag_drop_typee_answer_weightage_' . $count . '.value',
                    'multiple_choice_answer_question_weight' => 'js:multiple_choice_answer_weightage_' . $count . '.value',
                    'true_or_false_answer_question_weight' => 'js:true_or_false_answer_weightage_' . $count . '.value',
                    'hotspot_answer_question_weight' => 'js:hotspot_answer_weightage_' . $count . '.value',
                    'count' => $count,
                    'number_of_questions' => 'js:number_of_questions.value'
                ),
                'success' => 'function(data){ 
                               if(data[0].status=="success"){
//                                    document.getElementById("weightage_form_' . $nextcount . '").style.display = "block";
                                        
                                    removeHighlight("subject_area_id_' . $count . '");
                                    removeHighlight("subject_area_weightage_' . $count . '");
                                    removeHighlight("single_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_answer_weightage_' . $count . '");
                                    removeHighlight("short_written_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typea_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typeb_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typec_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typed_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typee_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_choice_answer_weightage_' . $count . '");
                                    removeHighlight("true_or_false_answer_weightage_' . $count . '");
                                    removeHighlight("hotspot_answer_weightage_' . $count . '");    
                                        
                                    document.getElementById("errorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("errorDisplay_' . $count . '").style.display="none";
                                    document.getElementById("remove_weightage_' . $count . '").disabled = false;
                                    document.getElementById("remove_weightage_' . $count . '").value = "Remove Subject Area";                   
                                    document.getElementById("remove_weightage_' . $count . '").className = "bluebtn";
                                    document.getElementById("add_weightage_' . $count . '").disabled = true;
                                    document.getElementById("add_weightage_' . $count . '").value = "Weightage Added";
                                    document.getElementById("add_weightage_' . $count . '").className = "greybtn";
                                    document.getElementById("subject_area_id_' . $count . '").disabled = true;
                               }else{
                                    removeHighlight("subject_area_id_' . $count . '");
                                    removeHighlight("subject_area_weightage_' . $count . '");
                                    removeHighlight("single_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_answer_weightage_' . $count . '");
                                    removeHighlight("short_written_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typea_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typeb_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typec_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typed_answer_weightage_' . $count . '");
                                    removeHighlight("drag_drop_typee_answer_weightage_' . $count . '");
                                    removeHighlight("multiple_choice_answer_weightage_' . $count . '");
                                    removeHighlight("true_or_false_answer_weightage_' . $count . '");
                                    removeHighlight("hotspot_answer_weightage_' . $count . '");

                                    document.getElementById("errorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("errorDisplay_' . $count . '").style.display="block";
                                   
                                    for(var x=0;x<data[1].length;x++){
                                        var element =  data[1][x];
                                        hightlightTextBox(element);
                                    }
                                    
                                    for(var y=0;y<data[2].length;y++){
                                        var element =  data[2][y];
                                        hightlightTextBox(element);
                                    }
                                    
                               }
                                
                                
                                    }'
                    ), array(
//                        'class' => 'btn btn-checkout',
                'class' => 'greybtn',
                'id' => 'add_weightage_' . $count,
                'name' => 'add_weightage_' . $count,
                'disabled' => 'true'
                    )
            );
            ?>&nbsp;&nbsp;<?php
        echo CHtml::ajaxButton('Remove Subject Area', CController::createUrl('ExamSubjectArea/removeSubjectArea'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            'data' => array('subject_area_id' => 'js:subject_area_id_' . $count . '.value',
                'exam_id' => $exam_id,
            ),
            'success' => 'function(data){ 
                               if(data.status=="success"){
                                    
                                    document.getElementById("weightage_form_' . $count . '").style.display="none";

                                    document.getElementById("errorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("errorDisplay_' . $count . '").style.display="none";
                                    document.getElementById("remove_weightage_' . $count . '").disabled = true;
                                    document.getElementById("remove_weightage_' . $count . '").value = "Remove Subject Area";                   
                                    document.getElementById("add_weightage_' . $count . '").disabled = false;
                                    document.getElementById("add_weightage_' . $count . '").value = "Add Weightages";
                                    document.getElementById("add_weightage_' . $count . '").className = "bluebtn";
                                    document.getElementById("subject_area_id_' . $count . '").disabled = false;
                               }else{
                                    document.getElementById("errorDisplay_' . $count . '").innerHTML=data[0].message;
                                    document.getElementById("errorDisplay_' . $count . '").style.display="block";
                               }
                                    }'
                ), array(
//                        'class' => 'btn btn-checkout',
            'class' => 'bluebtn',
            'id' => 'remove_weightage_' . $count,
            'name' => 'remove_weightage_' . $count,
                )
        );
    }
        ?>

    </div>
    <br>
</div>

<?php
if ($exam_subject_area == null) {
    ?>
    <script>
        document.getElementById("weightage_form_1").style.display = "block";
    </script>
    <?php
}
?>
<script  type="text/javascript">

function changeButton(count){
    //document.getElementById("remove_weightage_' . $count . '").disabled = false;
    document.getElementById("remove_weightage_"+count).value = "Remove Subject Area";                   
    document.getElementById("remove_weightage_"+count).className = "greybtn";
    document.getElementById("add_weightage_"+count).disabled = false;
    document.getElementById("add_weightage_"+count).value = "Add Weightages";
    document.getElementById("add_weightage_"+count).className = "bluebtn";
    
} 

</script>