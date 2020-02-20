<div class="form">

<?php $form=$this->beginWidget(
        'CActiveForm', array(
	    'id'=>'course-form',
	    'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
  ));

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'course_name'); ?>
		<?php echo $form->textField($model,'course_name',array('size'=>60,'maxlength'=>100,'placeholder'=>'Course Name')); ?>
		<?php echo $form->error($model,'course_name',array('style'=>'color:#B40404;')); ?>
	</div>

	<div class="controls">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button button-news')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->