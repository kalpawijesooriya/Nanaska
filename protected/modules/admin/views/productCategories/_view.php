<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commencement')); ?>:</b>
	<?php echo CHtml::encode($data->commencement); ?>
	<br />-->
        
<div class="row">
            <div class="span6 well transparent">

                <div class="border-seperated">
                        
                        <div class="dashbord-sub-menu"> <?php echo CHtml::link(CHtml::encode($data->product_name), array('View', 'id'=>$data->id), array('class'=>'user_text')); ?> </div> 
                        
                    </div>
            </div>
           
        </div>
    </div>
