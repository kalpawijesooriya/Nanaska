<style>
    .astrix{
        color: red;
    }
</style>
<div class="container">
    
          
          <div class="span12"> 
          
         <div class="span2"></div>
         
         <div class="span8">
          <h3 class="master_heading">Password Assistance</h3>   
          <div class="well">
            <p align=justify>To reset your password, please enter the email address associated with your LearnCIMA account below. We'll email you a code which will assist you to sign in.</p>
            
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'user-form',
                    'enableAjaxValidation'=>false,
                    'action'=>array('user/forgotpassword'),
                    'htmlOptions'=>array('class'=>'form-horizontal','role'=>'form')
                    ));
            ?>
            
            
              <div class="control-group">
                    <label class="sr-only" for="exampleInputEmail"><?php echo $form->labelEx($model,'email address'); ?></label>
                    <?php echo $form->textField($model,'email',array('class'=>'form-control','id'=>'exampleInputEmail2','placeholder'=>'Enter your email')); ?><br/>
                    <?php echo '<span class="astrix">'.Yii::app()->user->getFlash('fp_error').'</span>'; ?>
                </div>
              
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Send' : 'Save',array('class'=>'button button-news')); ?>
              
                  <?php $this->endWidget(); ?>
          </div>
         </div>
            <div class="span2"></div>    
</div> 
<!-- <div class="span6"> 
<div class="well">
<h4 class="master_heading">Lorem ipsum dolor sit amet? </h4>

<p> Access your online learning environment: <p/>
<ul>
	<li> Donec id elit non mi porta gravida at eget metus.</li>
	<li> Sed ut perspiciatis unde omnis iste natus error sit  </li>
	<li> t enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
</ul>


</div>
</div>    -->
</div>