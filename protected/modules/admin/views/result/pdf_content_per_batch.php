<div>
    <div><h3>Report For Batch</h3></div>
    <div> </div>
    <div><h3>Batch Details</h3></div>
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
                <td><b>Exam</b></td>
                <td><?php echo $exam?></td>
            </tr>
            <tr>
                <td><b>Sitting</b></td>
                <td><?php echo $sitting?></td>
            </tr>
        </table>
    </div>

    <div>
        <?php echo $results ?>
    </div>
</div>

<style>
    td{
        width: 150;
    }
</style>

