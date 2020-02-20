<div class="well">

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_name')); ?>:</b>
	<?php echo CHtml::encode($data->country_name); ?>
	<br />

        <br/>
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->country_id)); ?>
</div>