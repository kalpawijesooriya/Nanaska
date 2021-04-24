<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_subject_area_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_subject_area_id),array('view','id'=>$data->exam_subject_area_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_id')); ?>:</b>
	<?php echo CHtml::encode($data->subject_area_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weightage')); ?>:</b>
	<?php echo CHtml::encode($data->weightage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('single_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->single_answer_weightage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multiple_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->multiple_answer_weightage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_written_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->short_written_answer_weightage); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('drag_drop_typea_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->drag_drop_typea_answer_weightage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('drag_drop_typeb_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->drag_drop_typeb_answer_weightage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multiple_choice_answer_weightage')); ?>:</b>
	<?php echo CHtml::encode($data->multiple_choice_answer_weightage); ?>
	<br />

	*/ ?>

</div>