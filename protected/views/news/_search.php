<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'news_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'send_date_time',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'attachment',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'level_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'news_type',array('class'=>'span5','maxlength'=>512)); ?>

	<?php echo $form->textFieldRow($model,'course_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
