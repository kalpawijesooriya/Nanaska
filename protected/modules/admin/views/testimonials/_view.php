<?php
/* @var $this TestimonialsController */
/* @var $data Testimonials */
?>

<div class="well">

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_id')); ?>:</b>
	<?php echo CHtml::encode($data->testimonials_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_name')); ?>:</b>
	<?php echo CHtml::encode($data->testimonials_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('testimonials_description')); ?>:</b>
	<?php echo CHtml::encode($data->testimonials_description); ?>
	<br />
	<br />
    <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->testimonials_id)); ?>

</div>