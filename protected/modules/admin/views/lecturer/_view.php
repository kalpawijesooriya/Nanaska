<div class="well">
    
        <?php
        $userData=  User::getUserInfoById($data->user_id);
        ?>
    

	<b>Lecturer ID:</b>
	<?php echo CHtml::encode($data->lecturer_id); ?>
	<br />

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />-->
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('lecturer_Code')); ?>:</b>
	<?php echo CHtml::encode($data->lecturer_code); ?>
	<br />
        
        <b>Name:</b>
        <?php echo $userData['first_name']." ". $userData['last_name'] ?>
        <br/>
        
        <b>E-mail:</b>
        <?php echo $userData['email'] ?>
        <br/>
        <br/>
        <?php echo CHtml::link("View In Detail", array('view', 'id'=>$data->lecturer_id)); ?>
</div>