<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subject-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'level_id'); ?>
		<?php echo $form->textField($model,'level_id'); ?>
		<?php echo $form->error($model,'level_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject_name'); ?>
		<?php echo $form->textArea($model,'subject_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'subject_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->