<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'paper_question_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'take_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_part_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'answer_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'time_taken',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_marked',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
