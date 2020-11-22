<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_text_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->question_part_text_id),array('view','id'=>$data->question_part_text_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_text')); ?>:</b>
	<?php echo CHtml::encode($data->question_part_text); ?>
	<br />


</div>