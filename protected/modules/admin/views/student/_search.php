<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="control-group">
		<?php echo $form->label($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->label($model,'level_id'); ?>
		<?php echo $form->textField($model,'level_id'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->label($model,'sitting_id'); ?>
		<?php echo $form->textField($model,'sitting_id'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>
    
	<div class="control-group">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array('ACTIVE'=>'ACTIVE','INACTIVE'=>'INACTIVE')); ?>
	</div>

	<div class="controls">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->