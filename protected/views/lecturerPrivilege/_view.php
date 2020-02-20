<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_privilege_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lecturer_privilege_id),array('view','id'=>$data->lecturer_privilege_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->lecturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_management')); ?>:</b>
	<?php echo CHtml::encode($data->course_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_management')); ?>:</b>
	<?php echo CHtml::encode($data->level_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_management')); ?>:</b>
	<?php echo CHtml::encode($data->subject_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_management')); ?>:</b>
	<?php echo CHtml::encode($data->subject_area_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sitting_management')); ?>:</b>
	<?php echo CHtml::encode($data->sitting_management); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('news_management')); ?>:</b>
	<?php echo CHtml::encode($data->news_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_management')); ?>:</b>
	<?php echo CHtml::encode($data->country_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_management')); ?>:</b>
	<?php echo CHtml::encode($data->student_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_management')); ?>:</b>
	<?php echo CHtml::encode($data->lecturer_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temporary_users')); ?>:</b>
	<?php echo CHtml::encode($data->temporary_users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_management')); ?>:</b>
	<?php echo CHtml::encode($data->exam_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_management')); ?>:</b>
	<?php echo CHtml::encode($data->question_management); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('result_management')); ?>:</b>
	<?php echo CHtml::encode($data->result_management); ?>
	<br />

	*/ ?>

</div>