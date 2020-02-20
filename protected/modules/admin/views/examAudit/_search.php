<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'exam_audit_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exam_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'action',array('class'=>'span5','maxlength'=>4)); ?>

	<?php echo $form->textFieldRow($model,'date',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'time',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
