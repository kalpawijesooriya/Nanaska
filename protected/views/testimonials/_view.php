<?php
/* @var $this TestimonialsController */
/* @var $data Testimonials */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->testimonials_id), array('view', 'id'=>$data->testimonials_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_name')); ?>:</b>
	<?php echo CHtml::encode($data->testimonials_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_description')); ?>:</b>
	<?php echo CHtml::encode($data->testimonials_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_url')); ?>:</b>
	<?php echo CHtml::encode($data->image_url); ?>
	<br />


</div>