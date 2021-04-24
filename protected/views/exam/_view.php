<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_id),array('view','id'=>$data->exam_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_name')); ?>:</b>
	<?php echo CHtml::encode($data->exam_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_questions')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_questions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_type')); ?>:</b>
	<?php echo CHtml::encode($data->exam_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calculator_allowed')); ?>:</b>
	<?php echo CHtml::encode($data->calculator_allowed); ?>
	<br />


</div>