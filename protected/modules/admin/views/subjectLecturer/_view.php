<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_lecturer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subject_lecturer_id), array('view', 'id'=>$data->subject_lecturer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lecturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_id); ?>
	<br />


</div>