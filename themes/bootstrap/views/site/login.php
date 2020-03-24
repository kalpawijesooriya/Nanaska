<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
    'Login',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootbox.min.js', CClientScript::POS_HEAD);

?>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col col-lg-3"></div>


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
        <div class=" col-lg-5">
            <div class="well ">
                <di class="text-center form-group">
                    <h3 class="master_heading" style="margin-top: 30px; margin-bottom: 20px">Sign In</h3>
                </di>
                <br>
                <div class="border-seperated">

                    <div class="form-group row">

                        <?php echo $form->labelEx($model,'username',array('class'=>'col-md-3 col-form-label','label'=>'Email')); ?>
                        <div class="col-md-8">
                            <?php echo $form->textField($model,'username',array('placeholder'=>'Enter your email', 'class' => 'form-control textInput')); ?>
                            <?php echo $form->error($model,'username'); ?>
                        </div>

                    </div>

                    <div class="form-group row">
                        <?php echo $form->labelEx($model,'password',array('class'=>'col-md-3 col-form-label')); ?>
                        <div class="col-md-8">
                            <?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password', 'class' => 'form-control textInput')); ?>
                            <?php echo $form->error($model,'password'); ?>
                        </div>

                    </div>
                    <div class="form-group row text-center" >
                        <div class="col-md-10 offset-md-4 text-center" >
                            <div class="checkbox text-center">
                                <label>
                                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                                    <?php echo $form->labelEx($model,'rememberMe'); ?>
                                </label>
                                <?php echo $form->error($model, 'rememberMe'); ?>
                            </div>
                        </div>
                    </div>



                    <div class="controls text-center"><a href=<?php echo $this->createUrl('user/forgotpassword') ?>>Forgot password?</a></div><br/>
                    <div class="controls text-center btnContainer"><?php echo CHtml::submitButton('Sign in',array('class'=>'loginBtn')); ?></div>
                </div>
            </div>

        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>
<br>
<br>
<br>


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
