<script type="text/javascript">
    
    $(document).ready(function() {
        ajaxCall();     //for typeahead
    })
    

    function ajaxCall(){
        $.ajax({
            url:'<?php echo CController::createUrl('Student/getAllStudentEmails'); ?>',
            type: 'POST', //request type
            dataType: 'json',         
            success: function(data){
                if(data){
                    $('#product_search').typeahead({
                        source: function(query, process) {
                            return data;
                        }
                    });
                }
            }
        });
    }
    
    
    function findCourse(){
        var typehead = document.getElementById("product_search");
        if(typehead.value!=""){
            $.ajax({
                url:'<?php echo CController::createUrl('Student/getCourseForEmail'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    email:typehead.value
                },               
                success: function(data){
                    if(data.status=="success"){
                        var courseElement = document.getElementById("course_name");
                        courseElement.value = data.courseName;
                        var levelElement = document.getElementById("level_name");
                        levelElement.value= data.levelName;
                        
                        document.getElementById('subject_id').options.length = 1;
                                                
                        var arr = new Array();
                        arr = data.subjectDetails;
                        var lenght = arr.length;
                        for(i=0; i< lenght;i++){                          
                            $('#subject_id').append($(data.subjectDetails[i]));
                        } 
                    }
                }
            });
        }
        
    }

</script>

<script type="text/javascript">

    function resetRenderView(){
        if(document.getElementById("past_exam_summary").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
                 
            $.ajax({
                url:'<?php echo CController::createUrl('Result/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    //question_id:question_id
                },          
                success: function(data){                
                    $('#past_exam_summary').html(data.output);
                }
            });
        
        }
    }

</script>

<script>
    function setFormValues(){
        //set selected student email
        var student_email_obj = document.getElementById('product_search');
        var student_email = student_email_obj.value; 
        var selected_student_email_obj = document.getElementById('selected_student_email');
        selected_student_email_obj.value=student_email;
        
        //set selected course
        var course_id_obj = document.getElementById('course_name');
        var course = course_id_obj.value; 
        var selected_course_obj = document.getElementById('selected_course');
        selected_course_obj.value=course;
        
        //get selected level
        var level_id_obj = document.getElementById('level_name');
        var level = level_id_obj.value;
        var selected_level_obj = document.getElementById('selected_level');
        selected_level_obj.value=level;
        
        //get selected subject
        var subject_id_obj = document.getElementById('subject_id');
        var subject = subject_id_obj.options[subject_id_obj.selectedIndex].value;    
        var selected_subject_obj = document.getElementById('selected_subject');
        selected_subject_obj.value=subject;             
        
        //get selected exam
        var exam_id_obj = document.getElementById('exam_id');
        var exam = exam_id_obj.options[exam_id_obj.selectedIndex].value;    
        var selected_exam_obj = document.getElementById('selected_exam');
        selected_exam_obj.value=exam;        
        
        //get selected take
        var take_id_obj = document.getElementById('take_id');
        var take = take_id_obj.options[take_id_obj.selectedIndex].text;    
        var take_id = take_id_obj.options[take_id_obj.selectedIndex].value;    
        var selected_take_obj = document.getElementById('selected_take');
        selected_take_obj.value=take;        
        
        
        //get results
        var result_content_obj = document.getElementById('past_exam_summary');
        var pdf_content_obj = document.getElementById('pdf_content');
        pdf_content_obj.value=result_content_obj.innerHTML;

        //check take is selected
        if(take_id==""){
            alert("Please Select Take");
            return false;
        }else{
            return true;
        }
        
    }
</script>

<h2 class="light_heading">Results Per Student</h2>
<br/>

<?php
$form = $this->beginWidget('CActiveForm', array(       
    'id' => '',
    'action'=>Yii::app()->createUrl('admin/result/generatePDF'),
    'method'=>'POST',
    'enableAjaxValidation'=>false,

)); ?>

<input type="hidden" name="pdf_type" value="per_student">
<input type="hidden" name="selected_student_email" id="selected_student_email">
<input type="hidden" name="selected_course" id="selected_course">
<input type="hidden" name="selected_level" id="selected_level">
<input type="hidden" name="selected_subject" id="selected_subject">
<input type="hidden" name="selected_exam" id="selected_exam">
<input type="hidden" name="selected_take" id="selected_take">
<input type="hidden" name="pdf_content" id="pdf_content">


<input type="submit" value="Export To PDF" class="smallbluebtn" id="submit_pdf" onclick="return setFormValues()">

<?php $this->endWidget(); ?> 


<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Student Email</label>';
    echo '<input type="text" id="product_search" data-provide="typeahead">';
    echo '<input type="button" id="find_course" value="Find" class="btn" onclick="resetRenderView(),findCourse()">';
    echo '<div class="controls">';
    echo '</div>';
    ?> 

</div>

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Course</label>';
    echo '<div class="controls">';
    echo '<input type="text" id="course_name" value="course name" readonly="true">';
    echo '</div>';
    ?> 

</div>

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Level</label>';
    echo '<div class="controls">';
    echo '<input type="text" id="level_name" value="level name" readonly="true">';
    echo '</div>';
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
            'data' => array('subject_id' => 'js:subject_id.value',
                'student_email' => 'js:product_search.value',
            ),
            'type' => 'POST',
            'url' => CController::createUrl('Exam/getExamsForStudent'),
            'update' => '#exam_id',
            'beforeSend' => 'function() { 
                take_id.options.length = 1;
                resetRenderView();
            }',
        )
    ));
    ?>  

</div>

<div class="control-group">
    <?php
    echo 'Exam';
    echo '<br>';
    echo CHtml::dropDownList('exam_id', '', array(), array(
        'prompt' => 'Select Exam',
        'id' => 'exam_id',
        'ajax' => array(
            'data' => array('student_email' => 'js:product_search.value',
                'exam_id' => 'js:exam_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Exam/getTakes'),
            'update' => '#take_id',
            'beforeSend' => 'function() {                            
               resetRenderView();
            }',
        )
    ));
    ?>         
</div>

<div class="control-group">
    <?php
    echo 'Take';
    echo '<br>';
    echo CHtml::dropDownList('take_id', '', array(), array(
        'prompt' => 'Select Take',
        'ajax' => array(
            'data' => array('student_email' => 'js:product_search.value',
                'exam_id' => 'js:exam_id.value',
                'take_id' => 'js:take_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Exam/getExamSummaryForResultsManagement'),
            'beforeSend' => 'function(){               
                $("#question_details").addClass("loading");}',
            'complete' => 'function(){                
                 $("#question_details").removeClass("loading");}',
            'update' => '#past_exam_summary',
        )
    ));
    ?>         
</div>

<div id="past_exam_summary">

</div>