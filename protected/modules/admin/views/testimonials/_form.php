<?php
/* @var $this TestimonialsController */
/* @var $model Testimonials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testimonials-form',
    'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),

  ));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="control-group">
		<?php echo $form->labelEx($model,'testimonials_name'); ?>
		<?php echo $form->textField($model,'testimonials_name',array('size'=>60,'maxlength'=>255,'placeholder'=>'Testimonial Name','class'=>'width274')); ?>
		<?php echo $form->error($model,'testimonials_name'); ?>
	</div>

    <div class="control-group">
		<?php echo $form->labelEx($model,'testimonials_description'); ?>
		<?php echo $form->textField($model,'testimonials_description',array('size'=>60,'maxlength'=>255,'placeholder'=>'Testimonial Description','class'=>'width274')); ?>
		<?php echo $form->error($model,'testimonials_description'); ?>
	</div>

    <div class="control-group">
		<?php echo $form->labelEx($model,'image_url'); ?>
        <?php echo $form->fileField($model,'image_url'); ?>

		<?php echo $form->error($model,'image_url'); ?>
	</div>

	<div class="controls">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button button-news')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<style>

    .width274{width: 500px;}

</style>