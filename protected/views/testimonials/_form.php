<?php
/* @var $this TestimonialsController */
/* @var $model Testimonials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testimonials-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'testimonials_name'); ?>
		<?php echo $form->textField($model,'testimonials_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'testimonials_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'testimonials_description'); ?>
		<?php echo $form->textField($model,'testimonials_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'testimonials_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_url'); ?>
		<?php echo $form->textField($model,'image_url',array('size'=>60)); ?>
		<?php echo $form->error($model,'image_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->