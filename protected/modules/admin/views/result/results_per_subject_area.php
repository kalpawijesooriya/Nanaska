<script type="text/javascript">
    function setFormValues(){
        //set selected course
        var course_id_obj = document.getElementById('course_id');
        var course = course_id_obj.options[course_id_obj.selectedIndex].value; 
        var selected_course_obj = document.getElementById('selected_course');
        selected_course_obj.value=course;
        
        //get selected level
        var level_id_obj = document.getElementById('level_id');
        var level = level_id_obj.options[level_id_obj.selectedIndex].value;
        var selected_level_obj = document.getElementById('selected_level');
        selected_level_obj.value=level;
        
        //get selected subject
        var subject_id_obj = document.getElementById('subject_id');
        var subject = subject_id_obj.options[subject_id_obj.selectedIndex].value;    
        var selected_subject_obj = document.getElementById('selected_subject');
        selected_subject_obj.value=subject;
        
        //get selected subject
        var subject_area_id_obj = document.getElementById('subject_area_id');
        var subject_area = subject_area_id_obj.options[subject_area_id_obj.selectedIndex].value;    
        var selected_subject_area_obj = document.getElementById('selected_subject_area');
        selected_subject_area_obj.value=subject_area;
        
        //get results
        var result_content_obj = document.getElementById('results');
        var pdf_content_obj = document.getElementById('pdf_content');
        pdf_content_obj.value=result_content_obj.innerHTML;
        
        //check subject is selected
        if(subject_area==""){
            alert("Please Select Subject Area");
            return false;
        }else{
            return true;
        }
    }
</script>

    

<h2 class="light_heading">Results Per Subject Area</h2>

<br/>

<?php
$form = $this->beginWidget('CActiveForm', array(       
    'id' => '',
    'action'=>Yii::app()->createUrl('admin/result/generatePDF'),
    'method'=>'POST',
    'enableAjaxValidation'=>false,

)); ?>


<input type="hidden" name="pdf_type" value="per_subject_area">
<input type="hidden" name="selected_subject" id="selected_subject">
<input type="hidden" name="selected_course" id="selected_course">
<input type="hidden" name="selected_level" id="selected_level">
<input type="hidden" name="selected_subject_area" id="selected_subject_area">
<input type="hidden" name="pdf_content" id="pdf_content">
<input type="submit" value="Export To PDF" class="smallbluebtn" id="submit_pdf" onclick="return setFormValues()">

<?php $this->endWidget(); ?> 

<div class="control-group"> 
    <?php
    echo 'Course';
    echo '<br>';
    echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
        'empty' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array("course_id" => 'js:course_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevels'),
            'update' => '#level_id',
            'beforeSend' => 'function() {
                subject_id.options.length = 1;
                subject_area_id.options.length = 1;
                resetRenderView(); 
            }',
            )));
    ?> 
    <b id="course_error"></b>
</div>

<div class="control-group"> 
    <?php
    echo 'Level';
    echo '<br>';
    echo CHtml::dropDownList('level_id', '', array(), array(
        'empty' => 'Select Level',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array("level_id" => 'js:level_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjects'),
            'update' => '#subject_id',
            'beforeSend' => 'function() {
                  subject_area_id.options.length = 1;
                  resetRenderView(); 
            }',
            )));
    ?>   </div>   


<div class="control-group"> 
    <?php
    echo 'Subject';
    echo '<br>';
    echo CHtml::dropDownList('subject_id', '', array(), array(
        'empty' => 'Select Subject',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array("subject_id" => 'js:subject_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
            'update' => '#subject_area_id',
            'beforeSend' => 'function() {                
                  resetRenderView(); 
            }',
            )));
    ?></div>


<div class="control-group"> 
    <?php
    echo 'Subject Area';
    echo '<br>';
    echo CHtml::dropDownList('subject_area_id', '', array(), array(
        'empty' => 'Select Subject Area',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array("subject_area_id" => 'js:subject_area_id.value',
                "subject_id" => "js:subject_id.value"),
            'type' => 'POST', //request type           
            'url' => CController::createUrl('Result/getResultsPerSubjectArea'),
            'beforeSend' => 'function(){               
                $("#results").addClass("loading");}',
            'complete' => 'function(){                
                 $("#results").removeClass("loading");}',
            'update' => '#results',
            )));
    ?></div>

<div id="results">

</div>


<script type="text/javascript">

    function resetRenderView(){ 
        if(document.getElementById("results").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
            $.ajax({
                url:'<?php echo CController::createUrl('Result/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    //question_id:question_id
                },          
                success: function(data){                
                    $('#results').html(data.output);
                }
            });
        }
    }

</script>