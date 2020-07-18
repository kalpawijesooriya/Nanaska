<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="breadcrumb-banner-area" style="height:100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h1 class="text-center">Payments</h1>
                    <!-- <div class="breadcrumb-bar">
                        <ul class="breadcrumb text-center">
                            <li><a href="index.html">Home</a></li>
                            <li>Payments</li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Breadcrumb Banner Area-->
<div class="container" style="margin-bottom: 80px">
    <div class="row">
        <div class="span2">
        </div>
        <div class="span8">

            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'action' => array('user/paymentResult'),
                'id' => 'payment-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(

                    'role' => 'form'
                )
                    ));
            ?>
            <br>


            <div class="well">


                <div class="border-seperated">
                    <h4 class="bold">Payment <span class="light">Details</span> </h4> <br/>



                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="first_name">First Name <span class="required">*</span></label>
                        <div class="col-md-8"><input type="text" placeholder="First Name" class="form-control textInput" name="first_name"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="last_name">Last Name <span class="required ">*</span></label>
                        <?php //echo CHtml::textField('last_name', '', array('placeholder' => 'Last Name', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="Last Name" class="form-control textInput" name="last_name"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="address">Address <span class="requiredl">*</span></label>
                        <?php //echo CHtml::textField('address', '', array('placeholder' => 'Address', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="Address" class="form-control textInput" name="address"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="cima_id">CIMA ID <span class="required">*</span></label>
                        <?php //echo CHtml::textField('cima_id', '', array('placeholder' => 'CIMA ID', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="CIMA ID" class="form-control textInput" name="cima_id"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="email">Email <span class="required">*</span></label>
                        <?php //echo CHtml::textField('email', '', array('placeholder' => 'Email', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="Email" class="form-control textInput" name="email"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="contact_no">Contact No <span class="required">*</span></label>
                        <?php //echo CHtml::textField('contact_no', '', array('placeholder' => 'Contact No','onkeypress' => 'return restrictInput(this,event,digitsOnly);', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="Contact No" class="form-control textInput" name="contact_no" onkeypress = "return restrictInput(this,event,digitsOnly)"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="course">Course <span class="required">*</span></label>
                        <?php //echo CHtml::textField('course', '', array('placeholder' => 'Course', 'class' => 'span5')); ?>
                        <div class="col-md-8"><input type="text" placeholder="Course" class="form-control textInput" name="course"></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="amount">Amount (GBP) <span class="required">*</span></label>
                        <?php //echo CHtml::textField('amount', '',array('placeholder' => 'Amount (GBP)', 'class' => 'span5', 'min' => 0, 'numeric')); ?>
                        <div class="col-md-8">
                            <?php if ($price == null) {
                                ?>
                                <input type="number" placeholder="Amount (GBP)" class="form-control textInput" name="amount" min="1" >
                                <?php
                            } else {
                                ?>
                                <input type="number" placeholder="Amount (GBP)" class="form-control textInput" name="amount" value="<?php echo $price; ?>" min="1" readonly="true">
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
            
            

            <div class="control-group">
                
                <input type="checkbox" name="agree" id="check_box_agree" style="margin-top: 0px;" onclick="validateCheckBox()" /> I here by agree all the <?php echo CHtml::link('terms and conditions', array('site/termsofservice')); ?>. <br /><br />
                
                
                <button type="submit" class="loginBtn" id="btn-pay" disabled="true" >Pay</button>
                
            </div>
            <?php $this->endWidget(); ?>

        </div>
        <div class="span2">
        </div>

    </div>

</div>

</script>
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
<script type="text/javascript">
    var digitsOnly = /[+1234567890]/g;
    var integerOnly = /[0-9\.]/g;
    var alphaOnly = /[A-Za-z]/g;
    var usernameOnly = /[0-9A-Za-z\._-]/g;
    var startingWithLetter = /[0-9A-Za-z\._-]/g;
    function restrictInput(myfield, e, restrictionType, checkdot) {
        //alert(screen.width);
        if (!e)
            var e = window.event
        if (e.keyCode)
            code = e.keyCode;
        else if (e.which)
            code = e.which;
        var character = String.fromCharCode(code);
                
        // if user pressed esc... remove focus from field...
        if (code == 27) {
            this.blur();
            return false;
        }
                
        // ignore if the user presses other keys
        // strange because code: 39 is the down key AND ' key...
        // and DEL also equals .
        if (!e.ctrlKey && code != 9 && code != 8 && code != 36 && code != 37 && code != 38 && (code != 39 || (code == 39 && character == "'")) && code != 40) {
            if (character.match(restrictionType)) {
                if (checkdot == "checkdot") {
                            
                    return !isNaN(myfield.value.toString() + character);
                            
                } else {
                    var objTXT = document.getElementById('Address_zip');
                    objTXT.style.borderColor = "#BDBDBD";
                    document.getElementById('Address_zip').style.color="black";
                    return true;
                }
            } else {
                return false;
            }
        }
    }
    $(function () {
        // Setup form validation on the #payment-form element
        $("#payment-form").validate({     //main form id

            // Specify the validation rules
            rules: {
                first_name: "required", //field ids
                last_name: "required",
                address: "required",
                cima_id: "required",
                course: "required",
                contact_no:"required",
                amount: "required",
                "email": {
                    required: true,
                    email: true
                    
                } 

            },
            // Specify the validation error messages
            messages: {
                first_name: "Please enter your first name", //field ids
                last_name: "Please enter your last name",
                address: "Please enter your address",
                cima_id: "Please enter your CIMA ID",
                email: { required: "Please enter email"},
                course: "Please select a course",
                contact_no:"Please enter a phone number",
                amount: "Please enter a valid amount"
            },
            submitHandler: function (form) {
                form.submit();
            }

        });

    });


    
    function validateCheckBox(){
        if(document.getElementById("check_box_agree").checked){
            document.getElementById("btn-pay").className = "loginBtn";//attr('class', 'bluebtn');
            document.getElementById("btn-pay").disabled = false;
        }else{
            document.getElementById("btn-pay").className = "loginBtn";//attr('class', 'bluebtn');
            document.getElementById("btn-pay").disabled = true;
        }
    }

</script>

<style>

    .textInput {
        height: 30px !important;
    }
    .loginBtn{
        font-size: 16px;
        color: #fff;
        line-height: 1.2;
        justify-content: center;
        align-items: center;
        padding: 0 20px;
        min-width: 120px;
        height: 40px;
        background-color: #3282B8;
        border-radius: 27px;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        outline: none !important;
        border: none;
        margin-bottom: 30px;

    }

    .btnContainer{
        alignment: center;
    }


</style>



