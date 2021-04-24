<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prod_cat_id')); ?>:</b>
	<?php echo CHtml::encode($data->prod_cat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_course_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_course_name); ?>
	<br />


</div>