<?php

$question = Question::model()->getQuestion($question_id);

echo $question['question_logic'];