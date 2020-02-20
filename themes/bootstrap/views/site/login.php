<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootbox.min.js', CClientScript::POS_HEAD);

?>

<div class="container">
    <div class="span4"></div>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
        'htmlOptions'=>array(
                          'class'=>'form-horizontal form-control',
                          'role'=>'form'
                        )
));
    
        if (Yii::app()->user->getState('account')== 'TRUE'){
            ?>  <script type="text/javascript">bootbox.alert("Registration successful");</script>
            
            <?php
            Yii::app()->user->setState('account', 'FALSE'); 
        }


?>
    <div class="span5">
        <h3 class="master_heading">Sign in</h3>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <div class="well">
        

	<div class="control-group">
		<?php echo $form->labelEx($model,'username',array('class'=>'control-label','label'=>'Email')); ?>
		<div class="controls"><?php echo $form->textField($model,'username',array('placeholder'=>'Enter your email')); ?>
		<?php echo $form->error($model,'username'); ?></div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
		<div class="controls"><?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
		<?php echo $form->error($model,'password'); ?></div>
		
	</div>

	<div class="checkbox">
           <div class="controls"> <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->label($model, 'rememberMe'); ?>
            <?php echo $form->error($model, 'rememberMe'); ?></div>
        </div>
	
        
        
		<div class="controls"><a href=<?php echo $this->createUrl('user/forgotpassword') ?>>Forgot password?</a></div><br/>
	<div class="controls"><?php echo CHtml::submitButton('Sign in',array('class'=>'button button-news')); ?></div>
        </div>

<!--	<div class="row buttons">-->
		<?php //echo CHtml::submitButton('Login',array('class'=>'btn btn-primary')); ?>
<!--	</div>-->

<?php $this->endWidget(); ?>

<!--<div class="span6"> 
<div class="well">
<h4 class="master_heading">Lorem ipsum dolor sit amet? </h4>

<p> Access your online learning environment: <p/>
<ul>
	<li> Donec id elit non mi porta gravida at eget metus.</li>
	<li> Sed ut perspiciatis unde omnis iste natus error sit  </li>
	<li> t enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
</ul>


</div>
</div>--></div>
</div>
