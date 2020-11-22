<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->answer_id),array('view','id'=>$data->answer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_part_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_text')); ?>:</b>
	<?php echo CHtml::encode($data->answer_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_correct')); ?>:</b>
	<?php echo CHtml::encode($data->is_correct); ?>
	<br />


</div>