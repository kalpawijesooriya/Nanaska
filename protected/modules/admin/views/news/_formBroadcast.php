<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'news-form',
	'enableAjaxValidation'=>FALSE,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<div class="control-group"> 
	<?php //echo $form->errorSummary($model); ?>
        </div>
        
        <div class="control-group">
	<?php echo $form->textFieldRow($model,'subject',array('class'=>'span5','maxlength'=>255,'placeholder'=>'Subject')); ?>
        </div> 
        
        <div class="control-group">
            <?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8','placeholder'=>'Message')); ?>
        </div>

       <div class="control-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news')); ?>
    </div>

<!--<div class="form-actions">
		<?php 
//                $this->widget('bootstrap.widgets.TbButton', array(
//			'buttonType'=>'submit',
//			'type'=>'primary',
//			'label'=>$model->isNewRecord ? 'Create' : 'Save',
//		)); 
                ?>
	</div>-->

<?php $this->endWidget(); ?>


       
        <script>
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#news-form").validate({
    
        // Specify the validation rules
        rules: {           
            "News[subject]": "required",
            "News[message]": "required"
            
        },
        
        // Specify the validation error messages
        messages: {           
          
            "News[subject]": "Please enter a subject",
            "News[message]": "Please enter message body"  
            
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
