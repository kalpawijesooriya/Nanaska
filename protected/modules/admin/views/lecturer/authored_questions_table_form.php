<script>
    $(function () {
        $("a").bind("click", function () {
            var question_id = this.innerHTML;
            $("#mydialog_" + question_id).dialog("open");
            //return false;
        });
    });
</script>

<?php
Yii::app()->clientScript->scriptMap = array(
        //'jquery-ui.min.js' => false,
        //'jquery.js' => false,
        //'jquery.ba-bbq.js' => false
);
//print_r($questions);
?>
<div class="control-group">
    <strong>Lecturer Code&nbsp;&nbsp;</strong>
    <?php
    echo Lecturer::model()->getLecturerCode($lecturer_id);
    ?>
</div>

<div class="control-group">
    <strong>Lecturer Name&nbsp;&nbsp;</strong>

    <?php
    $user_id = Lecturer::getUserIdByLecturerId($lecturer_id);

    $user_data = User::getUserInfoById($user_id);

    echo $user_data['first_name'] . " " . $user_data['last_name'];
    ?>
</div>

<br/>

<?php
//if ($questions != null) {
?>
<table border="1">
    <tr>
        <th width="200">Question ID</th>
        <th width="200">Type</th>
        <th width="200">Date Created</th>
        <!--<th width="200">Action</th>-->
        <th width="200">Status</th>
    </tr>
    <?php
//    var_dump($questions);

    if ($questions != null) {
        foreach ($questions as $question) {
            echo '<tr height="30px">';
            echo '<td><center>';

            echo '<a id="qLink">';
            echo $question['question_id'];
            echo '</a>';

            echo '</td></center>';
            echo '<td><center>';
            echo Question::model()->getQuestionTypeLabel($question['question_type']);
            echo '</td></center>';
            echo '<td><center>';
            echo $question['date_created'];
            echo '</td></center>';
            echo '<td><center>';

            if ($question['approved'] == 0) {
                ?>

                <b id="action_<?php echo $question['question_id']; ?>">

                    Un-Approved
                </b>

                <?php
            } else {
                ?>

                <b id="action_<?php echo $question['question_id']; ?>">

                    Approved
                </b>

                <?php
            }
            echo '</td></center>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="5"><center>';
        echo 'No Un-Approved Questions For the Selected Lecturer';
        echo '</td></center>';
        echo '</tr>';
    }
    ?>    

</table>

<?php
//}
?>


<?php
foreach ($questions as $question) {

//    echo '<script>alert("rese");</script>';

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'mydialog_' . $question['question_id'],
        'options' => array(
            'title' => 'Question ' . $question['question_id'],
            'width' => 1000,
            'height' => 500,
            'autoOpen' => false,
            'resizable' => true,
            'modal' => false,
            'overlay' => array(
                'backgroundColor' => '#000',
                'opacity' => '0.5'
            ),
//        'buttons' => array(
//                'OK' => 'js:function(){alert("OK");}',
//                'Cancel' => 'js:function(){$(this).dialog("close");}',
//                'Close' => 'js:function(){$("#mydialog_' . $question['question_id'] . '").dialog("destroy");}',
//        ),
        ),
    ));

    echo $this->renderPartial('_viewQuestionDialog', array('question_id' => $question['question_id']));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
}
?>

