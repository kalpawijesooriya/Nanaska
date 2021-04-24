<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'question_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject_area_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_type',array('class'=>'span5','maxlength'=>22)); ?>

	<?php echo $form->textFieldRow($model,'number_of_marks',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'question_text',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'exclude_from_dynamic',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
