<div class="view">
    <div class="span6">
    <div class="form">
        
        <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-categories-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
        <p>You can change the commencement date in the following</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'commencement'); ?>
		<?php echo $form->textField($model,'commencement',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'commencement'); ?>
	</div>
        <p>&nbsp;</p>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button button-news')); ?>
	</div>

<?php $this->endWidget(); ?>
        
    </div>
</div>
</div>