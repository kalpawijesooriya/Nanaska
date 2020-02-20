<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'subject-area-form',
    'enableAjaxValidation' => false,
        ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="control-group">
    <?php
    $course_id = Subject::model()->getCourseOfSubject($model->subject_id);

    echo '<label class="control-label" for="course_id">Course <span class="required">*</span></label>';

    echo '<div class="controls">' . CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
        'options' => array($course_id => array('selected' => true)),
        'prompt' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array('course_id' => 'js:course_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevels'),
            'update' => '#level_id',
             'beforeSend' => 'function() {           
                if(subject_id.value!=""){
                    subject_id.options.length = 1;
                }
            
        }',
            
))) . '</div>';
    ?> 

</div>

<div class="control-group">
    <?php
    $level_id = Subject::model()->getLevelOfSubject($model->subject_id);

    $criteria = new CDbCriteria;
    $criteria->condition = "course_id= " . $course_id;
    $level = Level::model()->findAll($criteria);

    echo '<label class="control-label" for="level_id">Level <span class="required">*</span></label>';
    echo CHtml::dropDownList('level_id', '', CHtml::listData($level, 'level_id', 'level_name'), array(
        'options' => array($level_id => array('selected' => true)),
        'prompt' => 'Select Level',
        'ajax' => array(
            'data' => array('level_id' => 'js:level_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjects2'),
            'update' => '#subject_id',
    )));
    ?>         
</div>

<div class="control-group">
    <?php
    
    $criteria = new CDbCriteria;
    $criteria->condition = "level_id= " . $level_id;
    $subject = Subject::model()->findAll($criteria);
    
    echo '<label class="control-label" for="subject_id">Subject <span class="required">*</span></label>';
    echo $form->dropDownList($model, 'subject_id', CHtml::listData($subject, 'subject_id', 'subject_name'), array(
        'options' => array($model->subject_id => array('selected' => true)),
        'prompt' => 'Select Subject',
        'id' => 'subject_id',
//        'ajax' => array(
//            'type' => 'POST',
//            'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
//            'update' => $updateDropDowns,
//    )
    ));
    ?>  


    <br>
    <b id="subjectErr"></b>
</div>

<?php // echo $form->textFieldRow($model, 'subject_id', array('class' => 'span5'));   ?>

<?php echo $form->textFieldRow($model, 'subject_area_name', array('placeholder' => 'Subject-Area Name', 'class' => 'span5')); ?>

<!--<div class="form-actions">-->
<?php
//                $this->widget('bootstrap.widgets.TbButton', array(
//			'buttonType'=>'submit',
//			'type'=>'primary',
//			'label'=>$model->isNewRecord ? 'Create' : 'Save',
//		)); 
?>
<!--</div>-->

<div class="controls">
    <br/>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class' => 'button button-news')); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
  $( document ).ready(function() {
  
    // Setup form validation on the #register-form element
    $("#subject-area-form").validate({
    
        // Specify the validation rules
        rules: {
            course_id: "required",
            level_id: "required",
            subject_id: "required",
            "SubjectArea[subject_id]": "required",
            "SubjectArea[subject_area_name]": "required"
           
            
            
            
            
        },
        
        // Specify the validation error messages
        messages: {
            course_id: "Please select a course",
            level_id: "Please select a level",
            subject_id: "Please select a subject",
            "SubjectArea[subject_id]": "Please select a subject",
            "SubjectArea[subject_area_name]": "Please add subject area name"
           
            
            
            
            
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  }); //document ready
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>