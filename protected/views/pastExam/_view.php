<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('past_exam_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->past_exam_id),array('view','id'=>$data->past_exam_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('take_id')); ?>:</b>
	<?php echo CHtml::encode($data->take_id); ?>
	<br />


</div>