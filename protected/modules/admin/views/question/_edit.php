<style>
    .asterix{
        color: red;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        var x = "<?php echo $model->question_type; ?>";
        if (x == "HOT_SPOT_ANSWER") {
            $("#preview_bn").hide();
        } else {
            $("#preview_bn").show();
        }
    });

</script>


<?php
$user_id = Yii::app()->user->getId();
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'question-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>


<div class="control-group"> 
    <?php
    $subjectAreaDetails = SubjectArea::model()->getSubjectAreaDetails($model->subject_area_id);

    $subjectData = Subject::model()->getSubjectDetails($subjectAreaDetails['subject_id']);

    $levelData = Level::model()->getLevel($subjectData['level_id']);

    $course = Course::model()->getCourseDetails($levelData['course_id']);

    echo 'Course <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('course_id', '', Course::model()->getCoursesForUser($user_id), array(
        'options' => array($course['course_id'] => array('selected' => true)),
        'empty' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevelsForUser'),
            'update' => '#level_id',
            'beforeSend' => 'function() {
                
                if(subject_id.value!=""){                
                     subject_id.options.length = 1;                  
                }
                
                if(Question_subject_area_id.value!=""){
                    Question_subject_area_id.options.length = 1; 
                }
                
                
            
        }',
    )));
    ?> 
</div>

<div class="control-group"> 
    <?php
    $criteria = new CDbCriteria;
    $criteria->condition = "course_id= " . $course['course_id'];
    $level = Level::model()->findAll($criteria);

    echo 'Level <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('level_id', '', Level::model()->getLevelsForUser($course['course_id']), array(
        'options' => array($levelData['level_id'] => array('selected' => true)),
        'empty' => 'Select Level',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjectsForUser'),
            'update' => '#subject_id',
    )));
    ?>   </div>   

<?php echo $form->error($model, 'level_id', array('class' => 'alert alert-danger')); ?>
<?php echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>

<div class="control-group"> 
    <?php
    $criteria2 = new CDbCriteria;
    $criteria2->condition = "level_id= " . $levelData['level_id'];
    $subject = Subject::model()->findAll($criteria2);

    echo 'Subjects <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('subject_id', '', Subject::model()->getSubjectsForUser($levelData['level_id']), array(
        'options' => array($subjectData['subject_id'] => array('selected' => true)),
        'empty' => 'Select Subject',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
            'update' => '#Question_subject_area_id',
    )));
    ?></div>
<div class="control-group"> 
    <?php
    $criteria3 = new CDbCriteria;
    $criteria3->condition = "subject_id= " . $subjectData['subject_id'];
    $subjectAreas = SubjectArea::model()->findAll($criteria3);


    echo 'Subject Area <span class="asterix">*</span>';
    echo '<br>';
    echo $form->dropDownList($model, 'subject_area_id', CHtml::listData($subjectAreas, 'subject_area_id', 'subject_area_name'), array(
        'options' => array($model->subject_area_id => array('selected' => true)),
        'empty' => 'Select Subject Area'
    ));
    ?></div>

<div class="control-group"> 
    <?php
    echo 'Question Type <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('question_type', '', array(
        'empty' => 'Select Question Type',
        'SINGLE_ANSWER' => 'Single Answer Questions',
        'MULTIPLE_ANSWER' => 'Multiple Answer Questions',
        'SHORT_WRITTEN' => 'Short Written Answer Questions',
        'DRAG_DROP_TYPEA_ANSWER' => 'Drag & Drop Type A Answer Questions',
        'DRAG_DROP_TYPEB_ANSWER' => 'Drag & Drop Type B Answer Questions',
        'DRAG_DROP_TYPEC_ANSWER' => 'Drag & Drop Type C Answer Questions',
        'DRAG_DROP_TYPED_ANSWER' => 'Drag & Drop Type D Answer Questions',
        'DRAG_DROP_TYPEE_ANSWER' => 'Drag & Drop Type E Answer Questions',
        'MULTIPLE_CHOICE_ANSWER' => 'Multiple Choice Answer Questions',
        'TRUE_OR_FALSE_ANSWER' => 'True Or false Answer Questions',
        'HOT_SPOT_ANSWER' => 'Hot Spot Answer Questions',
        'ESSAY_ANSWER' => 'Essay Answer Questions'
            ), array(
        'options' => array($model->question_type => array('selected' => true)),
        'style' => 'pointer-events:none; curser:default;',
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Question/getAnswerForms'),
            'update' => '#answer-rows',
        )
    ));
    ?>   </div>  



<div class="control-group">
    <?php echo $form->textFieldRow($model, 'number_of_marks', array('maxlength' => 200, 'placeholder' => 'Number Of Marks')); ?>
</div>

<?php if ($model->question_type != "ESSAY_ANSWER") { ?>

    <div class="control-group">

        <label>Uploaded Exhibit</label>
        <input type="text" size="25" name="showBox" maxlength="255" readonly value="<?php
        if ($model->exhibit_attachment == NULL) {
            echo 'Not set';
        } else {
            echo $model->exhibit_attachment;
        }
        ?>"></input>

    </div>

    <div class="row">
        <div class="span3" id="exhibit_attach">
            <div class="control-group">
                <!--                <div class="span2">Upload exhibit</div>
                                <div class="span2"><input type="file" id="exhibit_file" name="exhibit_file" /></div>-->
                <?php
                echo $form->labelEx($model, 'exhibit_attachment');
                echo $form->fileField($model, 'exhibit_attachment');
                echo $form->error($model, 'exhibit_attachment');
                ?>
            </div>
        </div>
    </div>

<?php } ?>


<br/>
<div class="checkbox">
    <?php echo $form->checkBox($model, 'exclude_from_dynamic', array('value' => 1, 'uncheckValue' => 0)); ?>
    <?php echo $form->labelEx($model, 'exclude_from_dynamic'); ?>
    <?php echo $form->error($model, 'exclude_from_dynamic'); ?>
</div>
<br/>

<div class="row">
    <div class="span8">
        <?php echo $form->labelEx($model, 'Example'); ?>
        <?php
        echo CHtml::ajaxButton('Example', CController::createUrl('Question/viewExample'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            'data' => array('question_type' => 'js:document.getElementById("question_type").value'),
            'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_viewExample").dialog("open");                            
                            if(document.getElementById("dialog_data")!=null){
                                $("#dialog_data").remove();
                            }                          
                            
                            $("#mydialog_viewExample").append(data.qoutput);
                            
                            
                        }else{
                            
                            
                        }
                    }'
                ), array(
            'id' => 'rexample_btn',
            'class' => 'tinybluebtn',
                )
        );
        ?>



        <br />
    </div>

</div>

<br />



<?php echo $form->textAreaRow($model, 'question_text', array('rows' => 15, 'cols' => 50, 'class' => 'span8,mceEditor')); ?>
<div class="span8 no-left-margin" id="textAreaErrorDisplayRaw" style="display:none">
    <label id="textAreaErrorDisplay" class="error"></label>
</div>
<br/>
<?php echo $form->textAreaRow($model, 'question_logic', array('rows' => 15, 'cols' => 50, 'class' => 'span8,mceEditor')); ?>

<div class="control-group">
    <input type="hidden" id="update_ff" name="update_ff" value="UPDATE" />
    <input type="hidden" id="qid" name="qid" value="<?php echo $model->question_id; ?>">

</div>

<br/>
<br/>

<br/>
<div class="control-group"> 
    <?php //echo $form->textAreaRow($model, 'question_text', array('rows' => 15, 'cols' => 50, 'class' => 'span8'));      ?>
</div>




<div class="control-group"> 
    <div id ="answer-rows" >

        <?php
        if ($model->question_type == "SHORT_WRITTEN") {
            $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

            $numberOfQuestionParts = sizeof($questionParts);

            $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);
            $count = 1;

            $shortWrittenQuestionPartSession = array();
            $question_part_count = $numberOfQuestionParts;
            ?>
            <input type="hidden" name="question_part_count" id="question_part_count" value="<?php echo $question_part_count; ?>">  
            <?php
            foreach ($questionParts as $questionPart) {
                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

                if (sizeof($headings) == 2) {
                    echo $this->renderPartial('_short_written_answer_qs_form', array(
                        'count' => $count,
                        'edit' => 'true',
                        'question_part' => $questionPart['question_part_name'],
                        'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                        'heading_1' => $headings[0]['heading_text'],
                        'heading_2' => $headings[1]['heading_text'],
                        'question_id' => $model->question_id,
                        'question_part_count' => $question_part_count,
                        'part_count' => $question_part_count,
                    ));
                } else if (sizeof($headings) == 0) {
                    echo $this->renderPartial('_short_written_answer_qs_form', array(
                        'count' => $count,
                        'edit' => 'true',
                        'question_part' => $questionPart['question_part_name'],
                        'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                        'heading_1' => null,
                        'heading_2' => null,
                        'question_id' => $model->question_id,
                        'question_part_count' => $question_part_count,
                        'part_count' => $question_part_count,
                    ));
                } else if (sizeof($headings) == 1) {

                    if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 1) {
                        echo $this->renderPartial('_short_written_answer_qs_form', array(
                            'count' => $count,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                            'heading_1' => $headings[0]['heading_text'],
                            'heading_2' => null,
                            'question_id' => $model->question_id,
                            'question_part_count' => $question_part_count,
                            'part_count' => $question_part_count,
                        ));
                    } else if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 2) {
                        echo $this->renderPartial('_short_written_answer_qs_form', array(
                            'count' => $count,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                            'heading_1' => null,
                            'heading_2' => $headings[0]['heading_text'],
                            'question_id' => $model->question_id,
                            'question_part_count' => $question_part_count,
                            'part_count' => $question_part_count,
                        ));
                    }
                }




                $shortWrittenQuestionPartSession[] = array("question_part" => $questionPart['question_part_name'],
                    "answer" => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                    "position" => $count);

                $count++;
            }

            Yii::app()->session['short_written_question_part_session'] = $shortWrittenQuestionPartSession;


            $numberOfAvailableQuestionParts = 20;

            for ($count2 = $count; $count2 <= 20; $count2++) {
                echo $this->renderPartial('_short_written_answer_qs_form', array(
                    'count' => $count2,
                    'edit' => null,
                    'question_part' => null,
                    'answer' => null,
                    'heading_1' => null,
                    'heading_2' => null,
                    'question_id' => $model->question_id,
                    'question_part_count' => $question_part_count,
                    'part_count' => $question_part_count,
                ));
            }
            ?>
            <script>
                document.getElementById("short_written_answer_form_<?php echo $count ?>").style.display = "block";
            </script>

            <?php
        } else if ($model->question_type == "DRAG_DROP_TYPEA_ANSWER") {
            $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

            $numberOfQuestionParts = sizeof($questionParts);
            $count = 1;
            $dragDropTypeAQuestionPartSession = array();
            $question_part_count = $numberOfQuestionParts;
            ?>
            <input type="hidden" name="question_part_count" id="question_part_count" value="<?php echo $question_part_count; ?>">  
            <?php
            foreach ($questionParts as $questionPart) {
                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

                echo $this->renderPartial('_drag_drop_typea_answer_qs_form', array(
                    'count' => $count,
                    'edit' => 'true',
                    'question_part' => $questionPart['question_part_name'],
                    'question_part_count' => $question_part_count,
                    'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
//                    'heading_1' => $headings[0]['heading_text'],
//                    'heading_2' => $headings[1]['heading_text'],
                ));


                $dragDropTypeAQuestionPartSession[] = array("question_part" => $questionPart['question_part_name'],
                    "answer" => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                    "position" => $count);

                $count++;
            }

            Yii::app()->session['drag_drop_typea_session'] = $dragDropTypeAQuestionPartSession;


            $numberOfAvailableQuestionParts = 20;

            for ($count2 = $count; $count2 <= 20; $count2++) {
                echo $this->renderPartial('_drag_drop_typea_answer_qs_form', array(
                    'count' => $count2,
                    'edit' => null,
                    'question_part' => null,
                    'answer' => null,
//                    'heading_1' => null,
//                    'heading_2' => null,
                ));
            }
            ?>
            <script>
                document.getElementById("drag_drop_typea_form_<?php echo $count ?>").style.display = "block";
            </script>


            <?php
        } else if ($model->question_type == "TRUE_OR_FALSE_ANSWER") {
            $answer = Answer::model()->getAnswerOfQuestion($model->question_id);

            $is_true = $answer['is_correct'];

            $this->renderpartial('_true_or_false_qs_form', array(
                'is_true' => $is_true
            ));
        } else if ($model->question_type == "MULTIPLE_CHOICE_ANSWER") {
            $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);
            $numberOfQuestionParts = sizeof($questionParts);
            $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);
            $count = 1;
            $multipleChoiceQuestionPartSession = array();
            $partIds = array();
            $answerTxts = array();
            foreach ($questionParts as $questionPart) {
                $partIds[] = $questionPart['question_part_id'];
            }


            foreach ($partIds as $key => $value) {
                $c[] = Answer::model()->getAnswerTxtids($value, $model->question_id);
            }

            foreach ($c as $key => $values) {
                foreach ($values as $item) {
                    $answerTxts[$key][] = AnswerText::model()->getAnswerTextById($item['answer_text_id']);
                }
            }

            // ------ start creating session data before render partial _multiple_choice_answer_qs_form -------
            foreach ($questionParts as $questionPart) {
                $qparts[] = array(
                    "question_part_id" => $questionPart['question_part_id'],
                    "question_part" => $questionPart['question_part_name'],
                    "position" => $count
                );
            }

            $count2 = 1;
            if (isset($qparts)) {
                foreach ($qparts as $qpart) {
                    $answers = Answer::model()->getAnswersOfQuestionPart($qpart['question_part_id']);
                    $count3 = 1;

                    foreach ($answers as $answer) {
                        $multipleChoiceQuestionPartSession[$count2 - 1][] = array(
                            "question_part" => $qpart['question_part'],
                            "question_part_id" => $qpart['question_part_id'],
                            "answer_text" => AnswerText::model()->getAnswerTextById($answer['answer_text_id']),
                            "is_correct" => Answer::model()->getBoolVal($answer['is_correct']),
                            "position" => $count2,
                            "answer_position" => $count3);

                        $count3++;
                    }
                    $count2++;
                }
            }
            Yii::app()->session['multiple_choice_answer_session'] = $multipleChoiceQuestionPartSession;

            // ------ end creating session data before render partial _multiple_choice_answer_qs_form -------


            foreach ($questionParts as $questionPart) {
                //  $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

                if (sizeof($headings) == 2) {
                    echo $this->renderPartial('_multiple_choice_answer_qs_form', array(
                        'count' => $count,
                        'edit' => 'true',
                        'question' => $model->question_id,
                        'question_part_id' => $questionPart['question_part_id'],
                        'question_part' => $questionPart['question_part_name'],
                        'answer' => $answerTxts,
                        'heading_1' => $headings[0]['heading_text'],
                        'heading_2' => $headings[1]['heading_text'],
                            ), false, true);
                } else if (sizeof($headings) == 0) {
                    echo $this->renderPartial('_multiple_choice_answer_qs_form', array(
                        'count' => $count,
                        'question' => $model->question_id,
                        'edit' => 'true',
                        'question_part' => $questionPart['question_part_name'],
                        'question_part_id' => $questionPart['question_part_id'],
                        'answer' => $answerTxts,
                        'heading_1' => null,
                        'heading_2' => null,
                            ), false, true);
                } else if (sizeof($headings) == 1) {

                    if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 1) {
                        echo $this->renderPartial('_multiple_choice_answer_qs_form', array(
                            'count' => $count,
                            'question' => $model->question_id,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'question_part_id' => $questionPart['question_part_id'],
                            'answer' => $answerTxts,
                            'heading_1' => $headings[0]['heading_text'],
                            'heading_2' => null,
                                ), false, true);
                    } else if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 2) {
                        echo $this->renderPartial('_multiple_choice_answer_qs_form', array(
                            'count' => $count,
                            'question' => $model->question_id,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'question_part_id' => $questionPart['question_part_id'],
                            'answer' => $answerTxts,
                            'heading_1' => null,
                            'heading_2' => $headings[0]['heading_text'],
                                ), false, true);
                    }
                }

                /*
                  $qparts[] = array(
                  "question_part_id" => $questionPart['question_part_id'],
                  "question_part" => $questionPart['question_part_name'],
                  "position" => $count);
                 */
                ?>

                <script>
                    document.getElementById("multiple_choice_answer_form_<?php echo $count ?>").style.display = "block";
                </script>
                <?php
                $count++;
            }
            /*
              $count2 = 1;

              if (isset($qparts)) {
              foreach ($qparts as $qpart) {
              $answers = Answer::model()->getAnswersOfQuestionPart($qpart['question_part_id']);
              $count3 = 1;

              foreach ($answers as $answer) {
              $multipleChoiceQuestionPartSession[$count2 - 1][] = array(
              "question_part" => $qpart['question_part'],
              "answer_text" => AnswerText::model()->getAnswerTextById($answer['answer_text_id']),
              "is_correct" => Answer::model()->getBoolVal($answer['is_correct']),
              "position" => $count2,
              "answer_position" => $count3);

              $count3++;
              }
              $count2++;
              }
              }
              Yii::app()->session['multiple_choice_answer_session'] = $multipleChoiceQuestionPartSession;

             */


            $numberOfAvailableQuestionParts = 20;

            for ($count2 = $count; $count2 <= 20; $count2++) {
                echo $this->renderPartial('_multiple_choice_answer_qs_form', array(
                    'count' => $count2,
                    'question' => $model->question_id,
                    'edit' => true,
                    'question_part' => null,
                    'question_part_id' => null,
                    'heading_1' => null,
                    'heading_2' => null,
                ));
            }
            ?>

            <?php
        } else if ($model->question_type == "DRAG_DROP_TYPEE_ANSWER") {
            $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

            $numberOfQuestionParts = sizeof($questionParts);

            $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);
            ?>
            <input type="hidden" name="question_part_count" id="question_part_count" value="<?php echo $numberOfQuestionParts; ?>">  
            <?php
            $count = 1;

            $shortWrittenQuestionPartSession = array();

            $Session = array();

            foreach ($questionParts as $questionPart) {
                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

                $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($questionPart['question_part_id']);


                if (sizeof($headings) == 2) {
                    echo $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                        'count' => $count,
                        'edit' => 'true',
                        'question_part' => $questionPart['question_part_name'],
                        'question_part_text' => $questionPartText['question_part_text'],
                        'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                        'heading_1' => $headings[0]['heading_text'],
                        'heading_2' => $headings[1]['heading_text'],
                            ), true, false);
                } else if (sizeof($headings) == 0) {
                    echo $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                        'count' => $count,
                        'edit' => 'true',
                        'question_part' => $questionPart['question_part_name'],
                        'question_part_text' => $questionPartText['question_part_text'],
                        'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                        'heading_1' => null,
                        'heading_2' => null,
                            ), true, false);
                } else if (sizeof($headings) == 1) {

                    if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 1) {
                        echo $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                            'count' => $count,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'question_part_text' => $questionPartText['question_part_text'],
                            'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                            'heading_1' => $headings[0]['heading_text'],
                            'heading_2' => null,
                                ), true, false);
                    } else if (isset($headings[0]['heading_text']) && $headings[0]['heading_position'] == 2) {
                        echo $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                            'count' => $count,
                            'edit' => 'true',
                            'question_part' => $questionPart['question_part_name'],
                            'question_part_text' => $questionPartText['question_part_text'],
                            'answer' => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                            'heading_1' => null,
                            'heading_2' => $headings[0]['heading_text'],
                                ), true, false);
                    }
                }

                $Session[] = array("question_part" => $questionPart['question_part_name'],
                    "question_part_text" => $questionPartText['question_part_text'],
                    "answer" => AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']),
                    "position" => $count);

                $count++;
            }

            Yii::app()->session['drag_drop_typee_question_part_session'] = $Session;


            $numberOfAvailableQuestionParts = 20;

            for ($count2 = $count; $count2 <= 20; $count2++) {
                echo $this->renderPartial('_drag_drop_typee_answer_qs_form', array(
                    'count' => $count2,
                    'edit' => null,
                    'question_part' => null,
                    'question_part_text' => null,
                    'answer' => null,
                    'heading_1' => null,
                    'heading_2' => null,
                ));
            }
            ?>
            <script>
                document.getElementById("drag_drop_typee_answer_form_<?php echo $count ?>").style.display = "block";
            </script>

            <?php
            $other_answer_session = array();

            $other_answers = Answer::model()->getOtherAnswersOfQuestion($model->question_id);
            $count2 = 1;

            if ($other_answers != null) {
                foreach ($other_answers as $other_answer) {

                    $other_answer_text = AnswerText::model()->getAnswerText($other_answer['answer_text_id']);

                    echo $this->renderPartial('_other_answer_form', array(
                        'count' => $count2,
                        'edit' => 'true',
                        'other_answer' => $other_answer_text['answer_text'],
                        'question_type' => 'drag_drop_typee',
                    ));

                    $other_answer_session[] = array(
                        "other_answer" => $other_answer_text['answer_text'],
                        "position" => $count2);


                    $count2++;
                }
            }


            Yii::app()->session['other_answer_session'] = $other_answer_session;


//            die();

            $numberOfAvailableOtherAnswers = 20;

//            echo $count2;

            for ($count3 = $count2; $count3 <= 20; $count3++) {
                echo $this->renderPartial('_other_answer_form', array(
                    'count' => $count3,
                    'edit' => null,
                    'other_answer' => null,
                    'question_type' => 'drag_drop_typee',
                ));
            }
            ?>
            <script>
                document.getElementById("other_answer_form_<?php echo $count2 ?>").style.display = "block";
            </script>

            <?php
        } else if ($model->question_type == 'DRAG_DROP_TYPED_ANSWER') {
            $resultText = Answer::model()->getResultText($model->question_id);
            $answers = Answer::model()->getCorrectAnswersOfQuestion($model->question_id);
            $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($model->question_id);
            $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);

            $res_text = "";

            if ($answers != null) {
                $res_text = AnswerText::model()->getAnswerTextById($answers[0]['answer_text_id']);
            }

            $answer_1 = "";

            if ($answers != null) {
                $answer_1 = AnswerText::model()->getAnswerTextById($answers[1]['answer_text_id']);
            }

            $answer_2 = "";

            if ($answers != null) {
                $answer_2 = AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id']);
            }

            $this->renderpartial('_drag_drop_typed_answer_qs_form', array(
                'edit' => 'true',
                'result_text' => $res_text,
                'question_part' => $questionPart['question_part_name'],
                'operator_1' => $operators[0]['question_part_text'],
                'operator_2' => $operators[1]['question_part_text'],
                'answer_1' => $answer_1,
                'answer_2' => $answer_2,
            ));

            $other_answer_session = array();

            $other_answers = Answer::model()->getOtherAnswersOfQuestion($model->question_id);
            $question_part_count_d = sizeof($other_answers);
            $count2 = 1;
            ?>
            <input type="hidden" name="question_part_count" id="question_part_count" value="<?php echo $question_part_count_d; ?>">  
            <?php
            foreach ($other_answers as $other_answer) {

                $other_answer_text = AnswerText::model()->getAnswerText($other_answer['answer_text_id']);

                echo $this->renderPartial('_other_answer_form', array(
                    'count' => $count2,
                    'question_part_count' => $question_part_count_d,
                    'edit' => 'true',
                    'other_answer' => $other_answer_text['answer_text'],
                    'question_type' => 'drag_drop_typed'
                ));

                $other_answer_session[] = array(
                    "other_answer" => $other_answer_text['answer_text'],
                    "position" => $count2);


                $count2++;
            }

            Yii::app()->session['other_answer_session'] = $other_answer_session;


            $numberOfAvailableOtherAnswers = 20;

            for ($count3 = $count2; $count3 <= 20; $count3++) {
                echo $this->renderPartial('_other_answer_form', array(
                    'count' => $count3,
                    'edit' => null,
                    'other_answer' => null,
                    'question_type' => 'drag_drop_typed'
                ));
            }
            ?>
            <script>
                document.getElementById("other_answer_form_<?php echo $count2 ?>").style.display = "block";
            </script>

            <?php
        }
        ?>

    </div>
</div>


<div class="control-group">
    <div id="removed_answers">
        <!--removed element ids-->
    </div>
    <?php
    if ($model->question_type == "SINGLE_ANSWER") {

        echo $this->renderPartial('_edit_single_answer_qs', array(
            //'count' => $count,
            'id' => $model->question_id,
                //'edit' => 'true',
                //'answer' => $single_answer['answer_text'],
                ), false, true);
    }
    ?>

</div>
<div class="control-group">
    <div id="removed_multipleanswers">
        <!--removed element ids-->
    </div>
    <?php
    if ($model->question_type == "MULTIPLE_ANSWER") {

        echo $this->renderPartial('_edit_multiple_answer_qs_form', array(
            //'count' => $count,
            'id' => $model->question_id,
                //'edit' => 'true',
                //'answer' => $single_answer['answer_text'],
        ));
        //$count++;
    }
    ?>

</div>

<div class="control-group">  
    <div id="removed_answersb">
        <!--removed element ids-->
    </div>
    <?php
    if ($model->question_type == "DRAG_DROP_TYPEB_ANSWER") {

        Yii::app()->session['drag_drop_typeb_session'] = array();
        $dragDropTypeBQuestionPartSession = array();

        $drag_drop_b_headings = Heading::getHeadingTextforQuestionView($model->question_id);
        $heading1_id = null;
        $heading2_id = null;
        $heading1 = null;
        $heading2 = null;
        foreach ($drag_drop_b_headings as $drag_drop_b_heading) {
            if ($drag_drop_b_heading->heading_position == 1) {
                $heading1 = $drag_drop_b_heading->heading_text;
                $heading1_id = $drag_drop_b_heading->heading_id;
            } else {
                $heading2 = $drag_drop_b_heading->heading_text;
                $heading2_id = $drag_drop_b_heading->heading_id;
            }
        }

        $question_parts_for_b = QuestionPart::getQuestionPartsforQuestionView($model->question_id);
        $question_part_text = array();
        $question_part_array = array();
        foreach ($question_parts_for_b as $question_part) {
            $question_part_array[] = $question_part->question_part_id;
        }
        $question_part_count = count($question_part_array);
        ?>
        <input type="hidden" name="question_part_count" id="question_part_count" value="<?php echo $question_part_count; ?>">
        <?php
        $count = 1;

        for ($i = 0; $i < $question_part_count; $i++) {

            $answers = Answer::getAnswersforQuestionPartid($question_part_array[$i]);
            foreach ($answers as $answer) {
                $answer_id[] = $answer->answer_text_id;
            }

            echo $this->renderPartial('_drag_drop_typeb_answer_qs_form', array(
                'count' => $count,
                'edit' => 'true',
                'heading1_id' => isset($heading1_id) ? $heading1_id : null,
                'heading2_id' => isset($heading2_id) ? $heading2_id : null,
                'heading_1' => isset($heading1) ? $heading1 : null,
                'heading_2' => isset($heading2) ? $heading2 : null,
                'questio_part_id' => $question_part_array[$i],
                'question_part' => QuestionPart::getQuestionPartText($question_part_array[$i]),
                'question_part_count' => $question_part_count,
                'answer' => $answer_id,
            ));
            $count++;

            $answer_id = array();
        }

        $question_part_texts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);
        $answerTexts = AnswerText::model()->getAnswerTextByQId($model->question_id);

        $n = 0;
        for ($m = 0; $m < sizeof($answerTexts); $m++) {

            $mappedArrayAnswerTexts[$n]['answer_1'] = $answerTexts[$m]['answer_text'];
            $mappedArrayAnswerTexts[$n]['answer_2'] = $answerTexts[$m++]['answer_text'];
            $n++;
        }


        for ($k = 0; $k < sizeof($question_part_texts); $k++) {
            $dragDropTypeBQuestionPartSession[] = array("question_part" => $question_part_texts[$k]['question_part_name'],
                "answer1" => $mappedArrayAnswerTexts[$k]['answer_1'],
                "answer2" => $mappedArrayAnswerTexts[$k]['answer_2'],
                "position" => $k + 1);
        }

        Yii::app()->session['drag_drop_typeb_session'] = $dragDropTypeBQuestionPartSession;

        for ($count2 = $count; $count2 <= 20; $count2++) {
            echo $this->renderPartial('_drag_drop_typeb_answer_qs_form', array(
                'count' => $count2,
                'edit' => null,
                'question_part' => null,
                'answer' => null,
                'heading_1' => null,
                'heading_2' => null,
            ));
        }
        ?> 
        <script>
            document.getElementById("drag_drop_type_b_<?php echo $count ?>").style.display = "block";
        </script>
    <?php }
    ?>


</div>



<!-- start edit DRAG_DROP_TYPEC_ANSWER  -->
<div class="control-group">
    <?php
    if ($model->question_type == "DRAG_DROP_TYPEC_ANSWER") {
        $this->renderpartial('_drag_drop_typec_answer_qs_form', array('type' => 'edit', 'question_id' => $model->question_id));
    }
    ?>
</div>
<!-- end edit DRAG_DROP_TYPEC_ANSWER  -->


<div class="control-group">

    <?php
    if ($model->question_type == "HOT_SPOT_ANSWER") {
        $this->renderpartial('_edit_hot_spot_qs_form', array('question_id' => $model->question_id, 'model' => $model));
    }
    ?>

</div>


<div class="control-group">
    <?php
    if ($model->question_type == "ESSAY_ANSWER") {
        $this->renderpartial('_edit_essay_question', array('question_id' => $model->question_id, 'model' => $model));
    }
    ?>
</div>
<!--<br />
<input type="button" id="temp" onclick="validateForm()" value="test">
<br />-->





<div class="span8 no-left-margin" id="textAreaErrorDisplayRaw" style="display:none">
    <label id="textAreaErrorDisplay" class="error"></label>
</div>
<div class="control-group">
    <input type="hidden" id="update_ff" name="update_ff" value="UPDATE" />
    <input type="hidden" id="qid" name="qid" value="<?php echo $model->question_id; ?>">

</div>

<br/>
<br/>

<br/>
<div class="control-group"> 
    <?php //echo $form->textAreaRow($model, 'question_text', array('rows' => 15, 'cols' => 50, 'class' => 'span8'));       ?>
</div>


<div class="row">
    <div class="span8" id="preview_bn">
        <?php
        echo CHtml::ajaxButton('Preview', CController::createUrl('Question/reviewQuestion'), array(
            'type' => 'POST', //request type
            'dataType' => 'json',
            // 'onclick' => 'js:validateForm()',
            'beforeSend' => 'js:tinyMCE.triggerSave()',
            'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_Review").dialog("open");                            
                            if(document.getElementById("dialog_data")!=null){
                                $("#dialog_data").remove();
                            }                          
                            
                            $("#mydialog_Review").append(data.qoutput);
                            
                            
                        }else{
                            
                            
                        }
                    }'
                ), array(
            'id' => 'review_btn',
            'class' => 'tinybluebtn',
                )
        );
        ?>
    </div>

    <div class="span1">
        <?php
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news', 'id' => 'bttsubmit_update', 'onclick' => 'return validateForm()'));
        ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_Review',
    'options' => array(
        'title' => 'Review Page',
        'width' => 1000,
        'height' => 500,
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_viewExample',
    'options' => array(
        'title' => 'Example',
        'width' => 800,
        'height' => "auto",
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'position' => 'bottom',
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php $this->endWidget(); ?>
<!--        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script>
            tinymce.init({
                selector: "#Question_question_text,#Question_question_logic,#ref_table_formula_1,#ref_table_formula_2,#ref_table_formula_3, \n\
                   #ref_table_formula_4,#ref_table_formula_5,#ref_table_formula_6,#ref_table_formula_7,#ref_table_formula_8,#ref_table_formula_9, \n\
                   #ref_table_formula_10,#ref_table_formula_11,#ref_table_formula_12,#ref_table_formula_13,#ref_table_formula_14, \n\
                   #ref_table_formula_15,#ref_table_formula_16",
                theme: "modern",
                width: 800,
                height: 250,
                // mode : "specific_textareas",
                editor_selector: "mceEditor",
                editor_deselector: "mceNoEditor",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor jbimages"
                ],
                // content_css: "css/content.css",
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

            function validateForm() {
                var content = new Array();
                for (i = 0; i < tinyMCE.editors.length; i++) {
                    content[i] = tinyMCE.editors[i].getContent();
                }
                var select_qt = document.getElementById("question_type");
                var selectvalue_qt = select_qt.options[select_qt.selectedIndex].value;
                if (content[0] == '' || content[0] == null) {
                    document.getElementById("textAreaErrorDisplay").innerHTML = "Please enter the question text";
                    document.getElementById("textAreaErrorDisplayRaw").style.display = "block";
                    //document.getElementById("question_text").style.borderColor="red";
                    return false;
                } else {
                    if (selectvalue_qt == "DRAG_DROP_TYPEC_ANSWER") {
                        return validateFormTypeC();
                    } else if (selectvalue_qt == "ESSAY_ANSWER") {
                        return validateEmailEssay();
                    } else if (selectvalue_qt == "SINGLE_ANSWER") {
                        return checkSingleAnswer();
                    } else if (selectvalue_qt == "SHORT_WRITTEN") {
                        return checkShortWrittenAnswers();
                    } else if (selectvalue_qt == "DRAG_DROP_TYPEA_ANSWER") {
                        return checkDragnDropType_A_edit();
                    } else if (selectvalue_qt == "DRAG_DROP_TYPEB_ANSWER") {
                        return checkDragnDropType_B();
                    } else if (selectvalue_qt == "MULTIPLE_ANSWER") {
                        return checkMultipleAnswer();
                    } else if (selectvalue_qt == "DRAG_DROP_TYPED_ANSWER") {
                        return checkDragnDropType_D();
                    } else if (selectvalue_qt == "DRAG_DROP_TYPEE_ANSWER") {
                        return checkDragnDropType_E();
                    } else if (selectvalue_qt == "TRUE_OR_FALSE_ANSWER") {
                        return checkTrueFalse();
                    }
                    else {
                        return true;
                    }
                }
            }
</script>


<script type="text/javascript">
    function checkElement(element) {     //validation for all question types
        if (element.value == "") {
            error = 1;
            element.style.borderColor = "red";
        } else {
            error = 0;
            element.style.borderColor = "#cccccc";
        }
        return error;
    }
</script>


<script>
    $(function () {

        // Setup form validation on the #register-form element
        $("#question-form").validate({
            // Specify the validation rules
            rules: {
                course_id: "required",
                level_id: "required",
                subject_id: "required",
                "Question[subject_area_id]": "required",
                "Question[number_of_marks]": "required",
                "Question[question_text]": "required",
                question_type: "required",
                "Question[exhibit_attachment]": {
                    required: false,
                    accept: "jpg,png"
                }




            },
            // Specify the validation error messages
            messages: {
                course_id: "Please select a course",
                level_id: "Please select a level",
                subject_id: "Please select a subject",
                "Question[subject_area_id]": "Please select a subject area",
                "Question[number_of_marks]": "Please add marks for this question",
                "Question[question_text]": "Please fill in the question text",
                question_type: "Please select a question type",
                "Question[exhibit_attachment]": "Please upload an image"




            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });

</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js"></script>
