<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('paper_question_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->paper_question_id),array('view','id'=>$data->paper_question_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('take_id')); ?>:</b>
	<?php echo CHtml::encode($data->take_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_part_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_id')); ?>:</b>
	<?php echo CHtml::encode($data->answer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_taken')); ?>:</b>
	<?php echo CHtml::encode($data->time_taken); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_marked')); ?>:</b>
	<?php echo CHtml::encode($data->question_marked); ?>
	<br />


</div>