<div id="dialog_data">
    <?php
    echo $qtext;
    echo '<br />';

    if ($qtype == 'SINGLE_ANSWER') {

        foreach ($answer_details as $answer) {
            if ($answer != "") {
                echo '<input type="radio" name="answer_id" value="' . rand(0, 1000) . '" class="answer_text" style="margin-right:5px" />' . $answer . '<br />';
            }
        }

        if ($newanswer_details != null) {
            foreach ($newanswer_details as $answer) {
                if ($answer != "") {
                    echo '<input type="radio" name="answer_id" value="' . rand(0, 1000) . '" class="answer_text" style="margin-right:5px" />' . $answer . '<br />';
                }
            }
        }
    } else if ($qtype == 'MULTIPLE_ANSWER') {
        foreach ($answer_details as $answer) {
            if ($answer != "") {
                echo '<input type="checkbox" name="answer_id" value="' . rand(0, 1000) . '" class="answer_text" style="margin-right:5px" />' . $answer . '<br />';
            }
        }
        if ($newanswer_details != null) {
            foreach ($newanswer_details as $answer) {
                if ($answer != "") {
                    echo '<input type="checkbox" name="answer_id" value="' . rand(0, 1000) . '" class="answer_text" style="margin-right:5px" />' . $answer . '<br />';
                }
            }
        }
    } else if ($qtype == 'SHORT_WRITTEN') {
        $shortWrittenQuestionPartSession = Yii::app()->session['short_written_question_part_session'];

//    var_dump($shortWrittenQuestionPartSession);die;
        echo '<table>';
        echo '<tr>';

          if ($heading_1 != "" && $heading_2 != "") {
            echo '<th title="' . htmlspecialchars($heading_1) . '" style="width : 300px; text-align : left" >';
            echo (strlen($heading_1) > 30) ? substr($heading_1, 0, 30) . '...' : $heading_1."&nbsp;&nbsp;&nbsp;&nbsp;";
            echo '</th>';

            echo '<th title="' . htmlspecialchars($heading_2) . '">';
            echo (strlen($heading_2) > 30) ? substr($heading_2, 0, 30) . '...' : $heading_2;
            echo '</th>';
        } else if ($heading_1 != "" && $heading_2 == "") {
            echo '<th title="' . htmlspecialchars($heading_1) . '" style="width : 300px; text-align : left">';
            echo (strlen($heading_1) > 30) ? substr($heading_1, 0, 30) . '...' : $heading_1."&nbsp;&nbsp;&nbsp;&nbsp;";
            echo '</th>';

            echo '<th>';
            echo 'N/A';
            echo '</th>';
        } else if ($heading_1 == "" && $heading_2 != "") {
            echo '<th style="width : 300px; text-align : left">';
            echo 'N/A';
            echo '</th>';

            echo '<th title="' . htmlspecialchars($heading_2) . '">';
            echo (strlen($heading_2) > 30) ? substr($heading_2, 0, 30) . '...' : $heading_2."&nbsp;&nbsp;&nbsp;&nbsp;";
            echo '</th>';
        }
        echo '</tr>';


        foreach ($shortWrittenQuestionPartSession as $answer) {
            echo '<tr>';
            echo '<div class="control-group">';
            echo '<div class="control-label">';

            echo '<td title="'.$answer['question_part'].'">';
            echo (strlen($answer['question_part']) > 30) ? substr($answer['question_part'], 0, 30) . '...' : $answer['question_part'];
            echo '</td>';

            echo '<td>';
            echo '<input type="text" name="answer_id" id="' . rand(0, 99) . '" '
            . 'class="answer_text" style="margin-right:5px" value=" " placeholder="Enter Answer"/>';
            echo '</td>';

            echo '</div>';
            echo '</div>';
            echo '</tr>';
        }

        echo '</table>';
    } else if ($qtype == 'TRUE_OR_FALSE_ANSWER') {
        echo '<div class="control-group">';
        echo '<div class="control-label">';

        echo '<input type="radio" name="answer_id" value=" " class="answer_text" style="margin-right:5px" />True';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<input type="radio" name="answer_id" value="0" class="answer_text" style="margin-right:5px" />False';



        echo '</div>';
        echo '</div>';
    } else if ($qtype == 'DRAG_DROP_TYPEA_ANSWER') {
        $dragDropTypeASession = Yii::app()->session['drag_drop_typea_session'];

        if (!empty($dragDropTypeASession)) {
            echo '<div class="span7">';
            echo '<table>';

            foreach ($dragDropTypeASession as $answer) {
                echo '<tr>';
                echo '<td title="' . htmlspecialchars($answer['question_part']) . '">';

                echo (strlen($answer['question_part']) > 30) ? substr($answer['question_part'], 0, 30) . '...' : $answer['question_part'];
                echo '</td>';

                echo '<td>';
                echo '<input type="text" name="answer_text" class="droppable" value=" " style="width:200px; height:50px; border:1px solid #000000;" readonly/>';

                echo '</td>';

                echo '<td title="' . $answer['answer'] . '">';
                if ($answer['answer'] != "") {
                    $txt = (strlen($answer['answer']) > 20) ? substr($answer['answer'], 0, 20) . '...' : $answer['answer'];
                    echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px">' . $txt . '</div>';
                    //echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px">' . $answer['answer2'] . '</div>&nbsp;&nbsp;';
                }
                echo '</td>';
                echo '</tr>';
            }

            echo '</td>';

            echo '<td style="width:200px;">';

            echo '</td>';
            echo '</tr>';

            echo '</table>';
            echo '</div>';
        }
    } else if ($qtype == 'DRAG_DROP_TYPEB_ANSWER') {
        $drag_drop_typeB_session = Yii::app()->session['drag_drop_typeb_session'];

        echo '<div class="span7">';
        echo '<br/>';
        echo '<table class="table table-bordered">';
        echo '<tr>';

        if ($heading_1 != "" && $heading_2 != "") {
            echo '<th title="' . htmlspecialchars($heading_1) . '">';
            echo (strlen($heading_1) > 30) ? substr($heading_1, 0, 30) . '...' : $heading_1;
            echo '</th>';

            echo '<th title="' . htmlspecialchars($heading_2) . '">';
            echo (strlen($heading_2) > 30) ? substr($heading_2, 0, 30) . '...' : $heading_2;
            echo '</th>';
        } else if ($heading_1 != "" && $heading_2 == "") {
            echo '<th title="' . htmlspecialchars($heading_1) . '">';
            echo (strlen($heading_1) > 30) ? substr($heading_1, 0, 30) . '...' : $heading_1;
            echo '</th>';

            echo '<th>';
            echo 'N/A';
            echo '</th>';
        } else if ($heading_1 == "" && $heading_2 != "") {
            echo '<th>';
            echo 'N/A';
            echo '</th>';

            echo '<th title="' . htmlspecialchars($heading_2) . '">';
            echo (strlen($heading_2) > 30) ? substr($heading_2, 0, 30) . '...' : $heading_2;
            echo '</th>';
        }
        echo '</tr>';

        foreach ($drag_drop_typeB_session as $answertext) {

            echo '<tr>';
            echo '<td title="' . htmlspecialchars($answertext['question_part']) . '">';
            echo (strlen($answertext['question_part']) > 30) ? substr($answertext['question_part'], 0, 30) . '...' : $answertext['question_part'];
            echo '</td>';

            echo '<td>';

            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
            echo '</td>';

            echo '<td style="width:400px;">';
            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
        echo '<br/><br/>';
        $counter = 0;
        echo '<div class="span10">';

        $ansCount = 0;
        foreach ($drag_drop_typeB_session as $key => $answer) {
            $txt1 = (strlen($answer['answer1']) > 20) ? substr($answer['answer1'], 0, 20) . '...' : $answer['answer1'];
            $txt2 = (strlen($answer['answer2']) > 20) ? substr($answer['answer2'], 0, 20) . '...' : $answer['answer2'];

            echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px" margin-top="5px" title="' . $answer['answer1'] . '">' . $txt1 . '</div>&nbsp;&nbsp;';
            echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px" margin-top="5px" title="' . $answer['answer2'] . '">' . $txt2 . '</div>&nbsp;&nbsp;';

            if ($ansCount == 5) {
                echo '<br/>';
            }
            $ansCount++;
            $counter++;
        }

        echo '</div>';
        echo '<br/><br/>';
    } else if ($qtype == 'DRAG_DROP_TYPEC_ANSWER') {

        echo '<div class="span7">';
        echo '<table>';
        echo '<tr>';

        if ($answer_text == null) {

            foreach ($answer_details["answers"] as $value) {
                echo '<td title="' . $value . '">';
                $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px">' . $value . '</div>';

                echo '</td>';
            }
        } else {

            foreach ($answer_text as $value) {
                echo '<td title="' . $value . '">';
                $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px">' . $txt . '</div>';

                echo '</td>';
            }

            if (!empty($newans_text["answers"])) {
                foreach ($newans_text["answers"] as $value) {
                    echo '<td title="' . $value . '">';
                    $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                    echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px">' . $txt . '</div>';

                    echo '</td>';
                }
            }
        }

        echo '<tr>';
        echo '</table>';

        echo '<br/>';

        echo '<table>';

        if ($answer_text == null) {
            foreach ($answer_details['question_part'] as $value) {
                echo '<tr>';
                echo '<td style="width:400px;" title="' . $value . '">';
                $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                echo $txt;
                echo '</td>';

                echo '<td style="width:400px;">';
                echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            foreach ($qpart as $value) {
                echo '<tr>';
                echo '<td style="width:400px;" title="' . $value . '">';
                $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                echo $txt;
                echo '</td>';

                echo '<td style="width:400px;">';
                echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                echo '</td>';
                echo '</tr>';
            }

            if (!empty($newans_text["question_part"])) {
                foreach ($newans_text['question_part'] as $value) {
                    echo '<tr>';
                    echo '<td style="width:400px;" title="' . $value . '">';
                    $txt = (strlen($value) > 30) ? substr($value, 0, 30) . '...' : $value;
                    echo $txt;
                    echo '</td>';

                    echo '<td style="width:400px;">';
                    echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }

        echo '</table>';
        echo '</div>';
    } else if ($qtype == 'DRAG_DROP_TYPED_ANSWER') {
        echo '<div class="span7">';
        ?>
        <table>
            <tr>
                <td style="width:400px;" title="<?php echo $result_text; ?>">
            <center><?php
                if ($result_text != null) {
                    echo (strlen($result_text) > 20) ? substr($result_text, 0, 20) . '...' : $result_text;
                    ;
                }
                ?></center>
            </td>
            <td style="width:400px;">
                <?php
                if ($result_text != "") {
                    ?>    
                <center>=</center>
            <?php } ?>
            </td>
            <td style="width:400px;" title="<?php echo $question_part; ?>">
            <center><?php echo $question_part; ?></center>
            </td>
            <td style="width:400px;" title="<?php echo $operator_1; ?>">
            <center><?php echo $operator_1; ?></center>
            </td>
            <td>
                <?php
                if ($operator_1) {
                    echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
                }
                ?>
            </td>
            <td style="width:400px;" title="<?php echo $operator_2; ?>">
            <center><?php echo $operator_2; ?></center>
            </td>
            <td>
                <?php
                if ($operator_2 != "") {
                    echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';
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

        $other_answers = Yii::app()->session['other_answer_session'];

        if (!empty($other_answers)) {
            shuffle($other_answers);

            foreach ($other_answers as $other_answer) {
                $txt = (strlen($other_answer['other_answer']) > 20) ? substr($other_answer['other_answer'], 0, 20) . '...' : $other_answer['other_answer'];
                echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px" title="' . $other_answer['other_answer'] . '">' . $txt . '</div>&nbsp;&nbsp;';
                $count++;
                if ($count == 5) {
                    echo '<br/><br/>';
                }
            }
        }

        echo '</div>';
    } else if ($qtype == 'DRAG_DROP_TYPEE_ANSWER') {

        $dragDropTypeESession = Yii::app()->session['drag_drop_typee_question_part_session'];        
        $other_answers = Yii::app()->session['other_answer_session'];

        echo '<div class="span7">';
        echo '<br/>';

        echo '<table class="table table-bordered">';
        echo '<tr>';

        if ($heading_1 != "" && $heading_2 != "") {
            echo '<th title="' . $heading_1 . '">';
            echo(strlen($heading_1) > 20) ? substr($heading_1, 0, 20) . '...' : $heading_1;
            echo '</th>';

            echo '<th title="' . $heading_2 . '">';
            echo(strlen($heading_2) > 20) ? substr($heading_2, 0, 20) . '...' : $heading_2;
            echo '</th>';
        } else if ($heading_1 != "" && $heading_2 == "") {
            echo '<th title="' . $heading_1 . '">';
            echo(strlen($heading_1) > 20) ? substr($heading_1, 0, 20) . '...' : $heading_1;
            echo '</th>';

            echo '<th>';
            echo 'N/A';
            echo '</th>';
        } else if ($heading_1 == "" && $heading_2 != "") {
            echo '<th>';
            echo 'N/A';
            echo '</th>';

            echo '<th title="' . $heading_2 . '">';
            echo(strlen($heading_2) > 20) ? substr($heading_2, 0, 20) . '...' : $heading_2;
            echo '</th>';
        }
        echo '</tr>';

        $iterator = 0;

        foreach ($dragDropTypeESession as $item) {
            echo '<tr>';
            echo '<td style="width:400px;" title="' . $item['question_part'] . '">';
            echo(strlen($item['question_part']) > 20) ? substr($item['question_part'], 0, 20) . '...' : $item['question_part'];
            echo '</td>';

            echo '<td style="width:400px;" title="' . $item['question_part_text'] . '">';
            echo(strlen($item['question_part_text']) > 20) ? substr($item['question_part_text'], 0, 20) . '...' : $item['question_part_text'];
            echo '</td>';


            echo '<td style="width:400px;">';
            echo '<input type="text" name="answer_text" class="droppable" style="width:200px; height:50px; border:1px solid #000000;" readonly/>';

            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';

        $counter = 0;
        

        echo '<br/><br/>';
        echo '<div class="span8">';
        
        foreach($dragDropTypeESession as $ans){
            $txt = (strlen($ans['answer']) > 20) ? substr($ans['answer'], 0, 20) . '...' : $ans['answer'];
            echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px" title="'.$ans['answer'].'">' . $txt . '</div>&nbsp;&nbsp;';
            if ($counter == 3) {
                echo '<br /><br />';
                $counter = 0;
            }
            $counter++;
        }
        

        foreach ($other_answers as $answers) {
            $txt = (strlen($answers['other_answer']) > 20) ? substr($answers['other_answer'], 0, 20) . '...' : $answers['other_answer'];
            echo '<div id="' . rand(0, 99) . '" class="btn smallbluebtn" width="150px" height="125px" title="'.$answers['other_answer'].'">' . $txt . '</div>&nbsp;&nbsp;';
            if ($counter == 3) {
                echo '<br /><br />';
                $counter = 0;
            }
            $counter++;
        }
        echo '</div>';
    } else if ($qtype == 'MULTIPLE_CHOICE_ANSWER') {

        $answers = Yii::app()->session['multiple_choice_answer_session'];
        //var_dump($answers);

        echo '<table>';
        echo '<tr>';

        if ($heading_1 != "" && $heading_2 != "") {
            echo '<th>';
            echo $heading_1;
            echo '</th>';

            echo '<th>';
            echo $heading_2;
            echo '</th>';
        } else if ($heading_1 != "" && $heading_2 == "") {
            echo '<th>';
            echo $heading_1;
            echo '</th>';

            echo '<th>';
            echo 'N/A';
            echo '</th>';
        } else if ($heading_1 == "" && $heading_2 != "") {
            echo '<th>';
            echo 'N/A';
            echo '</th>';
            echo '<th>';
            echo $heading_2;
            echo '</th>';
        }
        echo '</tr>';



        foreach ($answers as $ans) {
            if (isset($ans[0]['question_part'])) {
                echo '<tr>';
                echo '<div class="control-group">';
                echo '<div class="control-label">';
                echo '<td>';
                echo $ans[0]['question_part'];
                echo '</td>';

                echo '<td>';
                ?>
                <select name="answer_id" class="answer_section">
                    <option value="" disabled selected>Select Answer</option>
                    <?php
                    foreach ($ans as $key => $item) {
                        ?>
                        <option id="<?php echo rand(0, 99) ?>" value="<?php echo $item['answer_text'] ?>" selected=""><?php echo $item['answer_text']; ?></option>
                        <?php
                    }
                    ?>
                </select><?php
                echo '</td>';

                echo '</div>';
                echo '</div>';
                echo '</tr>';
            }
        }
        echo '</table>';
    } else if ($qtype == 'ESSAY_ANSWER') {

        if ($ess_type == 'EMAIL_TYPE') {
            echo '<div class="span6">';
            echo '<div class="well">';

            echo '<div class="control-group">';
            echo '<div class="span2">From</div>';
            if ($email_from !== "") {
                echo $email_from;
            } else {
                echo '<br />';
            }
            echo $email_from;
            echo '</div>';

            echo '<div class="control-group">';
            echo '<div class="span2">To</div>';
            if ($email_to !== "") {
                echo $email_to;
            } else {
                echo '<br />';
            }

            echo '</div>';

            echo '<div class="control-group">';
            echo '<div class="span2">Cc</div>';
            if ($email_cc !== "") {
                echo $email_cc;
            } else {
                echo '<br />';
            }
            echo $email_cc;
            echo '</div>';

            echo '<div class="control-group">';
            echo '<div class="span2">Subject</div>';
            if ($email_subject !== "") {
                echo $email_subject;
            } else {
                echo '<br />';
            }
            echo $email_subject;
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }
    ?>

</div>