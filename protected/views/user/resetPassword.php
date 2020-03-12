<br><br>
<br>
<br>
<div class="container">
    <div class="span3"></div>

    <div class="span6">
        <h3 class="master_heading">Rest Password</h3>
        <br>
        <br>
        <?php
        $form = $this->beginWidget(
                'CActiveForm', array(
            'id' => 'password-reset',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal'),
                )
        );
        ?>

        <div class="well well-no-background">

<!--            <div class="control-group">
                <label class="control-label" for="inputEmail">Current Password</label>
                <div class="controls">
                    <input class="span3" type="password" id="currentPass" name="currentPass" placeholder="type your current password"/>
                </div>
            </div>-->

            <div class="control-group">
                <label class="control-label" for="inputEmail"  style="margin-right: 10px" >New Password </label>
                <div class="controls">
                    <input class="span3" type="password" id="newPass" name="newPass" placeholder="Type your new password"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"  style="margin-right: 10px" for="inputEmail">Confirm Password </label>
                <div class="controls">
                    <input class="span3" type="password" name="repeatPass" id="repeatPass" placeholder="Confirm your new password"/>
                </div>

            </div>

<!--            <input type="hidden" id="user_id_hidden" name="user_id_hidden" value="<?php //echo $id; ?>">-->

            <div class="control-group">
                <label class="control-label" for="inputEmail"></label>
                <div class="controls">
                    <?php
                    echo CHtml::button('Save', array('submit' => array('user/resetPassword','user'=>$user), 'class' => 'loginBtn'));
                    ?>
                </div>
            </div>
        </div>
        <?php
        $this->endWidget();
        ?>

    </div>

</div>
<br>
<br><br>
<br>

<script type="text/javascript">

    $(function() {
                
        // Setup form validation on the #register-form element
        $("#password-reset").validate({
                    
            // Specify the validation rules
            rules: {
                        
                //currentPass : "required",
                newPass : {
                    required:true,
                    minlength:6
                },
                repeatPass : {
                    required:true,
                    minlength:6,
                    equalTo:"#newPass"
                }  
                        
            },
                    
            // Specify the validation error messages
            messages: {
                //currentPass: "Please enter Current Password",
                newPass: {
                    required:"Please enter New Password",
                    minlength:"Your password must be at least 6 characters long"
                },
                repeatPass:{
                    required:"Please enter New Password",
                    minlength:"Your password must be at least 6 characters long",
                    equalTo:"Please enter the same password as above"
                } 
            },
                    
            submitHandler: function(form) {
                form.submit();
            }
        });
                
    });
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<style>
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

    }

    .btnContainer{
        alignment: center;
    }
</style>
