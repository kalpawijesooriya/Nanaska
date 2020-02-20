<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->question_id),array('view','id'=>$data->question_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_area_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_type')); ?>:</b>
	<?php echo CHtml::encode($data->question_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_marks')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_marks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_text')); ?>:</b>
	<?php echo CHtml::encode($data->question_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exclude_from_dynamic')); ?>:</b>
	<?php echo CHtml::encode($data->exclude_from_dynamic); ?>
	<br />


</div>