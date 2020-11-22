<?php
$this->menu = array(
    array('label' => 'List Exam', 'url' => array('index')),
    array('label' => 'Create Exam', 'url' => array('create')),
    array('label' => 'Update Exam', 'url' => array('update', 'id' => $model->exam_id)),
    array('label' => 'Set Attachments', 'url' => array('setAttachments', 'id' => $model->exam_id)),
    array('label' => 'View Exam', 'url' => array('view', 'id' => $model->exam_id)),
    //array('label' => 'Update Instructions', 'url' => array('editExamInstruction', 'id' => $model->exam_id)),
    //    array('label' => 'Delete Exam', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->exam_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Exams', 'url' => array('admin')),
    array('label' => 'Export To PDF', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
);
?>
<h2 class="light_heading">Set Tables & Formulae for Exam <?php echo $model->exam_id; ?></h2>
<br/>

<?php
$form = $this->beginWidget(
        'CActiveForm', array(
    'id' => 'upload-instruction-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
);
?>

<input type="hidden" name="exam_id" value="<?php echo $model->exam_id; ?>"/>

<div id="preseen" class="well" style="display: block">
    <b>Tables & Formulae</b><br/><br/>

    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#pre1">Tab 1</a>
        </li>
        <?php
        for ($i = 2; $i < 16; $i++) {
            echo '<li><a data-toggle="tab" href="#pre' . $i . '">Tab ' . $i . '</a></li>';
        }
        ?>

    </ul>
    <div class="tab-content">
        <div id="pre1" class="tab-pane fade in active">
            <div class="span2">
                <input type="checkbox" id="text_answer1" value="text_answer1" name="ref_answer1" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>
            </div>
            <div class="span2">
                <input type="checkbox" id="image_answer1" value="image_answer1" name="ref_answer1" class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>
            </div>
            <br />
            <br />
            Tab Title 1&nbsp;&nbsp;&nbsp;
            <input type="text" name="pre_title_1" id="pre_title_1" placeholder="Tab Title 1"/><br/><br/>

            <div id="textarea1">
                Tables & Formulae Text<br/><br/>
                <textarea name="pre_formula_1" id="pre_formula_1" class="mceEditor"></textarea>                
            </div>

            <div id="ref_image_answer1">
                <div class="span2" style="margin-left: 0px">Upload Tables & Formulae</div><div class="span2"><input type="file" name="ref_file1" id="ref_file1" accept="image/*"></div>
            </div>
        </div>


        <?php
        for ($i = 2; $i < 16; $i++) {
            echo '<div id="pre' . $i . '" class="tab-pane fade">';

            echo '<div class="span2">';
            echo '<input type="checkbox" id="text_answer' . $i . '" value="text_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>';
            echo '</div>';
            echo '<div class="span2">';
            echo '<input type="checkbox" id="image_answer' . $i . '" value="image_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>';
            echo '</div>';
            echo '<br />';
            echo '<br />';

            echo 'Tab Title ' . $i . '&nbsp;&nbsp;&nbsp';
            echo '<input type="text" name="pre_title_' . $i . '" id="pre_title_' . $i . '" placeholder="Tab Title ' . $i . '"/><br/><br/>';

            //text content
            echo '<div id="textarea' . $i . '">';
            echo 'Preseen Material Text<br/><br/>';
            echo '<textarea name="pre_formula_' . $i . '" id="pre_formula_' . $i . '" class="mceEditor"></textarea>';
            echo '</div>';

            //pdf content
            echo '<div id="ref_image_answer' . $i . '"><div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file' . $i . '" id="ref_file' . $i . '" accept="image/*"></div>
                </div>';

            echo '</div>';
        }
        ?>
    </div>
    <br />
</div>    


<br /><br />

<div class="row">
    <div class="span2">
        <?php
        echo CHtml::button('Save Materials', array('submit' => array('exam/saveTablesFormulae'), 'class' => 'smallbluebtn'));
        ?>
    </div>
</div>



<?php
$this->endWidget();
?>


<script type="text/javascript">
    //reference material check box functions
    $(document).ready(function () {
        for (i = 1; i < 16; i++) {
            $("#text_answer" + i).attr("checked", true);
            $("#ref_image_answer" + i).hide();
        }
        function createCallback(i) {
            return function () {
                $("#image_answer" + i).attr("checked", false);
                $("#ref_image_answer" + i).hide();
                $("#textarea" + i).show();
                $('#upload_ref_title').hide();
                $('#tab1_file_name').hide();

            }
        }

        function createImageCallback(i) {
            return function () {
                $("#text_answer" + i).attr("checked", false);
                $("#textarea" + i).hide();
                $('#upload_ref_title').show();
                $('#tab1_file_name').show();
                $("#ref_image_answer" + i).show();
            }
        }

        $(document).ready(function () {
            for (var i = 1; i < 16; i++) {
                $('input:checkbox[id=text_answer' + i + ']').click(createCallback(i));
            }
        });

        $(document).ready(function () {
            for (var i = 1; i < 16; i++) {
                $('input:checkbox[id=image_answer' + i + ']').click(createImageCallback(i));
            }
        });
    });
</script>


<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script>

    tinymce.init({
        mode: "textareas",
        theme: "modern",
        editor_selector: "mceEditor",
        editor_deselector: "mceNoEditor",
        width: 800,
        height: 250,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor jbimages"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image jbimages | print preview media fullpage | forecolor backcolor emoticons",
        relative_urls: false,
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]

    });
</script>
