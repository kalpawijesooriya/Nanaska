<div class="container footer-stable">
    <?php
    if ($student_id != null) {
        $this->renderpartial('_level_news_sidemenu');
        $student_exams = StudentExam::model()->getExamsOfStudent($student_id);

        if (!empty($student_exams)) {
            ?>
            <div class="span6"> 
                <h3 class="master_heading">Scheduled Exams</h3>

                <?php
                $count = 0;

                foreach ($student_exams as $key=> $student_exam) {
                    ?>

                    <div class="well" id="ex<?php echo $count; ?>">
                        <table>
                            <tr>
                                <td width="150">
                                    <strong>Exam Name</strong>
                                </td>
                                <td>
                                    <?php echo Exam::model()->getExamName($student_exam['exam_id']); ?>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <strong>Exam Type</strong>
                                </td>
                                <td>
                                    <?php echo Exam::model()->getExamType($student_exam['exam_id']); ?>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <strong>Starting Date</strong>
                                </td>
                                <td>
                                    <?php echo $student_exam['start_date']; ?>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <strong>Expiry Date</strong>
                                </td>
                                <td>
                                    <?php echo $student_exam['expiry_date']; ?>
                                </td> 
                            </tr>
                        </table>
                        <br/>
                        <?php
                        echo CHtml::ajaxButton('Take Exam', CController::createUrl('exam/takeExam'), array(
                            'type' => 'POST', //request type
                            'dataType' => 'json',
                            'data' => array(
                                'exam_id' => $student_exam['exam_id'],
                                'starting_date' => $student_exam['start_date'],
                                'expiry_date' => $student_exam['expiry_date'],
                                'exam_type' => 'PRESETORSAMPLE'
                            ),
                            'success' => 'function(data){ 
                        if(data.status=="success"){
                            clearSession();                             
                            $("#ex' . $key . '").hide();
                              location.href = data.redirect_url;
                            //window.open (data.redirect_url, "mywindow","location=0,status=1,scrollbars=1,fullscreen=yes");
                            
                            }else{
                            alert("The Current Date is not within the Starting date and Expiry date");
                        }
                                    }'
                                ), array('class' => 'bluebtn',
                            'id' => 'take_exam_' . $count)
                        );
                        ?>


                    </div>

                    <?php
                    $count++;
                }
                ?>

            </div>

        <?php } else {
            ?>
            <div class="span3"></div>
            <div class="span6">
                <h3 class="master_heading">Scheduled Exams</h3>

                <p style="color: red;"><b>No scheduled exams.</b></p>               
            </div> 


            <?php
        }
        ?>


    </div>


    <?php
} else {
    ?>
    <div class="span3"></div>
    <div class="span6">
        <h3 class="master_heading">Scheduled Exams</h3>

        <p style="color: red;"><b>Please Sign in to the System.</b></p>

    </div> 

    <?php
}
?>

<script type="text/javascript">

    function clearSession(){    
       
        $.ajax({
            url:'<?php echo CController::createUrl('Exam/destroySession'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data:{
                session_name:'exam_time'
            },
            success: function(data){
                //alert("k");
            }
        });
    }

</script>

