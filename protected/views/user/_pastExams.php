<div class="container">
    <?php
//$this->menu=array(
//	array('label'=>'View Account','url'=>array('view','id'=>$model->user_id)),
//	array('label'=>'Edit Account','url'=>array('update','id'=>$model->user_id)),
//	array('label'=>'Change Password','url'=>array('updatepass','id'=>$model->user_id)),
    //array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
    //array('label'=>'Manage User','url'=>array('admin')),
//);
    //
//    $student_exams = $student_exam_model;

    $past_exams = PastExam::model()->getPastExamsOfStudent($student_id);

    if ($past_exams != null) {
        $this->renderpartial('_level_news_sidemenu');
        ?>
        <div class="span6"> 
            <h3 class="master_heading">Past Exams</h3>




            <?php

            foreach ($past_exams as $past_exam) {

                ?>

                <div class="well">
                    <table>
                        <tr>
                            <td width="150">
                                <strong>Exam Name</strong>
                            </td>
                            <td>
                                <?php echo Exam::model()->getExamName($past_exam['exam_id']); ?>
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                <strong>Score</strong>
                            </td>
                            <td>
                                <?php 
                                    if(Exam::model()->getExamType($past_exam['exam_id']) == "ESSAY"){
                                        $take_model = new Take;
                                        $take_model = Take::model()->findByPk($past_exam['take_id']);
                                        echo Take::model()->getResultOfTheTakeByStatus($past_exam['take_id'], $take_model->status);
                                    }else{
                                        echo FinalResult::model()->getScoreTake($past_exam['take_id']) . ' %'; 
                                    }
                                
                                ?>
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                <strong>Total Time Taken</strong>
                            </td>
                            <td>
                                <?php
                                $totaltime = PaperQuestion::model()->getTotalTimeTaken($past_exam['take_id']);

                                $mins = $totaltime / 60;
                                $secs = $totaltime % 60;
                                $roundmins = round($mins);

                                if ($secs > 30) {
                                    $roundmins = $roundmins - 1;
                                }

                                echo $roundmins . '&nbsp; <b>:</b> &nbsp;' . $secs . '&nbsp; minutes';
                                ?>


                            </td> 
                        </tr>
                        <tr>
                            <td>
                                <strong>Exam Date</strong>
                            </td>
                            <td>
                                <?php
                                $take = Take::model()->getTake($past_exam['take_id']);
                                echo $take['date'];
                                ?>
                            </td> 
                        </tr>
                    </table>
                    <br/>
                    <?php
                    echo CHtml::button('View Exam Summary', array('class' => 'bluebtn', 'submit' => array('Exam/viewExamSummary&id=' . $past_exam['take_id'])));
                    ?>


                </div>

                <?php
            }
            ?>

        </div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php } else {
    ?>
    <div class="span3"></div>
    <div class="span6">
        <h3 class="master_heading">Past Exams</h3>

        <p style="color: red;"><b>No past exams.</b></p>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/>
    </div> 

    <?php
}
?>

</div>





