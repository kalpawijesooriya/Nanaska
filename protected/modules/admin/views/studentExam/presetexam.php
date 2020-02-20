<style>
    #presetexam-form label.error{
        color: #B40404;
    }
</style>


<?php
$this->breadcrumbs = array(
    'Student Exams',
);

$this->menu = array(
//	array('label'=>'Create Student Exam','url'=>array('create')),
//	array('label'=>'Manage Student Exam','url'=>array('admin')),
    //array('label'=>'Add preset exam','url'=>array('presetexam')),
    array('label' => 'Add Dynamic Exam', 'url' => array('studentExam/dynamicexam', 'id' => $id)),
    array('label' => 'Add Essay Exam', 'url' => array('studentExam/essayExam', 'id' =>$id )),
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => array('studentExam/createPresetExam'),
    'id' => 'presetexam-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
    //'class'=>'form-horizontal form-control',
    //'role'=>'form'
    )
        ));
?>

<?php
$student_id = $id;
?>
<?php
$studentDetails = Student::model()->getStudentById($student_id);
$levelDetails = Level::model()->getLevel($studentDetails['level_id']);
$courseDetails = Course::model()->getCourseDetails($levelDetails['course_id']);
?>

<h4>Preset Exam for Student Id <?php echo $student_id; ?></h4>

<div class="span4">
    <div class="well">
        <input type="hidden" value="<?php echo $student_id; ?>" id="student_id" name="student_id" />
        <div class="control-group">
            <label class="control-label" for="inputPassword">Course <span class="required">*</span></label>
            <input type="text" id="course_id" value="<?php echo $courseDetails['course_name']; ?>" readonly="true" />

            <?php
//            echo '<label class="control-label" for="inputEmail">Course <span class="required">*</span></label>';
//            echo '<div class="controls">';
//            echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
//                'prompt' => 'Select Course',
//                'ajax' => array(
//                    'type' => 'POST', //request type
//                    'data' => array('course_id' => 'js:course_id.value'),
//                    'url' => CController::createUrl('Level/GetLevelsforStudentCreation'),
//                    'update' => '#level_id',
//                    'beforeSend' => 'function() {           
//                            if(subject_id.value!=""){
//                                subject_id.options.length = 1;                             
//                            } 
//            
//        }',
//                    )));
//            echo '</div>';
            ?> 
            <?php //echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
        </div>

        <div class="control-group">  
            <label class="control-label" for="inputPassword">Level <span class="required">*</span></label>
            <input type="text" id="course_id" value="<?php echo $levelDetails['level_name']; ?>" readonly="true" />

            <?php
//            echo '<span id="level-label"> <label class="control-label" for="inputPassword">Level <span class="required">*</span></label></span>';
//            echo '<div class="controls">';
//            echo CHtml::dropDownList('level_id', '', array(), array(
//                'prompt' => 'Select Level',
//                'class' => 'form-control',
//                'ajax' => array(
//                    'data' => array('level_id' => 'js:level_id.value'),
//                    'type' => 'POST',
//                    'url' => CController::createUrl('Subject/GetSubjects'),
//                    'update' => '#subject_id',
//                )
//            ));
//            echo '</div>';
            ?>        
        </div>

        <div class="control-group">
            <?php
            echo '<label class="control-label" for="inputPassword">Subject <span class="required">*</span></label>';
            echo '<div class="controls">';
            echo CHTML::DropDownList('subject_id', '', array(), array(
                'prompt' => 'Select Subject',
                'ajax' => array(
                    'data' => array('subject_id' => 'js:subject_id.value'),
                    'type' => 'POST',
                    'url' => CController::createUrl('Exam/GetExams'),
                    'update' => '#exams',
                )
            ));
            echo '</div>';
            ?>  
        </div>

        <div class="control-group">
            <label class="control-label" for="inputPassword">Exam List <span class="required">*</span></label>
            <div class="controls">
                <select id="exams" name="exams" multiple="multiple" style="width:300px;height:100px;">

                </select>
            </div>
        </div>

        <div class="control-group">
            <input type="button" value="Add exam" class="btn" onclick="addExams()"/>
        </div>

    </div>
</div>

<div class="span4">
    <div class="well">
        <h5 class="light_heading">Selected Exams</h5>
        <select id="selected_exams" name="selected_exams[]" multiple="multiple" style="width:300px;height:100px;">


        </select>

        <div class="control-group">
            <br />
            <input type="button" value="Remove exam" class="btn" onclick="RemoveExam()"/>
        </div>
        <br/>

        <div class="control-group">
            <label class="control-label" for="inputPassword">Start Date <span class="required">*</span></label>
            <div class="controls">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'startdate',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'minDate' => 0,
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'id' => 'startdate',
                        'placeholder' => 'Select Starting Date'
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="inputPassword">End Date <span class="required">*</span></label>
            <div class="controls">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'expiredate',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'minDate' => 0,
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'id' => 'expiredate',
                        'placeholder' => 'Select Expiry Date'
                    ),
                ));
                ?>
            </div>
        </div>
        <br />
    </div>
</div>

<div class="span2">
    <div class="control-group">
        <div class="controls">               
            <?php
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news'));
            ?>
        </div>   
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        findSubjects();   //for typeahead
    })
    
    
    function findSubjects(){    
       
        $.ajax({
            url:'<?php echo CController::createUrl('Subject/getSubjectsForPresetExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data:{
                level_id:<?php echo $levelDetails['level_id']; ?>
            },
            success: function(data){
                if(data.status=="success"){                        
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
        

</script>




<script type="text/javascript">

    function addExams()
    {
        var conceptName = $('#exams').find(":selected").text();
        var opvalue = $('#exams').find(":selected").val();
        if(opvalue != undefined)
        {
            if($('#selected_exams option[value='+opvalue+']').length > 0){
                alert("Exam already selected!");
                
            }else{
                $("#selected_exams").append('<option value='+opvalue+' selected>'+conceptName+'</option>');
                
            }
        }
        else
        {
            alert("Please select an exam");
        }
        
    }

    function RemoveExam()
    {    
   
        $('#selected_exams').find(":selected").remove(); 
        $("#selected_exams option").prop("selected", "selected");
    
   
    
    }

</script>

<script>
    $(function() {
      
        $.validator.addMethod("greaterThan", 
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params).val());
            }
            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than {0}.');
  
        // Setup form validation on the #register-form element
        $("#presetexam-form").validate({     //main form id
    
            // Specify the validation rules
            rules: {
                course_id: "required",		//field ids
                level_id: "required",
                subject_id: "required",
                exams: "required",
                selected_exams:"required",
                //            startdate:"required",
                //            expiredate:"required",
                "selected_exams[]":"required",
                startdate:{
                    required:true
                },
                expiredate:{
                    required:true,
                    greaterThan: "#startdate"              
                }
            },
        
            // Specify the validation error messages
            messages: {
                course_id: "Please select a course",		//field ids
                level_id: "Please select a level",
                subject_id: "Please select a subject",
                exams: "Please add exam/exams",
                selected_exams:"required",
                //            startdate:"Please add a start date for exams",
                //            expiredate:"Please add an end date of the exam",
                "selected_exams[]":"",
                startdate:"Please enter start date of exam",
                expiredate:
                    { 
                    required:"Please enter expire date of exam",
                    greaterThan:"Exam start date cannot be greater than end date"
                }
            },
        
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
    
</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js"></script>
