<?php

function changeTime($Times) {

    $highMins = $Times / 60;
    $highSecs = $Times % 60;
    $highRoundmins = round($highMins);

    if ($highSecs > 30) {
        $highRoundmins = $highRoundmins - 1;
    }

    return $highRoundmins . '&nbsp; <b>:</b> &nbsp;' . $highSecs . '&nbsp; minutes';
}

$subjectAreaDetails = FinalResult::model()->getAllDoneInOne($subject_area_id)
?>
<Br/>
<table>
    <tr height="35">
        <td width = "300">
            <strong>
                Highest Mark
            </strong> 
        </td>
        <td>
            <?php
//$highest_mark = FinalResult::model()->getHighestMarksOfSubjectArea($subject_id);
            $highest_mark = $subjectAreaDetails['max_mark'];
            echo round($highest_mark, 2);
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Lowest Mark
            </strong> 
        </td>
        <td>
            <?php
// $lowest_mark = FinalResult::model()->getLowestMarksOfSubjectArea($subject_id);
            $lowest_mark = $subjectAreaDetails['min_mark'];
            echo round($lowest_mark, 2);
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Average Mark
            </strong> 
        </td>
        <td>
            <?php
//$average_mark = FinalResult::model()->getAverageMarksOfSubjectArea($subject_id);
            $average_mark = $subjectAreaDetails['average'];
            echo round($average_mark, 2);
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Longest Time Taken
            </strong> 
        </td>
        <td>
            <?php
// $longest_time = FinalResult::model()->getLongestTimeOfSubjectArea($subject_id);
            $longest_time = $subjectAreaDetails['max_time'];
            echo changeTime($longest_time);
//   echo $longest_time . " minutes";
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Shortest Time Taken
            </strong> 
        </td>
        <td>
            <?php
// $shortest_time = FinalResult::model()->getShortestTimeOfSubjectArea($subject_id);
            $shortest_time = $subjectAreaDetails['min_time'];
            echo changeTime($shortest_time);
// echo $shortest_time . " minutes";
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Average Time Taken
            </strong> 
        </td>
        <td>
            <?php
// $average_time = FinalResult::model()->getAverageMarksOfSubjectArea($subject_id);
            $average_time = $subjectAreaDetails['time_average'];
            echo changeTime($average_time);
// echo $average_time . " minutes";
            ?>
        </td>
    </tr>
</table>