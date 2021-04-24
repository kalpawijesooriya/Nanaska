<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'question-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<h3>Export Exam to PDF</h3>


<div class="control-group">
    <!--<input type="hidden" id="btnExport" name="btnExport"  value="<?php // echo $model->exam_id ?>">-->
    <?php
    echo CHtml::link("Export To PDF", array('exam/export', 'exam_id' => $model->exam_id), array('class' => 'smallbluebtn', 'target' => '_blank'));
    ?>
</div>


<div class="well transparent">
    <p>Once you press on the 'Export To PDF' button,you will be redirected to the Exam page.</p>
    <p>To convert the exam in to PDF form press Ctrl+P</p>
</div>

<?php $this->endWidget(); ?>
