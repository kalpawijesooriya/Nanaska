<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootbox.min.js', CClientScript::POS_HEAD);

?>

<div class="container">
    <div class="row">
    <div class="col col-lg-4"></div>


    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'login-form',
        'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
            'htmlOptions'=>array(
                              'class'=>'',
                              'role'=>'form'
                            )
    ));

    if (Yii::app()->user->getState('account')== 'TRUE'){
        ?>  <script type="text/javascript">bootbox.alert("Registration successful");</script>

        <?php
        Yii::app()->user->setState('account', 'FALSE');
    }


?>
        <div class=" col-lg-4">
        <div class="well ">
            <di class="text-center form-group">
            <h3 class="master_heading">Sign in</h3>
            </di>
            <br>
            <div class="control-group">
                <div class="text-enter" style="margin-left: 18%">
                <?php echo $form->labelEx($model,'username',array('class'=>'control-label','label'=>'Email')); ?>
                </div>
                <div class="controls text-center"><?php echo $form->textField($model,'username',array('placeholder'=>'Enter your email')); ?>
                <?php echo $form->error($model,'username'); ?></div>
            </div>

            <div class="control-group">
                <div class="text-enter" style="margin-left: 18%">
                <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
                </div>
                <div class="controls text-center">
                    <?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
            </div>

            <div class="checkbox text-center">
               <div class="controls">
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    <?php echo $form->label($model, 'rememberMe'); ?>
                    <?php echo $form->error($model, 'rememberMe'); ?>
               </div>
            </div>

            <div class="controls text-center"><a href=<?php echo $this->createUrl('user/forgotpassword') ?>>Forgot password?</a></div><br/>
	        <div class="controls text-center btnContainer"><?php echo CHtml::submitButton('Sign in',array('class'=>'loginBtn')); ?></div>
        </div>

    </div>
    <?php $this->endWidget(); ?>
        <div class="col col-lg-4"></div>
    </div>

</div>
<br>
<br>
<br>

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
