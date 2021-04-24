

<?php
$this->breadcrumbs = array(
    'News' => array('index'),
    $model->news_id => array('view', 'id' => $model->news_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List News', 'url' => array('index')),
    array('label' => 'Create News', 'url' => array('create')),
    array('label' => 'View News', 'url' => array('view', 'id' => $model->news_id)),
    array('label' => 'Manage News', 'url' => array('admin')),
);
?>

<div class="form">

    <?php
    $numberOfSubjectAreas = 4;

    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'exam-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal','enctype' => 'multipart/form-data'),
            ));
    ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php // echo $form->errorSummary($model);  ?>

    <?php // echo $form->textFieldRow($model,'subject_id',array('class'=>'span5'));   ?>
    <div class="control-group"><br/>
        <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
    </div>


    <div class="control-group">       
        <?php
        $course_id = News::model()->getCourseOfNews($model->news_id);
        $course_details = Course::model()->getCourseDetails($course_id);

        $level_id = News::model()->getLevelOfNews($model->news_id);
        $level_details = Level::model()->getLevel($level_id);
        
        echo 'Course<font color="#FF0000"> *</font>';
        echo '<br>';
        echo $form->dropDownList($model,'course_id', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'options' => array($course_id => array('selected' => true)),
            'prompt' => 'Select Course',
            'class' => 'form-control',
            'id'=>'course_id',
            'ajax' => array(
                'data' => array('course_id' => 'js:course_id.value'),
                'type' => 'POST', //request type
                'url' => CController::createUrl('Level/getLevels'),
                'update' => '#level_id',
                )));
        ?> 
      

    </div>

    <div class="control-group">
        <?php
        $criteria = new CDbCriteria;
        $criteria->condition = "course_id= " . $course_id;
        $level = Level::model()->findAll($criteria);
//    print_r(CHtml::listData($level, 'level_id', 'level_name'));

        echo 'Level <font color="#FF0000"> *</font>';
        echo '<br>';
        echo $form->dropDownList($model,'level_id', CHtml::listData($level, 'level_id', 'level_name'), array(
            'options' => array($level_id => array('selected' => true)),
            'prompt' => 'Select Level',
            'id'=>'level_id',
//            'ajax' => array(
//                'type' => 'POST', //request type
//                'url' => CController::createUrl('Subject/getSubjects'),
//                'update' => '#subject_id',
                ));
        ?>
    </div>

    <div class="control-group">
        <?php echo $form->textFieldRow($model, 'subject', array('class' => 'span5', 'maxlength' => 255,'placeholder'=>'Subject')); ?>
       
    </div> 

    <div class="control-group">
        <?php echo $form->textAreaRow($model, 'message', array('rows' => 6, 'cols' => 50, 'class' => 'span8','placeholder'=>'Message')); ?>
        
    </div>

    <div class="control-group">
        
        <label>Attachment</label>
        <input type="text" name="showBox" size="25" maxlength="255" readonly value=<?php
        if ($model->attachment == NULL) {
            echo 'Not set';
        } else {
            echo $model->attachment;
        }
        ?>></input>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'attachment'); ?>       
        <?php echo CHtml::activeFileField($model, 'attachment'); ?> 
        <?php echo $form->error($model, 'attachment'); ?>
    </div>


</div>


<?php
//$this->widget('bootstrap.widgets.TbButton', array(
//    'buttonType' => 'submit',
//    'type' => 'primary',
//    'label' => $model->isNewRecord ? 'Create' : 'Save',
//));

 echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news')); 
 echo '<br /><br /><br /><br />';  
?>

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
