
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'class' => 'form-horizontal form-control',
        'role' => 'form'
    )
        ));
?>
<div class="well well-no-background">
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>
    <br />
        <?php //echo $form->errorSummary($model);  ?>

    <div class="control-group">
            <?php echo $form->labelEx($model, 'first_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 100, 'value' => $model->first_name, 'class' => 'span5')); ?>
<?php echo $form->error($model, 'first_name'); ?></div>
    </div>

    <div class="control-group">
            <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 100, 'value' => $model->last_name, 'class' => 'span5')); ?>
<?php echo $form->error($model, 'last_name'); ?></div>
    </div>

    <div class="control-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100, 'value' => $model->email, 'class' => 'span5', 'readonly'=>true)); ?>
<?php echo $form->error($model, 'email'); ?></div>
    </div>



    <div class="control-group">
            <?php echo $form->labelEx($model, 'phone_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'phone_number', array('value' => $model->phone_number, 'class' => 'span5')); ?>
<?php echo $form->error($model, 'phone_number'); ?></div>
    </div>

    <div class="control-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100, 'value' => $model->address, 'class' => 'span5')); ?>
<?php echo $form->error($model, 'address'); ?></div>
    </div>
    
    <div class="control-group">
        <div class="span2" style="margin-left: 0px;"></div>
        <p>Please contact <?php echo CHtml::link('here', array('site/contact')) ?> to change your email</p>
    </div>
    

    <div class="form-actions form-actions-no-background">
<?php echo CHtml::submitButton('Save', array('class' => 'button button-news')); ?>
    </div>
</div>

<div class="control-group">
    <?php //echo $form->labelEx($model,'country_id');  ?>
    <?php //echo $form->hiddenField($model,'country_id',array('size'=>60,'maxlength'=>100, 'value'=>$model->country_id)); ?>

<?php //echo $form->error($model,'country_id');  ?>
</div>

<div class="control-group">
    <?php //echo $form->labelEx($model,'password'); ?>
<?php echo $form->hiddenField($model, 'password', array('size' => 32, 'maxlength' => 32, 'value' => $model->password)); ?>
    <?php //echo $form->error($model,'password');  ?>
</div>
<div class="control-group">
    <?php //echo $form->labelEx($model,'repeat password'); ?>
<?php echo $form->hiddenField($model, 'repeatpassword', array('size' => 32, 'maxlength' => 32, 'value' => $model->password)); ?>
<?php //echo $form->error($model,'repeatpassword');  ?>
</div>

<div class="control-group">
    <?php //echo $form->labelEx($model,'level_id');  ?>
    <?php echo $form->hiddenField($model, 'level_id', array('value' => Student::getLevelNameUpdate($model->user_id))) ?>

<?php //echo $form->error($model,'level_id');  ?>
</div>

<!--        <div class="row">-->
<?php //echo $form->labelEx($model,'level_id'); ?>
<?php //echo $form->dropDownList($model,'level_id', Level::model()->getLevels(),
// array('empty'=>'< Please select >')); 
?>
    <?php //echo $form->error($model,'level_id');  ?>
<!--	</div>-->

<div class="control-group">
<?php //echo $form->labelEx($model,'sitting_id');  ?>
<?php echo $form->hiddenField($model, 'sitting_id', array('value' => Student::getSittingIdUpdate($model->user_id))) ?>
    <?php //echo $form->error($model,'sitting_id');  ?>
</div>

<div class="control-group">
<?php //echo $form->labelEx($model,'Status');  ?>
<?php echo $form->hiddenField($model, 'status', array('size' => 60, 'maxlength' => 100, 'value' => 'ACTIVE')); ?>
    <?php echo $form->error($model, 'status'); ?>
</div>

<div class="control-group">
<?php //echo $form->labelEx($model,'user_type');  ?>
<?php echo $form->hiddenField($model, 'user_type', array('size' => 10, 'maxlength' => 10, 'value' => 'STUDENT')); ?>
<?php echo $form->error($model, 'user_type'); ?>
</div>




<?php $this->endWidget(); ?>

