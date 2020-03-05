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

<?php else: ?>
<!--Breadcrumb Banner Area Start-->
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
<!--End of Breadcrumb Banner Area-->
<!--Google Map Area Start-->
<div class="google-map-area">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1226013365304!2d79.88915801477265!3d6.875911295031303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25bc818a089b5%3A0x5be46ebee1b884f6!2sNanaska%20Institute!5e0!3m2!1sen!2slk!4v1583142839725!5m2!1sen!2slk" width="100%" height="485" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</div>
<!--End of Google Map Area-->
<!--Contact Form Area Start-->
<div class="contact-form-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="contact-title">contact info</h4>
                <div class="contact-text">
                    <p><span class="c-icon"><i class="zmdi zmdi-phone"></i></span><span class="c-text">+88 018 785 454 589</span></p>
                    <p><span class="c-icon"><i class="zmdi zmdi-email"></i></span><span class="c-text">info@nanaska.com</span></p>
                    <p><span class="c-icon"><i class="zmdi zmdi-pin"></i></span><span class="c-text">House 09, Road 32, Mohammadpur,<br>
                                    Dhaka-1200, UK</span></p>
                </div>
                <h4 class="contact-title">social media</h4>
                <div class="link-social">
                    <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                    <a href="#"><i class="zmdi zmdi-rss"></i></a>
                    <a href="#"><i class="zmdi zmdi-google-plus"></i></a>
                    <a href="#"><i class="zmdi zmdi-pinterest"></i></a>
                    <a href="#"><i class="zmdi zmdi-instagram"></i></a>
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
<!--End of Contact Form-->
<?php endif; ?>