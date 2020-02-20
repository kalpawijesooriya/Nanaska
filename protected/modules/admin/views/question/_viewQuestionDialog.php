<?php

                $model=Question::model()->findByPk((int)$question_id);

//echo $question_id;



//echo '<h4 class="light_heading">View Question '.$question_id.'</h4><hr>';
echo html_entity_decode($model->question_text);
echo '<br/>';
?>

<?php
if ($model->question_type == "SHORT_WRITTEN") {
    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

//    echo '<br/>';
    echo '<table>';

    $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);

    echo '<tr>';
//    print_r($headings);

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
//    echo '<tr><td></td></tr>';
//    print_r($questionParts);

    foreach ($questionParts as $questionPart) {
        echo '<tr>';
        echo '<td>';
        echo $questionPart['question_part_name'];
        echo '</td>';

        $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

//        print_r($questionPartAnswer);

        echo '<td>&nbsp;&nbsp;';
        ?>
        <input type="text" value="<?php echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']); ?>" readonly=""/>
        <?php
        echo '</td>';
        echo '</tr>';
    }


    echo '</table>';
//    print_r($questionParts);
} else
if ($model->question_type == "DRAG_DROP_TYPEA_ANSWER") {

    $questionParts = QuestionPart::model()->getQuestionPartsOfQuestion($model->question_id);

//    print_r($questionParts);
    ?>

    <div class="span4">
        <div class="row">
            <table>

                <?php
                foreach ($questionParts as $questionPart) {
                    $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
                    ?>
                    <tr style="height: 60px">
                        <td><?php echo $questionPart['question_part_name'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><button class="bluebtn" type="button"><?php echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']); ?></button></td>
                    </tr>
                    <?php
                }
                ?>
            </table>    
        </div>
    </div>
    <div class="span4">

        <div class="dragAwell">

            <?php
            shuffle($questionParts);
            foreach ($questionParts as $questionPart) {
                $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
                ?>
                <button class="greybtn" type="button"><?php echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']); ?></button><br/><br/>

                <?php
            }
            ?>

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

//        $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
        echo '<td>&nbsp;&nbsp;';
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--<input type="text" value="<?php // echo $questionPartAnswer['answer_text'];                                                     ?>" readonly=""/>-->


        <?php
        $answers = Answer::model()->getAnswersOfQuestionPart($questionPart['question_part_id']);

//        print_r($answers);
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
                } if ($answer['is_correct'] == 0) {
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
    } else if ($answer['is_correct'] == 3   ) {
        ?>
        <input type="radio" name="answer" value="true" disabled=""/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="answer" value="false" disabled=""/>&nbsp;&nbsp;False
        <?php
    }
} else if ($model->question_type == "SINGLE_ANSWER") {
    $single_answer_data = AnswerText::getAnswerTextForQuestion($model->question_id);

    $single_answer_images = Answer::getQuestionPartsforQuestionView($model->question_id);

    echo '<table class="table table-hover">';



    foreach ($single_answer_data as $single_data) {
        $is_correct = Answer::model()->getIsCorrectAnswers($single_data->answer_text_id);

        if ($is_correct['is_correct'] == 1) {
            echo '<tr><td><input type="checkbox" checked="checked" onclick="return false"/></td>  <td><span>' . $single_data->answer_text . '</span></td></tr>';
        } else {
            echo '<tr><td><input type="checkbox" onclick="return false"/></td>   <td><span>' . $single_data->answer_text . '</span></td></tr>';
        }
    }

    foreach ($single_answer_images as $single_images) {
        //$is_correct = Answer::model()->getIsCorrectAnswers($mul_images->answer_id);
        if ($single_images->image_answer == NULL) {
            break;
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
    $multiple_answer_data = AnswerText::getAnswerTextForQuestion($model->question_id);

    $multiple_answer_images = Answer::getQuestionPartsforQuestionView($model->question_id);

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
            break;
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
    //$answers = Answer::getQuestionPartsforQuestionView($model->question_id);
    $question_parts = QuestionPart::getQuestionPartsforQuestionView($model->question_id);

//    foreach($answers as $answer)
//    {        
//        $answer_texts[] = $answer->answer_text_id;
//    }
    foreach ($question_parts as $question_part) {
        $question_part_texts_b[] = $question_part->question_part_id;
    }

    $ques_part_count = count($question_part_texts_b);
    // $answer_count = count($answer_texts);
    //echo $ques_part_count;
    //echo $answer_count;
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <?php
                foreach ($headings as $heading) {
                    if ($heading['heading_position'] == 1) {
                        echo '<th>' . $heading->heading_text . '</th>';
                    } else {
                        echo '<th colspan="2"><center>' . $heading->heading_text . '</center></th>';
                    }
                }
                ?>                                       
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < $ques_part_count; $i++) {
                echo '<tr>';
                echo '<td class="span6">' . QuestionPart::getQuestionPartText($question_part_texts_b[$i]) . '</td>';
                $answers = Answer::getAnswersforQuestionPartid($question_part_texts_b[$i]);
                foreach ($answers as $answer) {

                    $answer_id[] = $answer->answer_text_id;
                }

                $answer_count = count($answer_id);

                for ($c = 0; $c < $answer_count; $c++) {
                    ?>



                <td  class="span5"><center><button class="bluebtn"><?php echo AnswerText::getAnswerTextById($answer_id[$c]); ?></button></center></td>
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
            echo '<button class="greybtn style="width:200px;margin:10px 10px 10px 10px;">' . $answer_text->answer_text . '</button>';

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
            ?>
            <button class="greybtn"><?php echo $answer->answer_text ?></button>
            <?php
            if ($i == 3) {
                echo '<br/><br/>';
            }
            $i++;
        }
        ?>
    </div>


    <!--<h4>Question Parts</h4>-->

    <!--  display questions -->


    <table>

        <?php
        foreach ($answers_data as $answer) {
//                    echo "<pre>";
//                    print_r($answer->questionPart->question_part_name);die();
            echo '<tr>';
            echo '<td>';

            echo $answer->questionPart->question_part_name;
            ?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <?php
            echo '</td>';
            echo '<td>';
            ?>

            <button class="bluebtn"><?php echo $answer->answerText->answer_text; ?></button>

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

//    echo '<br/>';
    echo '<table border="1">';

    $headings = Heading::model()->getHeadingsOfQuestion($model->question_id);

    echo '<tr>';
    echo '<td>';
    echo '</td>';
//    print_r($headings);

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
//    echo '<tr><td></td></tr>';
//    print_r($questionParts);

    foreach ($questionParts as $questionPart) {
        echo '<tr>';
        echo '<td width="200px"><center>';
        echo $questionPart['question_part_name'];
        echo '</center></td>';

        $questionPartText = QuestionPartText::model()->getQuestionPartTextsOfQuestion($questionPart['question_part_id']);

        echo '<td width="200px"><center>';
        echo $questionPartText['question_part_text'];
        echo '</center></td>';

        $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);

//        print_r($questionPartAnswer);

        echo '<td width="200px"><center>';
        ?>
        <button class="bluebtn"><?php echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']); ?></button>
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

//    echo '<pre>';
//    print_r($other_answers);
//    echo '</pre>';

        if (!empty($other_answers)) {
            shuffle($other_answers);

            foreach ($other_answers as $other_answer) {
                $other_answer_text = AnswerText::model()->getAnswerText($other_answer['answer_text_id']);
                ?>
                <button class="greybtn" type="button"><?php echo $other_answer_text['answer_text'] ?></button>
                <?php
                $count++;
            }
        }


        shuffle($questionParts);
        foreach ($questionParts as $questionPart) {
            $questionPartAnswer = Answer::model()->getAnswerOfQuestionPart($questionPart['question_part_id'], $model->question_id);
            ?>
            <button class="greybtn" type="button"><?php echo AnswerText::model()->getAnswerTextById($questionPartAnswer['answer_text_id']); ?></button>

            <?php
            if ($count == 3) {
                echo '<br/><br/>';
            }
            $count++;
        }
        ?>

    </div>

    <?php
//    print_r($questionParts);
} else if ($model->question_type == 'DRAG_DROP_TYPED_ANSWER') {

    $resultText = Answer::model()->getResultText($model->question_id);

    $answers = Answer::model()->getCorrectAnswersOfQuestion($model->question_id);

//    echo '<pre>';
//    print_r($answers);
//    echo '</pre>';


    $questionPart = QuestionPart::model()->getQuestionPartOfQuestion($model->question_id);

    $operators = QuestionPartText::model()->getOperatorsOfQuestion($questionPart['question_part_id']);

//    echo '<pre>';
//    print_r($operators);
//    echo '</pre>';
//    print_r($questionPart);
//    $other_answers = Answer::model()->getOtherAnswersOfQuestion($model->question_id);
//
//    echo '<pre>';
//    print_r($other_answers);
//    echo '</pre>';
    ?>
    <table>
        <tr>
            <td width="70">
        <center><?php
            if ($answers != null) {
                echo AnswerText::model()->getAnswerTextById($answers[0]['answer_text_id']);
            }
            ?></center>
    </td>
    <td width="70">
    <center>=</center>
    </td>
    <td width="70">
    <center><?php echo $questionPart['question_part_name']; ?></center>
    </td>
    <td width="70">
    <center><?php echo $operators[0]['question_part_text']; ?></center>
    </td>
    <td>
        <button class="bluebtn"><?php
            if ($answers != null) {
                echo AnswerText::model()->getAnswerTextById($answers[1]['answer_text_id']);
            }
            ?></button>
    </td>
    <td width="70">
    <center><?php echo $operators[1]['question_part_text']; ?></center>
    </td>
    <td>
        <button class="bluebtn"><?php
            if ($answers != null) {
                echo AnswerText::model()->getAnswerTextById($answers[2]['answer_text_id']);
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
                <button class="greybtn" type="button"><?php echo $other_answer_text['answer_text'] ?></button>
                <?php
                $count++;
            }
        }


        shuffle($answers);
        foreach ($answers as $answer) {
            if ($answer['question_part_id'] != null) {
                ?>
                <button class="greybtn"><?php echo AnswerText::model()->getAnswerTextById($answer['answer_text_id']); ?></button>&nbsp;&nbsp;
                <?php
            }
            if ($count == 3) {
                echo '<br/><br/>';
            }
            $count++;
        }
        ?>

    </div>

    <?php
//    $coords = Hotspot::model()->getImageName($model->question_id);
//
//    foreach ($coords as $coord) {
//        echo $coord->coordinates;
//    }
    ?>


    <?php
} else if ($model->question_type == 'HOT_SPOT_ANSWER') {

    $uploaded_images = Hotspot::getImageName($model->question_id);

    if (!empty($uploaded_images)) {

        foreach ($uploaded_images as $images) {
            if ($images->image_name != Null) {

                echo '<style>
                .overlays{
                 position: absolute;
                } 
                </style>';



                echo '<div id="imge" style="width:auto;height:600px">';
                echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $images->hotspot_id . '/' . $images->image_name . '" style="width:auto; height:600px" />';
                echo '</div>';
            } else {
                echo '<div id="imge" style="width:auto;height:300px">';
                echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png" style="width:auto; height:300px" />';
                echo '</div>';
            }
        }
    } else {
        echo '<div id="imge" style="width:auto;height:300px">';
        echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png" style="width:auto; height:300px" />';
        echo '</div>';
    }
    ?>
    <script>
        window.onload = function() {
            showImage();
        };

    </script>


    <?php
}
        




?>

    
    
