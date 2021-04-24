<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exam-lecturer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lecturer_id'); ?>
		<?php echo $form->textField($model,'lecturer_id'); ?>
		<?php echo $form->error($model,'lecturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exam_id'); ?>
		<?php echo $form->textField($model,'exam_id'); ?>
		<?php echo $form->error($model,'exam_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->