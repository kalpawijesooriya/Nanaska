<style>
    #singleanswerbulk-form label.error{
        color: #B40404;
    }
</style>

<?php

$this->menu=array(
	array('label'=>'Multiple Answer Questions','url'=>array('multipleanswerbulk')),
	array('label'=>'Short Written Answer Questions','url'=>array('shortwrittenbulk')),
	array('label'=>'Multiple Choice Answer Questions','url'=>array('multiplechoicebulk')),	
);
?>

<?php
    
    $form = $this->beginWidget('CActiveForm', array(   
        'action' => array('question/CreateSingleAnswerBulk'),
        'id' => 'singleanswerbulk-form',
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
    <h4>Upload single bulk answer questions</h4>
    
    <input type="file" name="single_bulk" /><input type="submit" value="upload" class="btn" />    
    
    
    <div class="control-group">
        <div class="controls">
                <br/>
                <a href="<?php echo 'bulkuploads/single_answer_questions/single-answer-document-template.xls'; ?>" class="btn" download>Download Template</a>  
        </div>   
    </div>
    
    
</div>



<?php $this->endWidget(); ?>

<script>
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#singleanswerbulk-form").validate({
    
        // Specify the validation rules
        rules: {
            single_bulk: "required"
         
            
        },
        
        // Specify the validation error messages
        messages: {
            single_bulk: "Please choose a .xls file to upload"
        
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
 
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>