<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_question_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_question_id),array('view','id'=>$data->exam_question_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />


</div>