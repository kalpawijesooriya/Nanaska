<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'answer_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_part_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'answer_text',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'is_correct',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
