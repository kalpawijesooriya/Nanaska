<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
//        'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
        'htmlOptions'=>array(
                 'enctype' => 'multipart/form-data',
                        )
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
       
        <div class="control-group"> 
	<?php //echo $form->errorSummary($model); ?>
        </div>
        
           <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputPassword">Course<font color="#FF0000"> *</font></label>';

        echo '<div class="controls">' . $form->dropDownList($model,'course_id', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'prompt' => 'Select Course',
            'class' => 'form-control',
            'id' => 'course_id',
            'ajax' => array(
                'data' => array('course_id' => 'js:course_id.value'),
                'type' => 'POST', //request type
                'url' => CController::createUrl('Level/getLevels'),
                'update' => '#level_id',
    ))) . '</div>';
        ?> 
               <?php echo $form->error($model, 'course_id'); ?>
       
   <!--    <b id="course_error"></b> -->
    </div>
               
         
          <div class="control-group">
        <?php echo $form->labelEx($model, 'level_id'); ?>
        <?php // echo $form->textField($model, 'level_id');  ?>

        <?php
        echo $form->dropDownList($model, 'level_id', array(), array(
            'empty' => 'Select Level',
            'class' => 'form-control',
            'id' => 'level_id',
//            'ajax' => array(
//                'type' => 'POST', //request type
//                'url' => CController::createUrl('Subject/getSubjects'),
//                'update' => '#subject',
//            )
        ));
        ?>
        <?php echo $form->error($model, 'level_id'); ?>
              
      
    </div>
        
        <div class="control-group">
	<?php echo $form->textFieldRow($model,'subject',array('class'=>'span5','maxlength'=>255,'placeholder'=>'Subject')); ?>
        </div> 
        
        <div class="control-group">
            <?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8','placeholder'=>'Message')); ?>
        </div>
                      
        <div class="control-group">
            <?php echo $form->labelEx($model,'attachment'); ?>
            <?php echo CHtml::activeFileField($model,'attachment'); ?> 
             <?php echo $form->error($model,'attachment'); ?>
        </div>
        
        
        <div class="control-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news')); ?>
   
        </div>
	
        
	

<?php $this->endWidget(); ?>

        
        <script>
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#news-form").validate({
    
        // Specify the validation rules
        rules: {
            "News[course_id]": "required",
            "News[level_id]": "required",
            
            "News[subject]": "required",
            "News[message]": "required"
           
            
            
            
            
        },
        
        // Specify the validation error messages
        messages: {
            "News[course_id]": "Please select a course",
            "News[level_id]": "Please select a level",
          
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
