<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'exam_tables_and_formulae_tab_title_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exam_tables_and_formulae_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'tab_title',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
