
<?php if (Yii::app()->user->hasFlash('contact')): ?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 962159633;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "AjJTCO3PhVkQkcjlygM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/962159633/?label=AjJTCO3PhVkQkcjlygM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts' => array('contact'),
        'htmlOptions' => array('class'=>'container')
    ));
    ?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php else: ?>

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'contact-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <div class="container">
        <div class="span2"></div>
        <div class="span8">
            <h3 class="master_heading">Contact Us</h3>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            
            <?php //echo $form->errorSummary($model); ?>
            
            <div class="well transparent">
                <div class="border-seperated">
            <?php echo $form->textFieldRow($model, 'name',array('placeholder'=>'Enter your name')); ?>

            <?php echo $form->textFieldRow($model, 'email',array('placeholder'=>'Enter your email')); ?>

            <?php echo $form->textFieldRow($model, 'subject', array('size' => 60, 'maxlength' => 128, 'placeholder'=>'Enter the subject')); ?>

            <?php echo $form->textAreaRow($model, 'body', array('rows' => 6, 'class' => 'span8', 'placeholder'=>'Enter your massage')); ?>

            <?php if (CCaptcha::checkRequirements()): ?>
                </div>
        <?php
        echo $form->captchaRow($model, 'verifyCode', array(
            'hint' => 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.','placeholder'=>'Enter the verification code'
        ));
        ?>
                <?php endif; ?>
            
            </div>

            
    <?php
    //$this->widget('bootstrap.widgets.TbButton',array(
    //'buttonType'=>'submit',
    //'type'=>'primary',
    //'label'=>'Submit',
    //)); 
    ?>
            
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo CHtml::submitButton('Submit', array('class' => 'button button-news')); ?>
                </div>
            <br /><br /><br />

    <?php $this->endWidget(); ?>
        </div>
    </div><!-- form -->

<?php endif; ?>
</div>