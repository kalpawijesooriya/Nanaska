<style>
    .astrix{
        color: red;
    }
</style>

<?php
    
    $form = $this->beginWidget('CActiveForm', array(       
        'id' => 'student-form',
        'enableAjaxValidation'=>false,
//        'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
        'htmlOptions'=>array(
                          'class'=>'form-horizontal form-control',
                          'role'=>'form'
                        )
)); ?>
<div class="well">
    <div class="row-fluid">
        <div class="span6"> <div class="bs-docs-example">
                <h4> Personal Details </h4>

    <div class="row">
        <?php // echo $form->labelEx($model,'user_id'); ?>
        <?php echo $form->hiddenField($model, 'user_id'); ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model,'first_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'First Name')); ?>
        <?php echo $form->error($model, 'first_name',array('class'=>'alert alert-danger')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Last Name')); ?>
        <?php echo $form->error($model, 'last_name', array('class' => 'alert alert-danger')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'E-Mail')); ?>
        <?php echo $form->error($model, 'email', array('class' => 'alert alert-danger')); ?></div>
    </div>

    
        <?php // echo $form->labelEx($model,'password'); ?>
        <?php
        $randomPassword = Lecturer::randomPassword();
        echo $form->hiddenField($model, 'password', array('value' => $randomPassword));
        ?>
        <?php // echo $form->error($model,'password',array('class'=>'alert alert-danger'));  ?>
   

    <div class="control-group">
        <?php echo $form->labelEx($model, 'phone_number', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'phone_number', array('placeholder' => 'Phone Number','onkeypress' => 'return restrictInput(this,event,digitsOnly);')); ?>
        <?php echo $form->error($model, 'phone_number', array('class' => 'alert alert-danger')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'address', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Address')); ?>
        <?php echo $form->error($model, 'address', array('class' => 'alert alert-danger')); ?></div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->dropDownList($model, 'country_id', Country::model()->getCountries(), array('empty' => 'Select Country'));
        ?>
        <?php echo $form->error($model, 'country_id', array('class' => 'alert alert-danger')); ?></div>
    </div>
    </div></div>
        
    <div class="span6">
	<div class="bs-docs-example">
		  <h4> Course Details </h4>

    <div class="row">
        <?php // echo $form->labelEx($model,'user_type');  ?>
        <?php echo $form->hiddenField($model, 'user_type', array('value' => "STUDENT")); ?>
        <?php // echo $form->error($model,'user_type',array('class'=>'alert alert-danger'));  ?>
    </div>

    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputEmail">Course<span class="astrix"> *</span></label>';
        echo '<div class="controls">';
        echo CHtml::dropDownList('course_id','', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'prompt' => 'Select Course',            
            'ajax' => array(
                'type' => 'POST', //request type
                'data'=>array('course_id'=>'js:course_id.value'),
                'url' => CController::createUrl('Level/GetLevelsforStudentCreation'),
                'update' => '#User_level_id,#level_id,#dynamic_level_id',
        )));
        echo '</div>';
        ?> 
        <?php echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
    </div>

    <div class="control-group">
        <?php
        echo '<label class="control-label" for="inputEmail">Level<span class="astrix"> *</span></label>';
        ?>
        <div class="controls">

            <?php    
            echo CHtml::activeDropDownList($model,'level_id',array(), array(
                'prompt' => 'Select Level',            
    //            'ajax' => array(
    //                'data' => array('level_id' => 'js:User_level_id.value'),
    //               'type' => 'POST',
    //               'url' => CController::createUrl('Student/getViews'),
    //               'update' => '#render_view',
    //       )
                ));
            ?>         
            <?php echo $form->error($model, 'level_id', array('class' => 'alert alert-danger')); ?>                    
            <?php echo Yii::app()->user->getFlash('error1'); ?>
        </div>
           
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'Session<span class="astrix"> *</span>', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->dropDownList($model, 'sitting_id', Sitting::model()->getSittings(), array('empty' => 'Select Session'));
        ?>
        <?php echo $form->error($model, 'sitting_id', array('class' => 'alert alert-danger')); ?>         
        </div>
    </div>


    <div class="control-group">
        <p class="control-label" style="display:inline">Note</p>
        <div class="controls"><textarea name="student_note" rows="4" cols="50"></textarea></div>
    </div>
    <div class="control-group"> 
        
            <div class="controls">
            <input type="checkbox" name="show_exam_breakdown" value="yes">&nbsp;&nbsp;<strong>Show Exam Breakdown</strong><br>      
            </div>
        
    </div>
    </div>
    </div>
    </div> <!-- row fluid -->
</div> <!-- well -->
    
   
<!--<div class="well">
    <div class="row-fluid">
        <div class="bs-docs-example">
            
                <ul id="myTab" class="nav nav-tabs">
                  <li class="active"><a href="#home" data-toggle="tab">Add Preset/Sample Exams</a></li>
                  <li class=""><a href="#profile" data-toggle="tab">Add Dynamic Exams</a></li>
                </ul>
            <div id="myTabContent" class="tab-content">
            
                    <div class="tab-pane fade active in" id="home">
                    <?php //echo $this->renderPartial('_addexamstostudent', array('model'=>$model), false, true);?>
                    </div>

                     <div class="tab-pane fade" id="profile">
                    <?php //echo $this->renderPartial('_adddynamicexams', array('model'=>$model));?>     

                    </div>
                    
          </div>
       </div>
   </div>  row-fluid       
</div>  well -->

    <div class="control-group">
        <div class="controls">
            <center>
                <!--<input type="submit" class="btn btn-primary">-->
                <?php
                echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news'));
            
                ?>
             </center>
         </div>   
    </div>
           <?php $this->endWidget(); ?> 

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
                            var objTXT = document.getElementById('Address_zip');
                            objTXT.style.borderColor = "#BDBDBD";
                            document.getElementById('Address_zip').style.color="black";
                            return true;
                        }
                    } else {
                        return false;
                    }
                }
            }
            $(function() {
                
                // Setup form validation on the #register-form element
                $("#student-form").validate({
                    
                    // Specify the validation rules
                    rules: {
                        "User[first_name]": "required",
                        "User[last_name]": "required", 
                        
                        "User[email]": {
                            required: true,
                            email: true,
                            message: 'Not a valid email address'
                        },            
                        "User[phone_number]": "required",
                        "User[address]": "required",
                        "User[country_id]": "required",
                        course_id : "required",
                        "User[level_id]": "required",
                        "User[sitting_id]": "required" 
                        
                    },
                    
                    // Specify the validation error messages
                    messages: {
                        "User[first_name]": "Please enter first name",
                        "User[last_name]": "Please enter last name", 
                        "User[email]":{ required: "Please enter email"},            
                        "User[phone_number]":"Please enter phone number",            
                        "User[address]": "Please enter address",
                        "User[country_id]": "Please enter country",
                        course_id : "Please select course",
                        "User[level_id]": "Please select level",
                        "User[sitting_id]": "Please select sitting" 
                    },
                    
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
                
            });
</script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>