<style>
    .asterix{
        color: red;
    }
</style>

<script>
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }

    function jsFunction() {
        var myselect = document.getElementById("exam_type");
        alert(myselect.options[myselect.selectedIndex].value);

    }

    function showMinusEnable() {

        if (document.getElementById('enable_custom_marks').checked) {
            document.getElementById("minus_mark_div").style.display = "block";
            document.getElementById("custom_mark_div").style.display = "none";
        } else {
            document.getElementById("minus_mark_div").style.display = "none";
            document.getElementById("custom_mark_div").style.display = "block";
        }
    }
</script>

<script type="text/javascript">

    function resetMultipleSelect() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/renderBlank'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                //question_id:question_id
            },
            success: function (data) {
                $('#final_render_view').html(data.output);
            }
        });
    }

</script>

<div class="form">
    <?php
    $numberOfSubjectAreas = 20;

    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'exam-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));
    ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>


    <div class="control-group">       
        <?php
        $course_id = Subject::model()->getCourseOfSubject($model->subject_id);
        $course_details = Course::model()->getCourseDetails($course_id);

        $level_id = Subject::model()->getLevelOfSubject($model->subject_id);
        $level_details = Level::model()->getLevel($level_id);

        echo 'Course';
        echo '<br>';
        echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'options' => array($course_id => array('selected' => true)),
            'prompt' => 'Select Course',
            'disabled' => 'disabled',
            'class' => 'form-control',
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('Level/getLevels'),
                'update' => '#level_id',
                'beforeSend' => 'function() {           
                if(subject_id.value!=""){
                    subject_id.options.length = 1;
                }
            
        }',
        )));
        ?> 

    </div>

    <div class="control-group">
        <?php
        $criteria = new CDbCriteria;
        $criteria->condition = "course_id= " . $course_id;
        $level = Level::model()->findAll($criteria);


        echo 'Level';
        echo '<br>';
        echo CHtml::dropDownList('level_id', '', CHtml::listData($level, 'level_id', 'level_name'), array(
            'options' => array($level_id => array('selected' => true)),
            'prompt' => 'Select Level',
            'disabled' => 'disabled',
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('Subject/getSubjects'),
                'update' => '#subject_id',
        )));
        ?>         
    </div>

    <div class="control-group">
        <?php
        $updateDropDowns = "";
        for ($count = 1; $count <= $numberOfSubjectAreas; $count++) {
            if ($count == $numberOfSubjectAreas) {
                $updateDropDowns = $updateDropDowns . '#subject_area_id_' . $count;
            } else {
                $updateDropDowns = $updateDropDowns . '#subject_area_id_' . $count . ',';
            }
        }

        $criteria2 = new CDbCriteria;
        $criteria2->condition = "subject_id= " . $model->subject_id;
        $subject = Subject::model()->findAll($criteria2);

        echo 'Subject';
        echo '<br>';
        echo CHTML::dropDownList('subject_id', '', CHtml::listData($subject, 'subject_id', 'subject_name'), array(
            'options' => array($model->subject_id => array('selected' => true)),
            'prompt' => 'Select Subject',
            'disabled' => 'disabled',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
                'update' => $updateDropDowns,
        )));
        ?>  


        <br>
        <b id="subjectErr"></b>
    </div>

    <div class="control-group">     
        <?php echo $form->textFieldRow($model, 'exam_name', array('id' => 'exam_name', 'class' => 'span5', 'maxlength' => 100, 'placeholder' => 'Exam Name')); ?>
    </div>  

    <div class="control-group">
        Exam Description <span class="asterix">*</span><br/>
        <?php echo $form->textArea($model, 'exam_description', array('id' => 'exam_description', 'class' => 'mceNoEditor', 'maxlength' => 100, 'placeholder' => 'Exam Description')); ?>
    </div> 

    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'number_of_questions', array('id' => 'number_of_questions', 'class' => 'span5', 'placeholder' => 'Number Of Questions')); ?>
    </div>


    <div class="control-group">   
        Exam Type<br/>

        <?php
        echo CHtml::dropDownList('exam_type', '', array('PRESET' => 'Preset', 'SAMPLE' => 'Sample', 'DYNAMIC' => 'Dynamic' , 'ESSAY'=>'Essay' ), array(
            'options' => array($model->exam_type => array('selected' => true)),
            'prompt' => 'Select Exam  Type',
            'class' => 'form-control',
            'disabled' => 'disabled'));
        ?>

    </div>
    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'time', array('id' => 'time', 'class' => 'span5', 'append' => 'minutes', 'placeholder' => 'Time')); ?>
    </div>
    <?php // echo $form->textFieldRow($model,'calculator_allowed',array('class'=>'span5'));      ?>

    <br/>
    <div class="control-group"> 
        Calculator Allowed<br/><br/>
        <?php
        if ($model->calculator_allowed == 1) {
            ?>
            <input id="cal_yes" type="radio" name="calculator_allowed" value="1" checked>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cal_no" type="radio" name="calculator_allowed" value="0">&nbsp;&nbsp;No
            <?php
        } else if ($model->calculator_allowed == 0) {
            ?>
            <input id="cal_yes" type="radio" name="calculator_allowed" value="1">&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cal_no" type="radio" name="calculator_allowed" value="0" checked>&nbsp;&nbsp;No    
            <?php
        }
        ?>



    </div>
    <br/>
    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'exam_price', array('id' => 'exam_price', 'class' => 'span5', 'prepend' => 'LKR', 'placeholder' => 'Exam Price')); ?>
    </div>
    <br/>

    <?php
    if ($model->exam_type != 'ESSAY') {
        if ($model->allow_custom_marks == 1) {
            ?>
            <div id="custom_mark_div" style="display: none"class="control-group"> 
                <?php echo $form->textFieldRow($model, 'marks_per_question', array('id' => 'marks_per_question', 'class' => 'span5', 'placeholder' => 'Marks Per Question')); ?>
            </div>

            <div class="control-group" style="display: block">
                <input id="enable_custom_marks" type="checkbox" name="enable_custom_marks" value="1" onclick="showMinusEnable()" checked>&nbsp;<strong>Enable Custom Marks</strong><br>
            </div><br/>
            <?php
            if ($model->allow_minus_marks == 1) {
                ?>
                <div id="minus_mark_div" class="control-group" style="display: block">
                    <input id="enable_minus_marks" type="checkbox" name="enable_minus_marks" value="1" checked>&nbsp;<strong>Enable Minus Marks</strong><br>
                </div>
                <?php
            } else if ($model->allow_minus_marks == 0) {
                ?>
                <div id="minus_mark_div" class="control-group" style="display: block">
                    <input id="enable_minus_marks" type="checkbox" name="enable_minus_marks" value="1">&nbsp;<strong>Enable Minus Marks</strong><br>
                </div>
                <?php
            }
            ?>


            <?php
        } else if ($model->allow_custom_marks == 0) {
            ?>


            <div class="control-group" style="display: block">
                <input id="enable_custom_marks" type="checkbox" name="enable_custom_marks" value="1" onclick="showMinusEnable()">&nbsp;<strong>Enable Custom Marks</strong><br>
            </div><br/>
            <div id="minus_mark_div" class="control-group" style="display: none">
                <input id="enable_minus_marks" type="checkbox" name="enable_minus_marks" value="1">&nbsp;<strong>Enable Minus Marks</strong><br>
            </div>
            <div id="custom_mark_div" style="display: block"class="control-group"> 
                <?php echo $form->textFieldRow($model, 'marks_per_question', array('id' => 'marks_per_question', 'class' => 'span5', 'placeholder' => 'Marks Per Question')); ?>
            </div>
            <?php
        }
        ?>

                                                                <!--<input id="enable_custom_marks" type="checkbox" name="enable_custom_marks" value="1" onclick="showMinusEnable()">&nbsp;<strong>Enable Custom Marks</strong><br>-->
        <br/>

        <div class="control-group"> 
            <?php echo $form->textFieldRow($model, 'pass_mark', array('id' => 'pass_mark', 'class' => 'span5', 'placeholder' => 'Pass Mark')); ?>
        </div>
        <br/>

        <div class="control-group">
            <?php
            if ($model->allow_view_marked_questions == 1) {
                ?><input id="allow_view_marked_questions" type="checkbox" name="allow_view_marked_questions" value="1" checked>&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br><?php
            } else {
                ?><input id="allow_view_marked_questions" type="checkbox" name="allow_view_marked_questions" value="1" >&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br><?php
            }
            ?>
        </div>
        <div class="control-group">
            <?php
            if ($model->allow_goto_question == 1) {
                ?><input id="allow_goto_question" type="checkbox" name="allow_goto_question" value="1" checked="">&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br><?php
            } else {
                ?><input id="allow_goto_question" type="checkbox" name="allow_goto_question" value="1" >&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br><?php
            }
            ?>
        </div>
        <div class="control-group">
            <?php
            if ($model->allow_view_unanswered_questions == 1) {
                ?><input id="allow_view_unanswered_questions" type="checkbox" name="allow_view_unanswered_questions" value="1" checked="">&nbsp;<strong>Allow Candidate to View Un-Answered Questions</strong><br><?php
            } else {
                ?><input id="allow_view_unanswered_questions" type="checkbox" name="allow_view_unanswered_questions" value="1" >&nbsp;<strong>Allow Candidate to View Unanswered Questions</strong><br><?php
            }
            ?>
        </div>
        <br/>
        <div class="control-group"> 
            <?php echo $form->textFieldRow($model, 'expiry_duration', array('id' => 'expiry_duration', 'class' => 'span5', 'append' => 'Months', 'placeholder' => 'Expiry Duration')); ?>
        </div>



       <br/>



        <div class="control-group">
            <?php
            if ($model->exam_type == "SAMPLE" || $model->exam_type == "PRESET") {
                $exam_questions = ExamQuestion::model()->getQuestionsOfExam($model->exam_id);

                $this->renderPartial('_existingQuestions', array('subject_id' => $model->subject_id, 'subject_area_id' => null, 'question_type' => null, 'exam_questions' => $exam_questions));

                echo '<br/><br/>';


                echo $this->renderPartial('_questionSelector', array('subject_id' => $model->subject_id, 'exam_questions' => $exam_questions), true, false);


                //            $this->renderPartial('_finalQuestionSelector', array('subject_id' => $model->subject_id, 'subject_area_id' => null, 'question_type' => null, 'exam_questions' => $exam_questions), false, true);
            } else if ($model->exam_type == "DYNAMIC") {

                $exam_subject_areas = ExamSubjectArea::getSubjectAreasOfExamById($model->exam_id);

                //            echo '<pre>';
                //            print_r($exam_subject_areas);
                //            echo '</pre>';

                $occupied_subject_areas = sizeof($exam_subject_areas);
                $available_subject_area = $numberOfSubjectAreas - $occupied_subject_areas;

                $count = 1;

                $subjectAreaSession = Yii::app()->session['subject_area_session'];
                //$process = false;
                foreach ($exam_subject_areas as $exam_subject_area) {
                    //$process = ($count == $occupied_subject_areas-1) ? true : false;
                    $this->renderPartial('_weightageForm', array(
                        'count' => $count,
                        'numberOfSubjectAreas' => $numberOfSubjectAreas,
                        'subject_id' => $model->subject_id,
                        'exam_id' => $model->exam_id,
                        'exam_subject_area' => $exam_subject_area,
                        'occupied_subject_areas' => $occupied_subject_areas
                            ), false, true);
                    $count++;


                    $subjectAreaSession[] = array("subject_area_id" => $exam_subject_area['exam_subject_area_details']['subject_area_id'],
                        "subject_area_weight" => $exam_subject_area['exam_subject_area_details']['weightage'],
                        "single_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['single_answer_weightage'],
                        "multiple_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['multiple_answer_weightage'],
                        "short_written_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['short_written_answer_weightage'],
                        "drag_drop_typea_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['drag_drop_typea_answer_weightage'],
                        "drag_drop_typeb_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['drag_drop_typeb_answer_weightage'],
                        "drag_drop_typec_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['drag_drop_typec_answer_weightage'],
                        "drag_drop_typed_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['drag_drop_typed_answer_weightage'],
                        "drag_drop_typee_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['drag_drop_typee_answer_weightage'],
                        "multiple_choice_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['multiple_choice_answer_weightage'],
                        "true_or_false_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['true_or_false_answer_weightage'],
                        "hotspot_answer_question_weight" => $exam_subject_area['exam_subject_area_details']['hotspot_answer_weightage']);
                }

                Yii::app()->session['subject_area_session'] = $subjectAreaSession;

                if ($available_subject_area != 0) {
                    $process = false;
                    for ($count2 = $count; $count2 <= $count + $available_subject_area - 1; $count2++) {
                        $process = ($count == 9) ? true : false;
                        $this->renderPartial('_weightageForm', array(
                            'count' => $count2,
                            'numberOfSubjectAreas' => $numberOfSubjectAreas,
                            'subject_id' => $model->subject_id,
                            'exam_id' => null,
                            'exam_subject_area' => null,
                            'occupied_subject_areas' => $occupied_subject_areas), false, $process);
                    }
                }
            }
            ?>
        </div>
        <div class="control-group"><br/>
            <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
        </div>
        <div class="control-group"> 
            <div>
                <?php
                echo CHtml::ajaxButton('Save Changes', CController::createUrl('Exam/SaveExam'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'beforeSend' => 'js:tinyMCE.triggerSave()',
                    'data' => array('exam_id' => $model->exam_id,
                        'course_id' => 'js:course_id.value',
                        'level_id' => 'js:level_id.value',
                        'subject_id' => 'js:subject_id.value',
                        'exam_name' => 'js:exam_name.value',
                        'exam_description' => 'js:exam_description.value',
                        'number_of_questions' => 'js:number_of_questions.value',
                        'exam_type' => 'js:exam_type.value',
                        'time' => 'js:time.value',
                        'cal_yes' => 'js:cal_yes.checked',
                        'exam_price' => 'js:exam_price.value',
                        'marks_per_question' => 'js:marks_per_question.value',
                        'enable_custom_marks' => 'js:enable_custom_marks.checked',
                        'enable_minus_marks' => 'js:enable_minus_marks.checked',
                        'pass_mark' => 'js:pass_mark.value',
                        'expiry_duration' => 'js:expiry_duration.value',
                        'allow_view_marked_questions' => 'js:allow_view_marked_questions.checked',
                        'allow_goto_question' => 'js:allow_goto_question.checked',
                        'allow_view_unanswered_questions' => 'js:allow_view_unanswered_questions.checked',
                        'tab_count' => 15,
//                        'tab_title_1' => 'js:tab_title_1.value',
//                        'tab_title_2' => 'js:tab_title_2.value',
//                        'tab_title_3' => 'js:tab_title_3.value',
//                        'tab_title_4' => 'js:tab_title_4.value',
//                        'tab_title_5' => 'js:tab_title_5.value',
//                        'tab_title_6' => 'js:tab_title_6.value',
//                        'tab_title_7' => 'js:tab_title_7.value',
//                        'tab_title_8' => 'js:tab_title_8.value',
//                        'tab_title_9' => 'js:tab_title_9.value',
//                        'tab_title_10' => 'js:tab_title_10.value',
//                        'tab_title_11' => 'js:tab_title_11.value',
//                        'tab_title_12' => 'js:tab_title_12.value',
//                        'tab_title_13' => 'js:tab_title_13.value',
//                        'tab_title_14' => 'js:tab_title_14.value',
//                        'tab_title_15' => 'js:tab_title_15.value',
//                        'table_formula_1' => 'js:table_formula_1.value',
//                        'table_formula_2' => 'js:table_formula_2.value',
//                        'table_formula_3' => 'js:table_formula_3.value',
//                        'table_formula_4' => 'js:table_formula_4.value',
//                        'table_formula_5' => 'js:table_formula_5.value',
//                        'table_formula_6' => 'js:table_formula_6.value',
//                        'table_formula_7' => 'js:table_formula_7.value',
//                        'table_formula_8' => 'js:table_formula_8.value',
//                        'table_formula_9' => 'js:table_formula_9.value',
//                        'table_formula_10' => 'js:table_formula_10.value',
//                        'table_formula_11' => 'js:table_formula_11.value',
//                        'table_formula_12' => 'js:table_formula_12.value',
//                        'table_formula_13' => 'js:table_formula_13.value',
//                        'table_formula_14' => 'js:table_formula_14.value',
//                        'table_formula_15' => 'js:table_formula_15.value',
                    ),
                    'success' => 'function(data){ 

                         if(data[0].status=="success"){
                            removeHighlight("course_id");
                            removeHighlight("level_id");
                            removeHighlight("subject_id");
                            removeHighlight("exam_name");
                            removeHighlight("exam_description");
                            removeHighlight("number_of_questions");
                            removeHighlight("exam_type");
                            removeHighlight("time");
                            removeHighlight("exam_price");
                            removeHighlight("marks_per_question");
                            removeHighlight("expiry_duration");
                            removeHighlight("pass_mark");

                            document.location.href = data[0].redirect_url; 
                         }else if(data[0].status=="fail"){
                            document.getElementById("errorDisplay").innerHTML="";
                            document.getElementById("errorDisplay").style.display="none";

                            removeHighlight("course_id");
                            removeHighlight("level_id");
                            removeHighlight("subject_id");
                            removeHighlight("exam_name");
                            removeHighlight("exam_description");
                            removeHighlight("number_of_questions");
                            removeHighlight("exam_type");
                            removeHighlight("time");
                            removeHighlight("exam_price");
                            removeHighlight("marks_per_question");
                            removeHighlight("expiry_duration");
                            removeHighlight("pass_mark");

                            for(var x=0;x<data[1].length;x++){
                                var element =  data[1][x];
                                hightlightTextBox(element);
                            }

                            for(var x=0;x<data[3].length;x++){
                                var element =  data[3][x];
                                hightlightTextBox(element);
                            }

                            for(var x=0;x<data[2].length;x++){
                                var msg =  data[2][x];
                                document.getElementById("errorDisplay").innerHTML=document.getElementById("errorDisplay").innerHTML+msg+"<br />";

                            }

                            document.getElementById("errorDisplay").style.display="block";

                         }
                                            }'
                        ), array('class' => 'button button-news',
                    'id' => 'saveBtn')
                );
                ?>
            </div>
        </div>

        <br/><br/>




        <?php
        if ($model->exam_type == "DYNAMIC") {
            if ($exam_subject_areas != null) {

                for ($count = 1; $count <= $occupied_subject_areas; $count++) {
                    ?>
                    <script>
                        document.getElementById("weightage_form_<?php echo $count; ?>").style.display = "block";
                    </script>    
                    <?php
                }
                ?>
                <script>
                    document.getElementById("weightage_form_<?php echo $count; ?>").style.display = "block";
                </script>
                <?php
            }
        }


        if ($model->exam_type == "DYNAMIC") {
            if ($exam_subject_areas == null) {
                ?>
                <script>
                    document.getElementById("weightage_form_1").style.display = "block";
                </script>
                <?php
            }
        }
    } elseif ($model->exam_type == 'ESSAY') {
        echo $this->renderPartial('_updateEssayExamInfo', array('model' => $model, 'subject_id' => $model->subject_id, 'exam_questions' => null), false, true);
    }
    ?>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<script>

                    tinymce.init({
                        mode: "textareas",
                        theme: "modern",
                        editor_selector: "mceEditor",
                        editor_deselector: "mceNoEditor",
                        width: 800,
                        height: 250,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor jbimages"
                        ],
                        content_css: "css/content.css",
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image jbimages | print preview media fullpage | forecolor backcolor emoticons",
                        relative_urls: false,
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]


                    });
</script>