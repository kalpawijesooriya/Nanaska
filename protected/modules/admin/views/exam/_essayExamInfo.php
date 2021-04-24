<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
</script>

<!-- start of essay exam div -->
<div class="control-group"> 
    Pass Mark <span class="asterix">*</span><br>
    <input type="text" name="pass_mark_essay" id="pass_mark_essay" placeholder="Pass Mark"/>   
</div>
<br/>
<div class="control-group"> 
    Expiry Duration <span class="asterix">*</span><br>
    <div class="input-append">
        <input type="text" name="expiry_duration_essay" id="expiry_duration_essay" placeholder="Expiry Duration" append="Months"/>
        <span class="add-on">Months</span>
    </div>
</div>

<!--<div class="control-group">
    <input id="allow_view_marked_questionss" type="checkbox" name="allow_view_marked_questionss">&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br>
</div>-->
<div class="control-group">
    <input id="allow_goto_questions" type="checkbox" name="allow_goto_questions">&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br>
</div>
<div class="control-group">
    <input id="allow_view_unanswered_questionss" type="checkbox" name="allow_view_unanswered_questionss">&nbsp;<strong>Allow Candidate to View Unanswered Questions</strong><br>
</div><br/>

<div id="essay_section_div" class="control-group" style="display:none">
    <a id="close_div" onclick="removeSection(this)" class="close"><font color="red">X</font></a>
<!--    <input type="button" name="close_div" id="close_div" class="close" value="X"/>-->

    <h3 id="section_header">Section</h3><br>
    No of Questions <span class="asterix">*</span> &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="no_of_questions" id="no_of_questions" placeholder="No of Questions"/><br><br>
    Section Time <span class="asterix">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="section_time" id="section_time" placeholder="Section Time" append="Minutes"/><br><br>


    <div class="control-group">       
        <?php
        //$count = 1;
        $criteria = new CDbCriteria;
        $criteria->condition = "subject_id= " . $subject_id;
        $subject_areas = SubjectArea::model()->findAll($criteria);

        echo 'Subject Area';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo CHtml::dropDownList('subject_area_id', '', CHtml::listData($subject_areas, 'subject_area_id', 'subject_area_name'), array(
            'prompt' => 'Select Subject Area',
            'class' => 'form-control',
            'onchange' => 'name = this.name; js:updateQuestionBox(name);'
                //'beforeSend' => 'js:getSubjectAreaID()',
//            'ajax' => array( name = js:this.name; 
//                'data' => array('subject_area' => 'js:this.value'),
//                'type' => 'POST',
//                'url' => CController::createUrl('Exam/getEssayQuestionByArea'),
//                'update' => 'js:getQuestionID()',
//            )
        ));
        ?> 
    </div>
    <h4>Select Questions</h4>

    <?php ?>
    <div class="form-control">

        <select  id="questions" name="questions" multiple="multiple" style="width:400px;height:100px;" class="selectBox">


        </select>
    </div>
    <label style="display:none" id="questionErr" class="error"></label>
    <div class="form-control">
        <input type="button" id="add_question" onclick="name = this.name;
                addQuestion(name)" class="bluebtn" value="Add Question">
               <?php
//        echo CHtml::ajaxSubmitButton('Add Question', CController::createUrl('Exam/addQuestionToExam'), array(
//            'type' => 'POST', //request type
//            'dataType' => 'json',
//            'data' => array('question_id' => 'js:questions.value'),
//            'success' => 'function(data){                                       
//                               if(data.status=="success"){
//                                    if(data.warning==1){
//                                        alert("Warning! The Selected Question is already used in a paper before.");
//                                    }
//                                    var questionList = document.getElementById("selected_questions");
//                                    var option = document.createElement("option");
//                                    option.text = data.question_id;
//                                    option.value = data.question_id;
//                                    questionList.add(option);
//                                    removeHighlight("questions");
//                                    document.getElementById("questionErr").innerHTML="";
//                                    document.getElementById("questionErr").style.display="none";
//
//                               }else if(data.status=="fail"){
//                                    hightlightTextBox("questions");
//                                    document.getElementById("questionErr").style.display="block";
//                                    document.getElementById("questionErr").innerHTML="";
//                                    document.getElementById("questionErr").innerHTML=data.message;
//                                }
//                            }'
//                ), array('class' => 'bluebtn', 'id' => uniqid())
//        );
               ?>
    </div><br/>

    <div class="form-control">    

        <select id="selected_questions" name="selected_questions" multiple="multiple" style="width:400px;height:100px;" class="selectBox">
            <!--<option disabled selected>Selected Questions</option>-->
            <?php
            if ($exam_questions != null) {
                $question_session = Yii::app()->session['question_session'];

                foreach ($exam_questions as $exam_question) {
                    echo '<option value=' . $exam_question['question_id'] . '>' . $exam_question['question_id'] . '</option>';


                    $question_id = $exam_question['question_id'];



                    if ($question_id != null) {
                        if ($question_session == null) {
                            $question_session = array();
                            $question_session[] = $question_id;
                        } else {
                            $item_found = false;
                            foreach ($question_session as $item) {
                                if ($item == $question_id) {
                                    $item_found = true;
                                }
                            }
                            if (!$item_found) {
                                $question_session[] = $question_id;
                            }
                        }
                    }
                }
                Yii::app()->session['question_session'] = $question_session;
            }
            ?>
        </select>
    </div>
    <label style="display:none" id="selectedQuestionErr" class="error"></label>
    <div class="form-control">
        <input type="button" id="remove_question" onclick="this.name;
                removeQuestion(name)" class="greybtn" value="Remove Question">
               <?php
//        echo CHtml::ajaxSubmitButton('Remove Question', CController::createUrl('Exam/removeQuestionFromExam'), array(
//            'type' => 'POST', //request type
//            'dataType' => 'json',
//            'data' => array('question_id' => 'js:selected_questions.value'),
//            'success' => 'function(data){                                       
//                                           if(data.status=="success"){
//                                                var questionList = document.getElementById("selected_questions");
//                                                questionList.remove(questionList.selectedIndex);
//                                                removeHighlight("selected_questions");
//                                                document.getElementById("selectedQuestionErr").innerHTML="";
//                                                document.getElementById("selectedQuestionErr").style.display="none";
//                                            }else if(data.status=="fail"){
//                                                hightlightTextBox("selected_questions");
//                                                document.getElementById("selectedQuestionErr").style.display="block";
//                                                document.getElementById("selectedQuestionErr").innerHTML="";
//                                                document.getElementById("selectedQuestionErr").innerHTML=data.message;
//                                            }
//                                        }'
//                ), array('class' => 'greybtn')
//        );
               ?>
    </div>

</div>
<div id="essay_append_div" class="control-group">

</div>
<div class="control-group">
    <input type="button" id="add_section" onclick="appendSection()" class="button button-news" value="Add Section">
    <?php
// echo CHtml::Button('Add Section','', array('class' => 'button button-news','id' => 'add_section', 'onclick'=>'appendSection()'));
    ?>
</div>

<div class="control-group">
    <input type="button" id="create_exam_essay" onclick="createEssayExam()" class="button button-news" value="Create Exam">
</div>

<script type="text/javascript">
    var sectionNo = 1;
    function appendSection() {
        var clone = $('#essay_section_div').clone().attr('id', 'essay_section_div_' + sectionNo);
        clone.find('[type=text]').val('');
        clone.find('[id=no_of_questions]').attr('name', 'no_of_questions_' + sectionNo);
        clone.find('[id=section_time]').attr('name', 'section_time_' + sectionNo);
        clone.find('[id=no_of_questions]').attr('id', 'no_of_questions_' + sectionNo);
        clone.find('[id=section_time]').attr('id', 'section_time_' + sectionNo);
        clone.find("#subject_area_id").attr('name', 'subject_area_id_' + sectionNo);
        clone.find("#subject_area_id").attr('id', 'subject_area_id_' + sectionNo);
        clone.find('[id=questions]').attr('name', 'questions_' + sectionNo);
        clone.find('[id=questions]').attr('id', 'questions_' + sectionNo);
        clone.find('[id=selected_questions]').attr('name', 'selected_questions_' + sectionNo);
        clone.find('[id=selected_questions]').attr('id', 'selected_questions_' + sectionNo);
        clone.find('[id=questionErr]').attr('name', 'questionErr_' + sectionNo);
        clone.find('[id=questionErr]').attr('id', 'questionErr_' + sectionNo);
        clone.find('[id=selectedQuestionErr]').attr('name', 'selectedQuestionErr_' + sectionNo);
        clone.find('[id=selectedQuestionErr]').attr('id', 'selectedQuestionErr_' + sectionNo);
        clone.find('[id=add_question]').attr('name', 'add_question_' + sectionNo);
        clone.find('[id=add_question]').attr('id', 'add_question_' + sectionNo);
        clone.find('[id=remove_question]').attr('name', 'remove_question_' + sectionNo);
        clone.find('[id=remove_question]').attr('id', 'remove_question_' + sectionNo);
        clone.find('[id=section_header]').attr('name', 'section_header_' + sectionNo);
        clone.find('[id=section_header]').attr('id', 'section_header_' + sectionNo);
        clone.find('[id=close_div]').attr('name', 'close_div_' + sectionNo);
        clone.find('[id=close_div]').attr('id', 'close_div_' + sectionNo);
        $('#essay_append_div').append(clone);
        $('#section_header_' + sectionNo).empty();
        $('#section_header_' + sectionNo).append("Section " + sectionNo);
        clone.show();
        sectionNo++;
    }

    function createEssayExam() {

        if (sectionNo >= 2) {
            var formData = new FormData($("#exam-form")[0]);
            var no_of_questions_section = new Array();
            var section_time = new Array();
            var no_selected_questions = new Array();
            var questions = new Array();
            var attchment = new Array();
            for (var x = 1; x < sectionNo; x++) {
                no_of_questions_section[x - 1] = $('#no_of_questions_' + x).val();
                section_time[x - 1] = $('#section_time_' + x).val();
                no_selected_questions[x - 1] = document.getElementById("selected_questions_" + x).options.length;
                var selectedQuestion = document.getElementById('selected_questions_' + x);
                questions[x - 1] = [];
                for (var y = 0; y < selectedQuestion.options.length; y++) {
                    questions[x - 1][y] = selectedQuestion.options[y].text;
                    //alert(selectedQuestion.options[y].value);
                    //removeQuestionSectionDelete(value);
                }

            }
            //            for(var x = 1; x<attachNo; x++){
//                var fileSelect = document.getElementById('attachment_file_'+x);
//                var files = fileSelect.files;
//                var file = files[0];
//                attchment[x-1] = file;
//                //alert(file.name);
//            }

            $.ajax({
                url: '<?php echo CController::createUrl('Exam/validateEssayExam'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                beforeSend: tinyMCE.triggerSave(),
                data: {
                    course_id: $('#course_id').val(),
                    level_id: $('#level_id').val(),
                    subject_id: $('#subject_id').val(),
                    exam_name: $('#exam_name').val(),
                    exam_description: $('#exam_description').val(),
                    number_of_questions: $('#number_of_questions').val(),
                    exam_type: $('#exam_type_drp_div').val(),
                    time: $('#time').val(),
                    cal_yes: $("#cal_yes").is(":checked"),
                    exam_price: $('#exam_price').val(),
                    pass_mark: $('#pass_mark_essay').val(),
                    expiry_duration: $('#expiry_duration_essay').val(),
                    no_of_questions_section: no_of_questions_section,
                    section_time: section_time,
                    no_selected_questions: no_selected_questions,
                    questions: questions,
                    allow_view_marked_questionss: $("#allow_view_marked_questionss").is(":checked"),
                    allow_goto_questionss: $("#allow_goto_questions").is(":checked"),
                    allow_view_unanswered_questionss: $("#allow_view_unanswered_questionss").is(":checked"),
//                    tab_count: 15,
//                    tabessay_title_1: $('#tab_title_1').val(),
//                    tabessay_title_2: $('#tab_title_2').val(),
//                    tabessay_title_3: $('#tab_title_3').val(),
//                    tabessay_title_4: $('#tab_title_4').val(),
//                    tabessay_title_5: $('#tab_title_5').val(),
//                    tabessay_title_6: $('#tab_title_6').val(),
//                    tabessay_title_7: $('#tab_title_7').val(),
//                    tabessay_title_8: $('#tab_title_8').val(),
//                    tabessay_title_9: $('#tab_title_9').val(),
//                    tabessay_title_10: $('#tab_title_10').val(),
//                    tabessay_title_11: $('#tab_title_11').val(),
//                    tabessay_title_12: $('#tab_title_12').val(),
//                    tabessay_title_13: $('#tab_title_13').val(),
//                    tabessay_title_14: $('#tab_title_14').val(),
//                    tabessay_title_15: $('#tab_title_15').val(),
//                    tableessay_formula_1: $('#table_formula_1').val(),
//                    tableessay_formula_2: $('#table_formula_2').val(),
//                    tableessay_formula_3: $('#table_formula_3').val(),
//                    tableessay_formula_4: $('#table_formula_4').val(),
//                    tableessay_formula_5: $('#table_formula_5').val(),
//                    tableessay_formula_6: $('#table_formula_6').val(),
//                    tableessay_formula_7: $('#table_formula_7').val(),
//                    tableessay_formula_8: $('#table_formula_8').val(),
//                    tableessay_formula_9: $('#table_formula_9').val(),
//                    tableessay_formula_10: $('#table_formula_10').val(),
//                    tableessay_formula_11: $('#table_formula_11').val(),
//                    tableessay_formula_12: $('#table_formula_12').val(),
//                    tableessay_formula_13: $('#table_formula_13').val(),
//                    tableessay_formula_14: $('#table_formula_14').val(),
//                    tableessay_formula_15: $('#table_formula_15').val()
                },
                success: function (data) {
                    if (data[0].status == "success") {
                        $('#errorDisplay').hide();
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
                    } else if (data[0].status == "fail") {
                        $('#errorDisplay').empty();
                        $('#errorDisplay').hide();
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
                        for (var x = 0; x < data[1].length; x++) {
                            var element = data[1][x];
                            hightlightTextBox(element);
                        }

                        for (var x = 0; x < data[3].length; x++) {
                            var element = data[3][x];
                            hightlightTextBox(element);
                        }



                        for (var x = 0; x < data[2].length; x++) {
                            var msg = data[2][x];
                            // $('#errorDisplay').html=$('#errorDisplay').html+msg+"<br />";
                            $('#errorDisplay').append(msg + "<br />");
                            //document.getElementById("errorDisplay").innerHTML=document.getElementById("errorDisplay").innerHTML+msg+"<br />";


                        }

                        $('#errorDisplay').show();
                    }
                }
            });
        } else {
            $('#errorDisplay').empty();
            $('#errorDisplay').append("Exam should contains atleast one section!");
            $('#errorDisplay').show();
        }
    }
    function removeSection(element) {
        var no = decodeButtonName(element.name);
        var selectedQuestion = document.getElementById('selected_questions_' + no);
        for (var x = 0; x < selectedQuestion.options.length; x++) {
            var value = selectedQuestion.options[x].value;
            removeQuestionSectionDelete(value);
        }
        document.getElementById('essay_append_div').removeChild(element.parentNode);
        //alert(no);
        for (var x = no + 1; x < sectionNo; x++) {
            var clone = $('#essay_section_div_' + x);
            clone.attr('id', 'essay_section_div_' + (x - 1));
            clone.find('[id=no_of_questions_' + x + ']').attr('name', 'no_of_questions_' + (x - 1));
            clone.find('[id=section_time_' + x + ']').attr('name', 'section_time_' + (x - 1));
            clone.find('[id=no_of_questions_' + x + ']').attr('id', 'no_of_questions_' + (x - 1));
            clone.find('[id=section_time_' + x + ']').attr('id', 'section_time_' + (x - 1));
            clone.find("#subject_area_id_" + x).attr('name', 'subject_area_id_' + (x - 1));
            clone.find("#subject_area_id_" + x).attr('id', 'subject_area_id_' + (x - 1));
            clone.find('[id=questions_' + x + ']').attr('name', 'questions_' + (x - 1));
            clone.find('[id=questions_' + x + ']').attr('id', 'questions_' + (x - 1));
            clone.find('[id=selected_questions_' + x + ']').attr('name', 'selected_questions_' + (x - 1));
            clone.find('[id=selected_questions_' + x + ']').attr('id', 'selected_questions_' + (x - 1));
            clone.find('[id=questionErr_' + x + ']').attr('name', 'questionErr_' + (x - 1));
            clone.find('[id=questionErr_' + x + ']').attr('id', 'questionErr_' + (x - 1));
            clone.find('[id=selectedQuestionErr_' + x + ']').attr('name', 'selectedQuestionErr_' + (x - 1));
            clone.find('[id=selectedQuestionErr_' + x + ']').attr('id', 'selectedQuestionErr_' + (x - 1));
            clone.find('[id=add_question_' + x + ']').attr('name', 'add_question_' + (x - 1));
            clone.find('[id=add_question_' + x + ']').attr('id', 'add_question_' + (x - 1));
            clone.find('[id=remove_question_' + x + ']').attr('name', 'remove_question_' + (x - 1));
            clone.find('[id=remove_question_' + x + ']').attr('id', 'remove_question_' + (x - 1));
            clone.find('[id=section_header_' + x + ']').attr('name', 'section_header_' + (x - 1));
            clone.find('[id=section_header_' + x + ']').attr('id', 'section_header_' + (x - 1));
            clone.find('[id=close_div_' + x + ']').attr('name', 'close_div_' + (x - 1));
            clone.find('[id=close_div_' + x + ']').attr('id', 'close_div_' + (x - 1));
            $('#section_header_' + (x - 1)).empty();
            $('#section_header_' + (x - 1)).append("Section " + (x - 1));
        }
        sectionNo--;
        //alert(sectionNo);
    }

    function removeQuestionSectionDelete(value) {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/removeQuestionFromEssayExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                question_id: value
            }
        });
    }

</script>
