<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'frontend-payment-form',
	'enableAjaxValidation'=>false,
)); ?>
        <p class="help-block">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="well">
            
            <div class="control-group">
                <?php echo $form->textFieldRow($model, 'first_name', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>
            </div>
            <?php echo $form->textFieldRow($model, 'last_name', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'address', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'cima_id', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'contact_no', array('class' => 'span5', 'maxlength' => 50, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'course', array('class' => 'span5', 'maxlength' => 255, 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'amount', array('class' => 'span5', 'readonly'=>'readonly')); ?>

            <?php echo $form->textFieldRow($model, 'ref_no', array('class' => 'span5', 'maxlength' => 50, 'readonly'=>'readonly')); ?>
            
            <?php echo $form->textFieldRow($model, 'transaction_id', array('class' => 'span5', 'maxlength' => 50, 'readonly'=>'readonly')); ?>

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
   
<?php $this->endWidget(); ?>
