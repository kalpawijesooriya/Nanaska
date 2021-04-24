<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_exam_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->student_exam_id),array('view','id'=>$data->student_exam_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiry_date); ?>
	<br />


</div>