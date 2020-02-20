<div class="well">

	<b>Level ID:</b>
	<?php echo CHtml::encode($data->level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_name')); ?>:</b>
	<?php echo CHtml::encode($data->level_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo Course::model()->getCourseName($data->course_id); ?>
	<br />
        <br/>
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->level_id)); ?>


</div>