<div class="well">
    
        <b><?php echo CHtml::encode($data->getAttributeLabel('news_id')); ?>:</b>
	<?php echo CHtml::encode($data->news_id); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('viewBroadcast','id'=>$data->news_id)); ?>
    
</div>
        
        
