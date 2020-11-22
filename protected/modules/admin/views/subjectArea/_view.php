<div class="well">

	<b><?php echo 'Subject-Area ID' ?>:</b>
	<?php echo $data->subject_area_id; ?>
	<br />

        <b><?php echo 'Course'; ?>:</b>
	<?php echo Course::model()->getCourseName(Subject::model()->getCourseOfSubject($data->subject_id)); ?>
	<br />
        
        <b><?php echo 'Level'; ?>:</b>
	<?php echo Level::model()->getLevelName(Subject::model()->getLevelOfSubject($data->subject_id)); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php echo Subject::model()->getSubjectName($data->subject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_name')); ?>:</b>
	<?php echo CHtml::encode($data->subject_area_name); ?>
	<br />
        <br />
        
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->subject_area_id)); ?>



</div>