<?php
/* @var $this TestimonialsController */
/* @var $model Testimonials */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'testimonials_id'); ?>
		<?php echo $form->textField($model,'testimonials_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'testimonials_name'); ?>
		<?php echo $form->textField($model,'testimonials_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'testimonials_description'); ?>
		<?php echo $form->textField($model,'testimonials_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image_url'); ?>
		<?php echo $form->textField($model,'image_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->