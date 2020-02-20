<?php
Yii::app()->clientScript->scriptMap = array(
    (YII_DEBUG ? 'jquery.js' : 'jquery.min.js') => false,
    'jquery.ba-bbq.js' => false
);
?>
<div class="wrapper wrapper-side-margined-table" id="question-list">

    <h2 class="item-left-margined"><?php echo $title; ?></h2>
    <br />

    <?php
    //$question_arry =
    //echo '<pre>';print_r($question_array); die;
    //var_dump($question_array); die;
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $question_array,
        'itemView' => '_essay_question_status',
        'viewData' => array('time_status' => $time_status),
        'enablePagination' => false,
    ));
    ?>

</div>

<div id="btn-end" class="wrapper wrapper-side-margined wrapper-top-margined">

    <?php
    $user_id = Yii::app()->user->getID();
    if ($unanswered != 0) {
        $messageConfirm = "You have chosen to end the current review, but have " . $unanswered . " incomplete questions. If you click Yes, you will NOT be able to return to this review and your exam will end.<br/>Are you sure you want to end this review and your exam?";
    } else {
        $messageConfirm = "You have chosen to end the current review. If you click Yes, you will NOT be able to return to this review and your exam will end.<br/>Are you sure you want to end this review and your exam?";
    }
    if ($user_id != null) {
//        echo CHtml::ajaxButton('End Exam', Yii::app()->createUrl('Exam/endEssayExam'), array(
//            'type' => 'POST',
//            'dataType' => 'json',
//            'data' => array(
//                'exam_id' => $exam_id,
//                'total_exam_time' => 'js:getTotalTimeTakenForExamLoggedIn()',
//            ),
//            'error' => 'js:function(xhr, status, error){
//            }',
//            'success' => 'js:function(data){
//                              if(data.status="success"){
//                                document.location.href = data.redirect_url; 
//                              }
//                            }'
//                ), array(
//            'confirm' => 'Are you sure you want to end the exam?',
//            'class' => 'btn-large btn-block button button-news',
//            'id' => 'exam-status'
//        ));
        ?>
        <input type="button" id="exam-status" class="btn-large btn-block button button-news" value="End Exam" onclick="bootFunction()">
        <?php
    } else {
        echo CHtml::button('End Exam Sample', array(
            'submit' => Yii::app()->createUrl("Exam/endExam", array("exam_id" => $exam_id)),
            'confirm' => 'Are you sure?',
            'class' => 'btn-large btn-block button button-news',
            'id' => 'exam-status'));
    }
    ?>


</div>


<script type="text/javascript">

    function bootFunction() {
        bootbox.confirm({
            title: "End Review",
            message: "<?php echo $messageConfirm; ?>",
            buttons: {
                'cancel': {
                    label: 'No'
                },
                'confirm': {
                    label: 'Yes'
                }
            },
            callback: function (result) {
                if (result === true) {
                    sendRequestStatus();
                }
            }
        });
    }


    function sendRequestStatus() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/endEssayExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                exam_id: <?php echo $exam_id; ?>,
                total_exam_time: getTotalTimeTakenForExamLoggedIn(),
            },
            success: function (data) {
                if (data) {
                    if (data.status == "success") {
                        document.location.href = data.redirect_url;
                    }
                }
            }
        });
    }

</script>