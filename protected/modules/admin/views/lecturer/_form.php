<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'lecturer-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model);    ?>

    <div class="control-group">
        <?php // echo $form->labelEx($model,'user_id');  ?>
        <?php echo $form->hiddenField($model, 'user_id'); ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

<!--    <div class="control-group">
        <p class="control-label" style="display: inline">Lecturer Code</p> 
        <div class="controls">
            <input placeholder="Lecturer Code" type="text" name="lecturer_code"/>
        </div>
    </div>-->

   <div class="control-group">
        <?php echo $form->labelEx($model_lecturer, 'lecturer_code', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model_lecturer, 'lecturer_code', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Lecturer Code')); ?>
            <?php echo $form->error($model_lecturer, 'lecturer_code', array('class' => 'error_msg')); ?></div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'first_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'First Name')); ?>
            <?php echo $form->error($model, 'first_name', array('class' => 'error_msg')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Last Name')); ?>
            <?php echo $form->error($model, 'last_name', array('class' => 'error_msg')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'E-mail')); ?>
            <?php echo $form->error($model, 'email', array('class' => 'error_msg')); ?></div>
    </div>

    <!--<div class="control-group">-->
    <?php // echo $form->labelEx($model,'password');   ?>
    <?php
    $randomPassword = Lecturer::randomPassword();
    echo $form->hiddenField($model, 'password', array('value' => $randomPassword));
    ?>
    <?php // echo $form->error($model,'password',array('class'=>'alert alert-danger'));  ?>
    <!--</div>-->

    <div class="control-group">
        <?php echo $form->labelEx($model, 'phone_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'phone_number', array('placeholder' => 'Phone Number')); ?>
            <?php echo $form->error($model, 'phone_number', array('class' => 'error_msg')); ?></div>
    </div>

<!--    <div class="control-group">
        <p class="control-label" style="display: inline">Phone Number 2</p> 
        <div class="controls">
            <input placeholder="Phone Number 2" type="text" name="extra_number"/>
        </div>
    </div>-->
    
   <div class="control-group">
        <?php echo $form->labelEx($model_lecturer, 'extra_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model_lecturer, 'extra_number', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Phone Number 2')); ?>
            <?php echo $form->error($model_lecturer, 'extra_number', array('class' => 'error_msg')); ?></div>
    </div>    

    <div class="control-group">
        <?php echo $form->labelEx($model, 'address', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Address')); ?>
            <?php echo $form->error($model, 'address', array('class' => 'error_msg')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->dropDownList($model, 'country_id', Country::model()->getCountries(), array('empty' => 'Select Country'));
        ?>
            <?php echo $form->error($model, 'country_id', array('class' => 'error_msg')); ?></div>
    </div>

<!--    <div class="control-group">
        <p class="control-label" style="display:inline">Note</p>
        <div class="controls"><textarea name="lecturer_note" rows="4" cols="50"></textarea></div>
    </div>-->

    <div class="control-group">
        <?php echo $form->labelEx($model_lecturer, 'note', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textArea($model_lecturer, 'note', array('maxlength' => 300)); ?>
            <?php echo $form->error($model_lecturer, 'note', array('class' => 'error_msg')); ?></div>
    </div>




    <div class="control-group">
        <?php // echo $form->labelEx($model,'user_type');    ?>
        <?php echo $form->hiddenField($model, 'user_type', array('value' => "LECTURER")); ?>
        <?php // echo $form->error($model,'user_type',array('class'=>'alert alert-danger'));   ?>
    </div>


    <?php echo $this->renderPartial('_examForm', array('model' => $model)); ?>


    <div class="control-group">

        <?php echo '<div class="controls">' . CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news', 'onClick' => 'submitForm()')) . '</div>'; ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->renderPartial('_js_validation')?>




