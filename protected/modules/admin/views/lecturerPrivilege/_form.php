<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'lecturer-privilege-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'lecturer_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'course_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'level_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject_area_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sitting_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'news_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'country_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'student_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lecturer_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'temporary_users',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exam_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'question_management',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'result_management',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
