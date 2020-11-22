<style type="text/css">
    .table th {
        white-space: pre-wrap !important;
    }
</style>

<?php
$exam_question_session = Yii::app()->session['exam_question_session'];

foreach ($exam_question_session as $key => $question) {
    if ($question_number == $question['question_number']) {
        $question_details = Question::model()->getQuestionsByQuestionId($question['question_id']);


        foreach ($question_details as $questions) {

            echo '<div id="exam_question_container">';
//            echo $question['question_number'];
            echo '<br />';
            echo '<b>';

            if ($questions['question_type'] != "HOT_SPOT_ANSWER") {

                echo '<u>Question ' . $question['question_number'] . '</u>';
                echo $questions['question_text'];
//            echo $questions['question_text'];
            } else {
                echo '<div class="hotspot_question_text">';
                echo '<u>Question ' . $question['question_number'] . '</u>';
                echo $questions['question_text'];
                echo '</div>';
            }
            echo '<br />';
            echo '<br />';
            echo '</b>';

            if ($questions['question_type'] == "SINGLE_ANSWER") {
                $answer_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';

                foreach ($answer_details as $answers) {
                    if ($answers['image_answer'] != null) {
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';
                        if ($question['answer_id'] == $answers['answer_id']) {
                            echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" checked="checked" />' . CHtml::image(Yii::app()->request->baseUrl . '/images/single_answer_images/' . $answers['image_answer'], "", array('width' => "200px", 'height' => "72px"));
                        } else {
                            echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />' . CHtml::image(Yii::app()->request->baseUrl . '/images/single_answer_images/' . $answers['image_answer'], "", array('width' => "200px", 'height' => "72px"));
                        }
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';
                        if ($question['answer_id'] == $answers['answer_id']) {
                            echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" checked="checked" />' . AnswerText::model()->getAnswertextByAnswerId($answers['answer_text_id']);
                        } else {
                            echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />' . AnswerText::model()->getAnswertextByAnswerId($answers['answer_text_id']);
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
            } else if ($questions['question_type'] == "MULTIPLE_ANSWER") {
                $answer_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';

                foreach ($answer_details as $answers) {
                    if ($answers['image_answer'] != null) {
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';
                        if (is_array($question['answer_id']) && in_array($answers['answer_id'], $question['answer_id'])) {
                            echo '<input type="checkbox" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" checked="checked" />' . CHtml::image(Yii::app()->request->baseUrl . '/images/multiple-answer-images/' . $answers['image_answer'], "", array('width' => "200px", 'height' => "72px"));
                        } else {
                            echo '<input type="checkbox" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />' . CHtml::image(Yii::app()->request->baseUrl . '/images/multiple-answer-images/' . $answers['image_answer'], "", array('width' => "200px", 'height' => "72px"));
                        }
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';
                        if (is_array($question['answer_id']) && in_array($answers['answer_id'], $question['answer_id'])) {
                            echo '<input type="checkbox" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" checked="checked" />' . AnswerText::getAnswertextByAnswerId($answers['answer_text_id']);
                        } else {
                            echo '<input type="checkbox" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />' . AnswerText::getAnswertextByAnswerId($answers['answer_text_id']);
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
            } else if ($questions['question_type'] == "SHORT_WRITTEN") {
                $answer_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                $headings = Heading::model()->getHeadingsOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                $count = 0;
                echo '<table>';
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
                foreach ($answer_details as $answers) {
                    echo '<tr>';
                    echo '<div class="control-group">';
                    echo '<div class="control-label">';
//                    if (is_array($question['answer_id']) && in_array($answers['answer_id'], $question['answer_id'])) {
                    if (isset($question['answer_id'])) {


                        echo '<td>';
                        echo QuestionPart::model()->getQuestionPartText($answers['question_part_id']);
                        echo '</td>';

                        echo '<td>';
                        echo '<input type="text" name="answer_id" id="' . $answers['answer_id'] . '" '
                        . 'class="answer_text" style="margin-right:5px" value="' . $question['answer_id'][$count] . '" placeholder="Enter Answer"/>';
                        echo '</td>';
                    } else {
                        echo '<td>';
                        echo QuestionPart::model()->getQuestionPartText($answers['question_part_id']);
                        echo '</td>';

                        echo '<td>';
                        echo '<input type="text" name="answer_id" id="' . $answers['answer_id'] . '" '
                        . 'class="answer_text" style="margin-right:5px" placeholder="Enter Answer"/>';
                        echo '</td>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</tr>';

                    $count++;
                }
                echo '</table>';
            } else if ($questions['question_type'] == "TRUE_OR_FALSE_ANSWER") {
                $answer_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';

                foreach ($answer_details as $answers) {
                    echo '<div class="control-group">';
                    echo '<div class="control-label">';

                    if ($question['answer_id'] == null || $question['answer_id'] == "null") {
                        echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />True';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<input type="radio" name="answer_id" value="0" class="answer_text" style="margin-right:5px" />False';
                    } else if ($question['answer_id'] == 0) {
                        echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" />True';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<input type="radio" name="answer_id" value="0" class="answer_text" style="margin-right:5px" checked="checked"/>False';
                    } else {
                        echo '<input type="radio" name="answer_id" value="' . $answers['answer_id'] . '" class="answer_text" style="margin-right:5px" checked="checked"/>True';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<input type="radio" name="answer_id" value="0" class="answer_text" style="margin-right:5px" />False';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            } else if ($questions['question_type'] == "MULTIPLE_CHOICE_ANSWER") {
                $answer_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                $headings = Heading::model()->getHeadingsOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                $count = 0;
                echo '<table>';
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

                $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($question['question_id']);

                $count = 0;

                foreach ($questionParts as $questionPart) {
                    echo '<tr>';
                    echo '<div class="control-group">';
                    echo '<div class="control-label">';

                    echo '<td>';
                    echo $questionPart['question_part_name'];
                    echo '</td>';

                    echo '<td>';

                    $answers = Answer::model()->getAnswersOfQuestionPart($questionPart['question_part_id']);

                    if (isset($question['answer_id'])) {
                        $selected_answer_id = $question['answer_id'][$count];
                        ?>
                        <select name="answer_id" class="answer_section">
                            <option value="" disabled selected>Select Answer</option>
                            <?php
                            foreach ($answers as $answer) {
                                $answer_text = AnswerText::model()->getAnswerText($answer['answer_text_id']);

                                if ($answer['answer_id'] == $selected_answer_id) {
                                    ?>
                                    <option id="<?php echo $answer['answer_id']; ?>" value="<?php echo $answer['answer_id'] ?>" selected=""><?php echo $answer_text->answer_text; ?></option>
                                    <?php
                                } else {
                                    ?>  
                                    <option id="<?php echo $answer['answer_id']; ?>" value="<?php echo $answer['answer_id'] ?>"><?php echo $answer_text->answer_text; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>

                        <?php
                    } else {
                        ?>

                        <select name="answer_id" class="answer_section">
                            <option value="" disabled selected>Select Answer</option>

                            <?php
                            foreach ($answers as $answer) {
                                $answer_text = AnswerText::model()->getAnswerText($answer['answer_text_id']);
                                ?>
                                <option id="<?php echo $answer['answer_id']; ?>" value="<?php echo $answer['answer_id'] ?>"><?php echo $answer_text->answer_text; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <?php
                    }

                    echo '</td>';

                    echo '</div>';
                    echo '</div>';
                    echo '</tr>';

                    $count++;
                }

                echo '</table>';
            } else if ($questions['question_type'] == "DRAG_DROP_TYPEA_ANSWER") {
                   
                $question_details = Answer::model()->getAnswersOfQuestion($question['question_id']);
                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                echo '<button onclick="resetDrag();">reset</button>';
                echo '<div class="span5">';
                echo '<table>';
                $count = 0;

                foreach ($question_details as $question_part_answer) {
                    echo '<tr>';
                    echo '<td style="width:100%;padding-bottom:15px;padding-right:15px;font-size: 14px;text-align: justify;">';

                    echo QuestionPart::model()->getQuestionPartText($question_part_answer['question_part_id']);

                    echo '</td>';

                    echo '<td style="width:100%;">';

                    if (isset($question['answer_id'])) {
                        //if (is_array($question['answer_id']) && in_array($question_part_answer['answer_text_id'], $question['answer_id']))
                        echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][$count]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" value="' . $question['answer_id'][$count] . '" style="display: none;"/>';
                    } else {
                        echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" style="display: none;"/>';
                        //echo AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']);
                    }

                    echo '</td>';

                    echo '<td style="width:200px;">';

                    //echo '<div id="'.$question_part_answer['answer_text_id'].'" class="btn" width="150px" height="125px">'.AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']).'</div>';
                    //echo AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']);

                    echo '</td>';
                    echo '</tr>';
                    $count++;
                }

                echo '</td>';

                echo '<td style="width:200px;">';

                //echo '<div id="'.$question_part_answer['answer_text_id'].'" class="btn" width="150px" height="125px">'.AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']).'</div>';
                //echo AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']);

                echo '</td>';
                echo '</tr>';
                $count++;

                echo '</table>';
                echo '</div>';

                echo '<div class="span6">';
                echo '<table frame="box">';

                shuffle($question_details);
                foreach ($question_details as $question_part_answer) {
                    $answer = AnswerText::model()->getAnswertextByAnswerId($question_part_answer['answer_text_id']);
                    $txt = (strlen($answer) > 60) ? substr($answer, 0, 60) . '...' : $answer;
                    echo '<tr>';
                    echo '<td style="width:200px; height: 60px;"><center>';
                    echo '<div title="' . htmlspecialchars($answer) . '" id="' . $question_part_answer['answer_text_id'] . '" class="btn smallbluebtnexam" height="125px">' . $txt . '</div>';
                    echo '</center></td>';
                    echo '</tr>';
                }

                echo '</div>';
                echo '</table>';
            } else if ($questions['question_type'] == "DRAG_DROP_TYPEB_ANSWER") {
            //echo 'xxxxxx';
                $question_details = Answer::model()->getAnswersOfQuestion($question['question_id']);
                $headings = Heading::model()->getHeadingsOfQuestion($question['question_id']);
                $answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';


                $counter = 1;
                shuffle($answer_details);

                echo '<div class="span10" style="position : relative">';
                foreach ($answer_details as $answer_detail) {
                    $answer = AnswerText::model()->getAnswertextByAnswerId($answer_detail['answer_text_id']);
                    $txt = (strlen($answer) > 60) ? substr($answer, 0, 60) . '...' : $answer;
                    echo '<div title="' . htmlspecialchars($answer) . '" id="' . $answer_detail['answer_text_id'] . '" class="btn smallbluebtnexam" height="125px">' . $txt . '</div>&nbsp;&nbsp;';

//                    if ($counter%4 == 0) {
//                        echo "<br/><br/>";
//                    }
                    //echo "<br/><br/>";
                    $counter++;
                }
                echo '</div>';

                echo '<br/><br/>';
                echo '<div class="span5">';



                echo '<br/>';

                echo '<table class="table table-bordered">';
                echo '<tr>';
                if (sizeof($headings) == 2) {
                    echo '<th>';
                    if (isset($headings[0]['heading_text'])) {
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                    }
                    echo '</th>';

                    echo '<th colspan="2">';
                    if (isset($headings[1]['heading_text'])) {
                        echo '<center>' . $headings[1]['heading_text'] . '</center>';
                    } echo '</th>';
                } else if (sizeof($headings) == 1) {

                    if ($headings[0]['heading_position'] == 1) {
                        echo '<th>';
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                        echo '</th>';
                        echo '<th colspan="2">';
                        echo '<center>N/A</center>';
                        echo '</th>';
                    } else if ($headings[0]['heading_position'] == 2) {
                        echo '<th>';
                        echo '<center>N/A</center>';
                        echo '</th>';
                        echo '<th colspan="2">';
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                        echo '</th>';
                    }
                }
                echo '</tr>';

                $iterator = 0;
                $count = 0;
                foreach ($question_details as $question_part_answer) {

                    if ($iterator % 2 == 0) {
                        echo '<tr>';
                        echo '<td style="width:400px;">';
                        echo QuestionPart::model()->getQuestionPartText($question_part_answer['question_part_id']);
                        echo '</td>';

                        echo '<td style="width:400px;">';
                        if (isset($question['answer_id'])) {
                            echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][$count]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" value="' . $question['answer_id'][$count] . '" style="display: none;"/>';
                        } else {
                            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" style="display: none;"/>';
                        }
                        echo '</td>';

                        echo '<td style="width:400px;">';
                        if (isset($question['answer_id'])) {
                            echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][$count + 1]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" value="' . $question['answer_id'][$count + 1] . '" style="display: none;"/>';
                        } else {
                            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" style="display: none;"/>';
                        }
                        echo '</td>';

                        echo '</tr>';

                        $count+=2;
                    }
                    $iterator+=1;
                }
                echo '</table>';
                echo '</div>';
            } else if ($questions['question_type'] == "DRAG_DROP_TYPEC_ANSWER") {

                $question_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                $answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                echo '<div class="span10">';



                foreach ($answer_details as $answer_detail) {
                    $answer = AnswerText::model()->getAnswertextByAnswerId($answer_detail['answer_text_id']);
                    $txt = (strlen($answer) > 60) ? substr($answer, 0, 60) . '...' : $answer;
                    echo '<div title="' . htmlspecialchars($answer) . '" id="' . $answer_detail['answer_text_id'] . '" class="btn smallbluebtnexam" height="125px">' . $txt . '</div>&nbsp;&nbsp;';
                }

                echo '</div>';
                echo '<br/><br/>';
                echo '<div class="span10">';
                echo '<table>';
                $count = 0;
                foreach ($question_details as $question_part_answer) {
                    echo '<tr>';
                    echo '<td style="width:400px;">';

                    echo QuestionPart::model()->getQuestionPartText($question_part_answer['question_part_id']);

                    echo '</td>';

                    echo '<td style="width:400px;">';

                    if (isset($question['answer_id'])) {
                        echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][$count]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" value="' . $question['answer_id'][$count] . '" style="display: none;"/>';
                    } else {
                        echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" style="display: none;"/>';
                    }

                    echo '</td>';
                    echo '</tr>';
                    $count++;
                }
                echo '</table>';
                echo '</div>';
            } else if ($questions['question_type'] == "DRAG_DROP_TYPED_ANSWER") {

                $question_details = Answer::model()->getAnswersOfQuestion($question['question_id']);

                $answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);
                $resultText = Answer::model()->getResultText($question['question_id']);
                $answers = Answer::model()->getCorrectAnswersOfQuestion($question['question_id']);
                $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($question['question_id']);
                $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';

                echo '<div class="span5">';
                ?>

                <table>
                    <tr>
                        <td style="width:400px;">
                    <center><?php
                        if ($answers != null) {
                            echo AnswerText::model()->getAnswerTextById($answers[0]['answer_text_id']);
                        }
                        ?></center>
                </td>
                <td style="width:400px;">
                <center>=</center>
                </td>
                <td style="width:400px;">
                <center><?php echo $questionPart['question_part_name']; ?></center>
                </td>
                <td style="width:400px;">
                <center><?php echo $operators[0]['question_part_text']; ?></center>
                </td>
                <td>
                    <?php
                    if (isset($question['answer_id'])) {
                        echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][0]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" value="' . $question['answer_id'][0] . '" style="display: none;"/>';
                    } else {
                        echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" style="display: none;"/>';
                    }
                    ?>
                </td>
                <td style="width:400px;">
                <center><?php echo $operators[1]['question_part_text']; ?></center>
                </td>
                <td>
                    <?php
                    if (isset($question['answer_id'])) {
                        echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][1]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" value="' . $question['answer_id'][1] . '" style="display: none;"/>';
                    } else {
                        echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                        echo '<input type="text" name="answer_id" style="display: none;"/>';
                    }
                    ?>
                </td>
                </tr>
                </table>

                <?php
                echo '<br/><br/>';
                echo '</div>';
                echo '<div class="span10">';
                $count = 1;

                $other_answers = Answer::model()->getOtherAnswersOfQuestion($question['question_id']);

                if (!empty($other_answers)) {
                    shuffle($other_answers);

                    foreach ($other_answers as $other_answer) {
                        
                        $answer = AnswerText::model()->getAnswertextByAnswerId($other_answer['answer_text_id']);
                        $txt = (strlen($answer) > 60) ? substr($answer, 0, 60) . '...' : $answer;
                        
                        echo '<div title="'.htmlspecialchars($answer).'" id="' . $other_answer['answer_text_id'] . '" class="btn smallbluebtnexam" height="125px">' . $txt . '</div>&nbsp;&nbsp;';
                        $count++;
//                        if ($count == 5) {
//                            echo '<br/><br/>';
//                        }
                    }
                }

//                shuffle($answers);
//                foreach ($answers as $answer) {
//                    if ($answer['question_part_id'] != null) {
//                        echo '<div id="' . $answer['answer_text_id'] . '" class="btn smallbluebtn" width="150px" height="125px">' . AnswerText::model()->getAnswertextByAnswerId($answer['answer_text_id']) . '</div>&nbsp;&nbsp;';
//                    }
//                    if ($count == 3) {
//                        echo '<br/><br/>';
//                    }
//                    $count++;
//                }
                echo '</div>';
            } else if ($questions['question_type'] == "DRAG_DROP_TYPEE_ANSWER") {

                $question_details = Answer::model()->getAnswersOfQuestion($question['question_id']);
                $headings = Heading::model()->getHeadingsOfQuestion($question['question_id']);
                $answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);

                echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';


                $counter = 0;
                shuffle($answer_details);

                echo '<div class="span10">';
                foreach ($answer_details as $answer_detail) {
                    $answer = AnswerText::model()->getAnswertextByAnswerId($answer_detail['answer_text_id']);
                    $txt = (strlen($answer) > 60) ? substr($answer, 0, 60) . '...' : $answer;
                    
                    echo '<div title="'.htmlspecialchars($answer).'" id="' . Answer::model()->getAnswerTextAnswerId($answer_detail['answer_text_id']) . '" class="btn smallbluebtnexam" height="125px">' .$txt. '</div>&nbsp;&nbsp;';
//                    if ($counter == 4) {
//                        echo '<br/><br/>';
//                    }
                    $counter++;
                }
                echo '</div>';

                echo '<br/><br/>';
                echo '<div class="span5">';



                echo '<br/>';

                echo '<table class="table table-bordered">';
                echo '<tr>';
                if (sizeof($headings) == 2) {
                    echo '<th>';
                    echo '</th>';
                    echo '<th>';
                    if (isset($headings[0]['heading_text'])) {
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                    }
                    echo '</th>';

                    echo '<th colspan="2">';
                    if (isset($headings[1]['heading_text'])) {
                        echo '<center>' . $headings[1]['heading_text'] . '</center>';
                    } echo '</th>';
                } else if (sizeof($headings) == 1) {

                    if ($headings[0]['heading_position'] == 1) {
                        echo '<th>';
                        echo '</th>';
                        echo '<th>';
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                        echo '</th>';
                        echo '<th colspan="2">';
                        echo '<center>N/A</center>';
                        echo '</th>';
                    } else if ($headings[0]['heading_position'] == 2) {
                        echo '<th>';
                        echo '</th>';
                        echo '<th>';
                        echo '<center>N/A</center>';
                        echo '</th>';
                        echo '<th colspan="2">';
                        echo '<center>' . $headings[0]['heading_text'] . '</center>';
                        echo '</th>';
                    }
                }
                echo '</tr>';

                $iterator = 0;
                $count = 0;
                foreach ($question_details as $question_part_answer) {

                    if ($question_part_answer['question_part_id'] != null) {
                        echo '<tr>';
                        echo '<td style="width:400px;">';

                        echo QuestionPart::model()->getQuestionPartText($question_part_answer['question_part_id']);
                        echo '</td>';

                        $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($question_part_answer['question_part_id']);

                        echo '<td style="width:400px;">';
                        echo $questionPartText['question_part_text'];
                        echo '</td>';

                        echo '<td style="width:400px;">';
                        if (isset($question['answer_id'])) {
                            echo '<input type="text" name="answer_text" class="droppable" value="' . AnswerText::model()->getAnswertextByAnswerId($question['answer_id'][$count]) . '" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" value="' . $question['answer_id'][$count] . '" style="display: none;"/>';
                        } else {
                            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                            echo '<input type="text" name="answer_id" style="display: none;"/>';
                        }
                        echo '</td>';
                        echo '</tr>';
                        $count+=1;
                    }
                }
                echo '</table>';
                echo '</div>';
            } else if ($questions['question_type'] == "HOT_SPOT_ANSWER") {

                if (isset($question['answer_id']) || $question['answer_id'] != NULL) {
                    //var_dump($question['answer_id']); die;
                    echo '<style>    

                    img.map, map area{    
                        outline: none; 
                    }

                    img.map:hover{
                        display: none;
                    }
                </style>';



                    $counter = 0;
                    $question_details = Question::model()->getHotspotQuestionsId($question['question_id']);

                    echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                    $coords = '';  //get coordinate string from db

                    foreach ($question_details as $details) {
                        $coords = $details['coordinates'];


                        echo '<style>
                                .overlays{
                                 position: absolute;
                                } 
                             </style>';

                        echo '<div class="sameImge">';
                        echo '<img id="myImage2" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $details['hotspot_id'] . '/' . $details['image_name'] . '" style="max-width:600px; max-height:400px" usemap="#image_map"  />';

                        $pieces = explode("/", $coords);

                        echo '<map name="image_map">';
                        foreach ($pieces as $k => $value) {

                            echo '<area class="map1' . $question['question_id'] . $k . '" shape="poly" coords="' . $value . '">';
                        }

                        echo '</map>';
                        echo '<input type="hidden" id="answer_count" value="' . count($pieces) . '">';
                        echo '</div>';

                        $answer_id = isset($question['answer_id'][$counter]) ? $question['answer_id'][$counter] : "";
                        echo '<input type="text" id="hotspot_areaId" name="answer_id" value="' . $answer_id . '" style="display: none;"/>';
//                         echo '<input type="text" id="hotspot_areaId" style="display: none;" />';
                        $counter++;
                    }
                } else {

                    $question_details = Question::model()->getHotspotQuestionsId($question['question_id']);

                    echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';

                    $coords = '';  //get coordinate string from db

                    foreach ($question_details as $details) {
                        $coords = $details['coordinates'];

                        echo '<div class="sameImge">';
                        echo '<img id="myImage2" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $details['hotspot_id'] . '/' . $details['image_name'] . '" style="max-width:600px; max-height:400px" usemap="#image_map"  />';

                        $pieces = explode("/", $coords);

                        echo '<map name="image_map">';
                        foreach ($pieces as $k => $value) {

                            echo '<area class="map1' . $question['question_id'] . $k . '" shape="poly" coords="' . $value . '">';
                        }
                        echo '</map>';
                        echo '<input type="hidden" id="answer_count" value="' . count($pieces) . '">';
                        echo '</div>';
                    }

                    echo '<style>    

                    img.map, map area{    
                        outline: none; 
                    }

                    img.map:hover{
                        display: none;
                    }
                </style>';

                    echo '<input type="text" id="hotspot_areaId" name="answer_id" value="" style="display: none;"/>';
//                    echo '<input type="text" id="nextHotspot_areaId" style="display: none;" />';
                }
            }

            echo '</div>';
        }
    }
}
?>
<script type="text/javascript">
    function isDivOverflow() {

    }

</script>







