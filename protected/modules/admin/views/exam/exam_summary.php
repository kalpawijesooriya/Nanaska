<?php
$take = FinalResult::model()->getFinalResultById($take_id);
$examID = Take::model()->getExamID($take_id);
$examDetails = Exam::model()->getExamDetails($examID);
foreach ($take as $question) {
    ?>
    <script>
        $(function() {
            $("#logicBtn_<?php echo $question['question_id'] ?>").click(function() {
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
    <!--<div class="span12">--> 
    <!--<h1 class="light_heading">Exam Summary</h1>-->

    <?php
//        echo $student_id;
    ?>

    <?php
//        echo $take_id;


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
        <h3 class="light_heading">
            Summary
        </h3>

        <table class="table table-bordered">
            <tr>
                <th width ="150px">
         
                <strong>
                    Study Area
                </strong>

            </th>
            <th width ="150px">
           
                <strong>
                    Number Of Correct Answers
                </strong>
         
            </th>
            <th width ="150px">
         

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

//            echo '<pre>';
//            print_r($summary_array);
//            echo '</pre>';

            foreach ($summary_array as $item) {
                ?>
                <tr>
                    <td>
                        <?php echo SubjectArea::model()->getSubjectAreaName($item['subject_area_id']) ?>
                    </td>
                    <td>
                        <?php echo $item['no_of_correct_answers']; ?>
                    </td>
                    <td>
                        <?php echo $item['no_of_questions']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <br/>
        <?php
//        $user_id = Yii::app()->user->getID();
//        $student_id = Student::model()->getStudentIdForUserId($user_id);
        //   $student_id = //        echo $student_id;

        $student = Student::model()->getStudentById($student_id);

        if ($student['show_exam_breakdown'] == 1) {
            ?>
            <h3 class="light_heading">
                Exam Breakdown
            </h3>

            <table class="table table-bordered">
                <tr>
                    <th width ="150">
                
                    <strong>
                        Question Number
                    </strong>
                
                </th>
                <th width ="250">
                
                    <strong>
                        Study Area
                    </strong>
                
                </th>
                <th width ="150">
                

                    <strong>
                        Time Taken
                    </strong>
                

                </th>
                <th width ="150">
               

                    <strong>
                        Mark
                    </strong>
                

                </th>
                <th width ="150">
               

                    <strong>
                        Result
                    </strong>
                

                </th>
                <th width ="150">
                

                    <strong>
                        Logic
                    </strong>
                

                </th>
                </tr>


                <?php
                $take = FinalResult::model()->getFinalResultById($take_id);

                foreach ($take as $question) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $question['question_number']; ?>
                        </td>
                        <td>
                            <?php echo Question::model()->getSubjectAreaOfQuestion($question['question_id']) ?>
                        </td>
                        <td>
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
                        <td>
            <?php echo $question['mark']; ?>
                        </td>
                        <td>
            <?php
            if ($question['mark'] > 0) {
                echo 'Correct';
            } else {
                echo 'Incorrect';
            }
            ?>
                        </td>
                        <td>
                            <button id="logicBtn_<?php echo $question['question_id'] ?>" class="bluebtnsmall">View Logic</button>
                        </td>
                    </tr>

            <?php
        }
        ?>
            </table>


        <?php
//            echo '<pre>';
//            print_r($take);
//            echo '</pre>';
    }
    ?>
        <?php
//        echo $take_id;
    } else {
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
    echo Take::model()->getResultOfTheTake($take_id, 1);
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
    echo $examDetails['number_of_questions'];
    ?>
                </td>
            </tr>
            <tr height="35">
                <td width="400">
                    <strong>
                        Total Time Taken(minutes)
                    </strong>
                </td>
                <td>
    <?php
    $totaltime = PaperQuestion::model()->getTotalTimeTaken($take_id);

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

    <?php
    $examSections = EssayAnswer::model()->getSectionsOfExamByTakeId($take_id);
    //var_dump($examSections);die;
    echo '<h3 class="light_heading">Exam Sections</h3>';
    foreach ($examSections as $examSection) {
        echo '<h4>Section ' . $examSection['section_no'] . '</h4>';
        $sectionQuestions = EssayAnswer::model()->getQuestionsOfExamByTakeIdSectionNo($take_id, $examSection['section_no']);
        ?>

            <table>
                <tr>
                    <td width="300">
                <strong>Question ID</strong>
                </td>
                <td width="300">
                <strong>Question Text</strong>
                </td>
                <td width="300">
                <strong>Mark</strong>
                </td>
                <td width="300">
                
                </td>
                </tr>

        <?php
        foreach ($sectionQuestions as $sectionQuestion) {
            $questionData = Question::model()->getQuestion($sectionQuestion['question_id']);
            echo '<tr>';

            echo '<td width="300">';
            
            echo $sectionQuestion['question_id'];
            
            echo '</td>';

            echo '<td width="300">';
            
            echo Question::model()->getQuestionText($sectionQuestion['question_id']);
            
            echo '</td>';

            echo '<td width="300">';
            
            $temp_status = EssayAnswer::model()->getStatus($take_id, $sectionQuestion['question_id']);
            if ($temp_status == "Marked") {
                echo round(EssayAnswer::model()->getMarkForTheQuestion($take_id, $sectionQuestion['question_id']), 2) . '%';
            } else {
                echo 'Pending';
            }
            
            echo '</td>';


            echo '<td width="300">';
            
            echo CHtml::link(CHtml::encode("View Feedback"), array('essayAnswer/viewIndividualFeedback', 'take_id' => $take_id, 'question_id' => $sectionQuestion['question_id']));

            
            echo '</td>';

            echo '</tr>';
        }

        echo '</table>';
        echo '<br/><br/>';
    }
}
?>
        <!--</div>-->
</div>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>


<?php
foreach ($take as $question) {
    //echo $question['question_id'];

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'mydialog_' . $question['question_id'],
        'options' => array(
            'title' => 'View Logic for Question ' . $question['question_id'],
            'width' => 1000,
            'height' => 500,
            'autoOpen' => false,
            'resizable' => true,
            'modal' => false,
            'overlay' => array(
                'backgroundColor' => '#000',
                'opacity' => '0.5'
            ),
        ),
    ));
    echo $this->renderPartial('_question_logic', array('question_id' => $question['question_id']));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
}
?>
