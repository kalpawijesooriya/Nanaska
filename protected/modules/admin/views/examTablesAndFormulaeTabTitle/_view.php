<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_tables_and_formulae_tab_title_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->exam_tables_and_formulae_tab_title_id),array('view','id'=>$data->exam_tables_and_formulae_tab_title_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exam_tables_and_formulae_id')); ?>:</b>
	<?php echo CHtml::encode($data->exam_tables_and_formulae_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tab_title')); ?>:</b>
	<?php echo CHtml::encode($data->tab_title); ?>
	<br />


</div>