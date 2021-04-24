<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sitting_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sitting_id), array('view', 'id'=>$data->sitting_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sitting_name')); ?>:</b>
	<?php echo CHtml::encode($data->sitting_name); ?>
	<br />


</div>