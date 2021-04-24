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
<h2 class="light_heading">Edit Instructions for Exam <?php echo $model->exam_id; ?></h2>
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

<?php
$examInstruction = Exam::model()->getExamInstructionForExam($model->exam_id);
$extension = substr($examInstruction, strrpos($examInstruction, '.') + 1);
$extension = strtolower($extension);
?>



<?php
if ($extension == "jpg" || $extension == "png" || $extension == "tif" || $extension == "gif") {
    $type = 0;
    ?>
    <div class="row">    
        <div class="span2">
            <input type="checkbox" id="text_answer1" value="text_answer1" name="instruction" class="checkbox-margined"><span id="answercheck-text">Instructions as Text</span>
        </div>
        <div class="span2">
            <input type="checkbox" id="image_answer1" value="image_answer1" name="instruction" class="checkbox-margined" checked="true"><span id="answercheck-text">Instructions as Image</span>
        </div>
    </div>
    <?php
} else {
    $type = 1;
    ?>
    <div class="row">    
        <div class="span2">
            <input type="checkbox" id="text_answer1" value="text_answer1" name="instruction" class="checkbox-margined" checked="true"><span id="answercheck-text">Instructions as Text</span>
        </div>
        <div class="span2">
            <input type="checkbox" id="image_answer1" value="image_answer1" name="instruction" class="checkbox-margined"><span id="answercheck-text">Instructions as Image</span>
        </div>
    </div>
    <?php
}
?>


<br /><br />


<?php
if ($extension == "jpg" || $extension == "png" || $extension == "tif" || $extension == "gif") {
    ?>
    <div class="row">
        <div id="text_instructions">
            <div class="span2"><textarea id="txt_ins" name="txt_ins"></textarea></div>
        </div>
        <div class="span10" id="textBox">
            <div class="span2" style="margin-left: 0px;">Uploaded Image : </div><div class="span2"><input type="text" value="<?php echo $examInstruction; ?>" readonly="true"></div>
        </div>

        <div id="image_instructions">
            <div class="span2">Upload Instructions as Image</div><div class="span2"><input type="file" name="instruction_file" id="instruction_file" accept="image/*"></div>
        </div>
    </div>

    <?php
} else {
    ?>
    <div class="row">
        <div id="text_instructions">
            <div class="span2"><textarea id="txt_ins" name="txt_ins"><?php echo $examInstruction; ?></textarea></div>
        </div>

        <div id="image_instructions">
            <div class="span2">Upload Instructions as Image</div><div class="span2"><input type="file" name="instruction_file" id="instruction_file" accept="image/*"></div>
        </div>
    </div>
    <?php
}
?>


<br /><br />

<div class="row">
    <div class="span2">
        <?php
        echo CHtml::button('Update Instructions', array('submit' => array('exam/saveExamInstructions'), 'class' => 'smallbluebtn'));
        ?>
    </div>
</div>



<?php
$this->endWidget();
?>


<script type="text/javascript">

    $(document).ready(function(){
        
        var type = <?php echo $type; ?>;
        
        if(type==0){
            $("#text_instructions").hide();
            $("#image_answer1").attr("checked",true);
        }else{
            $("#image_instructions").hide();
            $("#textBox").hide();
            $("#text_answer1").attr("checked",true);
        }
        
        
        $('input:checkbox[name=instruction]').click(function()
        {
            if($(this).is(':checked'))
                if($(this).val() == 'text_answer1')
            {               
                $("#image_answer1").attr("checked",false);               
                $('#text_instructions').show();
                $("#image_instructions").hide();
                $("#textBox").hide();
                
            }
            else if($(this).val() == 'image_answer1')
            {
                $("#text_answer1").attr("checked",false);
                $('#text_instructions').hide();
                $("#image_instructions").show();          
                $("#textBox").show();
            }
        })
     
    });

</script>



<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script>

    tinymce.init({
        selector: "textarea",        
        theme: "modern",
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