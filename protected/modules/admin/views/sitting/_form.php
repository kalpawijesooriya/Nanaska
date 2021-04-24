<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sitting-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'sitting_name'); ?>
		<?php echo $form->textField($model,'sitting_name',array('size'=>60,'maxlength'=>100, 'placeholder'=>'Session Name')); ?>
		<?php echo $form->error($model,'sitting_name', array('style'=>'color:#B40404;')); ?>
	</div>

	<div class="controls">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button button-news')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->