<?php
$take = FinalResult::model()->getFinalResultById($take_id);
$examID = Take::model()->getExamID($take_id);
$examDetails = Exam::model()->getExamDetails($examID);
foreach ($take as $question) {
    ?>
    <script>
        $(function () {
            $("#logicBtn_<?php echo $question['question_id'] ?>").click(function () {
                var question_id = '<?php echo $question['question_id']; ?>';
                $("#mydialog_" + question_id).dialog("open");
                return false;
            });
        });
    </script>
    <?php
}
?>

<div class="container">

    <?php
    if ($examDetails['exam_type'] != 'ESSAY') {
        ?>

        <br/><br/>

        <table>
            <tr height="35">
                <td width="400">
                    <strong>
                        Score
                    </strong>
                </td>
                <td>
                    <?php
                    echo FinalResult::model()->getScoreTake($take_id) . ' %';
                    ?>
                </td>
            </tr>
            <tr height="35">
                <td width="400">
                    <strong>
                        Number Of Questions
                    </strong>
                </td>
                <td>
                    <?php
                    echo FinalResult::model()->getNumberOfQuestions($take_id);
                    ?>
                </td>
            </tr>  
            <tr height="35">
                <td width="400">
                    <strong>
                        Number Of Correct Answers
                    </strong>
                </td>
                <td>
                    <?php
                    echo FinalResult::model()->getNumberOfCorrectAnswers($take_id);
                    ?>
                </td>
            </tr>
            <tr height="35">
                <td width="400">
                    <strong>
                        Number Of In-Correct Answers
                    </strong>
                </td>
                <td>
                    <?php
                    echo FinalResult::model()->getNumberOfInCorrectAnswers($take_id);
                    ?>
                </td>
            </tr>
            <tr height="35">
                <td width="400">
                    <strong>
                        Total Time Taken
                    </strong>
                </td>
                <td>
                    <?php
                    $totaltime = PaperQuestion::model()->getTotalTimeTaken($take_id) . ' minutes';

                    $mins = $totaltime / 60;
                    $secs = $totaltime % 60;
                    $roundmins = round($mins);

                    if ($secs > 30) {
                        $roundmins = $roundmins - 1;
                    }
//echo $roundmins;


                    echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
                    ?>
                </td>
            </tr>
        </table>

        <br/>
        <h4 class="light_heading">
            Summary
        </h4>

        <table cellspacing="0" style="width: 450px; border: 1px #D9D9D9 solid">
            <tr>
                <th style="width: 60%; border: 1px #D9D9D9 solid">

                    <strong>
                        Study Area
                    </strong>

                </th>
                <th style="border: 1px #D9D9D9 solid">

                    <strong>
                        Number Of Correct Answers
                    </strong>

                </th>
                <th style="border: 1px #D9D9D9 solid">


                    <strong>
                        Number Of Questions
                    </strong>


                </th>
            </tr>

            <?php
            $take = FinalResult::model()->getFinalResultById($take_id);

            $summary_array = array();

            $c = 0;
            foreach ($take as $question) {
                $subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($question['question_id']);

                $found = false;
                $found_index = 0;

                $count = 0;

                foreach ($summary_array as $item) {
                    if ($item['subject_area_id'] == $subject_area_id) {
                        $found = true;
                        $found_index = $count;
                    }
                    $count++;
                }

                if (!$found) {
                    $summary_array[]['subject_area_id'] = $subject_area_id;
                    if ($question['mark'] > 0) {
                        $summary_array[$c]['no_of_correct_answers'] = 1;
                    } else {
                        $summary_array[$c]['no_of_correct_answers'] = 0;
                    }
                    $summary_array[$c]['no_of_questions'] = 1;

                    $c++;
                } else {
                    if ($question['mark'] > 0) {
                        $summary_array[$found_index]['no_of_correct_answers'] = $summary_array[$found_index]['no_of_correct_answers'] + 1;
                    }
                    $summary_array[$found_index]['no_of_questions'] = $summary_array[$found_index]['no_of_questions'] + 1;
                }
            }

            foreach ($summary_array as $item) {
                ?>
                <tr>
                    <td style="border: 1px #D9D9D9 solid">
                        <?php echo SubjectArea::model()->getSubjectAreaName($item['subject_area_id']) ?>
                    </td>
                    <td style="border: 1px #D9D9D9 solid">
                        <?php echo $item['no_of_correct_answers']; ?>
                    </td>
                    <td style="border: 1px #D9D9D9 solid">
                        <?php echo $item['no_of_questions']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <br/>
        <?php
        $student = Student::model()->getStudentById($student_id);

        if ($student['show_exam_breakdown'] == 1) {
            ?>
            <h4 class="light_heading">
                Exam Breakdown
            </h4>

            <table cellspacing="0" style="width: 900px; border: 1px #D9D9D9 solid">
                <tr>
                    <th style="border: 1px #D9D9D9 solid">
                        <strong>Question<br />Number</strong>

                    </th>
                    <th width ="40%" style="border: 1px #D9D9D9 solid">

                        <strong>
                            Study Area
                        </strong>

                    </th>
                    <th style="border: 1px #D9D9D9 solid">


                        <strong>
                            Time Taken
                        </strong>


                    </th>
                    <th style="border: 1px #D9D9D9 solid">


                        <strong>
                            Mark
                        </strong>


                    </th>
                    <th style="border: 1px #D9D9D9 solid">


                        <strong>
                            Result
                        </strong>


                    </th>
        <!--                    <th width ="80">


                        <strong>
                            Logic
                        </strong>


                    </th>-->
                </tr>


                <?php
                $take = FinalResult::model()->getFinalResultById($take_id);

                foreach ($take as $question) {
                    ?>
                    <tr>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php echo $question['question_number']; ?>
                        </td>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php echo Question::model()->getSubjectAreaOfQuestion($question['question_id']) ?>
                        </td>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php
                            $totaltime = $question['time_taken'];

                            $mins = $totaltime / 60;
                            $secs = $totaltime % 60;
                            $roundmins = round($mins);

                            if ($secs > 30) {
                                $roundmins = $roundmins - 1;
                            }
//echo $roundmins;


                            echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
                            ?>
                        </td>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php echo $question['mark']; ?>
                        </td>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php
                            if ($question['mark'] > 0) {
                                echo 'Correct';
                            } else {
                                echo 'Incorrect';
                            }
                            ?>
                        </td>
            <!--                        <td>
                            <button id="logicBtn_<?php //echo $question['question_id']                   ?>" class="bluebtnsmall">View Logic</button>
                        </td>-->
                    </tr>

                    <?php
                }
                ?>
            </table>


            <?php
        }
        ?>
        <?php
    } else {
        ?>
        <br/><br/>

        <table cellspacing="0" style="width: 450px; border: 1px #D9D9D9 solid">
            <tr>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <strong>
                        Score
                    </strong>
                </td>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <?php
                    echo Take::model()->getResultOfTheTake($take_id, 1);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <strong>
                        Number Of Questions
                    </strong>
                </td>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <?php
                    echo $examDetails['number_of_questions'];
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <strong>
                        Total Time Taken(minutes)
                    </strong>
                </td>
                <td style="width: 60%; border: 1px #D9D9D9 solid">
                    <?php
                    $totaltime = PaperQuestion::model()->getTotalTimeTaken($take_id);

                    $mins = $totaltime / 60;
                    $secs = $totaltime % 60;
                    $roundmins = round($mins);

                    if ($secs > 30) {
                        $roundmins = $roundmins - 1;
                    }
                    echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
                    ?>
                </td>
            </tr>
        </table>

        <br /><br />

        <?php
        $examSections = EssayAnswer::model()->getSectionsOfExamByTakeId($take_id);
        ?>
        <h4 class="light_heading">Exam Sections</h4>
        <?php
        foreach ($examSections as $examSection) {
            echo '<h5>Section ' . $examSection['section_no'] . '</h5>';
            $sectionQuestions = EssayAnswer::model()->getQuestionsOfExamByTakeIdSectionNo($take_id, $examSection['section_no']);
            ?>

            <table cellspacing="0" style="width: 900px; border: 1px #D9D9D9 solid">
                <tr>
                    <td style="width: 10%; border: 1px #D9D9D9 solid">
                        <strong>Question ID</strong>
                    </td>
                    <td style="width: 60%; border: 1px #D9D9D9 solid">
                        <strong>Question Text</strong>
                    </td>
                    <td style="width: 10%; border: 1px #D9D9D9 solid">
                        <strong>Mark</strong>
                    </td>
                </tr>

                <?php
                foreach ($sectionQuestions as $sectionQuestion) {
                    $questionData = Question::model()->getQuestion($sectionQuestion['question_id']);
                    ?>
                    <tr>
                        <td style="border: 1px #D9D9D9 solid">
                            <?php echo $sectionQuestion['question_id']; ?>                                
                        </td>                                
                        <?php
                        $qtext = Question::model()->getQuestionText($sectionQuestion['question_id']);
                        ?>

                        <td id="<?php $sectionQuestion['question_id']; ?>" style="border: 1px #D9D9D9 solid" title="<?php htmlspecialchars($qtext); ?>">
                            <?php
                            $qtext_wrap = (strlen($qtext) > 150) ? substr($qtext, 0, 150) . '...' : $qtext;
                            echo $qtext_wrap;
                            ?>
                        </td>

                        <td width="300" style="border: 1px #D9D9D9 solid">
                            <?php
                            $temp_status = EssayAnswer::model()->getStatus($take_id, $sectionQuestion['question_id']);
                            if ($temp_status == "Marked") {
                                echo round(EssayAnswer::model()->getMarkForTheQuestion($take_id, $sectionQuestion['question_id']), 2) . '%';
                            } else {
                                echo 'Pending';
                            }
                            ?>
                        </td></tr>
                    <?php
                }
                ?>

            </table>
            <?php
            echo '<br/><br/>';
        }
    }
    ?>

</div>
