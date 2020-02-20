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


<br/>
<h3 class="light_heading">Results view</h3>

<table class="table">
    <tr>
        <td>Highest Mark</td><td><?php echo $highest_marks ?></td>
        <td>Lowest Mark</td><td><?php echo $lowest_marks ?></td>
    </tr>
    <tr>
        <td>Average Mark</td><td><?php echo number_format($average_marks, 2); ?></td>
        <td>Longest Time Taken</td><td><?php echo changeTime($highest_time); ?></td>
    </tr>
    <tr>
        <td>Shortest Time Taken</td><td><?php echo changeTime($lowest_time); ?></td>
        <td>Average Time Taken</td><td><?php echo changeTime(number_format($average_time, 2)); ?></td>
    </tr>
    <tr>
        <td>Number Of Passes</td><td><?php echo $passCount; ?></td>
        <td>Number Of Fails</td><td><?php echo $failCount; ?></td>
    </tr>

</table>