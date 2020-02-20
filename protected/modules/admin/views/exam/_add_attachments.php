<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
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
            array('label' => 'Export To PDF', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
        );
?>

<h2 class="light_heading">Upload Attachments For Exam <?php echo $model->exam_id; ?></h2>
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
    <div class="span4">
        <div id="attachment_div"class="control-group" style="display:none">
            <input type="file" id="attachment_file" name="attachment_file[]" accept="image/*"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" id="attachment_remove" name="attachment_remove" onclick="removeAttachmentField(this)" value="Remove">
        </div>           
        <div id="attachment_append_div" class="control-group"></div>
        <div class="control-group">
            <input type="button" id="add_att_upload_field" onclick="addAnotherAttchField()" value="Add Attachment">
        </div>

        <?php
        echo '</br>';
        echo '</br>';
        echo CHtml::button('Upload Attchments', array('submit' => array('exam/saveAttachments'), 'class' => 'smallbluebtn'));
        ?>
    </div>
    <div class="span4">
        <h4>Uploaded Attachments</h4>
        <?php
        if(count($attachments) > 0){
            $i = 0;
            echo '<table class="table" id="attachment_table">';
            foreach ($attachments as $attachment) {
                echo '<tr id='.str_replace(' ', '', $attachment['attachment']).'>';
                    echo '<td>';
                    echo substr($attachment['attachment'],13);
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="button" id="view_attachment_'.$i.'" name="view_attachment_'.$i.'" onclick="viewAttachment(this)" value="View">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="button" id="delete_attachment_'.$attachment['attachment'].'" name="delete_attachment_'.$attachment['attachment'].'" onclick="deleteAttachment(this)" value="Delete">';
                    echo '</td>';
                echo '<td>';
                ?>
                <div>
                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'mydialog_exam_attachment_'.$i,
                        'options' => array(
                            'title' => substr($attachment['attachment'],13),
                            'width' => '800',
                            'height' => '400',
                            'autoOpen' => false,
                            'resizable' => false,
                            'modal' => false,
                            'overlay' => array(
                                'backgroundColor' => '#000',
                                'opacity' => '0.5'
                            ),
                        ),
                    ));

                    echo $this->renderPartial('_attachment_viewer', array('attachment' => $attachment['attachment']));
                    $this->endWidget('zii.widgets.jui.CJuiDialog');
                    ?>
                </div>
                <?php
                echo '</td>';
                echo '</tr>';
                $i++;
            }
            echo '</table>';
        }else{
            echo 'No attachments uploaded';
        }
        
        
        ?>
        <div class="control-group"><br/>
            <p style="display:none" id="uploaded_attachment"></p>
        </div>
        <div class="control-group"><br/>
            <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
        </div>
    </div>
</div>
<?php
$this->endWidget();

?>
<script type="text/javascript">
var attachNo = 1;
    function addAnotherAttchField() {
        var clone = $('#attachment_div').clone().attr('id', 'attachment_div_' + attachNo);
        clone.find('[type=file]').val('');
        clone.find("#attachment_file").attr('id', 'attachment_file_' + attachNo);
        clone.find("#attachment_remove").attr('name', 'attachment_remove_' + attachNo);
        clone.find("#attachment_remove").attr('id', 'attachment_remove_' + attachNo);
        $('#attachment_append_div').append(clone);
        clone.show();
        attachNo++;
    }
    function removeAttachmentField(element) {
        var no = decodeButtonName(element.name);
        document.getElementById('attachment_append_div').removeChild(element.parentNode);
        for (var x = no + 1; x < attachNo; x++) {
            var clone = $('#attachment_div_' + x);
            clone.attr('id', 'attachment_div_' + (x - 1));
            clone.find("#attachment_file_" + x).attr('id', 'attachment_file_' + (x - 1));
            clone.find("#attachment_remove_" + x).attr('name', 'attachment_remove_' + (x - 1));
            clone.find("#attachment_remove_" + x).attr('id', 'attachment_remove_' + (x - 1));
        }
        attachNo--;
    }
    function decodeButtonName(name) {

        var split = name.split('_');
        return parseInt(split[2]);
    }
    function deleteAttachment(element) {
        var element_names = element.name;
        var file_name = element_names.substring(18);
        if (confirm("Attachment will be removed from the Exam!") == true) {
            $.ajax({
                url: '<?php echo CController::createUrl('Exam/removeAttachments'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data: {
                    file_name: file_name,
                    exam_id: $('#exam_id').val(),
                },
                success: function (data) {
                    if (data[0].status == "success") {
                        var row = document.getElementById(file_name.split(' ').join(''));
                        row.parentNode.removeChild(row);
                        var rowCount = $('#attachment_table tr').length;
                        if(rowCount == 0){
                            $('#uploaded_attachment').append("No attachments uploaded");
                            $('#uploaded_attachment').show();
                        }
                    } else if (data[0].status == "fail") {
                        
                        $('#errorDisplay').append(data[0].message);
                        $('#errorDisplay').show();
                    }
                }
            });
        }      
    }
    function viewAttachment(element){
        var element_names = element.name;
        var file_name = element_names.substring(16);
        
        $('#mydialog_exam_attachment_'+file_name).dialog('open');
    }
    var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];

    function validate() {
        
//        var arrInputs = document.getElementsByTagName("attachment_file");
//        for (var i = 0; i < arrInputs.length; i++) {
//            var oInput = arrInputs[i];
//            if (oInput.type == "file") {
//                var sFileName = oInput.value;
//                if (sFileName.length > 0) {
//                    var blnValid = false;
//                    for (var j = 0; j < _validFileExtensions.length; j++) {
//                        var sCurExtension = _validFileExtensions[j];
//                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
//                            blnValid = true;
//                            break;
//                        }
//                    }
//
//                    if (!blnValid) {
//                        //hightlightTextBox("attachment_file_"+(i+1));
//                        return false;
//                    }
//                }
//            }
//        }

        return true;
    }
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }
</script>