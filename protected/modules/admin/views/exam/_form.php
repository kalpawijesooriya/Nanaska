<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui.min.js" type="text/javascript"></script>
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
        var myselect = document.getElementById("exam_type_drp_div");
        alert(myselect.options[myselect.selectedIndex].value);

    }
    //hide default exam creation part if exam type is essay
    function hideOther() {
        //alert(document.getElementById("exam_type_drp_div").value);
        if (document.getElementById("exam_type_drp_div").value == 'ESSAY') {
            $('#none_essay_exam_div').hide();
            $('#create_exam').hide();

        } else {
            $('#none_essay_exam_div').show();
            $('#create_exam').show();
        }
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

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //  $('#image').css('background', 'transparent url('+e.target.result +') left top no-repeat') .width('Auto').height(500);

                $('#imge')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(auto);

            };

            reader.readAsDataURL(input.files[0]);
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


    function resetDynamic() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/renderBlank'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                //question_id:question_id
            },
            success: function (data) {
                $('#render_view').html(data.output);
            }
        });
    }


    function clearSession() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/clearSession'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function (data) {
//                alert(data.output);
            }
        });
    }

</script>



<div class="form">
    <?php
    $numberOfSubjectAreas = 20;
    $user_id = Yii::app()->user->getId();
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'exam-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>   

    <div class="control-group">       
        <?php
        echo 'Course <span class="asterix">*</span>';
        echo '<br>';
        echo CHtml::dropDownList('course_id', '', Course::model()->getCoursesForUser($user_id), array(
            'prompt' => 'Select Course',
            'class' => 'form-control',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('Level/getLevelsForUser'),
                'update' => '#level_id',
                'beforeSend' => 'function() {
                    
                     if(subject_id.value!=""){
                         subject_id.options.length = 1;                       
                     } 
                     
                    if(exam_type_drp_div.value!=""){                              
                         $("#exam_type_drp_div option:eq(0)").attr("selected","selected");
                     }  
                     
                     var subAreaElement = document.getElementById("subject_area_id");
                     var questionTypeElement = document.getElementById("question_type");
                     if(subAreaElement!=null && questionTypeElement!=null){
                         subAreaElement.options.length = 1;  
                         question_type.options.length = 1;
                        
                     }
                     if(document.getElementById("errorDisplay")!=null){                      
                        $( "#errorDisplay" ).hide();
                     }
                     
                     if(document.getElementById("render_view").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
                        resetDynamic();
                        clearSession();
                    }                   
                    
                }',
        )));
        ?> 

    </div>

    <div class="control-group">
        <?php
        echo 'Level <span class="asterix">*</span>';
        echo '<br>';
        echo CHtml::dropDownList('level_id', '', array(), array(
            'prompt' => 'Select Level',
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('Subject/getSubjectsForUser'),
                'update' => '#subject_id',
                'beforeSend' => 'function() { 
                    
                    if(exam_type_drp_div.value!=""){                              
                         $("#exam_type_drp_div option:eq(0)").attr("selected","selected");
                     }
                     
                     if(document.getElementById("errorDisplay")!=null){                      
                        $( "#errorDisplay" ).hide();
                     }

                      if(document.getElementById("render_view").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
                        resetDynamic();
                    }                  
                    
                }',
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


        echo 'Subject <span class="asterix">*</span>';
        echo '<br>';
        echo CHTML::dropDownList('subject_id', '', array(), array(
            'prompt' => 'Select Subject',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
                'update' => $updateDropDowns,
                'beforeSend' => 'function() {   
                    
                    if(exam_type_drp_div.value!=""){                              
                         $("#exam_type_drp_div option:eq(0)").attr("selected","selected");
                     } 
                     
                     if(document.getElementById("errorDisplay")!=null){                      
                        $( "#errorDisplay" ).hide();
                     }

                      if(document.getElementById("render_view").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
                        resetDynamic();
                    }                  
                    
                }',
        )));
        ?>  


        <br>
        <b id="subjectErr"></b>
    </div>

    <div class="control-group">     
        <?php echo $form->textFieldRow($model, 'exam_name', array('id' => 'exam_name', 'class' => 'span5', 'maxlength' => 100, 'placeholder' => 'Exam Name')); ?>
    </div>  

    <div class="control-group">
        Exam Description <span class="asterix">*</span> <br/>
        <?php echo $form->textArea($model, 'exam_description', array('id' => 'exam_description', 'class' => 'mceNoEditor', 'maxlength' => 512, 'placeholder' => 'Exam Description')); ?>
    </div> 

    <div class="control-group">   
        Exam Type  <span class="asterix">*</span><br/>

        <?php
        echo CHtml::dropDownList('exam_type', '', array('PRESET' => 'Preset', 'SAMPLE' => 'Sample', 'DYNAMIC' => 'Dynamic', 'ESSAY' => 'Essay'), array(
            'id' => 'exam_type_drp_div',
            'prompt' => 'Select Exam  Type',
            'class' => 'form-control',
            'onchange' => 'js:hideOther()',
            'ajax' => array(
                'data' => array('exam_type' => 'js:exam_type_drp_div.value', 'numberOfSubjectAreas' => $numberOfSubjectAreas, 'subject_id' => 'js:subject_id.value'),
                'type' => 'POST',
                'url' => CController::createUrl('Exam/getViewByType'),
                'update' => '#render_view'
        )));
        ?>


    </div>

    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'number_of_questions', array('id' => 'number_of_questions', 'class' => 'span5', 'placeholder' => 'Number Of Questions')); ?>
    </div>
    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'time', array('id' => 'time', 'class' => 'span5', 'append' => 'minutes', 'placeholder' => 'Time')); ?>
    </div>

    <br/>
    <div class="control-group"> 
        Calculator Allowed<br/><br/>    
        <input id="cal_yes" type="radio" name="calculator_allowed" value="1" checked="">&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="cal_no" type="radio" name="calculator_allowed" value="0">&nbsp;&nbsp;No
    </div>
    <br/>
    <div class="control-group"> 
        <?php echo $form->textFieldRow($model, 'exam_price', array('id' => 'exam_price', 'class' => 'span5', 'prepend' => 'GBP', 'placeholder' => 'Exam Price')); ?>
    </div>
    <br/>

    <!-- separate panel for none essay exams-->
    <div id="none_essay_exam_div" class="control-group">
        <div class="control-group">
            <input id="enable_custom_marks" type="checkbox" name="enable_custom_marks" value="1" onclick="showMinusEnable()">&nbsp;<strong>Enable Custom Marks</strong><br>
        </div><br/>    
        <div id="minus_mark_div" class="control-group" style="display: none">
            <input id="enable_minus_marks" type="checkbox" name="enable_minus_marks" value="1">&nbsp;<strong>Enable Minus Marks</strong><br>
        </div>
        <div id="custom_mark_div"    class="control-group"> 
            <?php echo $form->textFieldRow($model, 'marks_per_question', array('id' => 'marks_per_question', 'class' => 'span5', 'placeholder' => 'Marks Per Question')); ?>
        </div>
        <div class="control-group"> 
            <?php echo $form->textFieldRow($model, 'pass_mark', array('id' => 'pass_mark', 'class' => 'span5', 'placeholder' => 'Pass Mark')); ?>
        </div>
        <br/>
        <div class="control-group">
            <input id="allow_view_marked_questions" type="checkbox" name="allow_view_marked_questions" value="1" checked="">&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br>
        </div>
        <div class="control-group">
            <input id="allow_goto_question" type="checkbox" name="allow_goto_question" value="1" checked="">&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br>
        </div>
        <div class="control-group">
            <input id="allow_view_unanswered_questions" type="checkbox" name="allow_view_unanswered_questions" value="1" checked="">&nbsp;<strong>Allow Candidate to View Unanswered Questions</strong><br>
        </div><br/>

        <div class="control-group"> 
            <?php echo $form->textFieldRow($model, 'expiry_duration', array('id' => 'expiry_duration', 'class' => 'span5', 'append' => 'Months', 'placeholder' => 'Expiry Duration')); ?>
        </div>
    </div>
    <!-- end of panel -->




    <div id="render_view">

    </div><br/>

    <div class="control-group"><br/>
        <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
    </div>
    <div class="control-group"> 

        <?php
        echo CHtml::ajaxbutton('Create Exam', CController::createUrl('Exam/Validate'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            'beforeSend' => 'js:tinyMCE.triggerSave()',
            'data' => array('course_id' => 'js:course_id.value',
                'level_id' => 'js:level_id.value',
                'subject_id' => 'js:subject_id.value',
                'exam_name' => 'js:exam_name.value',
                'exam_description' => 'js:exam_description.value',
                'number_of_questions' => 'js:number_of_questions.value',
                'exam_type' => 'js:exam_type_drp_div.value',
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
//                'tab_count' => 15,
//                'tab_title_1' => 'js:tab_title_1.value',
//                'tab_title_2' => 'js:tab_title_2.value',
//                'tab_title_3' => 'js:tab_title_3.value',
//                'tab_title_4' => 'js:tab_title_4.value',
//                'tab_title_5' => 'js:tab_title_5.value',
//                'tab_title_6' => 'js:tab_title_6.value',
//                'tab_title_7' => 'js:tab_title_7.value',
//                'tab_title_8' => 'js:tab_title_8.value',
//                'tab_title_9' => 'js:tab_title_9.value',
//                'tab_title_10' => 'js:tab_title_10.value',
//                'tab_title_11' => 'js:tab_title_11.value',
//                'tab_title_12' => 'js:tab_title_12.value',
//                'tab_title_13' => 'js:tab_title_13.value',
//                'tab_title_14' => 'js:tab_title_14.value',
//                'tab_title_15' => 'js:tab_title_15.value',
//                'table_formula_1' => 'js:table_formula_1.value',
//                'table_formula_2' => 'js:table_formula_2.value',
//                'table_formula_3' => 'js:table_formula_3.value',
//                'table_formula_4' => 'js:table_formula_4.value',
//                'table_formula_5' => 'js:table_formula_5.value',
//                'table_formula_6' => 'js:table_formula_6.value',
//                'table_formula_7' => 'js:table_formula_7.value',
//                'table_formula_8' => 'js:table_formula_8.value',
//                'table_formula_9' => 'js:table_formula_9.value',
//                'table_formula_10' => 'js:table_formula_10.value',
//                'table_formula_11' => 'js:table_formula_11.value',
//                'table_formula_12' => 'js:table_formula_12.value',
//                'table_formula_13' => 'js:table_formula_13.value',
//                'table_formula_14' => 'js:table_formula_14.value',
//                'table_formula_15' => 'js:table_formula_15.value',
            // 'imageanswer' => 'js:upload.value'
            ),
            'success' => 'function(data){ 

                     if(data[0].status=="success"){
                        removeHighlight("course_id");
                        removeHighlight("level_id");
                        removeHighlight("subject_id");
                        removeHighlight("exam_name");
                        removeHighlight("exam_description");
                        removeHighlight("number_of_questions");
                        removeHighlight("exam_type_drp_div");
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
                        removeHighlight("exam_type_drp_div");
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
            'id' => 'create_exam')
        );
        ?>

    </div>
</div>    
<br />

<?php $this->endWidget(); ?>


<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
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

<script type="text/javascript">
    function updateQuestionBox(name) {
        //alert(name);
        //alert(obj.valueOf());
        var no = decodeName(name);
        $("#questions_" + no).empty();
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/getEssayQuestionByArea'); ?>',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                subject_area: $('#' + name).val()
                        //subject_area: $this.val()
            },
            success: function (data) {
                for (i = 0; i < data.status.length; i++) {
                    $("#questions_" + no).append(data.status[i]);
                }

            }
        });

    }
    function decodeName(name) {

        var split = name.split('_');
        return parseInt(split[3]);
    }
    function addQuestion(name) {
        //alert(name);
        var no = decodeButtonName(name);
        var selectedvalue = $('#questions_' + no).val()
        //        alert(no);
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/addQuestionToEssayExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                //question_id: $('#questions_'+no).val()             
                question_id: selectedvalue[0],
                section_no: no
            },
            success: function (data) {
                if (data.status == "success") {
                    if (data.warning == 1) {
                        alert("Warning! The Selected Question is already used in a paper before.");
                    }
                    var questionList = $('#selected_questions_' + no);
                    var option = document.createElement("option");
                    option.text = data.question_id;
                    option.value = data.question_id;
                    //$('#selected_questions_'+no).html(data.question_id)
                    questionList.append(option);//.add(option);
                    removeHighlight("questions_" + no);
                    $('#questionErr_' + no).hide();
                    //$('#questionErr_'+no).style.display="none";

                } else if (data.status == "fail") {
                    hightlightTextBox("questions_" + no);
                    //alert(data.message);
                    $('#questionErr_' + no).empty();
                    //$('#questionErr_'+no).innerHTML="";
                    $('#questionErr_' + no).append(data.message);
                    $('#questionErr_' + no).show();
                }
            }
        });
    }
    function decodeButtonName(name) {

        var split = name.split('_');
        return parseInt(split[2]);
    }
    function removeQuestion(name) {
        //alert(name);
        var no = decodeButtonName(name);
        var selectedvalue = $('#selected_questions_' + no).val();
        //        alert(no);
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/removeQuestionFromEssayExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                question_id: selectedvalue[0]
            },
            success: function (data) {
                if (data.status == "success") {
                    $('#selected_questions_' + no + ' option[value=' + selectedvalue[0] + ']').remove();
                    removeHighlight("selected_questions_" + no);
                    $('#selectedQuestionErr_' + no).hide();
                    //$('#selectedQuestionErr_'+no).style.display="none";
                } else if (data.status == "fail") {
                    hightlightTextBox("selected_questions_" + no);
                    //$('#selectedQuestionErr_'+no).style.display="block";
                    $('#selectedQuestionErr_' + no).empty();
                    $('#selectedQuestionErr_' + no).append(data.message);
                    $('#selectedQuestionErr_' + no).show();
                }
                //$('#selected_questions_'+no).show();
            }
        });

    }

</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //  $('#image').css('background', 'transparent url('+e.target.result +') left top no-repeat') .width('Auto').height(500);

                $('#imge')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(auto);

            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script type="text/javascript">



</script>