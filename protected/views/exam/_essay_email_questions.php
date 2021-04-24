<?php

$exam_question_session = Yii::app()->session['exam_question_session'];
//echo $question_number;
foreach ($exam_question_session as $key => $question) {
    if ($question_number == $question['question_number']) {

        $question_details=  Question::model()->getQuestionsByQuestionId($question['question_id']);

        foreach ($question_details as $questions) {

            foreach ($question_details as $questions) {

                echo '<div id="exam_question_container">';

                echo '<br />';
                echo '<div class="span10" style="margin-left: 0px">';
//                echo '<b><u>Question ' . $question['question_number'] . '</u></b>';
                echo $questions['question_text'];
                echo '</div>';
                echo '<br />';
                $email_details = EmailEssayHeader::model()->getEmailEssayHeaderDetailsByQuestionId($question['question_id']);
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
                if ($questions['question_type'] == "ESSAY_ANSWER") {
                    echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                }


                echo '</div>';
            }
        }
    }
}
?>

