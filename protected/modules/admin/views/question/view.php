<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/pdf/pdfobject.js"></script>

<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1) {

    $this->breadcrumbs = array(
        'Questions' => array('index'),
        $model->question_id,
    );

    $type = Question::model()->getQuestionTypeLabel($model->question_type);

    if ($type == "Essay Answer") {
        $this->menu = array(
            array('label' => 'List Questions', 'url' => array('index')),
            array('label' => 'Create Question', 'url' => array('create')),
            array('label' => 'Update Question', 'url' => array('update', 'id' => $model->question_id)),
            //array('label' => 'Set Reference', 'url' => array('viewReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id')),
            //array('label' => 'Update Reference', 'url' => array('ViewUpdateReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id_update')),
            array('label' => 'Manage Questions', 'url' => array('admin')),
        );
    } else {
        $this->menu = array(
            array('label' => 'List Questions', 'url' => array('index')),
            array('label' => 'Create Question', 'url' => array('create')),
            array('label' => 'Update Question', 'url' => array('update', 'id' => $model->question_id)),
            //array('label' => 'Set Reference', 'url' => array('viewReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id')),
            //array('label' => 'Update Reference', 'url' => array('ViewUpdateReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id_update')),
            array('label' => 'Manage Questions', 'url' => array('admin')),
        );
    }
    ?>

    <h2 class="light_heading">View Question <?php echo $model->question_id; ?></h2><br/>

    <input type="hidden" id="question_types" value="<?php echo $model->question_type; ?>">

    <?php
    $qid = $model->question_id;
    $attach = $model->exhibit_attachment;

    $subjectAreaDetails = SubjectArea::model()->getSubjectAreaDetails($model->subject_area_id);

    $subject = Subject::model()->getSubjectDetails($subjectAreaDetails['subject_id']);

    $level = Level::model()->getLevel($subject['level_id']);

    $course = Course::model()->getCourseDetails($level['course_id']);


    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            array('name' => 'Question ID', 'value' => $model->question_id),
            array('name' => 'Course', 'value' => $course['course_name']),
            array('name' => 'Level', 'value' => $level['level_name']),
            array('name' => 'Subject', 'value' => $subject['subject_name']),
            array('name' => 'Subject Area', 'value' => SubjectArea::model()->getSubjectAreaName($model->subject_area_id)),
            array('name' => 'Question Type', 'value' => Question::model()->getQuestionTypeLabel($model->question_type)),
            'number_of_marks',
            array('label' => 'Exhibit',
                'type' => 'raw',
                'value' => CHtml::link(CHtml::encode($model->exhibit_attachment), Yii::app()->baseUrl . '/images/exhibit_attachment/' . $model->question_id . '/' . $model->exhibit_attachment)),
            array('name' => 'Exclude From Dynamic', 'value' => Question::model()->getExcludeDynamicLabel($model->exclude_from_dynamic)),
            array('name' => 'Lecturer Code', 'value' => Lecturer::model()->getLecturerCodeByUserId($model->author_id)),
            array('name' => 'Lecturer Name', 'value' => User::model()->getName($model->author_id)),
        ),
    ));
    ?>

    <br/>
    <?php
    echo '<h4>Question Display</h4><hr>';
    echo '<div style="max-width:800px; height:auto; word-wrap: break-word;">';
    echo html_entity_decode($model->question_text, HTML_ENTITIES, 'UTF-8');
    echo '</div>';
    echo '<br/>';
    ?>

    <?php
    if ($model->question_type == "SHORT_WRITTEN") {
        $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);
        echo '<table>';

        $headings = Heading::model()->getHeadingsOfQuestion($model->question_id); 
        echo '<tr>';

        if (sizeof($headings) == 2) {
            
            echo '<th title="'.$headings[0]['heading_text'].'">';
            if (isset($headings[0]['heading_text'])) {
                echo (strlen($headings[0]['heading_text']) > 20) ? substr($headings[0]['heading_text'], 0, 20) . '...' : $headings[0]['heading_text'];
            }
            echo '</th>';

            echo '<th title="'.$headings[1]['heading_text'].'">';
            if (isset($headings[1]['heading_text'])) {
               echo (strlen($headings[1]['heading_text']) > 20) ? substr($headings[1]['heading_text'], 0, 20) . '...' : $headings[1]['heading_text'];
            } echo '</th>';
        } else if (sizeof($headings) == 1) {

            if ($headings[0]['heading_position'] == 1) {
                echo '<th title="'.$headings[0]['heading_text'].'">';
                echo (strlen($headings[0]['heading_text']) > 20) ? substr($headings[0]['heading_text'], 0, 20) . '...' : $headings[0]['heading_text'];
                echo '</th>';
                echo '<th>';
                echo 'N/A';
                echo '</th>';
            } else if ($headings[0]['heading_position'] == 2) {
                echo '<th>';
                echo 'N/A';
                echo '</th>';
                echo '<th title="'.$headings[0]['heading_text'].'">';
                echo (strlen($headings[0]['heading_text']) > 20) ? substr($headings[0]['heading_text'], 0, 20) . '...' : $headings[0]['heading_text'];
                echo '</th>';
            }
        }

        echo '</tr>';

        foreach ($questionParts as $questionPart) {
            echo '<tr>';
            echo '<td title="'.$questionPart['question_part_name'].'">';
            echo (strlen($questionPart['question_part_name']) > 20) ? substr($questionPart['question_part_name'], 0, 20) . '...' : $questionPart['question_part_name'];
            echo '</td>';

            $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

            $txt = AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
            $txt_trunk = (strlen($txt) > 20) ? substr($txt, 0, 20) . '...' : $txt;
            
            echo '<td title="'.$txt.'">&nbsp;&nbsp;';
            ?>
            <input type="text" value="<?php echo $txt_trunk; ?>" readonly=""/>
            <?php
            echo '</td>';
            echo '</tr>';
        }


        echo '</table>';
    } else
    if ($model->question_type == "DRAG_DROP_TYPEA_ANSWER") {

        $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);
        ?>
        <div class="row">
            <div class="span5">

                <table>

                    <?php
                    foreach ($questionParts as $questionPart) {
                        $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
                        $qpart_trunk = (strlen($questionPart['question_part_name']) > 40) ? substr($questionPart['question_part_name'], 0, 40) . '...' : $questionPart['question_part_name'];
                        $ans_text_blue = AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                        $ans_text_blue_trunk = (strlen($ans_text_blue) > 30) ? substr($ans_text_blue, 0, 30) . '...' : $ans_text_blue;
                        ?>
                        <tr>
                            <td style="width: 250px" title="<?php echo htmlspecialchars($questionPart['question_part_name']); ?>"><?php echo $qpart_trunk ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td title="<?php echo htmlspecialchars($ans_text_blue); ?>"><button class="bluebtn" type="button"><?php echo $ans_text_blue_trunk; ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>    
            </div>

            <div class="span4">

                <div class="dragAwell" style="background: transparent;">

                    <?php
                    shuffle($questionParts);
                    foreach ($questionParts as $questionPart) {
                        $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

                        $ans_text_grey = AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                        $ans_text_grey_trunck = (strlen($ans_text_grey) > 30) ? substr($ans_text_grey, 0, 30) . '...' : $ans_text_grey;
                        ?>
                        <button class="greybtn" type="button" title="<?php echo htmlspecialchars($ans_text_grey); ?>"><?php echo $ans_text_grey_trunck ?></button>
                        <br /><br />
                        <?php
                    }
                    ?>

                </div>
            </div>

        </div>



        <?php
    } else if ($model->question_type == "MULTIPLE_CHOICE_ANSWER") {

        $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

        echo '<table>';

        $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);

        echo '<tr>';

        if (sizeof($headings) == 2) {
            echo '<th>';
            if (isset($headings[0]['heading_text'])) {
                echo $headings[0]['heading_text'];
            }
            echo '</th>';

            echo '<th>';
            if (isset($headings[1]['heading_text'])) {
                echo $headings[1]['heading_text'];
            } echo '</th>';
        } else if (sizeof($headings) == 1) {

            if ($headings[0]['heading_position'] == 1) {
                echo '<th>';
                echo $headings[0]['heading_text'];
                echo '</th>';
                echo '<th>';
                echo 'N/A';
                echo '</th>';
            } else if ($headings[0]['heading_position'] == 2) {
                echo '<th>';
                echo 'N/A';
                echo '</th>';
                echo '<th>';
                echo $headings[0]['heading_text'];
                echo '</th>';
            }
        }
        echo '</tr>';

        foreach ($questionParts as $questionPart) {
            echo '<tr>';
            echo '<td>';
            echo $questionPart['question_part_name'];
            echo '</td>';
            echo '<td>&nbsp;&nbsp;';
            ?>

            <?php
            $answers = Answer::model()->getAnswersOfQuestionPart($questionPart['question_part_id']);
            ?>

            <select>
                <option value="" disabled selected>Select Answer</option>

                <?php
                foreach ($answers as $answer) {
                    $answer_text = AnswerText::model()->getAnswerText($answer['answer_text_id']);

                    if ($answer['is_correct'] == 1) {
                        ?>
                        <option value="<?php echo $answer['answer_text_id'] ?>" selected=""><?php echo $answer_text->answer_text; ?></option>
                        <?php
                    } else if ($answer['is_correct'] == 0) {
                        ?>  
                        <option value="<?php echo $answer['answer_text_id'] ?>"><?php echo $answer_text->answer_text; ?></option>
                        <?php
                    }
                }
                ?>
            </select>

            <?php
            echo '</td>';
            echo '</tr>';
        }


        echo '</table>';
    } else if ($model->question_type == "TRUE_OR_FALSE_ANSWER") {
        $answer = Answer::model()->getAnswerOfQuestion($model->question_id);

        if ($answer['is_correct'] == 1) {
            ?>
            <input type="radio" name="answer" value="true" checked="" disabled=""/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="answer" value="false" disabled=""/>&nbsp;&nbsp;False
            <?php
        } else if ($answer['is_correct'] == 0) {
            ?>
            <input type="radio" name="answer" value="true" disabled=""/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="answer" value="false" checked="" disabled=""/>&nbsp;&nbsp;False
            <?php
        } else if ($answer['is_correct'] == 3) {
            ?>
            <input type="radio" name="answer" value="true" disabled=""/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="answer" value="false" disabled=""/>&nbsp;&nbsp;False
            <?php
        }
    } else if ($model->question_type == "SINGLE_ANSWER") {
        $single_answer_data = AnswerText::model()->getAnswerTextForQuestion($model->question_id);

        $single_answer_images = Answer::model()->getQuestionPartsforQuestionView($model->question_id);

        echo '<table class="table table-hover">';



        foreach ($single_answer_data as $single_data) {
            $is_correct = Answer::model()->getIsCorrectAnswers($single_data->answer_text_id);

            if ($single_data->answer_text != "") {
                if ($is_correct['is_correct'] == 1) {
                    echo '<tr><td><input type="checkbox" checked="checked" onclick="return false"/></td>  <td><span>' . $single_data->answer_text . '</span></td></tr>';
                } else {
                    echo '<tr><td><input type="checkbox" onclick="return false"/></td>   <td><span>' . $single_data->answer_text . '</span></td></tr>';
                }
            }
        }

        foreach ($single_answer_images as $single_images) {
            //$is_correct = Answer::model()->getIsCorrectAnswers($mul_images->answer_id);
            if ($single_images->image_answer == NULL) {
                //break;
            } else {
                if ($single_images->is_correct == 1) {
                    echo '<tr><td><input type="checkbox" checked="checked" onclick="return false"/></td>  <td><span>' . CHtml::image(Yii::app()->request->baseUrl . '/images/single_answer_images/' . $single_images->image_answer, "", array("width" => "200px", "height" => "72px")) . '</span></td></tr>';
                } else {
                    echo '<tr><td><input type="checkbox" onclick="return false"/></td>   <td><span>' . CHtml::image(Yii::app()->request->baseUrl . '/images/single_answer_images/' . $single_images->image_answer, "", array("width" => "200px", "height" => "72px")) . '</span></td></tr>';
                }
            }
        }
        echo '</table>';
    } else if ($model->question_type == "MULTIPLE_ANSWER") {
        $multiple_answer_data = AnswerText::model()->getAnswerTextForQuestion($model->question_id);

        $multiple_answer_images = Answer::model()->getQuestionPartsforQuestionView($model->question_id);



//        var_dump($multiple_answer_data);
//        
//        echo '<br />';
//        echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
//         echo '<br />';
//        var_dump($multiple_answer_images);
//        die;

        echo '<table class="table table-hover">';



        foreach ($multiple_answer_data as $mul_data) {
            $is_correct = Answer::model()->getIsCorrectAnswers($mul_data->answer_text_id);

            if ($is_correct['is_correct'] == 1) {
                echo '<tr><td><input type="checkbox" checked="checked" onclick="return false"/></td>  <td><span>' . $mul_data->answer_text . '</span></td></tr>';
            } else {
                echo '<tr><td><input type="checkbox" onclick="return false"/></td>   <td><span>' . $mul_data->answer_text . '</span></td></tr>';
            }
        }

        foreach ($multiple_answer_images as $mul_images) {
            //$is_correct = Answer::model()->getIsCorrectAnswers($mul_images->answer_id);
            if ($mul_images->image_answer == NULL) {
                
            } else {
                if ($mul_images->is_correct == 1) {
                    echo '<tr><td><input type="checkbox" checked="checked" onclick="return false"/></td>  <td><span>' . CHtml::image(Yii::app()->request->baseUrl . '/images/multiple-answer-images/' . $mul_images->image_answer, "", array("width" => "200px", "height" => "72px")) . '</span></td></tr>';
                } else {
                    echo '<tr><td><input type="checkbox" onclick="return false"/></td>   <td><span>' . CHtml::image(Yii::app()->request->baseUrl . '/images/multiple-answer-images/' . $mul_images->image_answer, "", array("width" => "200px", "height" => "72px")) . '</span></td></tr>';
                }
            }
        }
        echo '</table>';
    }
    ?>


    <!-- ----------------    Start of Drag and Drop Type B view --------------------- -->
    <?php
    if ($model->question_type == 'DRAG_DROP_TYPEB_ANSWER') {
        $headings = Heading::getHeadingTextforQuestionView($model->question_id);

        $question_parts = QuestionPart::getQuestionPartsforQuestionView($model->question_id);

        $question_part_texts_b = array();

        foreach ($question_parts as $question_part) {
            $question_part_texts_b[] = $question_part->question_part_id;
        }

        $ques_part_count = count($question_part_texts_b);
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php
                    foreach ($headings as $heading) {

                        $heading_trunck = (strlen($heading->heading_text) > 10) ? substr($heading->heading_text, 0, 10) . '...' : $heading->heading_text;

                        if ($heading['heading_position'] == 1) {
                            echo '<th title="' . htmlspecialchars($heading->heading_text) . '">' . $heading_trunck . '</th>';
                        } else {
                            echo '<th colspan="2" title="' . htmlspecialchars($heading->heading_text) . '"><center>' . $heading_trunck . '</center></th>';
                        }
                    }
                    ?>                                       
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < $ques_part_count; $i++) {
                    $qpart_text = QuestionPart::getQuestionPartText($question_part_texts_b[$i]);
                    $qpart_text_trunck = (strlen($qpart_text) > 40) ? substr($qpart_text, 0, 40) . '...' : $qpart_text;

                    echo '<tr>';
                    echo '<td class="span6" title="' . htmlspecialchars($qpart_text) . '">' . $qpart_text_trunck . '</td>';
                    $answers = Answer::getAnswersforQuestionPartid($question_part_texts_b[$i]);
                    foreach ($answers as $answer) {

                        $answer_id[] = $answer->answer_text_id;
                    }


                    $answer_count = count($answer_id);

                    for ($c = 0; $c < $answer_count; $c++) {

                        $ans_text = AnswerText::getAnswerTextById($answer_id[$c]);
                        $txt = (strlen($ans_text) > 30) ? substr($ans_text, 0, 30) . '...' : $ans_text;
                        ?>

                    <td  class="span5" title="<?php echo htmlspecialchars($ans_text) ?>"><center><button class="bluebtn"><?php echo $txt; ?></button></center></td>
                <?php
            }

            $answer_id = array();
            echo '</tr>';
        }
        ?>
        </tbody>
        </table>
        <br/>

        <div class="drag-drop-type-b-well">
            <?php
            $answer_texts_b = AnswerText::getAnswerTextForQuestion($model->question_id);
            shuffle($answer_texts_b);


            $count2 = 1;
            foreach ($answer_texts_b as $answer_text) {
                $ans_text_grey = $answer_text->answer_text;

                $ans_text_grey_trunck = (strlen($ans_text_grey) > 30) ? substr($ans_text_grey, 0, 30) . '...' : $ans_text_grey;

                echo '<button class="greybtn style="width:200px;margin:10px 10px 10px 10px;" title="' . htmlspecialchars($ans_text_grey) . '">' . $ans_text_grey_trunck . '</button>';

                echo '&nbsp;&nbsp;';
                if ($count2 % 3 == 0) {
                    echo '<br/>';
                }
                $count2++;
            }
            ?>
        </div>
        <?php
    }
    ?>
    <!-- -------------------------- End of Drag and Drop Type B view -------------------------- -->


    <?php
    if ($model->question_type == "DRAG_DROP_TYPEC_ANSWER") {
        $qs_parts_and_answer = array();
        $answers_data = Answer::model()->getAnwersForQuestion($model->question_id);
        $answer_text_data = AnswerText::model()->getAnswerTextForQuestion($model->question_id);
        $question_part_data = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);
        ?>
        <!--        display answers-->

        <?php
        $no_of_answers = sizeof($answer_text_data);

        $i = 1;
        ?>

        <div class="drag-drop-type-c-well">

            <?php
            foreach ($answer_text_data as $answer) {
                $ans_text_grey_trunck = (strlen($answer->answer_text) > 30) ? substr($answer->answer_text, 0, 30) . '...' : $answer->answer_text;
                ?>
                <button class="greybtn" title="<?php echo htmlspecialchars($answer->answer_text); ?>"><?php echo $ans_text_grey_trunck; ?></button>
                <?php
                if ($i == 3) {
                    echo '<br/><br/>';
                }
                $i++;
            }
            ?>
        </div>

        <table>

            <?php
            foreach ($answers_data as $answer) {
                $qpart_text_trunck = (strlen($answer->questionPart->question_part_name) > 60) ? substr($answer->questionPart->question_part_name, 0, 60) . '...' : $answer->questionPart->question_part_name;
                echo '<tr>';
                echo '<td title="' . htmlspecialchars($answer->questionPart->question_part_name) . '">';

                echo $qpart_text_trunck;
                ?>

                &nbsp;&nbsp;&nbsp;&nbsp;

                <?php
                $ans_text_trunck = (strlen($answer->answerText->answer_text) > 30) ? substr($answer->answerText->answer_text, 0, 30) . '...' : $answer->answerText->answer_text;

                echo '</td>';
                echo '<td>';
                ?>


                <button class="bluebtn" title="<?php echo htmlspecialchars($answer->answerText->answer_text) ?>"><?php echo $ans_text_trunck; ?></button>

                <?php
                echo '</td>';

//        echo $answer->answerText->answer_text;
                echo '</tr>';
                echo '<tr height="10px"></tr>';
            }
            ?>


        </table>
        <?php
    } else if ($model->question_type == "DRAG_DROP_TYPEE_ANSWER") {
        $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

        echo '<table border="1">';

        $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);

        echo '<tr>';
        echo '<td>';
        echo '</td>';

        if (sizeof($headings) == 2) {
            echo '<th title="' . htmlspecialchars($headings[0]['heading_text']) . '">';
            if (isset($headings[0]['heading_text'])) {
                echo (strlen($headings[0]['heading_text']) > 30) ? substr($headings[0]['heading_text'], 0, 30) . '...' : $headings[0]['heading_text'];
            }
            echo '</th>';

            echo '<th title="' . htmlspecialchars($headings[1]['heading_text']) . '">';
            if (isset($headings[1]['heading_text'])) {
                echo (strlen($headings[1]['heading_text']) > 30) ? substr($headings[1]['heading_text'], 0, 30) . '...' : $headings[1]['heading_text'];
            } echo '</th>';
        } else if (sizeof($headings) == 1) {

            if ($headings[0]['heading_position'] == 1) {
                echo '<th title="' . htmlspecialchars($headings[0]['heading_text']) . '">';
                echo (strlen($headings[0]['heading_text']) > 30) ? substr($headings[0]['heading_text'], 0, 30) . '...' : $headings[0]['heading_text'];
                echo '</th>';
                echo '<th>';
                echo 'N/A';
                echo '</th>';
            } else if ($headings[0]['heading_position'] == 2) {
                echo '<th>';
                echo 'N/A';
                echo '</th>';
                echo '<th title="' . htmlspecialchars($headings[0]['heading_text']) . '">';
                echo (strlen($headings[0]['heading_text']) > 30) ? substr($headings[0]['heading_text'], 0, 30) . '...' : $headings[0]['heading_text'];
                echo '</th>';
            }
        }


        echo '</tr>';

        foreach ($questionParts as $questionPart) {
            echo '<tr>';
            echo '<td width="200px" title="' . htmlspecialchars($questionPart['question_part_name']) . '"><center>';
            echo (strlen($questionPart['question_part_name']) > 30) ? substr($questionPart['question_part_name'], 0, 30) . '...' : $questionPart['question_part_name'];
            echo '</center></td>';

            $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($questionPart['question_part_id']);

            echo '<td width="200px" title="' . htmlspecialchars($questionPartText['question_part_text']) . '"><center>';
            echo (strlen($questionPartText['question_part_text']) > 30) ? substr($questionPartText['question_part_text'], 0, 30) . '...' : $questionPartText['question_part_text'];
            echo '</center></td>';

            $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

            $ans_text_blue = AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
            $ans_text_blue_trunk = (strlen($ans_text_blue) > 30) ? substr($ans_text_blue, 0, 30) . '...' : $ans_text_blue;

            echo '<td width="200px" title="' . htmlspecialchars($ans_text_blue) . '"><center>';
            ?>
            <button class="bluebtn"><?php echo $ans_text_blue_trunk; ?></button>
            <?php
            echo '</center></td>';
            echo '</tr>';
        }

        echo '</table>';
        ?>
        <br/>

        <div class="drag-drop-type-d-well">

            <?php
            $count = 1;

            $other_answers = Answer::model()->getOtherAnswersOfQuestion($model->question_id);

            if (!empty($other_answers)) {
                shuffle($other_answers);

                foreach ($other_answers as $other_answer) {
                    $other_answer_text = AnswerText::model()->getAnswerText($other_answer['answer_text_id']);
                    $ans_text_grey = $other_answer_text['answer_text'];
                    $ans_text_grey_trunck = (strlen($ans_text_grey) > 30) ? substr($ans_text_grey, 0, 30) . '...' : $ans_text_grey;
                    ?>
                    <button class="greybtn" type="button" title="<?php echo htmlspecialchars($ans_text_grey); ?>"><?php echo $ans_text_grey_trunck ?></button>
                    <?php
                    if ($count % 3 == 0) {
                        echo '<br/><br/>';
                    }
                    $count++;
                }
            }


            shuffle($questionParts);
            foreach ($questionParts as $questionPart) {
                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
                $ans_text_grey2 = AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                $ans_text_grey2_trunk = (strlen($ans_text_grey2) > 30) ? substr($ans_text_grey2, 0, 30) . '...' : $ans_text_grey2;
                ?>
                <button class="greybtn" type="button" title="<?php echo htmlspecialchars($ans_text_grey2) ?>"><?php echo $ans_text_grey2_trunk; ?></button>

                <?php
                if ($count % 3 == 0) {
                    echo '<br/><br/>';
                }
                $count++;
            }
            ?>

        </div>

        <?php
    } else if ($model->question_type == 'DRAG_DROP_TYPED_ANSWER') {

        $resultText = Answer::model()->getResultText($model->question_id);

        $answers = Answer::model()->getCorrectAnswersOfQuestion($model->question_id);
        $ans_text = AnswerText::model()->getAnswerTextById($answers[0]['answer_text_id']);
        $ans_text_trunck = (strlen($ans_text) > 30) ? substr($ans_text, 0, 30) . '...' : $ans_text;       
       

        $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($model->question_id);

        $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);
        ?>
        <table>
            <tr>
                <td width="70" title="<?php echo htmlspecialchars($ans_text) ?>">
            <center><?php
                if ($answers != null) {
                    echo $ans_text_trunck;
                }
                ?></center>
        </td>
        <td width="70">
        <center>=</center>
        </td>
        <td width="70" title="<?php echo htmlspecialchars($questionPart['question_part_name']) ?>">
        <center><?php echo(strlen($questionPart['question_part_name']) > 30) ? substr($questionPart['question_part_name'], 0, 30) . '...' : $questionPart['question_part_name']; ?></center>
        </td>
        <td width="70" title="<?php echo htmlspecialchars($operators[0]['question_part_text']) ?>">
        <center><?php echo(strlen($operators[0]['question_part_text']) > 30) ? substr($operators[0]['question_part_text'], 0, 30) . '...' : $operators[0]['question_part_text']; ?></center>
        </td>
        <td>
            <button class="bluebtn" title="<?php echo htmlspecialchars($answers[1]['answer_text_id']) ?>"><?php
                if ($answers != null) {
                    if (isset($answers[1]['answer_text_id'])) {
                       echo (strlen(AnswerText::model()->getAnswerTextById($answers[1]['answer_text_id'])) > 30) ? substr(AnswerText::model()->getAnswerTextById($answers[1]['answer_text_id']), 0, 30) . '...' : AnswerText::model()->getAnswerTextById($answers[1]['answer_text_id']);                      
                        
                    }
                }
                ?></button>
        </td>
        <td width="70" title="<?php echo htmlspecialchars($operators[1]['question_part_text']) ?>">
        <center><?php echo (strlen($operators[1]['question_part_text']) > 30) ? substr($operators[1]['question_part_text'], 0, 30) . '...' : $operators[1]['question_part_text']; ?></center>
        </td>
        <td>
            <button class="bluebtn" title="<?php echo htmlspecialchars(AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id'])) ?>"><?php
                if ($answers != null) {
                    if (isset($answers[2]['answer_text_id'])) {
                        echo (strlen(AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id'])) > 30) ? substr(AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id']), 0, 30) . '...' : AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id']);
                    }
                }
                ?></button>
        </td>
        </tr>
        </table>

        <br/>


        <div class="drag-drop-type-d-well">

            <?php
            $count = 1;

            $other_answers = Answer::model()->getOtherAnswersOfQuestion($model->question_id);

            if (!empty($other_answers)) {
                shuffle($other_answers);

                foreach ($other_answers as $other_answer) {
                    $other_answer_text = AnswerText::model()->getAnswerText($other_answer['answer_text_id']);
                    ?>
                    <button class="greybtn" type="button" title="<?php echo htmlspecialchars($other_answer_text['answer_text']) ?>"><?php echo (strlen($other_answer_text['answer_text']) > 30) ? substr($other_answer_text['answer_text'], 0, 30) . '...' : $other_answer_text['answer_text']; ?></button>
                    <?php
                    if ($count % 3 == 0) {
                        echo '<br/><br/>';
                    }
                    $count++;
                }
            }


            shuffle($answers);
            foreach ($answers as $answer) {
                if ($answer['question_part_id'] != null) {
                    ?>
                    <button class="greybtn" type="button" title="<?php echo htmlspecialchars(AnswerText::model()->getAnswerTextById($answer['answer_text_id'])) ?>"><?php echo (strlen(AnswerText::model()->getAnswerTextById($answer['answer_text_id'])) > 30) ? substr(AnswerText::model()->getAnswerTextById($answer['answer_text_id']), 0, 30) . '...' : AnswerText::model()->getAnswerTextById($answer['answer_text_id']); ?></button>
                    <?php
                }
                if ($count % 3 == 0) {
                    echo '<br/><br/>';
                }
                $count++;
            }
            ?>

        </div>

        <?php
    } else if ($model->question_type == 'ESSAY_ANSWER') {

        $essayType = EssayQuestion::model()->getEmailEssayDetailsByQuestionId($model->question_id);

        if ($essayType == 'EMAIL') {
            echo '<h4 class="light_heading">Email Information</h4><br/>';

            $emailDetails = EmailEssayHeader::model()->getEmailEssayHeaderDetailsByQuestionId($model->question_id);
            ?>

            <div class="span2" style="margin-left: 0px;"><b>Email From :</b></div><div class="span2" style="margin-left: 0px;"><?php echo $emailDetails['from_field']; ?></div><br />
            <div class="span2" style="margin-left: 0px;"><b>Email To :</b></div><div class="span2" style="margin-left: 0px;"><?php echo $emailDetails['to_field']; ?></div><br />
            <div class="span2" style="margin-left: 0px;"><b>Email Cc :</b></div><div class="span2" style="margin-left: 0px;"><?php echo $emailDetails['cc_field']; ?></div><br />
            <div class="span2" style="margin-left: 0px;"><b>Email Subject :</b></div><div class="span2" style="margin-left: 0px;"><?php echo $emailDetails['subject_field']; ?></div><br />

            <?php
        }

        echo '<br />';
        echo '<br />';

        echo '<hr class="hrstyle" style="margin-left: 00px;"></hr>';

        echo '<h4 class="light_heading">Reference Materials</h4><br/>';

        $questionReferenceMat = QuestionReferenceMaterials::model()->findAllByAttributes(array('question_id' => $model->question_id));
        echo '<div class="well">';

        if (empty($questionReferenceMat)) {
            echo '<strong>No Reference material</strong>';

            echo '<br />';
            echo '<br />';

            echo CHtml::button('Set Reference ', array('submit' => array('viewReferenceMaterial', 'id' => $model->question_id), 'class' => 'smallbluebtn'));
        } else {
            ?>
            <div class="bs-example">
                <ul class="nav nav-tabs">

                    <?php
                    $count = 0;
                    foreach ($questionReferenceMat as $item) {
                        $id = $item->question_reference_material_id;
                        $tab_title = QuestionReferenceMaterialTabs::model()->findByAttributes(array('question_reference_material_id' => $id));
                        if ($count == 0) {
                            ?>
                            <li class="active"><a data-toggle="tab" href="#<?php echo $item['reference_tab_position']; ?>"><?php echo $tab_title['reference_tab_title']; ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li><a data-toggle="tab" href="#<?php echo $item['reference_tab_position']; ?>"><?php echo $tab_title['reference_tab_title']; ?></a></li>
                            <?php
                        }
                        $count++;
                    }
                    ?> 

                </ul>
                <div class="tab-content">
                    <?php
                    $count2 = 0;

                    foreach ($questionReferenceMat as $item) {
                        if ($count2 == 0) {
                            ?>
                            <div id="<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade in active">
                                <?php
                                if ($item['reference_material_text'] != null) {
                                    echo $item['reference_material_text'];
                                }

                                if ($item['reference_file'] != null) {
                                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/reference_material/' . $model->question_id . '/' . $item['reference_tab_position'] . '/' . $item['reference_file'], "", array("width" => "200px", "height" => "72px"));
                                } else {
                                    if ($item['reference_material_text'] == null) {
                                        if (Yii::app()->user->hasFlash(Consts::STATUS_IMAGE_NOT_SET)) {
                                            ?><div class="info">
                                            <?php echo Yii::app()->user->getFlash(Consts::STATUS_IMAGE_NOT_SET); ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?><div>
                                                <?php echo Consts::ERROR_IMAGE_NOT_SET; ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade">
                                <?php
                                if ($item['reference_material_text'] != null) {
                                    echo $item['reference_material_text'];
                                }

                                if ($item['reference_file'] != null) {
                                    //echo CHtml::image(CHtml::encode($item['reference_file']), Yii::app()->baseUrl . '/images/reference_material/' . $model->question_id . '/' . $item['reference_tab_position'] . '/' . $item['reference_file']);
                                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/reference_material/' . $model->question_id . '/' . $item['reference_tab_position'] . '/' . $item['reference_file'], "", array("width" => "200px", "height" => "72px"));
                                } else {
                                    if (Yii::app()->user->hasFlash(Consts::STATUS_IMAGE_NOT_SET)) {
                                        ?><div class="info">
                                        <?php echo Yii::app()->user->getFlash(Consts::STATUS_IMAGE_NOT_SET); ?>
                                        </div>
                                        <?php
                                    } else {
                                        ?><div>
                                            <?php echo Consts::ERROR_IMAGE_NOT_SET; ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }

                        $count2++;
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        echo '</div>';


        echo CHtml::button('Update Reference ', array('submit' => array('viewUpdateReferenceMaterial', 'id' => $model->question_id), 'class' => 'smallbluebtn'));
        echo '<br />';
    }
    ?>

    <br/>
    <?php
    echo '<h4>Question Logic</h4><hr>';
    if ($model->question_logic == null) {
        echo '<h6>question logic not set</h6>';
    } else {
        echo html_entity_decode($model->question_logic, HTML_ENTITIES, 'UTF-8');
        //echo html_entity_decode($model->question_logic);
    }

    echo '<br/>';
    ?>

    <br/>
    <br/>


    <!--<button class="btn btn-mock" id="formula-btn" type="button" onclick="openPdf()">View Pdf</button>-->

    <br /><br />


    <b>Status: </b>
    <?php
    if ($model->status == 1) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'Active<br/><br/>'; ?>
        </p>


                                                                                                                                                                                                                                                                                                                                                <!--        <p id="exam_question_message" style="color: red"></p>-->



        <?php
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Question/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){             
                           
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                           document.getElementById("suspendButton").style.display = "none";
                           document.getElementById("reactivateButton").style.display = "block";
                           document.getElementById("exam_question_message").style.color = "red";
                           document.getElementById("exam_question_message").innerHTML = data.message;                           
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:block')
        );



        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Question/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){   

                            document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";
                            document.getElementById("exam_question_message").style.color = "green";
                            document.getElementById("exam_question_message").innerHTML = data.message;  
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:none')
        );
        ?>
        <br />
        <p id="exam_question_message"></p>
        <?php
    } else if ($model->status == 0) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'In-Active<br/><br/>'; ?>
        </p>


        <?php
        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Question/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){                                       
                            document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";
                            document.getElementById("exam_question_message").style.color = "green";
                            document.getElementById("exam_question_message").innerHTML = data.message;  
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:block')
        );
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Question/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                           document.getElementById("suspendButton").style.display = "none";
                           document.getElementById("reactivateButton").style.display = "block";
                           document.getElementById("exam_question_message").style.color = "red";
                           document.getElementById("exam_question_message").innerHTML = data.message;                           
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:none')
        );
        ?>
        <br />
        <p id="exam_question_message"></p>
        <?php
    }
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
<br />
<!--</div>-->
<script type="text/javascript">
    function openPdf() {
        $("#mydialog_pdf").dialog("open");
        return false;
    }
</script>



<div id="tabel_formulae">

</div>
