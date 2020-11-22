<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //  $('#image').css('background', 'transparent url('+e.target.result +') left top no-repeat') .width('Auto').height(500);

                $('#imge')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(auto);

            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php 
$this->menu = array(
            array('label' => 'List Exam', 'url' => array('index')),
            array('label' => 'Create Exam', 'url' => array('create')),
            array('label' => 'Update Exam', 'url' => array('update', 'id' => $model->exam_id)),
            array('label' => 'Set Attachments', 'url' => array('setAttachments', 'id' => $model->exam_id)),
            array('label'=>'View Exam','url'=>array('view','id'=>$model->exam_id)),
            //array('label' => 'Update Instructions', 'url' => array('editExamInstruction', 'id' => $model->exam_id)),
            //    array('label' => 'Delete Exam', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->exam_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Exams', 'url' => array('admin')),
            array('label' => 'Export To Excel', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
        );
?>

<h2 class="light_heading">Upload an Exhibit For Exam <?php echo $model->exam_id; ?></h2>
<br/>
<?php
$form = $this->beginWidget(
        'CActiveForm', array(
    'id' => 'upload-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
);
//var_dump($attachments);
?>
<input type="hidden" id="exam_id" name="exam_id" value="<?php echo $model->exam_id; ?>"/>
<div class="row">
    <div class="span10">
        <div class="control-group">
            <div id="exhibit" class="well">
                <b>Exhibit</b><br/><br />
                <div class="span2">Upload the Exhibit as Image</div>
                <br><br>
                <div class="span2"><input type="file" name="exhibit_file" id="exhibit_file" accept="image/*" onchange="readURL(this);"></div>
    
                <br/><br/>
                <div id="image" style="width:400px; height:auto ">
                    <b>Preview</b>
                    <img id="imge"/>

                </div>
            </div>

        </div>
    </div>
</div>

<br /><br />

<div class="row">
    <div class="span2">
        <?php
        echo CHtml::button('Save Exhibit', array('submit' => array('exam/saveExhibitData'), 'class' => 'smallbluebtn'));
        ?>
    </div>
</div>
<?php
$this->endWidget();

?>
