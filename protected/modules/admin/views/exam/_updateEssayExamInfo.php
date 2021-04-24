<script type="text/javascript">
    var sectionNo = 1;
    //    var removed_section = new Array();
    //    var existed_section = new Array();
    //    var new_section = new Array();
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
        //new_section.push(sectionNo);
        sectionNo++;
    }
    var attachNo = 1;

    function addAnotherAttchField() {
        var clone = $('#attachment_div').clone().attr('id', 'attachment_div_' + attachNo);
        clone.find('[type=file]').val('');
        clone.find("#attachment_file").attr('name', 'attachment_file_' + attachNo);
        clone.find("#attachment_file").attr('id', 'attachment_file_' + attachNo);
        clone.find("#attachment_remove").attr('name', 'attachment_remove_' + attachNo);
        clone.find("#attachment_remove").attr('id', 'attachment_remove_' + attachNo);
        $('#attachment_append_div').append(clone);
        if (attachNo == 3) {
            $('#add_att_upload_field').hide();
        }
        clone.show();
        attachNo++;
    }
    function updateEssayExam() {

        if (sectionNo >= 2) {
            //            var formData = new FormData($("#exam-form")[0]);
            var no_of_questions_section = new Array();
            var section_time = new Array();
            var no_selected_questions = new Array();
            var questions = new Array();
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
            $.ajax({
                url: '<?php echo CController::createUrl('Exam/saveEssayExam'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                beforeSend: tinyMCE.triggerSave(),
                data: {
                    exam_id: '<?php echo $model->exam_id; ?>',
                    course_id: $('#course_id').val(),
                    level_id: $('#level_id').val(),
                    subject_id: $('#subject_id').val(),
                    exam_name: $('#exam_name').val(),
                    exam_description: $('#exam_description').val(),
                    number_of_questions: $('#number_of_questions').val(),
                    exam_type: $('#exam_type').val(),
                    time: $('#time').val(),
                    cal_yes: cal_yes.checked,
                    exam_price: $('#exam_price').val(),
                    pass_mark: $('#pass_mark_essay').val(),
                    expiry_duration: $('#expiry_duration_essay').val(),
                    no_of_questions_section: no_of_questions_section,
                    section_time: section_time,
                    no_selected_questions: no_selected_questions,
                    questions: questions,
                    allow_view_marked_questions: $("#allow_view_marked_questions").is(":checked"),
                    allow_goto_question: $("#allow_goto_question").is(":checked"),
                    allow_view_unanswered_questions: $("#allow_view_unanswered_questions").is(":checked"),
//                    tab_count: 15,
//                    tabessay_title_1: $('#tabessay_title_1').val(),
//                    tabessay_title_2: $('#tabessay_title_2').val(),
//                    tabessay_title_3: $('#tabessay_title_3').val(),
//                    tabessay_title_4: $('#tabessay_title_4').val(),
//                    tabessay_title_5: $('#tabessay_title_5').val(),
//                    tabessay_title_6: $('#tabessay_title_6').val(),
//                    tabessay_title_7: $('#tabessay_title_7').val(),
//                    tabessay_title_8: $('#tabessay_title_8').val(),
//                    tabessay_title_9: $('#tabessay_title_9').val(),
//                    tabessay_title_10: $('#tabessay_title_10').val(),
//                    tabessay_title_11: $('#tabessay_title_11').val(),
//                    tabessay_title_12: $('#tabessay_title_12').val(),
//                    tabessay_title_13: $('#tabessay_title_13').val(),
//                    tabessay_title_14: $('#tabessay_title_14').val(),
//                    tabessay_title_15: $('#tabessay_title_15').val(),
//                    tableessay_formula_1: $('#tableessay_formula_1').val(),
//                    tableessay_formula_2: $('#tableessay_formula_2').val(),
//                    tableessay_formula_3: $('#tableessay_formula_3').val(),
//                    tableessay_formula_4: $('#tableessay_formula_4').val(),
//                    tableessay_formula_5: $('#tableessay_formula_5').val(),
//                    tableessay_formula_6: $('#tableessay_formula_6').val(),
//                    tableessay_formula_7: $('#tableessay_formula_7').val(),
//                    tableessay_formula_8: $('#tableessay_formula_8').val(),
//                    tableessay_formula_9: $('#tableessay_formula_9').val(),
//                    tableessay_formula_10: $('#tableessay_formula_10').val(),
//                    tableessay_formula_11: $('#tableessay_formula_11').val(),
//                    tableessay_formula_12: $('#tableessay_formula_12').val(),
//                    tableessay_formula_13: $('#tableessay_formula_13').val(),
//                    tableessay_formula_14: $('#tableessay_formula_14').val(),
//                    tableessay_formula_15: $('#tableessay_formula_15').val()
                    //                    removed_section: removed_section,
                    //                    existed_section: existed_section,
                    //                    new_section: new_section
                    //attchment: attchment
                },
                success: function (data) {
                    if (data[0].status == "success") {
                        $('#errorDisplayEssay').hide();
                        //                            removeHighlight("course_id");
                        //                            removeHighlight("level_id");
                        //                            removeHighlight("subject_id");
                        //                            removeHighlight("exam_name");
                        //                            removeHighlight("exam_description");
                        //                            removeHighlight("number_of_questions");
                        //                            removeHighlight("exam_type");
                        //                            removeHighlight("time");
                        //                            removeHighlight("exam_price");
                        //                            //removeHighlight("marks_per_question");
                        //                            removeHighlight("expiry_duration");
                        //                            removeHighlight("pass_mark");

                        document.location.href = data[0].redirect_url;
                    } else if (data[0].status == "fail") {
                        $('#errorDisplayEssay').empty();
                        $('#errorDisplayEssay').hide();

                        //                            removeHighlight("course_id");
                        //                            removeHighlight("level_id");
                        //                            removeHighlight("subject_id");
                        //                            removeHighlight("exam_name");
                        //                            removeHighlight("exam_description");
                        //                            removeHighlight("number_of_questions");
                        //                            removeHighlight("exam_type");
                        //                            removeHighlight("time");
                        //                            removeHighlight("exam_price");
                        //                            //removeHighlight("marks_per_question");
                        //                            removeHighlight("expiry_duration");
                        //                            removeHighlight("pass_mark");

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
                            $('#errorDisplayEssay').append(msg + "<br />");

                        }

                        $('#errorDisplayEssay').show();

                    }
                }
            });
        } else {
            $('#errorDisplayEssay').empty();
            $('#errorDisplayEssay').append("Exam should contains atleast one section!");
            $('#errorDisplayEssay').show();
        }
    }
    function removeSection(element) {
        var no = decodeButtonName(element.name);
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
    function removeAttachmentField(element) {
        var no = decodeButtonName(element.name);
        //alert(no);
        document.getElementById('attachment_append_div').removeChild(element.parentNode);

        for (var x = no + 1; x < attachNo; x++) {
            var clone = $('#attachment_div_' + x);
            clone.find("#attachment_file_" + x).attr('name', 'attachment_file_' + (x - 1));
            clone.find("#attachment_file_" + x).attr('id', 'attachment_file_' + (x - 1));
            clone.find("#attachment_remove_" + x).attr('name', 'attachment_remove_' + (x - 1));
            clone.find("#attachment_remove_" + x).attr('id', 'attachment_remove_' + (x - 1));
        }
        attachNo--;
        if (attachNo <= 3) {
            $('#add_att_upload_field').show();
        }
    }
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
                    $('#questionErr_' + no).innerHTML = "";
                    //$('#questionErr_'+no).style.display="none";

                } else if (data.status == "fail") {
                    hightlightTextBox("questions_" + no);
                    $('#questionErr_' + no).style.display = "block";
                    $('#questionErr_' + no).innerHTML = "";
                    $('#questionErr_' + no).innerHTML = data.message;
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
                    $('#selectedQuestionErr_' + no).innerHTML = "";
                    $('#selectedQuestionErr_' + no).style.display = "none";
                } else if (data.status == "fail") {
                    hightlightTextBox("selected_questions_" + no);
                    $('#selectedQuestionErr_' + no).style.display = "block";
                    $('#selectedQuestionErr_' + no).innerHTML = "";
                    $('#selectedQuestionErr_' + no).innerHTML = data.message;
                }
                //$('#selected_questions_'+no).show();
            }
        });

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
<!-- start of essay exam div -->
<div class="control-group"> 
    Pass Mark <span class="asterix">*</span><br>
    <input type="text" name="pass_mark_essay" id="pass_mark_essay" placeholder="Pass Mark" value='<?php echo $model->pass_mark; ?>'/>

</div>
<br/>
<div class="control-group">    
        Expiry Duration <span class="asterix">*</span><br>
        <div class="input-append">
        <input type="text" name="expiry_duration_essay" id="expiry_duration_essay" placeholder="Expiry Duration" append="Months" value='<?php echo $model->expiry_duration; ?>'/>
        <span class="add-on">Months</span>
    </div>
</div>

<div class="control-group">
    <?php
    if (($model->allow_view_marked_questions) == 1) {
        ?>
        <!--<input id="allow_view_marked_questions" type="checkbox" name="allow_view_marked_questions" value="1" checked>&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br>-->
        <?php
    } else {
        ?>
        <!--<input id="allow_view_marked_questions" type="checkbox" name="allow_view_marked_questions" value="1">&nbsp;<strong>Allow Candidate to View Marked Questions</strong><br>-->
        <?php
    }
    ?>
</div>

<div class="control-group">
    <?php
    if (($model->allow_goto_question) == 1) {
        ?>
        <input id="allow_goto_question" type="checkbox" name="allow_goto_question" value="1" checked>&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br>
        <?php
    } else {
        ?>
        <input id="allow_goto_question" type="checkbox" name="allow_goto_question" value="1">&nbsp;<strong>Allow Candidate to Go To Selected Questions</strong><br>
        <?php
    }
    ?>
</div>

<div class="control-group">
    <?php
    if (($model->allow_view_unanswered_questions) == 1) {
        ?>
        <input id="allow_view_unanswered_questions" type="checkbox" name="allow_view_unanswered_questions" value="1" checked>&nbsp;<strong> Allow Candidate to View Unanswered Questions</strong><br>
        <?php
    } else {
        ?>
        <input id="allow_view_unanswered_questions" type="checkbox" name="allow_view_unanswered_questions" value="1">&nbsp;<strong> Allow Candidate to View Unanswered Questions</strong><br>
            <?php
        }
        ?>
        </div>

        <br/>


        <br/>    

        <div id="essay_section_div" class="well" style="display:none">
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

            </div><br/>
            <div class="form-control">    

                <select id="selected_questions" name="selected_questions" multiple="multiple" style="width:400px;height:100px;" class="selectBox">
                    <!--<option disabled selected>Selected Questions</option>-->
                    <?php
//            if ($exam_questions != null) {
//                $question_session = Yii::app()->session['question_session'];
//
//                foreach ($exam_questions as $exam_question) {
//                    echo '<option value=' . $exam_question['question_id'] . '>' . $exam_question['question_id'] . '</option>';
//
//
//                    $question_id = $exam_question['question_id'];
//                    
//
//
//                    if ($question_id != null) {
//                        if ($question_session == null) {
//                            $question_session = array();
//                            $question_session[] = $question_id;
//                        } else {
//                            $item_found = false;
//                            foreach ($question_session as $item) {
//                                if ($item == $question_id) {
//                                    $item_found = true;
//                                }
//                            }
//                            if (!$item_found) {
//                                $question_session[] = $question_id;
//                            }
//                        }
//                    }
//                }
//                Yii::app()->session['question_session'] = $question_session;
//            }
                    ?>
                </select>
            </div>
            <label style="display:none" id="selectedQuestionErr" class="error"></label>
            <div class="form-control">
                <input type="button" id="remove_question" onclick="this.name;
                           removeQuestion(name)" class="greybtn" value="Remove Question">

            </div>

        </div>

        <div id="essay_append_div" class="control-group">

        </div>

        <?php
        $examSections = Exam::getSectionsOfExamById($model->exam_id);
        $question_session_section = Yii::app()->session['question_session_section'];
        foreach ($examSections as $examSection) {
            $sectionQuestions = Exam::getQuestionsOfExamByIdSectionNo($model->exam_id, $examSection['section_number']);
            $question_session = Yii::app()->session['question_session'];

            $question_session_section[] = $examSection['section_number'];
            ?>
            <script type="text/javascript">
                appendSection();
                document.getElementById("no_of_questions_" + (sectionNo - 1)).value = '<?php echo $examSection['number_of_questions'] ?>';
                document.getElementById("section_time_" + (sectionNo - 1)).value = '<?php echo $examSection['section_time'] ?>';
                var questionList = $('#selected_questions_' + (sectionNo - 1));
                //existed_section.push((sectionNo-1));
            </script>
            <?php
            foreach ($sectionQuestions as $sectionQuestion) {
                ?>
                <script type="text/javascript">
                    var option = document.createElement("option");
                    option.text = '<?php echo $sectionQuestion['question_id']; ?>';
                    option.value = '<?php echo $sectionQuestion['question_id']; ?>';
                    questionList.append(option);
                </script>
                <?php
                $question_session[] = $sectionQuestion['question_id'];
            }
            Yii::app()->session['question_session'] = $question_session;
        }
        Yii::app()->session['question_session_section'] = $question_session_section;
        ?>
        <div class="control-group">
            <input type="button" id="add_section" onclick="appendSection()" class="button button-news" value="Add Section">
            <?php ?>
        </div>
        <!--<h4>Upload Attachment</h4>
        <div id="attachment_div"class="control-group" style="display:none">
            <input type="file" id="attachment_file" name="attachment_file"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" id="attachment_remove" name="attachment_remove" onclick="removeAttachmentField(this)" value="Remove">
                <a id="attachment_remove_1" name="attachment_remove_1" onclick="removeAttachmentField(this)" class="close">X</a>
        </div>            
        <div id="attachment_append_div" class="control-group"></div>
        <div class="control-group">
            <input type="button" id="add_att_upload_field" onclick="addAnotherAttchField()" value="Add Attachment">
        </div>-->
        <div class="control-group"><br/>
            <p style="display:none" id="errorDisplayEssay" class="alert alert-danger"></p>
        </div>
        <div class="control-group">
            <input type="button" id="update_exam_essay" onclick="updateEssayExam()" class="button button-news" value="Save Changes">
        </div>

