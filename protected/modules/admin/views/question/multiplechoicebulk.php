<style>
    #multiplechoicebulk-form label.error{
        color: #B40404;
    }
</style>

<?php

$this->menu=array(
	array('label'=>'Single Answer Questions','url'=>array('singleanswerbulk')),
	array('label'=>'Multiple Answer Questions','url'=>array('shortwrittenbulk')),
	array('label'=>'Short Written Answer Questions','url'=>array('multiplechoicebulk')),	
);
?>

<?php
    
    $form = $this->beginWidget('CActiveForm', array(   
        'action' => array('question/CreateMultipleChoiceBulk'),
        'id' => 'multiplechoicebulk-form',
        'enableAjaxValidation'=>false,
//        'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
        'htmlOptions'=>array(
                          'enctype' => 'multipart/form-data',
                        )
)); ?>

<div class="well">
    <h4>Upload multiple choice bulk answer questions</h4>
    
    <input type="file" name="multiplechoice_bulk" /><input type="submit" value="upload" class="btn" />  
    
   
        
        <div class="control-group">
        <div class="controls">
                <br/>
                <a href="<?php echo 'bulkuploads/multiple_choice_answer_questions/multiple-choice-answer-document-template.xls'; ?>" class="btn" download>Download Template</a>  
        </div>   
    </div>    
    
</div>

<?php $this->endWidget(); ?>


<script>
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#multiplechoicebulk-form").validate({
    
        // Specify the validation rules
        rules: {
            multiplechoice_bulk: "required"
         
            
        },
        
        // Specify the validation error messages
        messages: {
            multiplechoice_bulk: "Please choose a .xls file to upload"
        
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
 
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>