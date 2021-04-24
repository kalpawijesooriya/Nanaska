<?php

$exam_question_session = Yii::app()->session['exam_question_session'];
//echo $question_number;
//echo '<br />';
foreach ($exam_question_session as $key => $question) {
    if ($question_number == $question['question_number']) {


        $question_details = Question::model()->getQuestionsByQuestionId($question['question_id']);

        foreach ($question_details as $questions) {

            foreach ($question_details as $questions) {


                echo '<div id="exam_question_container">';

                echo '<br />';

//                echo '<b><u>Question ' . $question['question_number'] . '</u></b>';

                echo $questions['question_text'];

                if ($questions['question_type'] == "ESSAY_ANSWER") {
                    echo '<input type="hidden" id="question_count_key" name="question_count_key" value="' . $key . '">';
                }


                echo '</div>';
            }
        }
    }
}