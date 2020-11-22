 <script type = "text/javascript" >
    history.pushState(null, null, 'index.php?r=exam/notLoggedinViewExam');
    window.addEventListener('popstate', function(event) {
    history.pushState(null, null, 'index.php?r=exam/notLoggedinViewExam');
    });
    </script>
    
    <?php 
    
    $examDetails = Exam::model()->getExamDetails($examID);
    ?>
<div class="container">
    <div class="span12">
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
                        echo $score . ' %';
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
                        echo $numberOfQuestions;
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
                        echo $noOfCorrectAns;
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
                        echo $noOfIncorrectAns;
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
                        $totaltime = $totalTimeTaken;
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
                for ($i = 0; $i < sizeof($mark); $i++) {

                    $subject_area_id = Question::model()->getSubjectAreaIdOfQuestion($questionid[$i]);

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

                        if ($mark[$i] > 0) {
                            $summary_array[$c]['no_of_correct_answers'] = 1;
                        } else {
                            $summary_array[$c]['no_of_correct_answers'] = 0;
                        }
                        $summary_array[$c]['no_of_questions'] = 1;

                        $c++;
                    } else {
                        if ($mark[$i] > 0) {
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
        </div>
    </div>


</div>


<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

