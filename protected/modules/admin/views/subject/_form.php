<style>
    #subject-form label.error{
        color: #B40404;
    }
</style>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'subject-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>




    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputPassword">Course <span class="required">*</span></label>';

        echo '<div class="controls">' . CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'prompt' => 'Select Course',
            'class' => 'form-control',
            'ajax' => array(
                'data' => array('course_id' => 'js:course_id.value'),
                'type' => 'POST', //request type
                'url' => CController::createUrl('Level/getLevels'),
                'update' => '#level_id',
    ))) . '</div>';
        ?> 

    </div>

    <!--<div class="control-group">-->
        <?php
//        echo '<label class="control-label" for="inputPassword">Level</label>';
        ?>         
    <!--</div>-->

    <div class="control-group">
        <?php echo $form->labelEx($model, 'level_id'); ?>
        <?php // echo $form->textField($model, 'level_id');  ?>

        <?php
        echo $form->dropDownList($model, 'level_id', array(), array(
            'prompt' => 'Select Level',
            'class' => 'form-control',
            'id' => 'level_id',
//            'ajax' => array(
//                'type' => 'POST', //request type
//                'url' => CController::createUrl('Subject/getSubjects'),
//                'update' => '#subject',
//            )
        ));
        ?>
        <?php echo $form->error($model, 'level_id'); ?>
    </div>

    <div class="control-group">
        <?php // echo $form->labelEx($model, 'level_id'); ?>
        <?php // echo $form->textField($model, 'level_id'); ?>
        <?php // echo $form->error($model, 'level_id'); ?>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'subject_name'); ?>
        <?php echo $form->textField($model, 'subject_name', array('placeholder' => 'Subject Name')); ?>
        <?php echo $form->error($model, 'subject_name'); ?>
    </div>

    <div class="controls">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button button-news')); ?>
    </div>

    <br/>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#subject-form").validate({
    
        // Specify the validation rules
        rules: {
            course_id: "required",
            "Subject[level_id]": "required",
            "Subject[subject_name]": "required"
        },
        
        // Specify the validation error messages
        messages: {
            course_id: "Please select a course",
            "Subject[level_id]": "Please select a subject",
            "Subject[subject_name]": "Please add subject area name"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
