<div id="dialog_data">
<?php
$question = Question::model()->findByPk($questionID);
if ($question != NULL) {
    if ($question->exhibit_attachment != NULL) {
        $location = Yii::app()->baseUrl . '/images/exhibit_attachment/' . $questionID . '/' . $question['exhibit_attachment'];
        echo '<img src="'.$location.'" style="width:relative;height:relative">';
        ?>
        <br><br>
        <?php
    }else{
        echo '<h4>';
        echo 'No Question Exhibit';
        echo '</h4>';
    }
}
?>
</div>