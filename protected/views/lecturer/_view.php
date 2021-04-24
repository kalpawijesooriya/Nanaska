<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lecturer_id), array('view', 'id'=>$data->lecturer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />


</div>