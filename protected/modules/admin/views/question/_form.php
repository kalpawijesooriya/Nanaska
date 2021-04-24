<!--<link rel="stylesheet" href="../../sceditor/minified/themes/default.min.css" type="text/css" media="all" />-->
<!--<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/sceditor/minified/themes/default.min.css" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<!--<script src="../../sceditor/minified/jquery.sceditor.bbcode.min.js"></script>-->

<style>
    .asterix{
        color: red;
    }
</style>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php $cs = Yii::app()->clientScript;
$cs->coreScriptPosition = $cs::POS_END;

$cs->scriptMap = array(
    'jquery.js'=>false,
    'jquery.ui.js'=>false,
    'jquery.min.js'=>false
); ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-1.8.0.js"></script>

<?php
//Yii::app()->session['drag_drop_typeb_session'] = array();
$user_id = Yii::app()->user->getId();
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'question-form',
    'enableAjaxValidation' => false,
//        'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>


<?php //echo $form->errorSummary($model);  ?>
<?php
//foreach (Yii::app()->user->getFlashes() as $key => $message) {
//    echo '<div class="alert alert-danger">' . $message . "</div>\n";
//}
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php //echo $form->errorSummary($model);  ?>
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-danger">' . $message . "</div>\n";
}
?>
<div class="container">
    <div class="row">
        <div class="span3">
            <div class="control-group">
                <?php
                echo 'Course <span class="asterix">*</span>';
                echo '<br>';
                echo CHtml::dropDownList('course_id', '', Course::model()->getCoursesForUser($user_id), array(
                    'empty' => 'Select Course',
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('Level/getLevelsForUser'),
                        'update' => '#level_id',
                        'beforeSend' => 'function() {                    
                if(subject_id.value!=""){                
                     subject_id.options.length = 1;                  
                }
                
                if(Question_subject_area_id.value!=""){
                    Question_subject_area_id.options.length = 1; 
                }
                
                
            
        }',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
                <b id="course_error"></b>
            </div>

            <div class="control-group">
                <?php
                echo 'Level <span class="asterix">*</span>';
                echo '<br>';
                echo CHtml::dropDownList('level_id', '', array(), array(
                    'empty' => 'Select Level',
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('Subject/getSubjectsForUser'),
                        'update' => '#subject_id',
                        'beforeSend' => 'function() {  
                    if(Question_subject_area_id.value!=""){
                    Question_subject_area_id.value="";
                }
            }',
                    )));
                ?>   </div>

            <?php echo $form->error($model, 'level_id', array('class' => 'alert alert-danger')); ?>


            <div class="control-group">
                <?php
                echo 'Subjects <span class="asterix">*</span>';
                echo '<br>';
                echo CHtml::dropDownList('subject_id', '', array(), array(
                    'empty' => 'Select Subject',
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('subjectArea/getSubjectAreas'),
                        'update' => '#Question_subject_area_id',
                    )));
                ?></div>
        </div>

        <div class="span9">
            <div class="control-group">
                <?php
                echo 'Subject Area <span class="asterix">*</span>';
                echo '<br>';
                echo $form->dropDownList($model, 'subject_area_id', array(), array('empty' => 'Select Subject Area'));
                ?></div>

            <?php
            //    echo '<br>';
            ?>
            <div class="control-group">
                <?php
                echo 'Question Type <span class="asterix">*</span>';
                echo '<br>';
                echo CHtml::dropDownList('question_type', '', array(
                    '' => 'Select Question Type',
                    'SINGLE_ANSWER' => 'Single Answer Questions',
                    'MULTIPLE_ANSWER' => 'Multiple Answer Questions',
                    'SHORT_WRITTEN' => 'Short Written Answer Questions',
                    'DRAG_DROP_TYPEA_ANSWER' => 'Drag & Drop Type A Answer Questions',
                    'DRAG_DROP_TYPEB_ANSWER' => 'Drag & Drop Type B Answer Questions',
                    'DRAG_DROP_TYPEC_ANSWER' => 'Drag & Drop Type C Answer Questions',
                    'DRAG_DROP_TYPED_ANSWER' => 'Drag & Drop Type D Answer Questions',
                    'DRAG_DROP_TYPEE_ANSWER' => 'Drag & Drop Type E Answer Questions',
                    'MULTIPLE_CHOICE_ANSWER' => 'Multiple Choice Answer Questions',
                    'TRUE_OR_FALSE_ANSWER' => 'True Or false Answer Questions',
                    'HOT_SPOT_ANSWER' => 'Hot Spot Answer Questions',
                    'ESSAY_ANSWER' => 'Essay Answer Questions'
                ), array(
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('Question/getAnswerForms'),
                        'update' => '#answer-rows',
                        'complete' => 'function(){
                            
                       
                var x = $("#question_type").val();
                    if(x=="ESSAY_ANSWER"){
                     $("#exhibit_attach").hide();
                    }else{
                     $("#exhibit_attach").show();
                    }

                if(x=="HOT_SPOT_ANSWER"){                
                     $("#preview_bn").hide();
                     $("#button_row").css("margin-top","450px");
                }else{
                    $("#preview_bn").show();
                    $("#button_row").css("margin-top","10px");
                }
            }'
                    )));
                ?>   </div>

            <?php echo $form->textFieldRow($model, 'number_of_marks', array('maxlength' => 200, 'placeholder' => 'Number Of Marks')); ?>

        </div>
    </div>

    <div class="row">
        <div class="span3" id="exhibit_attach">
            <div class="control-group">
                <!--                <div class="span2">Upload exhibit</div>
                                <div class="span2"><input type="file" id="exhibit_file" name="exhibit_file" /></div>-->
                <?php
                echo $form->labelEx($model, 'exhibit_attachment');
                echo $form->fileField($model, 'exhibit_attachment');
                echo $form->error($model, 'exhibit_attachment');
                ?>
            </div>
        </div>
    </div>

    <br/>
    <div class="row">
        <div class="span3">
            <div class="checkbox">
                <?php echo $form->checkBox($model, 'exclude_from_dynamic', array('value' => 1, 'uncheckValue' => 0)); ?>
                <?php echo $form->labelEx($model, 'exclude_from_dynamic'); ?>
                <?php echo $form->error($model, 'exclude_from_dynamic'); ?>
            </div>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="span8">
            <?php echo $form->labelEx($model, 'Example'); ?>
            <?php
            echo CHtml::ajaxButton('Example', CController::createUrl('Question/viewExample'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                'data' => array('question_type' => 'js:document.getElementById("question_type").value'),
                'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_viewExample").dialog("open");                            
                            if(document.getElementById("dialog_data")!=null){
                                $("#dialog_data").remove();
                            }                          
                            
                            $("#mydialog_viewExample").append(data.qoutput);
                            
                            
                        }else{
                            
                            
                        }
                    }'
            ), array(
                    'id' => 'rexample_btn',
                    'class' => 'tinybluebtn',
                )
            );
            ?>



            <br />
        </div>

    </div>

    <br />

    <div class="row">
        <div class="span8">
            <?php echo $form->textAreaRow($model, 'question_text', array('rows' => 15, 'cols' => 50, 'class' => 'span8,mceEditor')); ?>
            <div class="span8 no-left-margin" id="textAreaErrorDisplayRaw" style="display:none">
                <label id="textAreaErrorDisplay" class="error"></label>
            </div>
            <br/>
            <?php echo $form->textAreaRow($model, 'question_logic', array('rows' => 15, 'cols' => 50, 'class' => 'span8,mceEditor')); ?>

            <br />
            <div class="control-group">
                <input type="hidden" id="update_ff" name="update_ff" value="CREATE" />
                <input type="hidden" name="question_part_count" id="question_part_count" value="">
            </div>
            <div class="control-group">
                <?php //echo $form->textAreaRow($model, 'question_text', array('rows' => 15, 'cols' => 50, 'class' => 'span8'));  ?>
            </div>

            <div class="control-group">
                <div id ="answer-rows" >
                    <?php //$this->renderpartial('_single_answers');   ?>
                </div>
            </div>

            <div class="control-group">
                <div id ="essay-type-row" >
                    <?php
                    ?>
                </div>
            </div>
        </div>
    </div>



    <!--        <br />
            <input type="button" id="temp" onclick="validateForm()" value="test">
            <br />-->

    <div class="row" id="button_row">

        <div class="span7" id="preview_bn">
            <?php
            echo CHtml::ajaxButton('Preview', CController::createUrl('Question/reviewQuestion'), array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                //'onclick' => 'js:validateForm()',
                'beforeSend' => 'js:tinyMCE.triggerSave()',
                'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_Review").dialog("open");                            
                            if(document.getElementById("dialog_data")!=null){
                                $("#dialog_data").remove();
                            }                          
                                                   
                            $("#mydialog_Review").append(data.qoutput);
                            
                            
                        }else{
                            
                            
                        }
                    }'
            ), array(
                    'id' => 'review_btn',
                    'class' => 'tinybluebtn',
                )
            );
            ?>

        </div>
        <div class="span5">
            <?php
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news', 'id' => 'bttsubmit', 'onclick' => 'return validateForm()'));
            ?>
        </div>
    </div>
</div>
<br/>
<br/>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_Review',
    'options' => array(
        'title' => 'Review Page',
        'width' => 800,
        'height' => "auto",
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_viewExample',
    'options' => array(
        'title' => 'Example',
        'width' => 800,
        'height' => "auto",
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'position' => 'bottom',
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>





<?php $this->endWidget(); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<!--<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>-->
<script>

    tinymce.init({
        selector: "textarea",
        theme: "modern",
        width: 800,
        height: 250,
        editor_selector: "mceEditor",
        editor_deselector: "mceNoEditor",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor jbimages"
        ],
        //content_css: "css/content.css",
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
<script>
    $(function () {

        // Setup form validation on the #register-form element
        $("#question-form").validate({
            // Specify the validation rules
            rules: {
                course_id: "required",
                level_id: "required",
                subject_id: "required",
                "Question[subject_area_id]": "required",
                "Question[number_of_marks]": "required",
                //"Question[question_text]": "required",
                question_type: "required",
                essay_type: "required",
                "Question[exhibit_attachment]": {
                    required: false,
                    accept: "jpg, gif, png,jpeg,PNG,JPG,JPEG,GIF,TIF,tif"
                }

            },
            // Specify the validation error messages
            messages: {
                course_id: "Please select a course",
                level_id: "Please select a level",
                subject_id: "Please select a subject",
                "Question[subject_area_id]": "Please select a subject area",
                "Question[number_of_marks]": "Please add marks for this question",
                //"Question[question_text]": "Please fill in the question text",
                question_type: "Please select a question type",
                essay_type: "Please select an essay question type",
                "Question[exhibit_attachment]": "Please upload an image"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });


    function validateForm() {

        //        var questionText = tinymce.get('question_text').getContent();
        //        alert($.trim(questionText));
        // var content = tinyMCE.activeEditor.getContent();

        var content = null;
        content = tinyMCE.get('Question_question_text').getContent();

        var select_qt = document.getElementById("question_type");
        var selectvalue_qt = select_qt.options[select_qt.selectedIndex].value;
        if (content == '' || content == null) {
            document.getElementById("textAreaErrorDisplay").innerHTML = "Please enter the question text";
            document.getElementById("textAreaErrorDisplayRaw").style.display = "block";
            //document.getElementById("question_text").style.borderColor="red";
            return false;
        } else {
            if (selectvalue_qt == "DRAG_DROP_TYPEC_ANSWER") {
                return validateFormTypeC();
            } else if (selectvalue_qt == "ESSAY_ANSWER") {
                return validateEmailEssay();
            } else if (selectvalue_qt == "SINGLE_ANSWER") {
                return checkSingleAnswer();
            } else if (selectvalue_qt == "MULTIPLE_ANSWER") {
                return checkMultipleAnswer();
            } else if (selectvalue_qt == "SHORT_WRITTEN") {
                return checkShortWrittenAnswers();
            } else if (selectvalue_qt == "DRAG_DROP_TYPEA_ANSWER") {
                return checkDragnDropType_A();
            } else if (selectvalue_qt == "DRAG_DROP_TYPEB_ANSWER") {
                return checkDragnDropType_B();
            } else if (selectvalue_qt == "DRAG_DROP_TYPED_ANSWER") {
                return checkDragnDropType_D();
            } else if (selectvalue_qt == "DRAG_DROP_TYPEE_ANSWER") {
                return checkDragnDropType_E();
            } else if (selectvalue_qt == "MULTIPLE_CHOICE_ANSWER") {
                //isCorrectAnswerChecked();
                if (checkMultipleChoice() == true) {
                    return isCorrectAnswerChecked();
                } else {
                    return false;
                }
                //return checkMultipleChoice();
            } else if (selectvalue_qt == "TRUE_OR_FALSE_ANSWER") {
                return checkTrueFalse();
            }
            else {
                return true;
            }
        }





    }
</script>

<script type="text/javascript">
    function isCorrectAnswerChecked() {
        var returnValue = true;

        //check all Q&A blocks (max blocks = 20)
        for (var i = 1; i <= 20; i++) {
            var isChecked = false;
            var q_n_a_divObj = document.getElementById("multiple_choice_answer_form_" + i);

            //for all visible Q&A blocks
            if (q_n_a_divObj.style.display == "block") {
                var isCorrectObj = document.getElementsByName("iscorrect_" + i);
                //check radio button is checked for correct answer (max radio buttons is 10)
                for (var j = 0; j < 10; j++) {
                    if (isCorrectObj[j].checked == true) {
                        isChecked = true; //correct answer is checked
                    }
                }

                //display and hide error msg
                var correct_answer_error_msg_obj = document.getElementById("correct_answer_error_msg_" + i);
                if (isChecked == false) {
                    returnValue = false;
                    correct_answer_error_msg_obj.style.display = "block";
                } else {
                    correct_answer_error_msg_obj.style.display = "none";
                }

            }
        }
        return returnValue;
    }
</script>

<script type="text/javascript">
    function checkElement(element) {
        if (element.value == "") {
            error = 1;
            element.style.borderColor = "red";
        } else {
            error = 0;
            element.style.borderColor = "#cccccc";
        }
        return error;
    }

    var c = 2;
    var q = 1;

    var imgc = 2;
    var imgq = 1;

    $('.addm').live('click',function(){
        //alert(c);
        var delcount = "tr_"+q;
        var deltxt = "txt_"+q;
        $(this).val('Delete Answer');
        $(this).attr('class','del');
        $(this).attr('onclick','deleteAnswer("'+delcount+'","'+deltxt+'")');
        var appendTxt = "<tr id='tr_"+c+"' class='span5' style='margin-left:0px; width:400px;'><td><textarea id='txt_"+c+"' name='answer[]' /></td> <td><input type='checkbox' name='correct["+c+"]' id='acheck_"+c+"'></td> <td><input type='button' class='addm' value='Add More' class='btn'/></td></tr>";

        $("#options-table tr:last").after(appendTxt);
        c++;
        q++;
    });

    $('.imgaddm').live('click',function(){
        var deltr = "imgtr_"+imgq;
        var delimg = "imgfile_"+imgq;
        $(this).val('Delete Answer');
        $(this).attr('class','imgdel');
        $(this).attr('onclick','deleteImageAnswers("'+deltr+'","'+delimg+'")');
        var appendTxt = "<tr id='imgtr_"+imgc+"' class='span5' style='margin-left:0px; width:400px;'><td><input type='file' id='imgfile_"+imgc+"' name='imageanswer[]' style='width:220px;' /></td> <td><input type='checkbox' name='correctimg["+imgc+"]' id='imgch_"+c+"'></td> <td><input type='button' class='imgaddm' value='Add More' class='btn'/></td></tr>";

        $("#image-answer-table tr:last").after(appendTxt);
        imgc++;
        imgq++;
    });

    var sc = 2;
    var sq = 1;

    var simgc = 2;
    var simgq = 1;
    $('.adds').live('click',function(){
        var delcount = "tr_"+sq;
        var deltxt = "txt_"+sq;
        var delCheck = "acheck_"+sq;
        $(this).val('Delete Answer');
        $(this).attr('class','del');
        $(this).attr('onclick','deleteAnswer("'+delcount+'","'+deltxt+'","'+delCheck+'")');
        var appendTxt = "<tr id='tr_"+sc+"' class='span5' style='margin-left:0px; width:400px;'><td><textarea id='txt_"+sc+"' name='answer[]' /></td> <td><input type='checkbox' name='correct["+sc+"]' id='acheck_"+sc+"'></td> <td><input type='button' class='adds' value='Add More' class='btn'/></td></tr>";

        $("#options-table tr:last").after(appendTxt);
        sc++;
        sq++;
    });

    $('.imgadds').live('click',function(){
        var deltr = "imgtr_"+simgq;
        var delimg = "imgfile_"+simgq;
        $(this).val('Delete Answer');
        $(this).attr('class','imgdel');
        $(this).attr('onclick','deleteImageAnswers("'+deltr+'","'+delimg+'")');
        var appendTxt = "<tr id='imgtr_"+simgc+"' class='span5' style='margin-left:0px; width:400px;'><td><input type='file' id='imgfile_"+simgc+"' name='imageanswer[]' style='width:220px;' /></td> <td><input type='checkbox' name='correctimg["+simgc+"]' id='imgch_"+sc+"'></td> <td><input type='button' class='imgadds' value='Add More' class='btn'/></td></tr>";

        $("#image-answer-table tr:last").after(appendTxt);
        simgc++;
        simgq++;
    });
</script>


<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js"></script>


