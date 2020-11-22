<!--
SINGLE_ANSWER
MULTIPLE_ANSWER
SHORT_WRITTEN
DRAG_DROP_TYPEA_ANSWER
DRAG_DROP_TYPEB_ANSWER
DRAG_DROP_TYPEC_ANSWER
DRAG_DROP_TYPED_ANSWER
DRAG_DROP_TYPEE_ANSWER
MULTIPLE_CHOICE_ANSWER
TRUE_OR_FALSE_ANSWER
-->

<div><?php //echo "Type : " . $question->question_type . "<br/><br/>"; ?></div>
<br/>
<div class="well">
    <div><b>Question :</b></div>
    <div><?php echo $question->question_text ?></div>

    <?php
    if ($question->question_type == "SHORT_WRITTEN" || $question->question_type == "MULTIPLE_CHOICE_ANSWER"
            || $question->question_type == "DRAG_DROP_TYPEA_ANSWER" || $question->question_type == "DRAG_DROP_TYPEB_ANSWER" ||
            $question->question_type == "DRAG_DROP_TYPEC_ANSWER" || $question->question_type == "DRAG_DROP_TYPEE_ANSWER"
            || $question->question_type == "MULTIPLE_CHOICE_ANSWER") {
        ?>
        <div>
            <b>Question part and answer</b>
            <?php foreach ($answers as $answer) { ?>
                <?php if ($answer->is_correct == 1) { ?>
                    <div><?php echo $answer->questionPart->question_part_name ?> : <?php echo $answer->answerText->answer_text ?></div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php
    }

    if ($question->question_type == "TRUE_OR_FALSE_ANSWER") {
        echo "<b>Answer : </b>";
        foreach ($answers as $answer) {
            if ($answer->is_correct == 1) {
                echo "True";
            } else {
                echo "False";
            }
        }
    }

    if ($question->question_type == "MULTIPLE_ANSWER") {
        echo "<b>Answers : </b>";
        foreach ($answers as $answer) {
            if ($answer->is_correct == 1) {
                echo "<div>" . $answer->answerText->answer_text . "</div>";
            }
        }
    }

    if ($question->question_type == "SINGLE_ANSWER") {
        echo "<b>Answers : </b>";
        foreach ($answers as $answer) {
            if ($answer->is_correct == 1) {
                ?>
                <div>
                    <?php
                    if ($answer->answer_text_id != "") {
                        echo $answer->answerText->answer_text . "<br/>";
                    }
                    if ($answer->image_answer != "") {
                        echo "<img src='images/single_answer_images/" . $answer->image_answer . "'>";
                    }
                    ?>
                </div>
                <?php
            }
        }
    }

    if ($question->question_type == "DRAG_DROP_TYPED_ANSWER") {
        echo "<b>Answers : </b>";
        $correct_answer="";
        $number_1="";
        $question_part_id="";
        $number_2_and_3=array();
        
        foreach ($answers as $answer) {
            if($answer->question_part_id=="" && $answer->is_correct==1){
                $correct_answer=$answer->answerText->answer_text;
            }
            if($answer->question_part_id!="" ){
                $question_part_id=$answer->question_part_id;
                $number_1=$answer->questionPart->question_part_name;
                $number_2_and_3[]=$answer->answerText->answer_text;
            }
            
        }
        
        $operators=  QuestionPartText::model()->getQuestionPartTextByQuestionPartID($question_part_id);
        
        echo $correct_answer." = ".$number_1." ".$operators[0]->question_part_text." ".$number_2_and_3[0]." ".$operators[1]->question_part_text." ".$number_2_and_3[1];
        //getQuestionPartTextByQuestionPartID
    }
    ?>

</div>
