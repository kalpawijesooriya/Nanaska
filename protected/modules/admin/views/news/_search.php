<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'news_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subject',array('class'=>'span5','maxlength'=>255,'placeholder'=>'Subject')); ?>

	<?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8','placeholder'=>'Message')); ?>

	<?php echo $form->textFieldRow($model,'level_id',array('class'=>'span5','placeholder'=>'Level')); ?>
        <br /><br />
	<?php
       // echo $form->textFieldRow($model,'news_type',array('class'=>'span5','maxlength'=>512,'placeholder'=>'News Type'));
       // echo $form->dropDownList($model,'news_type',  array('LEVEL_NEWS'=>'Level News', 'BROADCAST_NEWS'=> 'Broadcast News'),array('empty'=>"Select News Type"));
        echo $form->dropDownList($model,'news_type',  array('Level News'=>'Level News', 'Broadcast News'=> 'Broadcast News'),array('empty'=>"Select News Type"));
        ?>
        

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
