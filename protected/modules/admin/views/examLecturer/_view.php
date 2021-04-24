<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_lecturer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_lecturer_id), array('view', 'id'=>$data->exam_lecturer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lecturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />


</div>