<div class="well">

	<b>Session ID:</b>
	<?php echo CHtml::encode($data->sitting_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sitting_name')); ?>:</b>
	<?php echo CHtml::encode($data->sitting_name); ?>
	<br />
        <br/>
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->sitting_id)); ?>


</div>