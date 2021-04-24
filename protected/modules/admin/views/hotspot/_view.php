<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hotspot_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hotspot_id),array('view','id'=>$data->hotspot_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_name')); ?>:</b>
	<?php echo CHtml::encode($data->image_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinates')); ?>:</b>
	<?php echo CHtml::encode($data->coordinates); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />


</div>