<?php if (Yii::app()->user->hasFlash('contact')): 
    
    ?>
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

<?php else: ?>
<!--Breadcrumb Banner Area Start-->
    <br> <br>
<div class="breadcrumb-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h1 class="text-center">CONTACT US</h1>
                    <div class="breadcrumb-bar">
                        <ul class="breadcrumb text-center">
                            <li><a href="index.html">Home</a></li>
                            <li>CONTACT Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <br>
<!--End of Breadcrumb Banner Area-->

<!--Contact Form Area Start-->
<div class="contact-form-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="contact-title">contact info</h4>
                <div class="contact-text">
                    <p><span class="c-icon"><i class="zmdi zmdi-phone"></i></span><span class="c-text">+94 777 398 996	</span></p>
                    <p><span class="c-icon"><i class="zmdi zmdi-email"></i></span><span class="c-text">info@nanaska.com	</span></p>
                    <p><span class="c-icon"><i class="zmdi zmdi-pin"></i></span><span class="c-text">104/11, Lake Road ,Boralesgamuwa	<br>Sri Lanka - 10290
                                   </span></p>
                </div>
                <h4 class="contact-title">social media</h4>
                <div class="link-social">
                    <a href="https://www.facebook.com/LearnCIMA			"><i class="zmdi zmdi-facebook"></i></a>
                    <a href="https://lk.linkedin.com/in/nanaska-learncima-92b430120					"><i class="zmdi zmdi-linkedin"></i></a>
                    <a href="https://twitter.com/learn_cima"><i class="zmdi zmdi-twitter"></i></a>

                </div>
            </div>
            <div class="col-md-7">
                <h4 class="contact-title">Contact Us</h4>




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
                    <div class="row">
                        <div class="col-md-8">
                            <?php echo $form->error($model, 'name'); ?>
                            <?php echo $form->textField($model, 'name',array('placeholder'=>'Enter your name')); ?>

                        </div>
                        <div class="col-md-8">
                            <?php echo $form->error($model, 'email'); ?>
                            <?php echo $form->textField($model, 'email',array('placeholder'=>'Enter your email')); ?>


                        </div>

                        <div class="col-md-8">
                            <?php echo $form->error($model, 'subject'); ?>
                            <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128, 'placeholder'=>'Enter the subject')); ?>
                        </div>


                        <div class="col-md-12">
                            <?php echo $form->error($model, 'body'); ?>
                            <?php echo $form->textArea($model, 'body', array('rows' => 10, 'placeholder'=>'Enter your massage')); ?>
                        </div>
                        <div class="col-md-12">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php if(CCaptcha::checkRequirements()): ?>

                                    <?php //echo $form->labelEx($model,'verifyCode'); ?>

                                    <?php $this->widget('CCaptcha'); ?>
                                    <?php echo $form->textField($model,'verifyCode',array('class'=> 'form-control textInput','style'=>'width:200px;')); ?>

                                    <div>Please enter the letters as they are shown in the image above.
                                        <br/>Letters are not case-sensitive.</div>
                                    <?php echo $form->error($model,'verifyCode'); ?>

                                <?php endif; ?>

                        </div>


                        <div class="col-md-8">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::submitButton('SUBMIT', array('class' => 'button-default','style'=>'color:white')); ?>

                        </div>
                    </div>
                    <?php $this->endWidget(); ?>


            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php $cs = Yii::app()->clientScript;
$cs->coreScriptPosition = $cs::POS_END;

$cs->scriptMap = array(
    'jquery.js'=>false,
    'jquery.ui.js'=>false,
    'jquery.min.js'=>false
); ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!--End of Contact Form-->
<?php endif; ?>