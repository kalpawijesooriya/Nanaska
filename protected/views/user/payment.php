<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container">
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
                    'class' => 'form-horizontal form-control',
                    'role' => 'form'
                )
                    ));
            ?>

            <h3 class="master_heading">Payment</h3>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <div class="well transparent">


                <div class="border-seperated">

                    <div class="control-group">
                        <label class="control-label" for="first_name">First Name <span class="required">*</span></label>
                        <?php //echo CHtml::textField('first_name', '', array('placeholder' => 'First Name', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="First Name" class="span5" name="first_name"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="last_name">Last Name <span class="required">*</span></label>
                        <?php //echo CHtml::textField('last_name', '', array('placeholder' => 'Last Name', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="Last Name" class="span5" name="last_name"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="address">Address <span class="required">*</span></label>
                        <?php //echo CHtml::textField('address', '', array('placeholder' => 'Address', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="Address" class="span5" name="address"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="cima_id">CIMA ID <span class="required">*</span></label>
                        <?php //echo CHtml::textField('cima_id', '', array('placeholder' => 'CIMA ID', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="CIMA ID" class="span5" name="cima_id"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">Email <span class="required">*</span></label>
                        <?php //echo CHtml::textField('email', '', array('placeholder' => 'Email', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="Email" class="span5" name="email"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="contact_no">Contact No <span class="required">*</span></label>
                        <?php //echo CHtml::textField('contact_no', '', array('placeholder' => 'Contact No','onkeypress' => 'return restrictInput(this,event,digitsOnly);', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="Contact No" class="span5" name="contact_no" onkeypress = "return restrictInput(this,event,digitsOnly)"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="course">Course <span class="required">*</span></label>
                        <?php //echo CHtml::textField('course', '', array('placeholder' => 'Course', 'class' => 'span5')); ?>
                        <div class="controls"><input type="text" placeholder="Course" class="span5" name="course"></div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="amount">Amount (GBP) <span class="required">*</span></label>
                        <?php //echo CHtml::textField('amount', '',array('placeholder' => 'Amount (GBP)', 'class' => 'span5', 'min' => 0, 'numeric')); ?>
                        <div class="controls">
                            <?php if ($price == null) {
                                ?>
                                <input type="number" placeholder="Amount (GBP)" class="span5" name="amount" min="1" >
                                <?php
                            } else {
                                ?>
                                <input type="number" placeholder="Amount (GBP)" class="span5" name="amount" value="<?php echo $price; ?>" min="1" readonly="true"> 
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
            
            

            <div class="control-group">
                
                <input type="checkbox" name="agree" id="check_box_agree" style="margin-top: 0px;" onclick="validateCheckBox()" /> I here by agree all the <?php echo CHtml::link('terms and conditions', array('site/termsofservice')); ?>. <br /><br />
                
                
                <button type="submit" class="greybtnsmall" id="btn-pay" disabled="true">Pay</button>
                
            </div>
            <?php $this->endWidget(); ?>

        </div>
        <div class="span2">
        </div>

    </div>

</div>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js">
</script>

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
            document.getElementById("btn-pay").className = "bluebtnsmall";//attr('class', 'bluebtn');
            document.getElementById("btn-pay").disabled = false;
        }else{
            document.getElementById("btn-pay").className = "greybtnsmall";//attr('class', 'bluebtn');
            document.getElementById("btn-pay").disabled = true;
        }
    }

</script>