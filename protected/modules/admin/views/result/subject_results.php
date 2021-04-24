<?php
$details = FinalResult::model()->getAllDoneForSubject($subject_id);
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
            //$highest_mark = FinalResult::model()->getHighestMarkOfSubject($subject_id);
            $highest_mark = $details['max_mark'];
            echo $highest_mark;
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
            // $lowest_mark = FinalResult::model()->getLowestMarkOfSubject($subject_id);
            $lowest_mark = $details['min_mark'];
            echo $lowest_mark;
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
            //$average_mark = FinalResult::model()->getAverageOfSubject($subject_id);
            $average_mark = $details['average'];
            echo $average_mark;
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
            // $longest_time = FinalResult::model()->getLongestTimeTaken($subject_id);
            $longest_time = $details['max_time'];
            echo changeTime($longest_time);           
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
            //  $shortest_time = FinalResult::model()->getShortestTimeTaken($subject_id);
            $shortest_time = $details['min_time'];
            echo changeTime($shortest_time);         
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
            // $average_time = FinalResult::model()->getAverageTimeTaken($subject_id);
            $average_time = $details['time_average'];
            echo changeTime($average_time);           
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Number Of Passes
            </strong> 
        </td>
        <td>
            <?php
            // $no_of_passes = FinalResult::model()->getNumberOfPasses($subject_id);
            $no_of_passes = $details['passCount'];
            echo $no_of_passes;
            ?>
        </td>
    </tr>
    <tr height="35">
        <td width = "300">
            <strong>
                Number Of Fails
            </strong> 
        </td>
        <td>
            <?php
            //   $no_of_fails = FinalResult::model()->getNumberOfFails($subject_id);
            $no_of_fails = $details['failCount'];
            echo $no_of_fails;
            ?>
        </td>
    </tr>
</table>

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
?>