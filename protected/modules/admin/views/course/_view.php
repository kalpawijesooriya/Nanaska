<div class="well">

	<b>Course ID:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_name')); ?>:</b>
	<?php echo CHtml::encode($data->course_name); ?>
	<br />
        <br />
        
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->course_id)); ?>


</div>