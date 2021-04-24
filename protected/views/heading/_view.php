<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('heading_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->heading_id),array('view','id'=>$data->heading_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('heading_text')); ?>:</b>
	<?php echo CHtml::encode($data->heading_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('heading_position')); ?>:</b>
	<?php echo CHtml::encode($data->heading_position); ?>
	<br />


</div>