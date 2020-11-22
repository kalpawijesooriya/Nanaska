<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->level_id), array('view', 'id'=>$data->level_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_name')); ?>:</b>
	<?php echo CHtml::encode($data->level_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />


</div>