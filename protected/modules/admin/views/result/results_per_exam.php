<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<h3 class="light_heading">Results Per Exam</h3>


<script>
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
        
        
        //get selected exam
        var exam_id_obj = document.getElementById('exam_id');
        var exam = exam_id_obj.options[exam_id_obj.selectedIndex].value;    
        var selected_exam_obj = document.getElementById('selected_exam');
        selected_exam_obj.value=exam;        
        
        //get selected from date
        var from_date = document.getElementById('from_date').value;
        var selected_from_date_obj = document.getElementById('selected_from_date');
        selected_from_date_obj.value=from_date;
        
        //get selected to date
        var to_date = document.getElementById('to_date').value;
        var selected_to_date_obj = document.getElementById('selected_to_date');
        selected_to_date_obj.value=to_date;
        
        //get results
        var result_content_obj = document.getElementById('result_content');
        var pdf_content_obj = document.getElementById('pdf_content');
        pdf_content_obj.value=result_content_obj.innerHTML;
    
        //check exam is selected
        if(exam==""){
            alert("Please Select exam");
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

<input type="hidden" name="pdf_type" value="per_exam">
<input type="hidden" name="selected_course" id="selected_course">
<input type="hidden" name="selected_level" id="selected_level">
<input type="hidden" name="selected_subject" id="selected_subject">
<input type="hidden" name="selected_from_date" id="selected_from_date">
<input type="hidden" name="selected_to_date" id="selected_to_date">
<input type="hidden" name="selected_exam" id="selected_exam">
<input type="hidden" name="pdf_content" id="pdf_content">


<input type="submit" value="Export To PDF" class="smallbluebtn" id="submit_pdf" onclick="return setFormValues()">

<?php $this->endWidget(); ?> 


<?php
//Yii::app()->session['drag_drop_typeb_session'] = array();

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => '',
    'id' => 'question-form',
    'enableAjaxValidation' => false,
//        'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
        ));
?>

<?php //echo $form->errorSummary($model); ?>

<div class="control-group"> 
    <?php
    echo 'Course';
    echo '<br>';
    echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
        'empty' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevels'),
            'update' => '#level_id',
            'beforeSend' => 'function() {               
                subject_id.options.length = 1;
                exam_id.options.length = 1; 
                resetRenderView();                
                
                }',
            )));
    ?> 
    <?php //echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
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
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjects'),
            'update' => '#subject_id',
            'beforeSend' => 'function() {
                exam_id.options.length = 1;
                resetRenderView(); 
                }',
            )));
    ?>   </div>   

<?php //echo $form->error($model, 'level_id', array('class' => 'alert alert-danger')); ?>


<div class="control-group"> 
    <?php
    echo 'Subject';
    echo '<br>';
    echo CHtml::dropDownList('subject_id', '', array(), array(
        'empty' => 'Select Subject',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('exam/GetExams'),
            'update' => '#exam_id',
            'beforeSend' => 'function() {                    
                 resetRenderView(); 
                }',
            )));
    ?>
</div>

<div class="control-group">
    <span>From</span><br/>
    <input type="text" name="from_date" id="from_date" class="getdate" placeholder="From Date">
</div>

<div class="control-group">
    <span>To</span><br/>
    <input type="text" name="to_date" id="to_date" class="getdate" placeholder="To Date">
</div>

<div class="control-group"> 
    <?php
    echo 'Exam';
    echo '<br>';
    echo CHtml::dropDownList('exam_id', '', array(), array(
        'empty' => 'Select Exam',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'data' => array(
                'exam_id' => 'js:exam_id.value',
                'start_date' => 'js:from_date.value',
                'end_date' => 'js:to_date.value'
//                    'from_date' => 'js:from_date.value',
//                    'to_date' => 'js:to_date'
            ),
            'url' => CController::createUrl('take/getResultPerExam'),
            'beforeSend' => 'function(){               
                $("#question_details").addClass("loading");}',
            'complete' => 'function(){                
                 $("#question_details").removeClass("loading");}',
            'update' => '#result_content',
        )
    ));
    ?>
</div>


<div class="control-group" id="result_content">

</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function() {
        $( ".getdate" ).datepicker({ dateFormat: 'yy/mm/dd' });
    });
</script>

<script type="text/javascript">

    function resetRenderView(){ 
        if(document.getElementById("result_content").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
            $.ajax({
                url:'<?php echo CController::createUrl('Result/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    //question_id:question_id
                },          
                success: function(data){                
                    $('#result_content').html(data.output);
                }
            });
        }
    }

</script>