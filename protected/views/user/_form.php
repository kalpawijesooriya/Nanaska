<style>
    .astrix{
        color: red;
    }
    .textInput{
   height: 30px !important;
    }
</style>

<div class="breadcrumb-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h1 class="text-center">Registeration</h1>
                    <div class="breadcrumb-bar">
                        <ul class="breadcrumb text-center">
                            <li><a href="index.html">Home</a></li>
                            <li>Register</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>





<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form'
    )
));
?>
<div class="container">

    <div class="span2"></div>
    <div class="span8">
        <br/><br/>


        <?php //echo $form->errorSummary($model);  ?>
        <h2 class="text-center">Student Registration</h2>
        <br/>

        <div class="well transparent">

            <h4 class="bold"> Personal <span class="light">Details</span> </h4> <br/>
            <div class="border-seperated">





                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'First Name', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'first_name'); ?></div>
                </div>

                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Last Name', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'last_name'); ?></div>
                </div>

                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'phone_number', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->textField($model, 'phone_number', array('placeholder' => 'Phone Number', 'onkeypress' => 'return restrictInput(this,event,digitsOnly);', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'phone_number'); ?></div>
                </div>

                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Address', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'address'); ?></div>
                </div>

                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'country_id', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->dropDownList($model, 'country_id', Country::model()->getCountries(), array('empty' => 'Select Country', 'class' => 'form-control textInput'));
                        ?>
                        <?php echo $form->error($model, 'country_id'); ?></div>
                </div>

                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'col-md-3 col-form-label')); ?>
                    <div class="col-md-8"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'E-mail', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'email'); ?></div>
                </div>
            </div>
        </div>


        <div class="well transparent" id="logincreation">
            <h4 class="bold"> Course <span class="light">Details</span> </h4> <br/>
            <div class="border-seperated">
                <div class="control-group">
                    <?php
                    echo '<label for="inputEmail3" class="col-md-3 col-form-label">Course <span class="astrix">*</span></label>';

                    echo '<div class="col-md-8">' . CHtml::activeDropDownList($model, 'course_id', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
                            'prompt' => 'Select Course',
                            'class' => 'form-control',
                            'ajax' => array(
                                'type' => 'POST', //request type
                                'url' => CController::createUrl('Level/getlevels'),
                                'update' => '#User_level_id',
                            )));
                    echo $form->error($model, 'course_id');
                    echo '</div>';
                    ?>
                </div>

                <div class="control-group row">
                    <?php
                    echo '<label for="inputEmail3" class="col-md-3 col-form-label">Level <span class="astrix">*</span></label>';

                    echo '<div class="col-md-8">' . CHtml::activeDropDownList($model, 'level_id', array(), array(
                            'empty' => 'Select Level',
                            'class' => 'form-control'
                        ));
                    ?>
                    <?php
                    echo $form->error($model, 'level_id');
                    echo '</div>';
                    ?>

                </div>

                <div class="control-group row">
                    <?php echo '<label for="inputEmail3" class="col-md-3 col-form-label">Session <span class="astrix">*</span></label>'; ?>
                    <!--                    <p class="col-sm-2 control-label" style="display:inline">Session<span class="astrix">*</span></p>-->
                    <div class="col-md-8"><?php echo $form->dropDownList($model, 'sitting_id', Sitting::model()->getSittings(), array('empty' => 'Select Session', 'class' => 'span5'));
                        ?>
                        <?php echo $form->error($model, 'sitting_id'); ?></div>
                </div>

                <!--                <div>
                <?php //echo $form->labelEx($model,'Status'); ?>
                <?php echo $form->hiddenField($model, 'status', array('size' => 60, 'maxlength' => 100, 'value' => 'ACTIVE')); ?>
                <?php echo $form->error($model, 'status'); ?>
                                </div>

                                <div>
                <?php //echo $form->labelEx($model,'user_type'); ?>
                <?php echo $form->hiddenField($model, 'user_type', array('size' => 10, 'maxlength' => 10, 'value' => 'STUDENT')); ?>
                <?php echo $form->error($model, 'user_type'); ?>
                                </div>-->
            </div>




            <div class="control-group">
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if(CCaptcha::checkRequirements()): ?>

                        <?php //echo $form->labelEx($model,'verifyCode'); ?>

                        <?php $this->widget('CCaptcha'); ?>
                        <?php echo $form->textField($model,'verifyCode'); ?>

                        <div>Please enter the letters as they are shown in the image above.
                            <br/>Letters are not case-sensitive.</div>
                        <?php echo $form->error($model,'verifyCode'); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="control-group">

            <div class="controls text-left">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn btn-primary" id="changebutton">Send Contact Info</button>
            </div>
        </div>

        <div class="well transparent">
            <div class="border-seperated">
                <input type="checkbox" class ="logincheck" name="logincheck" id="logincheck" style="margin-top: -2px;"><span style="margin-left:5px;">Create an account</span>
            </div>
        </div>

        <div class="well transparent login" id="logincreation">
            <h4 class="bold"> Login <span class="light">Details</span> </h4> <br/>
            <div class="border-seperated">


                <div class="control-group row">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-md-8"><?php echo $form->passwordField($model, 'password', array('size' => 32, 'maxlength' => 32, 'placeholder' => 'Password', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'password'); ?></div>
                </div>
                <div class="control-group row">
                    <p class="col-sm-2 control-label" style="display:inline">Repeat Password<span class="astrix">*</span></p>
                    <div class="col-md-8"><?php echo $form->passwordField($model, 'repeatpassword', array('size' => 32, 'maxlength' => 32, 'placeholder' => 'Repeat Password', 'class' => 'form-control textInput')); ?>
                        <?php echo $form->error($model, 'repeatpassword'); ?></div>
                </div>
            </div>
        </div>

        <div class="control-group">
            <div class="controls" style="margin-bottom: 10%">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn btn-primary text-center" id="register_for_exams">Register for exams</button>
            </div>
        </div>

    </div>
</div>
<br/>
<br/>

<?php $this->endWidget(); ?>
<br/>

<br/>
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
                    return true;
                }
            } else {
                return false;
            }
        }
    }


</script>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php $cs = Yii::app()->clientScript;
$cs->coreScriptPosition = $cs::POS_END;

$cs->scriptMap = array(
    'jquery.js'=>false,
    'jquery.ui.js'=>false,
); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        //hide following ids for send contact info
        $("#register_for_exams").hide();
        $(".login").hide();
        $("#User_password").val("123456");
        $("#User_repeatpassword").val("123456");

        $(".logincheck").change(function() {
            if(this.checked)
            {
                $("#changebutton").hide();
                $(".login").show('slow');
                $("#User_password").val("");
                $("#User_repeatpassword").val("");
                $("#register_for_exams").show();

            }
            else
            {
                $("#changebutton").show();
                $("#changebutton").html('Send Contact Info');
                $("#register_for_exams").hide();
                $(".login").hide();
                $("#User_password").val("123");
                $("#User_repeatpassword").val("123");
            }

        });


    });
</script>