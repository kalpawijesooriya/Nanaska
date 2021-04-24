<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->news_id),array('view','id'=>$data->news_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->send_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attachment')); ?>:</b>
	<?php echo '<a href="#"><img src="'.Yii::app()->basePath.'/images/NewsImageAttachments/'.$data->attachment.'">downloaddd image</a>'; ?>
        <?php echo '<a href="#">nfrjngr</a>'; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level_id')); ?>:</b>
	<?php echo CHtml::encode($data->level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_type')); ?>:</b>
	<?php echo CHtml::encode($data->news_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />

	*/ ?>

</div>