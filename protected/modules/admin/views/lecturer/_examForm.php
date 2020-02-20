<?php
$subjects = Yii::app()->session['subject_session'];

//echo '<pre>';
//print_r($subjects);
//echo '</pre>';
?>

<script>
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        alert("asdsadsada");
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }
</script>


<style>
    .well-exam {
        min-height: 20px;
        padding: 19px;
        padding-left: 59px;
        margin-bottom: 20px;

        border: 1px solid #e3e3e3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
</style>

<style>
    .lecturer_subject{
        float: left;
    }
    .error_message2{
        color: #B40404;
        display: none;
    }
</style>


<div class="well">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'exam-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=>array('class'=>'form-horizontal'),
    ));
    ?>


    <div class="control-group">
        <?php // echo $form->labelEx($model,'user_type');   ?>
        <?php  echo $form->hiddenField($model, 'user_type', array('value' => "LECTURER")); ?>
        <?php // echo $form->error($model,'user_type',array('class'=>'alert alert-danger'));  ?>
    </div>

    <?php /*?>
    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputPassword">Course</label>';
       
        echo '<div class="controls">'.CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'prompt' => 'Select Course',
            'class' => 'form-control',
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('Level/getLevels'),
                'update' => '#level_id',
                'beforeSend' => 'function() {           
                    if(subject.value!="prompt"){
                         subject.options.length = 1;
                    }
                
        }',                
                
        ))).'</div>';
        ?> 

    </div>
    <?php */?>


   <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label" for="inputPassword">Course</label>
        </div>
        <div class="lecturer_subject">
            <?php
                echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
                'prompt' => 'Select Course',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('Level/getLevels'),
                    'update' => '#level_id',
                    'beforeSend' => 'function() {           
                        if(subject.value!="prompt"){
                             subject.options.length = 1;
                        }

            }',                

            )))
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label" for="inputPassword">Level</label>
        </div>
        <div class="lecturer_subject">
            <?php
            echo CHtml::dropDownList('level_id', '',array(), array(
                'prompt' => 'Select Level',
                'class' => 'form-control', 
                'onclick'=>'removeHighlight("level_id")',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('Subject/getSubjects2'),
                    'update' => '#subject',
            )))
            ?>
            <div id="level_id_error" class="error_msg" style="display: none">Please select Level</div>
        </div>
    </div>
    
    <?php /*?>
    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputPassword">Level</label>';
        
        echo '<div class="controls">'.CHtml::dropDownList('level_id', '',array(), array(
            'prompt' => 'Select Level',
            'class' => 'form-control', 
            'onclick'=>'removeHighlight("level_id")',
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('Subject/getSubjects2'),
                'update' => '#subject',
        ))).'</div>';
        ?>         
    </div>
    <?php */?>
    
    <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label" for="inputPassword">Subjects</label>
        </div>
        <div class="lecturer_subject">
            <?php
            echo CHtml::dropDownList('subject', '', 
                    array(
                        'prompt' => 'Select Subject',
                    ),array('onclick'=>'removeHighlight("subject")')
                )
            ?>
            <div id="subject_error" class="error_msg" style="display: none">Please select Subject</div>
        </div>
    </div>
    
    <?php /*?>
    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputPassword">Subjects</label>';
        
        echo '<div class="controls">'.CHtml::dropDownList('subject', '', array(
            'prompt' => 'Select Subject',
        ),array('onclick'=>'removeHighlight("subject")')
                ).'</div>';
        ?>         <br>
        <b id="subjectErr"></b>
    </div>
    <?php */?>
    <br>


   <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label" ></label>
        </div>
        <div class="lecturer_subject">
            <?php
                    echo CHtml::ajaxSubmitButton('Add Subject', CController::createUrl('SubjectLecturer/addSubject'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array('subject_id' => 'js:subject.value'),
                    'success' => 'function(data){                                       
                                                if(data.status=="success"){
                                                    removeHighlightSubjects();
                                                    var subjectList = document.getElementById("subjects");
                                                    var option = document.createElement("option");
                                                    option.text = data.subjectName;
                                                    option.value = data.subjectID;
                                                    subjectList.add(option);
                                                    removeHighlight("subject");
                                                    document.getElementById("subjectErr").innerHTML="";
        //                                            document.getElementById("subject").value=prompt;

                                                }else if(data.status=="fail"){
                                                    removeHighlightSubjects();
                                                    //hightlightTextBox("subject");
                                                    document.getElementById("subjectErr").innerHTML="";
                                                    document.getElementById("subjectErr").innerHTML=data.message;
                                                    
                                                }
                                            }'
                        ), array(
                            'class' => 'btn btn-checkout',
                            'id' => 'add_subject_button',
                            )
                )
            ?>

        </div>
        <div id="subjectErr" class="error_msg"></div>
    </div>
    
    <?php /*?>
    <div class="control-group">

        <?php
        echo '<div class="controls">'.CHtml::ajaxSubmitButton('Add Subject', CController::createUrl('SubjectLecturer/addSubject'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            'data' => array('subject_id' => 'js:subject.value'),
            'success' => 'function(data){                                       
                                        if(data.status=="success"){
                                            var subjectList = document.getElementById("subjects");
                                            var option = document.createElement("option");
                                            option.text = data.subjectName;
                                            option.value = data.subjectID;
                                            subjectList.add(option);
                                            removeHighlight("subject");
                                            document.getElementById("subjectErr").innerHTML="";
//                                            document.getElementById("subject").value=prompt;
                                            
                                        }else if(data.status=="fail"){
                                            hightlightTextBox("subject");
                                            document.getElementById("subjectErr").innerHTML="";
                                            document.getElementById("subjectErr").innerHTML=data.message;
                                        }
                                    }'
                ), array(
                    'class' => 'btn btn-checkout'
                    )
        ).'</div>';
        ?>
    </div>
    <?php */?>
    
    <br>
    <?php /*?>
    <div class="control-group">
       <div class="controls"> 
        Selected Subjects<br/>   
        <select id="subjects" name="exams" multiple="multiple" style="width:220px;height:100px;">
            
            <?php
            if (!empty($subjects)) {
                foreach ($subjects as $subject) {
                    echo '<option value='.$subject['subject_id'].'>' . $subject['subject_name'] . '</option>';
                }
            }
            ?>
        </select>
           </div>
    </div>
    <?php */?>
    
   <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label" for="inputPassword"></label>
        </div>
        <div class="lecturer_subject">
            <div id="" class="" >
                <select id="subjects" name="exams" multiple="multiple" style="width:220px;height:100px;">            
                    <?php
                    if (!empty($subjects)) {
                        foreach ($subjects as $subject) {
                            echo '<option value='.$subject['subject_id'].'>' . $subject['subject_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div id="subjects_error" class="error_message2" >Subject cannot be empty</div>
        </div>
    </div>


   <div class="control-group">
        <div class="lecturer_subject">
            <label class="control-label"></label>
        </div>
        <div class="lecturer_subject">
            <div id="" class="" >           
                    <?php
                    echo CHtml::ajaxSubmitButton('Remove Selected Subject', CController::createUrl('SubjectLecturer/removeSubject'), array(
                            'type' => 'POST', //request type
                            'dataType' => 'json',
                            'data' => array('subject_id' => 'js:subjects.value'),
                            'success' => 'function(data){                                       
                                                        if(data.status=="success" && data.subjectSelected!="Selected Subjects"){
                                                            var subjectList = document.getElementById("subjects");
                                                            subjectList.remove(subjectList.selectedIndex);
                                                            removeHighlight("subjects");
                                                        }else if(data.status=="fail"){
                                                            hightlightTextBox("subjects");
                                                        }
                                                    }'
                                ), array(
                                    'class' => 'btn btn-checkout',
                                    'id'=>'remove_selected_subject'
                                    )
                        )
                    ?>
            </div>
        </div>
    </div>
    
    <?php 
    
   
    /*
    echo '<div class="controls"> '.CHtml::ajaxSubmitButton('Remove Selected Subject', CController::createUrl('SubjectLecturer/removeSubject'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            'data' => array('subject_id' => 'js:subjects.value'),
            'success' => 'function(data){                                       
                                        if(data.status=="success" && data.subjectSelected!="Selected Subjects"){
                                            var subjectList = document.getElementById("subjects");
                                            subjectList.remove(subjectList.selectedIndex);
                                            removeHighlight("subjects");
                                        }else if(data.status=="fail"){
                                            hightlightTextBox("subjects");
                                        }
                                    }'
                ), array(
                    'class' => 'btn btn-checkout',
                    'id'=>'remove_selected_subject'
                    )
        ).'</div>';
    */
    
    
    
    $this->endWidget(); ?>

</div><!-- form -->
