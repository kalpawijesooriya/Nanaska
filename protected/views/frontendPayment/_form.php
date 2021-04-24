<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'frontend-payment-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="container">
    <div class="span2"></div>
    <div class="span8">

        <h3 class="master_heading">Payment</h3>
        <p class="help-block">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="well">
            
            <div class="control-group">
                <?php echo $form->textFieldRow($model, 'first_name', array('class' => 'span5', 'maxlength' => 255)); ?>
            </div>
            <?php echo $form->textFieldRow($model, 'last_name', array('class' => 'span5', 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'address', array('class' => 'span5', 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'cima_id', array('class' => 'span5', 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'contact_no', array('class' => 'span5', 'maxlength' => 50)); ?>

            <?php echo $form->textFieldRow($model, 'course', array('class' => 'span5', 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'amount', array('class' => 'span5')); ?>

            <?php echo $form->textFieldRow($model, 'ref_no', array('class' => 'span5', 'maxlength' => 50)); ?>

            <?php echo $form->textFieldRow($model, 'status', array('class' => 'span5', 'maxlength' => 50)); ?>

        </div>
        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Create' : 'Save',
            ));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
