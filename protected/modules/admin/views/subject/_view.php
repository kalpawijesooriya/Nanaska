<div class="well">

	<b>Subject ID:</b>
	<?php echo CHtml::encode($data->subject_id); ?>
	<br />

	<b>Course:</b>
	<?php 
        
        $levelData = Level::model()->getLevel($data->level_id);
        
        echo Course::model()->getCourseName($levelData['course_id']); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('level_id')); ?>:</b>
	<?php 
       
        echo Level::model()->getLevelName($data->level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_name')); ?>:</b>
	<?php echo CHtml::encode($data->subject_name); ?>
	<br />
        <br />
        
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->subject_id)); ?>


</div>