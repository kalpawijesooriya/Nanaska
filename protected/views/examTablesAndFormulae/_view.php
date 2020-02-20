<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_tables_and_formulae_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_tables_and_formulae_id),array('view','id'=>$data->exam_tables_and_formulae_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tables_and_formulae_text')); ?>:</b>
	<?php echo CHtml::encode($data->tables_and_formulae_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tab_position')); ?>:</b>
	<?php echo CHtml::encode($data->tab_position); ?>
	<br />


</div>