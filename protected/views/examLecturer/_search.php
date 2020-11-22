<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'exam_lecturer_id'); ?>
		<?php echo $form->textField($model,'exam_lecturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lecturer_id'); ?>
		<?php echo $form->textField($model,'lecturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exam_id'); ?>
		<?php echo $form->textField($model,'exam_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->