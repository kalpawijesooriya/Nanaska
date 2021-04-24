<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'exam_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exam_name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'number_of_questions',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exam_type',array('class'=>'span5','maxlength'=>7)); ?>

	<?php echo $form->textFieldRow($model,'time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'calculator_allowed',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
