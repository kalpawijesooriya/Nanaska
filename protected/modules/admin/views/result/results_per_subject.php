<h2 class="light_heading">Results Per Subject</h2>
<Br/>

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
        
        //get results
        var result_content_obj = document.getElementById('question_details');
        var pdf_content_obj = document.getElementById('pdf_content');
        pdf_content_obj.value=result_content_obj.innerHTML;
        
        //check subject is selected
        if(subject==""){
            alert("Please Select Subject");
            return false;
        }else{
            return true;
        }
    }
</script>

<?php
$form = $this->beginWidget('CActiveForm', array(       
    'id' => '',
    'action'=>Yii::app()->createUrl('admin/result/generatePDF'),
    'method'=>'POST',
    'enableAjaxValidation'=>false,

)); ?>


<input type="hidden" name="pdf_type" value="per_subject">
<input type="hidden" name="selected_subject" id="selected_subject">
<input type="hidden" name="selected_course" id="selected_course">
<input type="hidden" name="selected_level" id="selected_level">
<input type="hidden" name="pdf_content" id="pdf_content">
<input type="submit" value="Export To PDF" class="smallbluebtn" id="submit_pdf" onclick="return setFormValues()">

<?php $this->endWidget(); ?> 


<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Course</label>';

    echo '<div class="controls">' . CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
        'prompt' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array('course_id' => 'js:course_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevels'),
            'update' => '#level_id',
            'beforeSend' => 'function() {
                  subject_id.options.length = 1;
                   resetRenderView(); 
            }',
))) . '</div>';
    ?> 

</div>

<div class="control-group">
    <?php
    echo 'Level';
    echo '<br>';
    echo CHtml::dropDownList('level_id', '', array(), array(
        'prompt' => 'Select Level',
        'ajax' => array(
            'data' => array('level_id' => 'js:level_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjects2'),
            'update' => '#subject_id',
            'beforeSend' => 'function() {                 
                   resetRenderView(); 
            }',
    )));
    ?>         
</div>

<div class="control-group">
    <?php
    echo 'Subject';
    echo '<br>';
    echo CHtml::dropDownList('subject_id', '', array(), array(
        'prompt' => 'Select Subject',
        'id' => 'subject_id',
        'ajax' => array(
            'data' => array('subject_id' => 'js:subject_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Result/getResultPerSubject'),
            'beforeSend' => 'function(){               
                $("#question_details").addClass("loading");}',
            'complete' => 'function(){                
                 $("#question_details").removeClass("loading");}',
            'update' => "#question_details",
        )
    ));
    ?>  
</div>

<div id="question_details">

</div>


<script type="text/javascript">

    function resetRenderView() {
        if (document.getElementById("question_details").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
            $.ajax({
                url: '<?php echo CController::createUrl('Result/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data: {
                    //question_id:question_id
                },
                success: function (data) {
                    $('#question_details').html(data.output);
                }
            });
        }
    }

</script>
