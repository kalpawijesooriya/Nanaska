<div>
    <table>
        <tr>
            <td width="600"><img src="assets/img/logo.png" width="175" height="100"></td>                
        </tr>
    </table>
</div>
<hr>
<div class="control-group" id="paper">
    <table class="table" id="exam_paper">

        <tr>
            <td colspan="1"><b>Exam Name</b></td><td colspan="3"><?php echo $model->exam_name ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Course</b></td><td colspan="3"><?php echo Course::model()->getCourseName(Subject::model()->getCourseOfSubject($model->subject_id)) ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Level</b></td><td colspan="3"><?php echo Level::model()->getLevelName(Subject::model()->getLevelOfSubject($model->subject_id)) ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Subject</b></td><td colspan="3"><?php echo Subject::model()->getSubjectName($model->subject_id) ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Exam Type</b></td><td colspan="3"><?php echo $model->exam_type ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Time</b></td><td colspan="3"><?php echo $model->time ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Marks Per Question</b></td><td colspan="3"><?php echo $model->marks_per_question ?></td>
        </tr>
        <tr>
            <td colspan="1"><b>Pass Mark</b></td><td colspan="3"><?php echo $model->pass_mark ?></td>
        </tr>
    </table>
    <br/>

    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>
    <br/><br/>

    <?php
    if ($model->exam_type == "PRESET" || $model->exam_type == "SAMPLE") {
        $examQuestions = Exam::getQuestionsOfExamById($model->exam_id);
        if ($examQuestions != null) {
            foreach ($examQuestions as $key => $examQuestion) {
                $questionData = Question::model()->getQuestion($examQuestion['question_id']);
                if ($questionData['question_type'] == "SINGLE_ANSWER") {
                    $single_answer_data = AnswerText::model()->getAnswerTextForQuestion($examQuestion['question_id']);
                    $single_answer_images = Answer::model()->getQuestionPartsforQuestionView($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>


                        <?php
                        foreach ($single_answer_data as $single_data) {
                            if ($single_data->answer_text != "") {

                                echo '<div class="control-group">';
                                echo '<div class="control-label">';

                                echo '<input type="radio" name="answer_id" disabled/>' . $single_data->answer_text;

                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        foreach ($single_answer_images as $single_images) {
                            if ($single_images->image_answer == NULL) {
                                
                            } else {
                                echo '<div class="control-group">';
                                echo '<div class="control-label">';

                                if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/single_answer_images/' . $single_images->image_answer)) {
                                    echo '<input type="checkbox" name="answer_id" disabled/>';
                                    echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/single_answer_images/' . $single_images->image_answer . '" alt="image" style="width:200px; height:72px"/>';
                                } else {
                                    echo '<input type="checkbox" name="answer_id" disabled/> No Image';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "MULTIPLE_ANSWER") {
                    $single_answer_data = AnswerText::model()->getAnswerTextForQuestion($examQuestion['question_id']);
                    $single_answer_images = Answer::model()->getQuestionPartsforQuestionView($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>


                        <?php
                        foreach ($single_answer_data as $single_data) {
                            if ($single_data->answer_text != "") {

                                echo '<div class="control-group">';
                                echo '<div class="control-label">';

                                echo '<input type="checkbox" name="answer_id" disabled/>' . $single_data->answer_text;

                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        foreach ($single_answer_images as $single_images) {
                            if ($single_images->image_answer == NULL) {
                                
                            } else {
                                echo '<div class="control-group">';
                                echo '<div class="control-label">';


                                if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/multiple-answer-images/' . $single_images->image_answer)) {
                                    echo '<input type="checkbox" name="answer_id" disabled/>';
                                    echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/multiple-answer-images/' . $single_images->image_answer . '" alt="image" style="width:200px; height:72px"/>';
                                } else {
                                    echo '<input type="checkbox" name="answer_id" disabled/> No Image';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "SHORT_WRITTEN") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    ?>

                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                foreach ($headings as $heading) {
                                    echo '<td>';
                                    echo $heading['heading_text'];
                                    echo '</td>';
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEA_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($questionParts);
                            foreach ($questionParts as $questionPart) {
                                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $examQuestion['question_id']);
                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEB_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);

                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {
                                    if ($i == 1) {
                                        echo '<td colspan="2">';
                                    } else {
                                        echo '<td>';
                                    }
                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($questionParts);
                            foreach ($questionParts as $questionPart) {
                                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $examQuestion['question_id']);
                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEC_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $answer_details = Answer::model()->getDistinctAnswersOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($answer_details);
                            foreach ($answer_details as $answer_detail) {

                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($answer_detail['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPED_ANSWER") {
                    $resultText = Answer::model()->getResultText($examQuestion['question_id']);

                    $answers = Answer::model()->getCorrectAnswersOfQuestion($examQuestion['question_id']);
                    $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($examQuestion['question_id']);

                    $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <td>
                                    <?php echo AnswerText::model()->getAnswerTextById(isset($answers[0]['answer_text_id']) ? $answers[0]['answer_text_id'] : " "); ?>
                                </td>
                                <td>
                                    =
                                </td>
                                <td>
                                    <?php echo $questionPart['question_part_name']; ?>
                                </td>
                                <td>
                                    <?php echo $operators[0]['question_part_text']; ?>
                                </td>
                                <td>
                                    <input type="text" name="answer_id" disabled/>
                                </td>
                                <td>
                                    <?php echo $operators[1]['question_part_text']; ?>
                                </td>
                                <td>
                                    <input type="text" name="answer_id" disabled/>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            $other_answers = Answer::model()->getOtherAnswersOfQuestion($examQuestion['question_id']);

                            if (!empty($other_answers)) {
                                shuffle($other_answers);

                                foreach ($other_answers as $other_answer) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo AnswerText::model()->getAnswerTextById($other_answer['answer_text_id']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEE_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);

                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    //$answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <td>

                                </td>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {

                                    echo '<td>';

                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';
                                $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($questionPart['question_part_id']);
                                echo '<td>';
                                echo $questionPartText['question_part_text'];
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            $other_answers = Answer::model()->getOtherAnswersOfQuestion($examQuestion['question_id']);

                            if (!empty($other_answers)) {
                                shuffle($other_answers);

                                foreach ($other_answers as $other_answer) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo AnswerText::model()->getAnswerTextById($other_answer['answer_text_id']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "MULTIPLE_CHOICE_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $rawSize = 0;
                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    $x = 0;
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {

                                    echo '<td>';

                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                        </table>
                        <?php
                        foreach ($questionParts as $questionPart) {
                            echo '<table>';
                            $answers = Answer::model()->getAnswersOfQuestionPart($questionPart['question_part_id']);
                            $rows = sizeof($answers) + 1;
                            ?>
                            <tr>
                                <td rowspan="<?php echo $rows; ?>">
                                    <?php echo $questionPart['question_part_name']; ?>
                                </td>
                                <td>

                                </td>

                            </tr>
                            <?php
                            foreach ($answers as $answer) {
                                $answer_text = AnswerText::model()->getAnswerText($answer['answer_text_id']);
                                echo '<tr>';

                                echo '<td>';
                                echo '<input type="checkbox" name="answer_id" disabled/>' . $answer_text['answer_text'];
                                echo '</td>';

                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '<br/>';
                        }
                        ?>


                    </div>

                    <?php
                } else if ($questionData['question_type'] == "TRUE_OR_FALSE_ANSWER") {
                    $answer_details = Answer::model()->getAnswersOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <?php
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';

                        echo '<input type="radio" name="answer_id" disabled/> True';

                        echo '</div>';
                        echo '</div>';
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';

                        echo '<input type="radio" name="answer_id" disabled/> False';

                        echo '</div>';
                        echo '</div>';
                        ?>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "HOT_SPOT_ANSWER") {
                    $question_details = Question::model()->getHotspotQuestionsId($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <?php
                        echo '<div class="sameImge" style="width:auto; height:400px">';
                        if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/hotspot_answer_images/' . $question_details[0]['hotspot_id'] . '/' . $question_details[0]['image_name'])) {
                            echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/hotspot_answer_images/' . $question_details[0]['hotspot_id'] . '/' . $question_details[0]['image_name'] . '" alt="image" style="width:auto; height:400px" usemap="#image_map"/>';
                        } else {
                            echo 'No Image';
                        }
                        echo '</div>';
                        ?>
                    </div>
                    <?php
                }
                ?>
                <br/><br/>
                <?php
            }
        }
    } else if ($model->exam_type == "ESSAY") {
        $examQuestions = Exam::model()->getQuestionsOfExamById($model->exam_id);
        if ($examQuestions != null) {
            foreach ($examQuestions as $key => $examQuestion) {
                $questionData = Question::model()->getQuestion($examQuestion['question_id']);
                ?>
                <div class="container" id="exam_question_container">

                    <u>Question <?php echo ($key + 1) ?></u>
                    <?php
                    echo $questionData['question_text'];
                    echo '</b>';
                    if (EssayQuestion::model()->getEmailEssayDetailsByQuestionId($examQuestion['question_id']) == "EMAIL") {
                        $email_details = EmailEssayHeader::model()->getEmailEssayHeaderDetailsByQuestionId($examQuestion['question_id']);
                        echo '<div class="span10" style="margin-left: 0px">';
                        echo '<table class="table  well">';
                        echo '<tr>';
                        echo '<td style="width: 30px">';
                        echo "<b>From:</b>";
                        echo '</td>';
                        echo '<td>';
                        echo $email_details['from_field'];
                        echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>';
                        echo "<b>To:</b>";
                        echo '</td>';
                        echo '<td>';
                        echo $email_details['to_field'];
                        echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>';
                        echo "<b>Cc:</b>";
                        echo '</td>';
                        echo '<td>';
                        echo $email_details['cc_field'];
                        echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>';
                        echo "<b>Subject:</b>";
                        echo '</td>';
                        echo '<td>';
                        echo $email_details['subject_field'];
                        echo '</td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                    }
                    ?>

                    <?php
                    echo '<div class="sameImge" style="width:auto; height:200px">';
                    echo '</div>';
                    ?>
                </div>
                <?php
            }
        }
    } else if ($model->exam_type == "DYNAMIC") {
        $exam_questions = Exam::model()->getQuestionsOfDynamicExamById($model->exam_id);

        foreach ($exam_questions as $key => $examQuestion) {
            $questionData = Question::model()->getQuestion($examQuestion['question_id']);
            if ($questionData['question_type'] == "SINGLE_ANSWER") {
                $single_answer_data = AnswerText::model()->getAnswerTextForQuestion($examQuestion['question_id']);
                $single_answer_images = Answer::model()->getQuestionPartsforQuestionView($examQuestion['question_id']);
                ?>
                <div class="container" id="exam_question_container">

                    <u>Question <?php echo ($key + 1) ?></u>
                    <?php echo $questionData['question_text']; ?>


                    <?php
                    foreach ($single_answer_data as $single_data) {
                        if ($single_data->answer_text != "") {

                            echo '<div class="control-group">';
                            echo '<div class="control-label">';

                            echo '<input type="radio" name="answer_id" disabled/>' . $single_data->answer_text;

                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    foreach ($single_answer_images as $single_images) {
                        if ($single_images->image_answer == NULL) {
                            
                        } else {
                            echo '<div class="control-group">';
                            echo '<div class="control-label">';

                            if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/single_answer_images/' . $single_images->image_answer)) {
                                echo '<input type="checkbox" name="answer_id" disabled/>';
                                echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/single_answer_images/' . $single_images->image_answer . '" alt="image" style="width:200px; height:72px"/>';
                            } else {
                                echo '<input type="checkbox" name="answer_id" disabled/> No Image';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <?php
            }else if ($questionData['question_type'] == "MULTIPLE_ANSWER") {
                    $single_answer_data = AnswerText::model()->getAnswerTextForQuestion($examQuestion['question_id']);
                    $single_answer_images = Answer::model()->getQuestionPartsforQuestionView($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>


                        <?php
                        foreach ($single_answer_data as $single_data) {
                            if ($single_data->answer_text != "") {

                                echo '<div class="control-group">';
                                echo '<div class="control-label">';

                                echo '<input type="checkbox" name="answer_id" disabled/>' . $single_data->answer_text;

                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        foreach ($single_answer_images as $single_images) {
                            if ($single_images->image_answer == NULL) {
                                
                            } else {
                                echo '<div class="control-group">';
                                echo '<div class="control-label">';


                                if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/multiple-answer-images/' . $single_images->image_answer)) {
                                    echo '<input type="checkbox" name="answer_id" disabled/>';
                                    echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/multiple-answer-images/' . $single_images->image_answer . '" alt="image" style="width:200px; height:72px"/>';
                                } else {
                                    echo '<input type="checkbox" name="answer_id" disabled/> No Image';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "SHORT_WRITTEN") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    ?>

                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                foreach ($headings as $heading) {
                                    echo '<td>';
                                    echo $heading['heading_text'];
                                    echo '</td>';
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEA_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($questionParts);
                            foreach ($questionParts as $questionPart) {
                                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $examQuestion['question_id']);
                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEB_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);

                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {
                                    if ($i == 1) {
                                        echo '<td colspan="2">';
                                    } else {
                                        echo '<td>';
                                    }
                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($questionParts);
                            foreach ($questionParts as $questionPart) {
                                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $examQuestion['question_id']);
                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEC_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $answer_details = Answer::model()->getDistinctAnswersOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';


                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            shuffle($answer_details);
                            foreach ($answer_details as $answer_detail) {

                                echo '<tr>';
                                echo '<td>';
                                echo AnswerText::model()->getAnswerTextById($answer_detail['answer_text_id']);
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPED_ANSWER") {
                    $resultText = Answer::model()->getResultText($examQuestion['question_id']);

                    $answers = Answer::model()->getCorrectAnswersOfQuestion($examQuestion['question_id']);
                    $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($examQuestion['question_id']);

                    $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <td>
                                    <?php echo AnswerText::model()->getAnswerTextById(isset($answers[0]['answer_text_id']) ? $answers[0]['answer_text_id'] : " "); ?>
                                </td>
                                <td>
                                    =
                                </td>
                                <td>
                                    <?php echo $questionPart['question_part_name']; ?>
                                </td>
                                <td>
                                    <?php echo $operators[0]['question_part_text']; ?>
                                </td>
                                <td>
                                    <input type="text" name="answer_id" disabled/>
                                </td>
                                <td>
                                    <?php echo $operators[1]['question_part_text']; ?>
                                </td>
                                <td>
                                    <input type="text" name="answer_id" disabled/>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            $other_answers = Answer::model()->getOtherAnswersOfQuestion($examQuestion['question_id']);

                            if (!empty($other_answers)) {
                                shuffle($other_answers);

                                foreach ($other_answers as $other_answer) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo AnswerText::model()->getAnswerTextById($other_answer['answer_text_id']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "DRAG_DROP_TYPEE_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);

                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    //$answer_details = Answer::model()->getDistinctAnswersOfQuestion($question['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <td>

                                </td>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {

                                    echo '<td>';

                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($questionParts as $questionPart) {
                                echo '<tr>';
                                echo '<td>';
                                echo $questionPart['question_part_name'];
                                echo '</td>';
                                $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($questionPart['question_part_id']);
                                echo '<td>';
                                echo $questionPartText['question_part_text'];
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="text" name="answer_id" disabled/>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <br/>
                        <b>
                            Answers
                        </b>
                        <table>
                            <?php
                            $other_answers = Answer::model()->getOtherAnswersOfQuestion($examQuestion['question_id']);

                            if (!empty($other_answers)) {
                                shuffle($other_answers);

                                foreach ($other_answers as $other_answer) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo AnswerText::model()->getAnswerTextById($other_answer['answer_text_id']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else if ($questionData['question_type'] == "MULTIPLE_CHOICE_ANSWER") {
                    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($examQuestion['question_id']);
                    $rawSize = 0;
                    $headings = Heading::model()->getHeadingsOfQuestion($examQuestion['question_id']);
                    $x = 0;
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <table>
                            <tr>
                                <?php
                                $i = 0;
                                foreach ($headings as $heading) {

                                    echo '<td>';

                                    echo $heading['heading_text'];
                                    echo '</td>';
                                    $i++;
                                }
                                ?>
                            </tr>
                        </table>
                        <?php
                        foreach ($questionParts as $questionPart) {
                            echo '<table>';
                            $answers = Answer::model()->getAnswersOfQuestionPart($questionPart['question_part_id']);
                            $rows = sizeof($answers) + 1;
                            ?>
                            <tr>
                                <td rowspan="<?php echo $rows; ?>">
                                    <?php echo $questionPart['question_part_name']; ?>
                                </td>
                                <td>

                                </td>

                            </tr>
                            <?php
                            foreach ($answers as $answer) {
                                $answer_text = AnswerText::model()->getAnswerText($answer['answer_text_id']);
                                echo '<tr>';

                                echo '<td>';
                                echo '<input type="checkbox" name="answer_id" disabled/>' . $answer_text['answer_text'];
                                echo '</td>';

                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '<br/>';
                        }
                        ?>


                    </div>

                    <?php
                } else if ($questionData['question_type'] == "TRUE_OR_FALSE_ANSWER") {
                    $answer_details = Answer::model()->getAnswersOfQuestion($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <?php
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';

                        echo '<input type="radio" name="answer_id" disabled/> True';

                        echo '</div>';
                        echo '</div>';
                        echo '<div class="control-group">';
                        echo '<div class="control-label">';

                        echo '<input type="radio" name="answer_id" disabled/> False';

                        echo '</div>';
                        echo '</div>';
                        ?>
                    </div>
                    <?php
                }else if ($questionData['question_type'] == "HOT_SPOT_ANSWER") {
                    $question_details = Question::model()->getHotspotQuestionsId($examQuestion['question_id']);
                    ?>
                    <div class="container" id="exam_question_container">

                        <u>Question <?php echo ($key + 1) ?></u>
                        <?php echo $questionData['question_text']; ?>

                        <?php
                        echo '<div class="sameImge" style="width:auto; height:400px">';
                        if (@getimagesize(Yii::app()->getBaseUrl(true) . '/images/hotspot_answer_images/' . $question_details[0]['hotspot_id'] . '/' . $question_details[0]['image_name'])) {
                            echo '<img src="' . Yii::app()->getBaseUrl(true) . '/images/hotspot_answer_images/' . $question_details[0]['hotspot_id'] . '/' . $question_details[0]['image_name'] . '" alt="image" style="width:auto; height:400px" usemap="#image_map"/>';
                        } else {
                            echo 'No Image';
                        }
                        echo '</div>';
                        ?>
                    </div>
                    <?php
                }
                ?>
                <br/><br/>
                <?php
        }
    }
    ?>

</div>
