<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'exam-subject-area-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'exam_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject_area_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'single_answer_weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'multiple_answer_weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'short_written_answer_weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'drag_drop_typea_answer_weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'drag_drop_typeb_answer_weightage',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'multiple_choice_answer_weightage',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
