<div class="well">

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_id')); ?>:</b>
	<?php echo CHtml::encode($data->news_id); ?>
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
        
        <?php
            if($data->news_type=='BROADCAST_NEWS'){
                
            }else{
        ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('attachment')); ?>:</b>
	 
        <?php 
        if($data->attachment==NULL){
            echo 'Attachment not set';
        }else{
            echo '<a href="'.Yii::app()->baseUrl. '/images/NewsImageAttachments/' . $data->news_id . '/'.$data->attachment.'" download>Download Attachment</a>';
        }        
       // echo '<a href="'.Yii::app()->baseUrl.'/images/NewsImageAttachments/'.$data->attachment.'" download>'; echo $name.'</a>';
               
        ?>
       
	<br />
	
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('level_id'));?>:</b>
        <?php        
        echo Level::model()->getLevelNameForNews($data->level_id); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id'));?>:</b>
	<?php
        $levelData = Level::model()->getLevelForNews($data->level_id);
      
        if($levelData!='No'){            
        echo Course::model()->getCourseName($levelData['course_id']);
        }  ?>	
	<br />
	<?php } ?>
        
        <?php  
        
            if($data->news_type=='BROADCAST_NEWS'){
                echo CHtml::link(CHtml::encode("View In Detail"),array('viewBroadcast','id'=>$data->news_id)); 
            }else{
              //  echo $data->news_type;die();
                echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->news_id));
            }
        ?>
</div>