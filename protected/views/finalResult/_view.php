<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('final_result_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->final_result_id),array('view','id'=>$data->final_result_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('take_id')); ?>:</b>
	<?php echo CHtml::encode($data->take_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mark')); ?>:</b>
	<?php echo CHtml::encode($data->mark); ?>
	<br />


</div>