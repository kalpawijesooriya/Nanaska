<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_exam_order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subject_exam_order_id),array('view','id'=>$data->subject_exam_order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />


</div>