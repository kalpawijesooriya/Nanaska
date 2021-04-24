<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'answer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'question_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_part_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'answer_text',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'is_correct',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
