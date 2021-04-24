<div>
    <div><h3>Report For Subject Area : <?php echo $subject_area?></h3></div>
    <div> </div>
    <div><h3>Subject Area Details</h3></div>
    <div>
        <table>
            <tr>
                <td width="100"><b>Course</b></td>
                <td><?php echo $course?></td>
            </tr>
            <tr>
                <td><b>Level</b></td>
                <td><?php echo $level?></td>
            </tr>
            <tr>
                <td><b>Subject</b></td>
                <td><?php echo $subject?></td>
            </tr>
            <tr>
                <td><b>Subject Area</b></td>
                <td><?php echo $subject_area?></td>
            </tr>
        </table>
    </div>
    <div><h3>Result</h3></div>
    <div>
        <?php echo $results ?>
    </div>
</div>

<style>
    td{
        width: 300;
    }
</style>

