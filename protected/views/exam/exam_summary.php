<script type = "text/javascript" >
    history.pushState(null, null, 'index.php?r=user/detail');
    window.addEventListener('popstate', function(event) {
        history.pushState(null, null, 'index.php?r=user/detail');
    });
</script>
<?php
$take = FinalResult::model()->getFinalResultById($take_id);
$examID =  Take::model()->getExamID($take_id);
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
    <div class="span12">
        <?php
        if($examDetails['exam_type'] != "ESSAY"){
        ?>
        <div class="well">
            <h1 class="master_heading">Exam Summary - <?php echo $examDetails['exam_name'] ?></h1>

            <?php
//        echo $take_id;
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
                            Number Of Incorrect Answers
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
//echo PaperQuestion::model()->getTotalTimeTaken($take_id) . ' minutes';
                        $totaltime = PaperQuestion::model()->getTotalTimeTaken($take_id);
//echo $totaltime;
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
                    <th>
                <center>
                    <strong>
                        Study Area
                    </strong>
                </center>
                </th>
                <th>
                <center>
                    <strong>
                        Number Of Correct Answers
                    </strong>
                </center>
                </th>
                <th>
                <center>

                    <strong>
                        Number Of Questions
                    </strong>
                </center>

                </th>
                </tr>

                <?php
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
                        <td>
                    <center>
                        <?php echo SubjectArea::model()->getSubjectAreaName($item['subject_area_id']) ?>
                    </center>    
                    </td>
                    <td>
                    <center>
                        <?php echo $item['no_of_correct_answers']; ?>
                    </center>
                    </td>
                    <td>
                    <center>
                        <?php echo $item['no_of_questions']; ?>
                    </center>
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <br/>
            <?php
            $user_id = Yii::app()->user->getID();

            $student_id = Student::model()->getStudentIdForUserId($user_id);

            $student = Student::model()->getStudentById($student_id);

            if ($student['show_exam_breakdown'] == 1) {
                ?>
                <h3 class="light_heading">
                    Exam Breakdown
                </h3>

                <table class="table table-bordered">
                    <tr>
                        <th>
                    <center>
                        <strong>
                            Question Number
                        </strong>
                    </center>
                    </th>
                    <th>
                    <center>
                        <strong>
                            Study Area
                        </strong>
                    </center>
                    </th>
                    <th>
                    <center>

                        <strong>
                            Time Taken (minutes)
                        </strong>
                    </center>

                    </th>
                    <th>
                    <center>

                        <strong>
                            Mark
                        </strong>
                    </center>

                    </th>
                    <th>
                    <center>

                        <strong>
                            Result
                        </strong>
                    </center>

                    </th>
                    <th>
                    <center>

                        <strong>
                            Logic
                        </strong>
                    </center>

                    </th>
                    </tr>


                    <?php
                    $take = FinalResult::model()->getFinalResultById($take_id);

                    foreach ($take as $question) {
                        ?>
                        <tr>
                            <td>
                        <center>
                            <?php echo $question['question_number']; ?>
                        </center>    
                        </td>
                        <td>
                        <center>
                            <?php echo Question::model()->getSubjectAreaOfQuestion($question['question_id']) ?>
                        </center>
                        </td>
                        <td>
                        <center>
                            <?php
                            $totaltime = $question['time_taken'];

                            $mins = $totaltime / 60;
                            $secs = $totaltime % 60;
                            $roundmins = round($mins);

                            if ($secs > 30) {
                                $roundmins = $roundmins - 1;
                            }

                            echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
                            ?>
                        </center>
                        </td>
                        <td>
                        <center>
                            <?php echo $question['mark']; ?>
                        </center>
                        </td>
                        <td>
                        <center>
                            <?php
                            if ($question['mark'] > 0) {
                                echo 'Correct';
                            } else {
                                echo 'Incorrect';
                            }
                            ?>
                        </center>    
                        </td>
                        <td>
                        <center>
                            <button id="logicBtn_<?php echo $question['question_id'] ?>" class="bluebtnsmall">View Logic</button>
                        </center>    
                        </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>

                <?php
            }
            ?>
        </div>
        <?php
        }else{
            $take_model = new Take;
            $take_model = Take::model()->findByPk($take_id);
        ?>
            <div class="well">
            <h1 class="master_heading">Exam Summary - <?php echo $examDetails['exam_name'] ?></h1>
            
            
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
                        
                        echo Take::model()->getResultOfTheTakeByStatus($take_id, $take_model->status);
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
                        $totaltime = (int)PaperQuestion::model()->getTotalTimeTaken($take_id);
                        //echo $totaltime;
                        $mins = $totaltime / 60;
                        $secs = $totaltime % 60;
                        $roundmins = round($mins);

                        if ($secs > 30) {
                            $roundmins = $roundmins - 1;
                        }
                        //echo $roundmins;
                        //echo $totaltime;
                        echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
          
                        ?>
                    </td>
                </tr>
                
                
            </table>
            
            <?php
                
                $examSections = EssayAnswer::model()->getSectionsOfExamByTakeId($take_id);
                //var_dump($examSections);die;
                echo '<h3 class="light_heading">Exam Sections</h3>';
                $number = 1;
                foreach ($examSections as $examSection) {
                    echo '<h4>Section ' . $examSection['section_no'] . '</h4>';
                    $sectionQuestions = EssayAnswer::model()->getQuestionsOfExamByTakeIdSectionNo($take_id, $examSection['section_no']);
                    ?>

                    <table>
                    <tr>
                        <td width="300">
                        <center><strong>Question No</strong></center>
                        </td>
<!--                        <td width="300">
                        <center><strong>Question Text</strong></center>
                        </td>-->
                        <td width="300">
                        <center><strong>Mark</strong></center>
                        </td>
                        <td width="300">
                        <center></center>
                        </td>
                    </tr>

                    <?php
                    
                    foreach ($sectionQuestions as $sectionQuestion) {
                        $questionData = Question::model()->getQuestion($sectionQuestion['question_id']);
                        echo '<tr>';

                        echo '<td width="300">';
                        echo '<center>';
                        echo $number;
                        echo '</center>';
                        echo '</td>';

//                        echo '<td width="300">';
//                        echo '<center>';
//                        echo Question::model()->getQuestionText($sectionQuestion['question_id']);
//                        echo '</center>';
//                        echo '</td>';

                        echo '<td width="300">';
                        echo '<center>';
                        $temp_status = EssayAnswer::model()->getStatus($take_id, $sectionQuestion['question_id']);
                        if($temp_status == "Marked"){
                            echo round(EssayAnswer::model()->getMarkForTheQuestion($take_id, $sectionQuestion['question_id']), 2).'%';
                        }else{
                            echo 'Pending';
                        }
                        echo '</center>';
                        echo '</td>';


                        echo '<td width="300">';
                        echo '<center>';
                        //echo CHtml::link(CHtml::encode("View Feedback"), array('essayAnswer/viewIndividualFeedback','take_id' => $take_id, 'question_id' => $sectionQuestion['question_id']));
                        echo CHtml::ajaxButton('View Feedback', CController::createUrl('essayAnswer/viewIndividualFeedbackInDialog'), array(
                            'type' => 'POST', //request type
                            'dataType' => 'json',
                            'data' => array(
                                'take_id' => $take_id,
                                'question_id' => $sectionQuestion['question_id']
                                
                                ),
                            'success' => 'js:function(data){ 
                                                                
                                    $("#mydialog_viewFeedback").dialog("open");   
                                    if(document.getElementById("dialog_data")!=null){
                                        $("#dialog_data").remove();
                                    }                          

                                    $("#mydialog_viewFeedback").append(data.feedback);


                                    
                                }'
                                ), array(
                            'id' => 'rexample_btn'.$sectionQuestion['question_id'],
                            'class' => 'tinybluebtn',
                                )
                        );
                        echo '</center>';
                        echo '</td>';

                        echo '</tr>';
                        $number++;
                    }

                    echo '</table>';
                    echo '<br/><br/>';
                }
            
            
            ?>
            
            </div>
        <?php
        }
        ?>
    </div>
</div>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<?php

foreach ($take as $question) {
    //echo $question['question_id'];

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'mydialog_' . $question['question_id'],
        'options' => array(
            'title' => 'View Logic for Question',
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
<div>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_viewFeedback',
    'options' => array(
        'title' => 'View Feedback',
        'width' => 1000,
        'height' => 500,
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'position'=>'bottom',
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
</div>