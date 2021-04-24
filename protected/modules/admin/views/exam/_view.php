<div class="well">

	<b>Exam ID:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject_id')); ?>:</b>
	<?php 
        
        echo Subject::model()->getSubjectName($data->subject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_name')); ?>:</b>
	<?php echo CHtml::encode($data->exam_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_questions')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_questions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_type')); ?>:</b>
	<?php echo CHtml::encode($data->exam_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php
        
        if($data->time =="1"){
         echo $data->time." minute";
     }else{
         echo $data->time." minutes";
     }           
        
         ?>
	<br />  

	<b><?php echo CHtml::encode($data->getAttributeLabel('calculator_allowed')); ?>:</b>
	<?php 
        
        $calAllowedBool = $data->calculator_allowed;
        
        if($calAllowedBool==1){
            echo 'Yes';
        }else{
            echo 'No';
        }
        
        ?>
        <br/>
        <b><?php echo CHtml::encode($data->getAttributeLabel('exam_price')); ?>:</b>
	<?php echo CHtml::encode($data->exam_price); ?>
        
	<br />
        <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php 
        $status = $data->status;
        if($status==1){
            echo 'Active';
        }  else if($status==0){
            echo 'In-Active';
        }
        ?>
	<br />
        <br/>
        <?php echo CHtml::link(CHtml::encode("View In Detail"),array('view','id'=>$data->exam_id)); ?>

</div>