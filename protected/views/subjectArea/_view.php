<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subject_area_id),array('view','id'=>$data->subject_area_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_name')); ?>:</b>
	<?php echo CHtml::encode($data->subject_area_name); ?>
	<br />


</div>