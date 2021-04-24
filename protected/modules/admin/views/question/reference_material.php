<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1) {

    $this->breadcrumbs = array(
        'Questions' => array('index'),
        $id,
    );

    $this->menu = array(
        array('label' => 'List Questions', 'url' => array('index')),
        array('label' => 'Create Question', 'url' => array('create')),
        array('label' => 'Update Question', 'url' => array('update', 'id' => $id)),
        array('label' => 'Manage Questions', 'url' => array('admin')),
    );
    ?>

    <?php
    $form = $this->beginWidget(
            'CActiveForm', array(
        'id' => 'upload-referenceMaterial-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );
    ?>

    <input type="hidden" name="question_id" value="<?php echo $id; ?>"/>

    <div class="span10">
        <h4>Reference material</h4>

        <div class="bs-example">
            <ul class="nav nav-tabs" >
                <li class="active"><a data-toggle="tab" href="#ref_section1">Tab 1</a></li>
                <?php
                for ($i = 2; $i < 16; $i++) {
                    echo '<li><a data-toggle="tab" href="#ref_section' . $i . '">Tab ' . $i . '</a></li>';
                }
                ?>
            </ul>
            <div class="tab-content">     


                <div id="ref_section1" class="tab-pane fade in active">
                    <div class="span2">
                        <input type="checkbox" id="text_answer1" value="text_answer1" name="ref_answer1" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>
                    </div>
                    <div class="span2">
                        <input type="checkbox" id="image_answer1" value="image_answer1" name="ref_answer1" class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>
                    </div>
                    <br />
                    <br />
                    Tab Title 1&nbsp;&nbsp;&nbsp;
                    <input type="text" name="ref_tab_title_1" id="ref_tab_title_1" placeholder="Tab Title 1"/><br/><br/>

                    <div id="textarea1">Reference Text<br/><br/>
                        <textarea name="ref_table_formula_1" id="ref_table_formula_1" class="mceEditor"></textarea>
                    </div>

                    <div id="ref_image_answer1">
                        <div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file1" id="ref_file1" accept="jpg,jpeg,png,tif,gif"></div>
                    </div>
                </div>

                <?php
                //reference material tabs
                for ($i = 2; $i < 16; $i++) {
                    echo '<div id="ref_section' . $i . '" class="tab-pane fade">';
                    //add the check boxes
                    echo '<div class="span2">';
                    echo '<input type="checkbox" id="text_answer' . $i . '" value="text_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined"><span id="answercheck-text">Reference as Text</span>';
                    echo '</div>';
                    echo '<div class="span2">';
                    echo '<input type="checkbox" id="image_answer' . $i . '" value="image_answer' . $i . '" name="ref_answer' . $i . '" class="checkbox-margined"><span id="answercheck-text">Reference as Image</span>';
                    echo '</div>';
                    echo '<br />';
                    echo '<br />';

                    //tab tile input
                    echo "Tab Title $i&nbsp;&nbsp;&nbsp;";
                    echo '<input type="text" name="ref_tab_title_' . $i . '" id="ref_tab_title_' . $i . '" placeholder="Tab Title ' . $i . '"/><br/><br/>';

                    //tab body
                    echo '<div id="textarea' . $i . '">Reference Material Text<br/><br/>';
                    echo '<textarea name="ref_table_formula_' . $i . '" id="ref_table_formula_' . $i . '" class="mceEditor"></textarea></div>';
                    echo '<div id="ref_image_answer' . $i . '"><div class="span2" style="margin-left: 0px">Upload reference material</div><div class="span2"><input type="file" name="ref_file' . $i . '" id="ref_file' . $i . '" accept="jpg,jpeg,png,tif,gif"></div>
                </div>
                </div>';
                }
                ?>
            </div>
        </div>
        <br /><br /><br />
    </div>


    <div class="row">
        <div class="span2">
            <?php
            echo CHtml::button('Set Reference Material', array('submit' => array('question/setReferenceMaterial'), 'class' => 'bluebtn'));
            ?>
        </div>
    </div>


    <?php
    $this->endWidget();
    ?>

    <?php
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>

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
    function createCallback(i) {
        return function () {
            $("#image_answer" + i).attr("checked", false);
            $("#ref_image_answer" + i).hide();
            $("#textarea" + i).show();
        }
    }

    function createImageCallback(i) {
        return function () {
            $("#text_answer" + i).attr("checked", false);
            $("#textarea" + i).hide();
            $("#ref_image_answer" + i).show();
        }
    }

    $(document).ready(function () {
        
        for (i = 1; i < 16; i++) {
            $("#text_answer" + i).attr("checked", true);
            $("#ref_image_answer" + i).hide();           
            $("#textarea" + i).show();
        }


        for (var i = 1; i < 16; i++) {
            $('input:checkbox[id=text_answer' + i + ']').click(createCallback(i));
        }
        
        //        for (i = 1; i < 16; i++) {
        //            $("#text_answer" + i).attr("checked", true);
        //            $("#ref_image_answer" + i).hide();
        //            $("#textarea" + i).show();
        //        }

        for (var i = 1; i < 16; i++) {
            $('input:checkbox[id=image_answer' + i + ']').click(createImageCallback(i));
        }
    });

</script>
