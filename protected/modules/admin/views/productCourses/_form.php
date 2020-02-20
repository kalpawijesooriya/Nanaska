<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-courses-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'prod_cat_id'); ?>
		<?php echo $form->textField($model,'prod_cat_id'); ?>
		<?php echo $form->error($model,'prod_cat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_course_name'); ?>
		<?php echo $form->textField($model,'product_course_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'product_course_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->