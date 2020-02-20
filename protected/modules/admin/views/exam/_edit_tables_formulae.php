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
    array('label' => 'Export To Excel', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
);
?>
<h2 class="light_heading">Update Tables & Formulae for Exam <?php echo $model->exam_id; ?></h2>
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
<div class="control-group">
    <h4>Tables & Formulae</h4>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#ref_section1">Tab 1</a></li>
        <?php
        for ($i = 2; $i < 16; $i++) {
            echo '<li><a data-toggle="tab" href="#ref_section' . $i . '">Tab ' . $i . '</a></li>';
        }
        ?>
    </ul>

    <div class="tab-content">
        <div id="ref_section1" class="tab-pane fade in active">
            <?php
            $questionReferenceMat = ExamTablesAndFormulae::model()->findByAttributes(array('exam_id' => $model->exam_id, 'tab_position' => 1));

            if (!empty($questionReferenceMat)) {
                $questionReferencematTabtitle = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $questionReferenceMat->exam_tables_and_formulae_id));
            } else {
                $questionReferencematTabtitle = null;
            }

            if (isset($questionReferenceMat->tables_and_formulae_text)) {
                ?>
                <div class="span2">
                    <input type="checkbox" id="text_answer1" value="text_answer1" name="ref_answer1" checked="true" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>
                </div>
                <?php
            } else {
                ?>
                <div class="span2">
                    <input type="checkbox" id="text_answer1" value="text_answer1" name="ref_answer1" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>
                </div>  
                <?php
            }

            if (isset($questionReferenceMat->table_formulae_image)) {
                ?>
                <div class="span2">
                    <input type="checkbox" id="image_answer1" value="image_answer1" name="ref_answer1" checked="true" class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>
                </div>
                <?php
            } else {
                ?>
                <div class="span2">
                    <input type="checkbox" id="image_answer1" value="image_answer1" name="ref_answer1"  class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>
                </div>
                <?php
            }
            ?>

            <br />
            <br />

            Tab Title 1&nbsp;&nbsp;&nbsp;

            <?php
            if (!empty($questionReferencematTabtitle)) {
                ?>
                <input type="text" name="ref_tab_title_1" id="ref_tab_title_1" placeholder="Tab Title 1" value="<?php echo $questionReferencematTabtitle['tab_title']; ?>"/><br/><br/>

                <?php
            } else {
                ?>
                <input type="text" name="ref_tab_title_1" id="tab_title_1" placeholder="Tab ref_tab_title_1 1"/><br/><br/>

                <?php
            }

            if (isset($questionReferenceMat['tables_and_formulae_text'])) {
                ?>
                <div id="textarea1">Table Text<br/><br/>
                    <textarea name="ref_table_formula_1" id="ref_table_formula_1"><?php echo $questionReferenceMat['tables_and_formulae_text']; ?></textarea>
                </div>
                <?php
            } else {
                ?>
                <div id="textarea1" style="display: none;">Table Text<br/><br/>
                    <textarea name="ref_table_formula_1" id="ref_table_formula_1" ></textarea>
                </div>  

                <?php
            }
            ?>
            <?php
            if (isset($questionReferenceMat['table_formulae_image'])) {
                ?>
                <div class="span2" id="upload_ref_title" style="margin-left: 0px;"><b>Uploaded </b></div><div class="span7"><input type="text" id="tab1_file_name" value="<?php echo $questionReferenceMat['table_formulae_image']; ?>" readonly="true"></div>
                <br />  <br />
                <div id="ref_image_answer1">
                    <div class="span2" style="margin-left: 0px">Upload table image</div><div class="span2"><input type="file" name="ref_file1" id="ref_file1" accept="jpg,jpeg,png,tif,gif"></div>
                </div>  
                <?php
            } else {
                ?>
                <div id="ref_image_answer1" style="display: none;">
                    <div class="span2" style="margin-left: 0px">Upload table image</div><div class="span2"><input type="file" name="ref_file1" id="ref_file1" accept="jpg,jpeg,png,tif,gif"></div>
                </div>    
                <?php
            }
            ?>
        </div>
        <?php
        for ($i = 2; $i < 16; $i++) {
            echo '<div id="ref_section' . $i . '" class="tab-pane fade">';
            $questionReferenceMat = ExamTablesAndFormulae::model()->findByAttributes(array('exam_id' => $model->exam_id, 'tab_position' => $i));

            if (!empty($questionReferenceMat)) {
                $questionReferencematTabtitle = ExamTablesAndFormulaeTabTitle::model()->findByAttributes(array('exam_tables_and_formulae_id' => $questionReferenceMat->exam_tables_and_formulae_id));
            } else {
                $questionReferencematTabtitle = null;
            }

            if (isset($questionReferenceMat->tables_and_formulae_text)) {

                echo '<div class="span2">';
                echo '<input type="checkbox" id="text_answer' . $i . '" value="text_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined" checked><span id="answercheck-text">Reference as Text</span>';
                echo '</div>';

                echo '<div class="span2">';
                echo '<input type="checkbox" id="image_answer' . $i . '" value="image_answer' . $i . '" name="ref_answer' . $i . '"  class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>';
                echo '</div>';
            } else if (isset($questionReferenceMat->table_formulae_image)) {
                echo '<div class="span2">';
                echo '<input type="checkbox" id="text_answer' . $i . '" value="text_answer' . $i . '" name="ref_answer' . $i . '"  class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>';
                echo '</div>';

                echo '<div class="span2">';
                echo '<input type="checkbox" id="image_answer' . $i . '" value="image_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined" checked><span id="answercheck-text">Reference as Image</span>';
                echo '</div>';
            } else {
                echo '<div class="span2">';
                echo '<input type="checkbox" id="text_answer' . $i . '" value="text_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined" checked><span id="answercheck-text">Reference as Text</span>';
                echo '</div>';

                echo '<div class="span2">';
                echo '<input type="checkbox" id="image_answer' . $i . '" value="image_answer' . $i . '" name="ref_answer' . $i . '"  class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>';
                echo '</div>';
            }

            echo '<br />';
            echo '<br />';

            echo 'Tab Title ' . $i . '&nbsp;&nbsp;&nbsp;';

            if (!empty($questionReferencematTabtitle)) {
                echo '<input type="text" name="ref_tab_title_' . $i . '" id="ref_tab_title_' . $i . '" placeholder="Tab Title ' . $i . '" value="' . $questionReferencematTabtitle->tab_title . '"/><br/><br/>';
            } else {
                echo '<input type="text" name="ref_tab_title_' . $i . '" id="tab_title_' . $i . '" placeholder="Tab ref_tab_title_' . $i . '"/><br/><br/>';
            }

            if (isset($questionReferenceMat->tables_and_formulae_text)) {
                echo '<div id="textarea1">Reference Text<br/><br/>';
                echo '<textarea name="ref_table_formula_' . $i . '" id="ref_table_formula_' . $i . '">' . $questionReferenceMat->tables_and_formulae_text . '</textarea>';
                echo '</div>';

                echo '<div id="ref_image_answer' . $i . '" style="display: none;">';
                echo '<div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file' . $i . '" id="ref_file' . $i . '" accept="jpg,jpeg,png,tif,gif"></div>';
                echo '</div>';
            } else if (isset($questionReferenceMat->table_formulae_image)) {
                echo '<div id="textarea' . $i . '" style="display: none;">Reference Text<br/><br/>';
                echo '<textarea name="ref_table_formula_' . $i . '" id="ref_table_formula_' . $i . '" ></textarea>';
                echo '</div>';


                echo '<span id="uploadedfile' . $i . '"><div class="span2" id="upload_ref_title" style="margin-left: 0px;"><b>Uploaded reference</b></div><div class="span7"><input type="text" id="tab' . $i . '_file_name" value="' . $questionReferenceMat->table_formulae_image . '" readonly="true"></div></span>';
                echo '<br />  <br />';
                echo '<div id="ref_image_answer' . $i . '">';
                echo '<div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file' . $i . '" id="ref_file' . $i . '" accept="jpg,jpeg,png,tif,gif"></div>';
                echo '</div>';
            } else {
                echo '<div id="textarea' . $i . '" style="display: block;">Reference Text<br/><br/>';
                echo '<textarea name="ref_table_formula_' . $i . '" id="ref_table_formula_' . $i . '" ></textarea>';
                echo '</div>';

                echo '<div id="ref_image_answer' . $i . '" style="display: none;">';
                echo '<div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file' . $i . '" id="ref_file' . $i . '" accept="jpg,jpeg,png,tif,gif"></div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <br /><br /><br />
</div>


<div class="row">
    <div class="span2">
        <?php
        echo CHtml::button('Update Tables & Formulae', array('submit' => array('exam/updateTablesData'), 'class' => 'bluebtn'));
        ?>
    </div>
</div>

<?php
$this->endWidget();
?>




<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script>

    tinymce.init({
        selector: "#ref_table_formula_1,#ref_table_formula_2,#ref_table_formula_3, \n\
                   #ref_table_formula_4,#ref_table_formula_5,#ref_table_formula_6,#ref_table_formula_7,#ref_table_formula_8,#ref_table_formula_9, \n\
                   #ref_table_formula_10,#ref_table_formula_11,#ref_table_formula_12,#ref_table_formula_13,#ref_table_formula_14, \n\
                   #ref_table_formula_15,#ref_table_formula_16",
        theme: "modern",
        editor_selector: "mceEditor",
        editor_deselector: "mceNoEditor",
        width: 800,
        height: 250,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
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

<script type="text/javascript">

    //reference material check box functions
    //    $(document).ready(function () {
    //        for (i = 1; i < 16; i++) {
    //           // $("#text_answer" + i).attr("checked", true);
    //          //  $("#ref_image_answer" + i).hide();
    //           // $("#textarea" + i).show();
    //        }
    //    });
    //for (i = 1; i < 16; i++) {
    //        $('input:checkbox[id=image_answer1]').click(function ()
    //        {
    //            $("#text_answer1").attr("checked", false);
    //            $("#textarea1").hide();
    //            $("#ref_image_answer1").show();
    //        });
    //
    //        $('input:checkbox[id=text_answer1]').click(function ()
    //        {
    //            $("#image_answer1").attr("checked", false);
    //            $("#ref_image_answer1").hide();
    //            $("#textarea1").show();
    //        });

    function createCallback(i) {
        return function () {
            $("#image_answer" + i).attr("checked", false);
            $("#ref_image_answer" + i).hide();
            $("#uploadedfile" + i).hide();
            $("#textarea" + i).show();
        }
    }

    function createImageCallback(i) {
        return function () {
            $("#text_answer" + i).attr("checked", false);
            $("#textarea" + i).hide();
            $("#uploadedfile" + i).show();
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
    //}


</script>
