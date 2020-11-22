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

    <?php /*?>
    <div class="control-group">
        <p class="control-label" style="display:inline">Lecturer Code</p>
        <div class="controls"><input type="text" value="<?php echo $lecturer_model->lecturer_code ?>" name="lecturer_code"/></div>

    </div><?php */?>
    
<!--    <div class="control-group">
        <?php // echo $form->labelEx($lecturer_model, 'lecturer_code', array('class' => 'control-label')); ?>
        <div class="controls"><?php // echo $form->textField($lecturer_model, 'lecturer_code', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Lecturer Code')); ?>
            <?php // echo $form->error($lecturer_model, 'lecturer_code', array('class' => 'alert alert-danger')); ?></div>
    </div>-->

    <div class="control-group">
        <?php echo $form->labelEx($lecturer_model, 'lecturer_code', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($lecturer_model, 'lecturer_code', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Lecturer Code')); ?>
            <?php echo $form->error($lecturer_model, 'lecturer_code', array('style' => 'color:#B40404;')); ?></div>
    </div>         
            
    <div class="control-group">
        <?php echo $form->labelEx($model, 'first_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'First Name')); ?>
            <?php echo $form->error($model, 'first_name', array('style' => 'color:#B40404;')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Last Name')); ?>
            <?php echo $form->error($model, 'last_name', array('style' => 'color:#B40404;')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'E-mail','readonly'=>TRUE)); ?>
            <?php echo $form->error($model, 'email', array('style' => 'color:#B40404;')); ?></div>
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
            <?php echo $form->error($model, 'phone_number', array('style' => 'color:#B40404;')); ?></div>
    </div>

    <!--    <div class="control-group">
            <p class="control-label" style="display: inline">Phone Number 2</p> 
            <div class="controls">
                <input placeholder="Phone Number 2" type="text" name="extra_number"/>
            </div>
        </div>-->

    <?php /*?>
     <div class="control-group">
        <p class="control-label" style="display:inline">Phone Number 2</p>
        <div class="controls"><input type="text" value="<?php echo $lecturer_model->extra_number ?>" name="extra_number"/></div>
    </div>
    <?php */?>
    
<!--    <div class="control-group">
        <?php // echo $form->labelEx($lecturer_model, 'extra_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php // echo $form->textField($lecturer_model, 'extra_number', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Lecturer Code')); ?>
            <?php // echo $form->error($lecturer_model, 'extra_number', array('class' => 'alert alert-danger')); ?></div>
    </div>-->
            
     <div class="control-group">
        <?php echo $form->labelEx($lecturer_model, 'extra_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($lecturer_model, 'extra_number', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Phone Number 2')); ?>
            <?php echo $form->error($lecturer_model, 'extra_number', array('style' => 'color:#B40404;')); ?></div>
    </div>          

    <div class="control-group">
        <?php echo $form->labelEx($model, 'address', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Address')); ?>
            <?php echo $form->error($model, 'address', array('style' => 'color:#B40404;')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->dropDownList($model, 'country_id', Country::model()->getCountries(), array('empty' => 'Select Country'));
        ?>
            <?php echo $form->error($model, 'country_id', array('style' => 'color:#B40404;')); ?></div>
    </div>

    <!--    <div class="control-group">
            <p class="control-label" style="display:inline">Note</p>
            <div class="controls"><textarea name="lecturer_note" rows="4" cols="50"></textarea></div>
        </div>-->

    <?php /*?>
    <div class="control-group">
        <p class="control-label" style="display:inline">Note</p>
        <div class="controls"><textarea name="lecturer_note" rows="4" cols="50"><?php echo $lecturer_model->note ?></textarea></div>
    </div>
    <?php */?>
    
   <div class="control-group">
        <?php echo $form->labelEx($lecturer_model, 'note', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textArea($lecturer_model, 'note', array('maxlength' => 300)); ?>
            <?php echo $form->error($lecturer_model, 'note', array('style' => 'color:#B40404;')); ?></div>
    </div>
    
<!--
    <div class="control-group">
        <?php // echo $form->labelEx($lecturer_model, 'note', array('class' => 'control-label')); ?>
        <div class="controls"><?php // echo $form->textArea($lecturer_model, 'note', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Lecturer Code')); ?>
            <?php // echo $form->error($lecturer_model, 'note', array('class' => 'alert alert-danger')); ?></div>
    </div>-->

    <div class="control-group">
        <?php // echo $form->labelEx($model,'user_type');    ?>
        <?php echo $form->hiddenField($model, 'user_type', array('value' => "LECTURER")); ?>
        <?php // echo $form->error($model,'user_type',array('class'=>'alert alert-danger'));   ?>
    </div>


    <?php echo $this->renderPartial('_examForm', array('model' => $model,'userId'=>$model->user_id)); ?>


    <div class="control-group">

        <?php echo '<div class="controls">' . CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news', 'onClick' => 'submitForm()')) . '</div>'; ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->renderPartial('_js_validation')?>

<script>


    function submitFormX() {
        document.getElementById('lecturer-form').submit();
    }

</script>





