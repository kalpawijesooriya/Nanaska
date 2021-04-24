<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->question_part_id),array('view','id'=>$data->question_part_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_part_name')); ?>:</b>
	<?php echo CHtml::encode($data->question_part_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />


</div>