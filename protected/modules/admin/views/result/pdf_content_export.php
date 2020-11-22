<div>
    <div><h3>Report For Student : <?php echo $student_email?></h3></div>
    <div> </div>
    <div><h3>Exam Details</h3></div>
    <div>
        <table>
            <tr>
                <td width="100"><b>Student Email</b></td>
                <td width="300"><?php echo $student_email?></td>
            </tr>
            <tr>
                <td><b>Exam</b></td>
                <td><?php echo $exam?></td>
            </tr>

        </table>
    </div>
    
    <div> </div>
    <div> </div>
    
    <div>
        <?php echo $results ?>
    </div>
</div>

<style>
    td{
        width:100px
    }
</style>


