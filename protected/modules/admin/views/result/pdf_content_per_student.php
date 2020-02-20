<div>
    <div><h3>Report For Student : <?php echo $student_email?></h3></div>
    <div> </div>
    <div><h4>Student Details</h4></div>
    <div>
        <table>
            <tr>
                <td width="100"><b>Student Email</b></td>
                <td><?php echo $student_email?></td>
            </tr>
            <tr>
                <td><b>Course</b></td>
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
                <td><b>Take</b></td>
                <td><?php echo $take?></td>
            </tr>
        </table>
    </div>

    <div>
        <?php echo $results ?>
    </div>
</div>


