<style>
    .astrix{
        color: red;
    }
</style>

<style>
    #student-form label.error{
        color: #B40404;
    }
</style>



<div class="span10">
    <div class="row-fluid">
        <div class="span10">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'student-form',
                'enableAjaxValidation' => false,
                    ));
            ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>


            <div class="control-group">
                <?php echo $form->labelEx($model, 'first_name <span class="astrix"> *</span>'); ?>
                <?php echo $form->textField($model, 'first_name', array('value' => $model->user->first_name)); ?>
                <?php echo $form->error($model, 'first_name'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'last_name <span class="astrix"> *</span>'); ?>
                <?php echo $form->textField($model, 'last_name', array('value' => $model->user->last_name)); ?>
                <?php echo $form->error($model, 'last_name'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'email <span class="astrix"> *</span>'); ?>
                <?php echo $form->textField($model, 'email', array('value' => $model->user->email,'readonly'=>TRUE)); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'phone_number <span class="astrix"> *</span>'); ?>
                <?php echo $form->textField($model, 'phone_number', array('value' => $model->user->phone_number,'onkeypress' => 'return restrictInput(this,event,digitsOnly);')); ?>
                <?php echo $form->error($model, 'phone_number'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'address <span class="astrix"> *</span>'); ?>
                <?php echo $form->textField($model, 'address', array('value' => $model->user->address)); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
            <div class="control-group">
                <?php
                $course_id = Student::model()->getCourseOfStudent($model->student_id);
                echo '<label class="control-label" for="inputEmail">Course<span class="astrix"> *</span></label>';

                echo '<div class="controls">' . CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
                    'options' => array($course_id => array('selected' => true)),
                    'prompt' => 'Select Course',
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('Level/getLevels'),
                        'update' => '#level_id2,#Student_level_id,#level_id',
                        )));
                echo '</div>';
                ?> 
                <?php echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'level_id <span class="astrix"> *</span>'); ?>
                <?php
//                    echo $form->dropDownList($model, 'level_id', Level::model()->getLevels());

                echo CHtml::activeDropDownList($model, 'level_id', Level::model()->getLevelsOfCourse($model->level_id), array(
                    'prompt' => 'Select Level',
                    'class' => 'form-control',
                        //'ajax' => array(
                        //  'data' => array('level_id' => 'js:level_id.value'),
                        //'type' => 'POST',
                        //'url' => CController::createUrl('Student/getViews'),
                        //'update' => '#render_view',
                ));
                ?>
                <?php echo $form->error($model, 'level_id'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'Session <span class="astrix"> *</span>'); ?>
                <?php echo $form->dropDownList($model, 'sitting_id', Sitting::model()->getSittings()); ?>
                <?php echo $form->error($model, 'sitting_id'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'note'); ?>
                <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'note'); ?>
            </div>

            <!--<div class="row">-->
            <?php // echo $form->labelEx($model,'status'); ?>
            <?php // echo $form->textField($model,'status');  ?>
            <?php // echo $form->error($model,'status');  ?>
            <!--</div>-->

            <br/>
            <div class="control-group">
                <center>
                    <?php
                    if ($model->show_exam_breakdown == 1) {
                        ?><input type="checkbox" name="show_exam_breakdown" value="yes" checked="">&nbsp;&nbsp;<strong>Show Exam Breakdown</strong><br>
                        <?php
                    } else if ($model->show_exam_breakdown == 0) {
                        ?><input type="checkbox" name="show_exam_breakdown" value="yes">&nbsp;&nbsp;<strong>Show Exam Breakdown</strong><br>
                        <?php
                    }
                    ?>
                </center>
            </div>


            <!-- form -->
            <?php
            //$examsOfStudent = StudentExam::model()->getExamsOfStudent($model->student_id);
//print_r($examsOfStudent);
            ?>

            <div id="render_view">
                <?php
                $examsOfStudent = StudentExam::model()->getExamsOfStudent($model->student_id);
//print_r($examsOfStudent);
                ?>

                <h4>Scheduled Exams</h4>
                <div id="removedexams">
                    <!-- Removed exam elements -->
                </div>

                <table class="table">
                    <tr>
                        <th width="200">Exam Name</th>
                        <th width="200">Exam Type</th>
                        <th width="200">Subject</th>
                        <th width="200">Start Date</th> 
                        <th width="200">Expiry Date</th> 
                        <th width="200"></th>
                    <tr>
                        <?php
                        $rowcount = 0;
                        foreach ($examsOfStudent as $examOfStudent) {
                            $examDetails = Exam::getExamInfoById($examOfStudent['exam_id']);
                            $subjectDetails = Subject::getSubjectInfoById($examDetails->subject_id);
                            echo '<tr id=' . $rowcount . '>';
                            echo '<td><center>';
                            echo $examDetails->exam_name;
                            echo '</td></center>';
                            echo '<td><center>';
                            if ($examDetails->exam_type == "DYNAMIC") {
                                echo 'Dynamic';
                            } else if ($examDetails->exam_type == "SAMPLE") {
                                echo 'Sample';
                            } else if ($examDetails->exam_type == "PRESET") {
                                echo 'Preset';
                            }else if ($examDetails->exam_type == "ESSAY") {
                                echo 'Essay';
                            }
                            echo '</td></center>';
                            echo '<td><center>';
                            echo $subjectDetails->subject_name;
                            echo '</td></center>';
                            echo '<td><center>';
                            echo $examOfStudent['start_date'];
                            echo '</td></center>';
                            echo '<td><center>';
                            echo $examOfStudent['expiry_date'];
                            echo '</td></center>';
                            echo '<td><center>';
                            echo '<input type="button" value="Remove" class="tinygreybtn" onclick="RemoveExam(' . $examOfStudent['student_exam_id'] . ',' . $rowcount . ')">';
                            echo '</td></center>';
                            echo '</tr>';

                            $rowcount++;
                        }
                        ?>    

                </table>
                <br/>




            </div>
        </div>
    </div>
</div>
<?php //echo $this->renderPartial('_edit_addexamtostudent', array('model' => $model, 'level_id' => $model->level_id,'exams_of_student'=>$examsOfStudent));  ?>
<?php //echo $this->renderPartial('_edit_adddynamicexams', array('model' => $model, 'level_id' => $model->level_id,'exams_of_student'=>$examsOfStudent));  ?>

<div class="row buttons">
    <center>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news')); ?>
    </center>
</div>
<p>&nbsp;</p>
<?php $this->endWidget(); ?>


<script type="text/javascript">

    function RemoveExam(exam_id,row_count){
   
        $("#removedexams").append('<input type="hidden" value="'+exam_id+'" name="deleted_exams[]">');
        $('#'+row_count).hide();    
    }

</script>
<script type="text/javascript">
           
            $(function() {
                
                // Setup form validation on the #register-form element
                $("#student-form").validate({                   
                 
                    rules: {
                        "Student[first_name]": "required",
                        "Student[last_name]": "required", 
                        "Student[email]":{
                            email:true,
                            required:true
                            //message:"Not a valid email address"
                        },
                        "Student[phone_number]": "required",
                        "Student[address]": "required",
                        course_id: 'required',
                        "Student[level_id]": "required",
                        "Student[sitting_id]": "required"
                    },
                    // Specify the validation error messages
                    messages: {
                        "Student[first_name]": "Please enter first name",
                        "Student[last_name]": "Please enter last name",
                        "Student[email]":{ required: "Please enter email"},
                        "Student[phone_number]":"Please enter phone number",
                        "Student[address]": "Please enter address",
                        "Student[country_id]": "Please enter country",
                        course_id : "Please select course",
                        "Student[level_id]": "Please select level",
                        "Student[sitting_id]": "Please select sitting"
                    },
                    
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
                
            });
</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js"></script>

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
                            return true;
                        }
                    } else {
                        return false;
                    }
                }
            }

</script>

