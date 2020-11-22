<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/bootstrap-modal.js" type="text/javascript"></script>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles-small.css', 'only screen and (max-width: 800px)'); ?>


<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<?php Yii::app()->bootstrap->register(); ?>
<!-- custom style sheet of the site -->    
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.blockUI.js"></script>
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<?php
$question_array = array();
$question_index = -1;

//validations for non registered users
if (isset(Yii::app()->session['exam_question_session'])) {
    $session_question = Yii::app()->session['exam_question_session'];
} else {
    $this->redirect(array('/site/customError', Consts::STR_MESSAGE => 'Data not found'));
}



// to update go to question dropdown list
foreach ($session_question as $question) {
    $question_array[$question['question_number']] = $question['question_number'];
}
//$session_question[0]['current_question']=0;
//get exam form refresh count
$Session = Yii::app()->session["exam_time"];
$refreshCount = 0;
if ($Session == null) {
    $Session['refreshCount'] = $refreshCount;
    $Session['refreshed_before'] = false;
    Yii::app()->session["exam_time"] = $Session;
} else {
    $refCount = $Session['refreshCount'];
    $Session['refreshCount'] = $Session['refreshCount'] + 1;
    $Session['refreshed_before'] = true;
    Yii::app()->session["exam_time"] = $Session;
}

//get relevent exam details using this function
$essayExamSectionDetails = EssayExamSection::model()->getDetailsForSectionvalidation($exam_id);
$sectionCount = sizeof($essayExamSectionDetails);

//var_dump($essayExamSectionDetails);
//get relevent details for the exam 
$exam_time = Exam::model()->getExamTime($exam_id);
$numOfQues = sizeof($session_question);

$exam = Exam::model()->findByAttributes(array('exam_id' => $exam_id));
$examAttachment = ExamAttachment::model()->findByAttributes(array('exam_id' => $exam_id));
?>


<script type="text/javascript">
    var blocked = false;
    function checkconnection() {
        var status = navigator.onLine;
        if (status) {
            if (blocked) {
                $.unblockUI();
                blocked = false;
            }
        } else {
            if (!blocked) {
                $.blockUI({message: 'Connection Lost!'});
                blocked = true;
            }
        }
    }

    setInterval(checkconnection, 1000);

    index = -1;
    $(document).ready(function () {
        hideElementsWhenStartPageLoaded();
        var sectionNumberForNextbtn = 0; //number of the section for next btn
        var sectionNumberForPrevbtn = 0; //number of the section for previous btn 
    })

    //to stop page refreshing using F5 key 
    var fn = function (e)
    {
        if (!e)
            var e = window.event;
        var keycode = e.keyCode;
        if (e.which)
            keycode = e.which;
        var src = e.srcElement;
        if (e.target)
            src = e.target;
        // 116 = F5
        if (116 == keycode)
        {
            // Firefox and other non IE browsers
            if (e.preventDefault)
            {
                e.preventDefault();
                e.stopPropagation();
            }
            // Internet Explorer
            else if (e.keyCode)
            {
                e.keyCode = 0;
                e.returnValue = false;
                e.cancelBubble = true;
            }

            return false;
        }
    }

    // Assign function to onkeydown event
    document.onkeydown = fn;</script>

<style type="text/css">
    body { margin:60px 0; padding:0; overflow: hidden;}
    #panel-heading { left:5px; right: 5px; position:fixed; top:0; }
    .panel-footer { left:5px; right: 5px; position:fixed; bottom:0 }
</style>

<body>
    <div class="container">
        <div class="span12" style="margin-bottom: 0px">
            <div class="panel panel-default" style="margin-bottom: 0px">
                <div class="panel-heading" id="panel-heading"> 
                    <div class="span2" id="img_logo" style="margin-left: 0px"> <img src="assets/img/logo.png" class="logo exam-page-logo" alt="Responsive image"> </div>
                    <p class="questionofquestion"><span id="view-question-num"></span><br/><span id="display_time_remaining" style="display: none;">Time Remaining</span>&nbsp;<button class="btn btn-mock" id="display_time" type="button"  style="float: right; display: none;"> Timer</button></p>
                    <!--                <br/> -->
                    <!-- Single button -->
                    <div class="btn-group" style="margin-top: 10px;" id="attachemnt_div">

                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Attachments <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a onclick="openPreseen()">Pre-seen</a></li>
                            <li><a onclick="openTable()">Table & Formulae</a></li>
                        </ul>
                        <button class="btn btn-mock" id="scratch-btn" type="button" onclick="openScratchPad()" style="display: none;">Scratch Pad</button> 
                        <?php
                        if ($exam->calculator_allowed == 1) {
                            ?>
                            <button class="btn btn-mock" id="calculator-btn" type="button" style="display: none;" onclick="openCal()">Calculator</button>
                            <?php
                        }
                        if (!empty($examAttachment)) {
                            ?>
                            <!--<button class="btn btn-mock" id="exam_attachment-btn" type="button" style="display: none;" onclick="openExamAttachemtn()">Attachment</button>-->
                            <?php
                        }
                        ?>

                    </div>
                    <p class="questionofquestion"><span id="view-question-num"></span><br/><span id="display_time_remaining" style="display: none;">Time Remaining</span>&nbsp;<button class="btn btn-mock" id="display_time" type="button"  style="float: right; display: none;"> Timer</button></p>
                    <br/> 
                </div>
                <input type="hidden" id="question_number_for_time" value="1">
                <input type="hidden" id="num_of_questions" value="0">
                <input type="hidden" id="question_number_count" name="question_number_count" value="1">
                <input type="hidden" id="previous_question_number_count" name="previous_question_number_count" value="">
                <input type="hidden" id="crossCount_nail" value="0">
                <input type="hidden" id="current_question_id" name="current_question_id" value="0">
                <div id="panel-body-exhibit-view" class="panel-body">
                    <?php
                    echo '<br>';
//                    echo CHtml::ajaxButton('Exhibit ', CController::createUrl('Exam/questionExhibit'), array(
//                        'type' => 'POST', //request type
//                        'dataType' => 'json',
//                        'data' => array(
//                            'question_id' => 'js:current_question_id.value',
//                            'question_session' => $session_question,
//                        ),
//                        'success' => 'js:function(data){ 
//                        if(data.status=="success"){                            
//                            $("#mydialog_exhibit").dialog("open"); 
//                            if(document.getElementById("dialog_data")!=null){
//                                $("#dialog_data").remove();
//                            }        
//                            $("#mydialog_exhibit").append(data.qoutput);
//                            
//                           
//                        }else{
//                            
//                        }
//                    }'
//                            ), array(
//                        'id' => "btn_exhibit",
//                        'class' => 'tinybluebtn',
//                            )
//                    );
//                    echo '&nbsp';
                    echo CHtml::ajaxButton('Reference Materials ', CController::createUrl('Exam/questionReference'), array(
                        'type' => 'POST', //request type
                        'dataType' => 'json',
                        'data' => array(
                            'question_id' => 'js:current_question_id.value',
                            'question_session' => $session_question,
                        ),
                        'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_reference_materials").dialog("open"); 
                            if(document.getElementById("reference-dialog")!=null){
                                $("#reference-dialog").remove();
                            }        
                            $("#mydialog_reference_materials").append(data.qoutput);
                            
                           
                        }else{
                            
                        }
                    }'
                            ), array(
                        'id' => "btn_reference",
                        'class' => 'tinybluebtn',
                            )
                    );
                    ?> 

                    <div>
                        <?php
                        //reference materials dialog 
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'mydialog_reference_materials',
                            'options' => array(
                                'title' => 'Reference Materials',
                                'width' => 700,
                                'height' => 500,
                                'autoOpen' => false,
                                'resizable' => true,
                                'modal' => false,
                                'overlay' => array(
                                    'backgroundColor' => '#000',
                                    'opacity' => '0.5'
                                ),
                            ),
                        ));

                        //echo $this->renderPartial('question_exhibit', array('questionID' => $session_question[0]['current_question']));
                        $this->endWidget('zii.widgets.jui.CJuiDialog');
                        ?>
                    </div>
                </div>


                <div class="panel-body" id="panel-body" style="height: 490px;overflow-y: auto;overflow-x: hidden; width: 100%;" >
                    <div class="panel-body-inner">

                        <?php
                        $examInstruction = Exam::model()->getExamInstructionForExam($exam_id);
                        $extension = substr($examInstruction, strrpos($examInstruction, '.') + 1);
                        $extension = strtolower($extension);
                        ?>

                        <div class="span10" id="instructions">
                            <h4>Exam Instructions</h4>

                            <?php
                            if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "JPG" || $extension == "JEPG" || $extension == "PNG") {
                                echo '<center>' . CHtml::image(Yii::app()->request->baseUrl . '/images/exam_instructions/' . $exam_id . '/' . $examInstruction, "", array("width" => "700px", "height" => "auto")) . '</center>';
                            } else {
                                echo $examInstruction;
                            }
                            ?>
                        </div>                       


                        <div class="span10" id="question-body">

                        </div>
                        <script type="text/javascript">

                            function openExhibit() {
                                //var $j = jQuery.noConflict(true);
                                $("#mydialog_exhibit").dialog("open");
                                return false;
                            }


                        </script>


                        <br />

                        <div class="span10" id="tinymce-div" style="display: none;">
                            <textarea id="answer"></textarea>
                        </div>

                        <?php
                        echo CHtml::ajaxButton('Start', Yii::app()->createUrl('Exam/viewStartEssayQuestion'), array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'onClick' => 'js:showElementsWhenStartExam()', 'js:timer()', 'js:setSectiontime()', 'js:storeQuestionNumber()', 'js:moveToNextSection()',
                            'data' => array(
                                'question_number_count' => 'js:getQuestionNumForStart()',
                                'question_count_key' => 'js:getQuestionCountKey()',
                                'flag' => 'js:flag.checked',
                            ),
                            'success' => 'function(data){
                                var rrcount = getRefreshCount();
                                if(rrcount == 0) {
                                   index=0;
                                   }else{
                                   index=getQuestionNumForStart()-1;
                                    }
                                   document.getElementById("current_question_id").value = index;
                                    
                                   $("#tinymce-div").css("display","block");                                  
                                   $("input[name=round_btn]").hide();
                                  
                                  // tinyMCE.activeEditor.setContent(data.answer);
                                   tinyMCE.get("answer").setContent(data.answer);
                                   
                                   if(data.previous_question_number_count == 0){
                                        $("#previous").prop("disabled",true);
                                    }else{
                                        $("#previous").prop("disabled",false);
                                    }
                                     if(data.next_question_number > data.no_of_questions)
                                    {
                                      $("#next_button").prop("disabled",true);                                                        
                                    }
                                     if(data.flag_value == 1)
                                    {                                                    
                                        $("#flag").prop("checked", true);
                                    }
                                    
                                    if(data.flag_value == 0)
                                    {
                                        $("#flag").prop("checked", false);
                                    }
                                    
                                   
                                                                      
                                    $("#question_number_for_time").val(data.next_question_number-1);
                                    var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                                    latestSection = parseInt(sectionNumberForNext); //current section number                                    
                                    var numofSections = localStorage.getItem("numberOfSections");                                    
                                   $("#view-question-num").text("Section "+(latestSection)+" of "+numofSections);
                                  
                                    localStorage.setItem("storedQuestionNum", data.next_question_number);
                                    localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                                   document.getElementById("question-body").innerHTML = data.exam_questions; 
                                  // document.getElementById("session").innerHTML = JSON.stringify(data.session);
                                  $("#panel-body").scrollTop(0);
                                   
                         }'
                                ), array(
                            'class' => 'round-button',
                            'name' => 'round_btn',
                            'id' => uniqid(),
                                )
                        );
                        ?>

                    </div>
                </div>
                <div class="panel-footer">
                    <span id="end-exam-btn-place"> &nbsp; &nbsp;
                        <?php
                        echo CHtml::ajaxButton('Review Exam', array('Exam/essayExamStatus'), array(
                            'type' => 'POST',
                            // 'onClick' => 'js:hideElementsInFooter(), js:hideElementsInHeader()',
//                        'dataType' => 'json',
                            'onClick' => 'js:hideElementsForLinksInfooter()',
                            'data' => array(
                                'answer_id' => 'js:getAnswerId()',
                                'question_count_key' => 'js:getQuestionCountKey()',
                                //'flag' => 'js:flag.checked',
                                'timetaken' => 'js:timerForEachQuestion()',
                                'exam_id' => $exam_id,
                                'time_status' => Consts::STATUS_TIME_REMAINS
                            ),
                            'update' => '#question-body',
                                ), array(
//                        'confirm' => 'Are you sure you want to Review the exam?',
                            'class' => 'btn btn-mock',
                            'id' => 'exam-review'
                        ));
                        ?>  &nbsp; &nbsp;

                    </span>

                    <span id="hide-links-footer-panel">
                        <span id="view-mark">
                        </span>

                        &nbsp; &nbsp;

                        <span id="all-unanswered-questions"> &nbsp; &nbsp;
                            <?php
                            if ($exam->allow_view_unanswered_questions == 1) {
                                echo CHtml::ajaxLink('View Unanswered Questions', array('Exam/viewEssayUnansweredQuestions'), array(
                                    'type' => 'POST',
                                    //'dataType' => 'json',
                                    'onClick' => 'js:hideElementsForLinksInfooter()',
                                    
                                    'update' => '#question-body',
                                   
                                        ), array(
                                    'id' => 'all-unanswered-questions'.uniqid(),
                                ));
                            }
                            ?>
                        </span>

                        &nbsp; &nbsp; &nbsp; &nbsp;
                        <input type="checkbox" name="flaged" id="flag" class="checkbox-margined" onchange="setFlaged()" style="display: none">
                        &nbsp; &nbsp;&nbsp; &nbsp; 


<?php
if ($exam->allow_goto_question == 1) {
    ?>
                            <span id = "goto">Go to</span> &nbsp;
                            &nbsp;

                            <select id="question_num" onchange="nextEssayQuesionbyDropdown()">
                                <option value="">Select Question</option>
                                S               <?php
    foreach ($question_array as $key => $ques) {
        echo '<option value="' . $key . '">' . $ques . '</option>';
    }
    ?>
                            </select>

                                <?php
                            }
                            ?>


                    </span>

                    <ul class="pager pull-right" id="btn-nav-pane">

                        <li>
<?php
echo CHtml::ajaxButton(
        'Previous', $url = Yii::app()->createUrl('Exam/viewPreviousEssayQuestions'), $ajaxOptions = array(
    'type' => 'POST',
    'dataType' => 'json',
    'data' => array(
        'previous_question_number_count' => 'js:getPreviousQuestionNum()',
        'question_count_key' => 'js:getQuestionCountKey()',
        'answer_id' => 'js:getAnswerId()',
        'flag' => 'js:flag.checked',
        'timetaken' => 'js:timerForEachQuestion()',
    ),
    'beforeSend' => 'function(xhr, opts){                              
                                var firstQuestionInSection = getFirstQuestionNumberInSection();
                           
                                if(firstQuestionInSection==1){
                                bootbox.alert("You cannot go back to the previous section");
                                xhr.abort();                           
                            }
                        }',
    'success' => 'function(data){
                                if(index>0){
                                    index--;
                                    document.getElementById("current_question_id").value = index; 
                                }
                            
                                tinyMCE.get("answer").setContent(data.answer);
                                $("#question_number_for_time").val(data.next_question_number-1);
                           
                                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                                var numofSections = localStorage.getItem("numberOfSections");                                    
                                $("#view-question-num").text("Section "+(latestSection)+" of "+numofSections);
                            
                                if(data.next_question_number <= data.no_of_questions)
                                
                                {
                                    $("#next_button").removeAttr("disabled");                                                        
                                }
                                if(data.previous_question_number_count == 0)
                                {
                                    $("#previous").prop("disabled",true);
                                }

                                if(data.flag_value == 1)
                                {                                                    
                                    $("#flag").prop("checked", true);
                                }
                                if(data.flag_value == 0)
                                {
                                    $("#flag").prop("checked", false);
                                }
                            
                            
                                 localStorage.setItem("storedQuestionNum", data.next_question_number);
                                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                                document.getElementById("question-body").innerHTML = data.exam_questions; 
                                //document.getElementById("session").innerHTML = JSON.stringify(data.session);
                                $("#panel-body").scrollTop(0);
                            }'
        ), $htmlOptions = array(
    'id' => 'previous',
    'class' => 'btn btn-mock',
    'style' => 'width: 70px'
        )
);
?>                        
                        </li>

                        <li>
                            <input type="button" id="next_button" class="btn btn-mock" style="width: 70px" value="Next" onclick="moveToNextSection(), nextEssayQuestion();" />

                        </li>
                    </ul>                    
                </div>
            </div>

        </div>

    </div>

    <div id="tabel_formulae">
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_formulae',
    'options' => array(
        'title' => 'Tables & Formulae',
        'width' => '900',
        'height' => '300',
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

echo $this->renderPartial('tabels_formulae', array('examID' => $exam_id));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    </div>

    <div id="tabel_formulae">
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_examAttachemtn',
    'options' => array(
        'title' => 'Exam Attachment',
        'width' => '800',
        'height' => '400',
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

echo $this->renderPartial('_exam_attachment', array('examID' => $exam_id));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    </div>


    <div id="pre_seen">
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_preseen',
    'options' => array(
        'title' => 'Pre-seen Materials',
        'width' => 750,
        'height' => 600,
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

echo $this->renderPartial('preseen_materials', array('examID' => $exam_id));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    </div>



    <div id="cal">
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_cal',
    'options' => array(
        'title' => 'Calculator',
        'width' => 310,
        'height' => 428,
        'autoOpen' => false,
        'resizable' => false,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5'
        ),
    ),
));

echo $this->renderPartial('calculator');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    </div>



    <div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog_scratchpad',
    'options' => array(
        'title' => 'Scratch Pad',
        'width' => 800,
        'height' => 340,
        'autoOpen' => false,
        'resizable' => true,
        'modal' => false,
        'overlay' => array(
            'backgroundColor' => '#000',
            'opacity' => '0.5',
        ),
    ),
));

echo $this->renderPartial('scratch_pad');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
    </div>
</body>

<script type="text/javascript">
    var gotSession = null;
    var session = new Array();
    function nextEssayQuestion() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/viewNextEssayQuestion'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                'question_number_count': getNextQuestionNum(),
                'previous_question_number_count': getPreviousQuestionNum(),
                'question_count_key': getQuestionCountKey(),
                'answer_id': getAnswerId(),
                'flag': flag.checked,
                'timetaken': timerForEachQuestion(),
            },
            beforeSend: function (jqXHR, settings) {
                var sectionNumber = localStorage.getItem("sectionNumForNextbtn");
                var secNumCount = validateJumpToNewSection();
                var lastQuestionInSection = getLastQuestionNumberInSection(secNumCount);
                if (lastQuestionInSection === 1) {
                    jqXHR.abort();
                    var unAnswered = getUnansweredQuestions(sectionNumber, session);
                    var messageConfirm = "";
                    if (unAnswered === 0) {
                        messageConfirm = "You have chosen to end the current section. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                    } else {
                        messageConfirm = "You have chosen to end the current section, but have " + unAnswered + " incomplete question. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                    }

                    bootbox.confirm({
                        title: "End Section",
                        message: messageConfirm,
                        callback: function (result) {
//                            jqXHR.abort();
                            if (result === true) {
                                endSectionConfirm();
                            }
                        }
                    });
                }
            },
            success: function (data) {
                index++;
                session = JSON.stringify(data.session);
                document.getElementById("current_question_id").value = index;
                tinyMCE.get("answer").setContent(data.answer);
                $("#question_number_for_time").val(data.next_question_number - 1);
                if (data.previous_question_number_count >= 1)
                {
                    $("#previous").removeAttr("disabled");
                }
                if (data.next_question_number - 1 >= data.no_of_questions)
                {
                    $("#next_button").prop("disabled", true);
                }

                if (data.flag_value == 1)
                {
                    $("#flag").prop("checked", true);
                }
                if (data.flag_value == 0)
                {
                    $("#flag").prop("checked", false);
                }

                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                var numofSections = localStorage.getItem("numberOfSections");
                $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
                localStorage.setItem("storedQuestionNum", data.next_question_number);
                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                document.getElementById("question-body").innerHTML = data.exam_questions;
                $("#panel-body").scrollTop(0);
            }
        });
    }

    function endSectionConfirm() {
        localStorage.setItem("sectionChange", "true");
        var sectionNumber = localStorage.getItem("sectionNumForNextbtn");
        sectionNumber++;
        localStorage.setItem("sectionNumForNextbtn", sectionNumber);
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/viewNextEssayQuestion'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                'question_number_count': getNextQuestionNum(),
                'previous_question_number_count': getPreviousQuestionNum(),
                'question_count_key': getQuestionCountKey(),
                'answer_id': getAnswerId(),
                'flag': flag.checked,
                'timetaken': timerForEachQuestion(),
            },
            success: function (data) {
                index++;
                document.getElementById("current_question_id").value = index;
                tinyMCE.get("answer").setContent(data.answer);
                $("#question_number_for_time").val(data.next_question_number - 1);
                if (data.previous_question_number_count >= 1)
                {
                    $("#previous").removeAttr("disabled");
                }
                if (data.next_question_number - 1 >= data.no_of_questions)
                {
                    $("#next_button").prop("disabled", true);
                }

                if (data.flag_value == 1)
                {
                    $("#flag").prop("checked", true);
                }
                if (data.flag_value == 0)
                {
                    $("#flag").prop("checked", false);
                }

                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                var numofSections = localStorage.getItem("numberOfSections");
                $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
                localStorage.setItem("storedQuestionNum", data.next_question_number);
                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                document.getElementById("question-body").innerHTML = data.exam_questions;
                $("#panel-body").scrollTop(0);
            }
        });
    }

    function nextEssayQuesionbyDropdown() {
        index = getPreviousQuestionNum();
        document.getElementById("current_question_id").value = index;
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/viewDropdownEssayQuestions'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                'question_num': document.getElementById("question_num").value,
                'question_count_key': getQuestionCountKey(),
                'answer_id': getAnswerId(),
                'flag': flag.checked,
                'timetaken': timerForEachQuestion(),
            },
            beforeSend: function (jqXHR, settings) {
//                jqXHR.abort();
                var isIn = isQuestionNoInSection(question_num.value);
                if (isIn == 1) {
                    jqXHR.abort();
                    var sectionNumber = localStorage.getItem("sectionNumForNextbtn");
                    var unAnswered = getUnansweredQuestions(sectionNumber, session);
                    var messageConfirm = "";
                    if (unAnswered === 0) {
                        messageConfirm = "You have chosen to end the current section. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                    } else {
                        messageConfirm = "You have chosen to end the current section, but have " + unAnswered + " incomplete question. If you click Yes, you will NOT be able to return to this section. \n Are you sure you want to end this section.";
                    }

                    bootbox.confirm({
                        title: "End Section",
                        message: messageConfirm,
                        callback: function (result) {
                            if (result === true) {
                                endSectionByDropdown();
                            }
                        }
                    });
                } else if (isIn == 2) {
                    bootbox.alert("You cannot go back to previous sections.");
                    jqXHR.abort();
                }
            },
            success: function (data) {

                tinyMCE.get("answer").setContent(data.answer);
                $("#tinymce-div").show();
                session = JSON.stringify(data.session);


                tinyMCE.get("answer").setContent(data.answer);
                $("#question_number_for_time").val(data.next_question_number - 1);

                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                var numofSections = localStorage.getItem("numberOfSections");
                $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
                if (data.next_question_number - 1 >= data.no_of_questions)
                {
                    $("#next_button").prop("disabled", true);
                }
                if (data.previous_question_number_count > 0)
                {
                    $("#previous").prop("disabled", false);
                }

                if (data.flag_value == 1)
                {
                    $("#flag").prop("checked", true);
                }
                if (data.flag_value == 0)
                {
                    $("#flag").prop("checked", false);
                }

                localStorage.setItem("storedQuestionNum", data.next_question_number);
                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                document.getElementById("question-body").innerHTML = data.exam_questions;
                // document.getElementById("session").innerHTML = JSON.stringify(data.session);
                $("#panel-body").scrollTop(0);
            }
        });
    }

    function endSectionByDropdown() {
        index = getPreviousQuestionNum();
        document.getElementById("current_question_id").value = index;
        localStorage.setItem("sectionChange", "true");
        increaseSectionNo(question_num.value);
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/viewDropdownEssayQuestions'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                'question_num': document.getElementById("question_num").value,
                'question_count_key': getQuestionCountKey(),
                'answer_id': getAnswerId(),
                'flag': flag.checked,
                'timetaken': timerForEachQuestion(),
            },
            success: function (data) {

                tinyMCE.get("answer").setContent(data.answer);
                $("#tinymce-div").show();
                session = JSON.stringify(data.session);
                tinyMCE.get("answer").setContent(data.answer);
                $("#question_number_for_time").val(data.next_question_number - 1);

                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                var numofSections = localStorage.getItem("numberOfSections");
                $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
                if (data.next_question_number - 1 >= data.no_of_questions)
                {
                    $("#next_button").prop("disabled", true);
                }
                if (data.previous_question_number_count > 0)
                {
                    $("#previous").prop("disabled", false);
                }

                if (data.flag_value == 1)
                {
                    $("#flag").prop("checked", true);
                }
                if (data.flag_value == 0)
                {
                    $("#flag").prop("checked", false);
                }

                localStorage.setItem("storedQuestionNum", data.next_question_number);


                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                document.getElementById("question-body").innerHTML = data.exam_questions;

                // document.getElementById("session").innerHTML = JSON.stringify(data.session);
                $("#panel-body").scrollTop(0);

            }
        });
    }

    function viewUnansweredQuestionConfirmed(q_id, q_number) {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/viewEssayQuestion'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                'question_id': q_id,
                'question_num': q_number,
            },
            success: function (data) {

                tinyMCE.get("answer").setContent(data.answer);
                session = JSON.stringify(data.session);
                $("#tinymce-div").show();
                $("#question_number_for_time").val(data.next_question_number - 1);
                var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                latestSection = parseInt(sectionNumberForNext); //current section number                                    
                var numofSections = localStorage.getItem("numberOfSections");
                $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
                $("#view-question-num").show();

                if (data.previous_question_number_count >= 1)
                {
                    $("#previous").removeAttr("disabled");
                }

                if (data.next_question_number <= data.no_of_questions)
                {
                    $("#next_button").removeAttr("disabled");
                }

                if (data.previous_question_number_count == 0)
                {
                    $("#previous").prop("disabled", true);
                }

                var lastQnumarray = localStorage.getItem("lastQuestionNumArray");

                localStorage.setItem("storedQuestionNum", data.next_question_number);
                localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                document.getElementById("question-body").innerHTML = data.exam_question;
                document.getElementById("session").innerHTML = JSON.stringify(data.session);
            }
        });

        localStorage.setItem("sectionChange", "true");
        increaseSectionNo(q_number);
    }



    function getUnansweredQuestions(secNum, getSession) {
        var unansweredQuestions = 0;
        var firstQnum = getFirstQuestionNo(secNum);
        var loopFirstNum = parseInt(firstQnum) - 1; //current section first number

        var lastQnum = getLastQuestionNo(secNum);
        var loopLastNum = parseInt(lastQnum) - 1; //current secion last number

        if (getSession.length > 0) {

            var JSONObject = JSON.parse(getSession);
            for (i = loopFirstNum; i < loopLastNum; i++) {

                if (JSONObject[i].answer_id === '<p><br data-mce-bogus="1"></p>') {
                    unansweredQuestions++;
                }
            }
        } else {
            unansweredQuestions = loopLastNum - loopFirstNum;
        }
        return unansweredQuestions;
    }
</script>


<script type="text/javascript">

    var essayExamSectionDetails = <?php echo json_encode($essayExamSectionDetails); ?>;
    var sectionNumberForPrevbtn = 0;
    var lastQuestionNum = 0; //last question number in a section

    var lastNumber = 0;
    var lastQNumber = new Array(); //stores lastquestion number in sections
    var refconditionCount = 0;
    function getAnswerId() {
        // var answer = tinyMCE.activeEditor.getContent({format: 'raw'});
        var answer = tinyMCE.get('answer').getContent({format: 'raw'});
        return answer;
    }


    function getQuestionCountKey() {
        var question_count_key = $("#question_count_key").val();
        if (question_count_key == null) {
            question_count_key = -1;
        }
        return question_count_key;
    }


    function hideElementsWhenStartPageLoaded() {
        $('.navbar-inner').hide();
        $('.masthead').hide();
        $('.main_heading').hide();
        // $('#img_logo').hide();
        $('#footer_main').hide();
        $('#previous').hide();
        $('#next_button').hide();
        $('#attachemnt_div').hide();
        $('#display_time').hide();
        $('#display_time_remaining').hide();
        $('#end-exam-btn-place').hide();
        $('#hide-links-footer-panel').hide();
        $('#btn_exhibit').hide();
        $('#panel-body-exhibit-view').hide();
    }

    function showElementsWhenStartExam() {

        $('#previous').show();
        $('#next_button').show();
        $('#attachemnt_div').show();
        $('#display_time').show();
        $('#display_time_remaining').show();
        $('#end-exam-btn-place').show();
        $('#hide-links-footer-panel').show();
        $("#scratch-btn").show();
        $("#calculator-btn").show();
        $("#exam_attachment-btn").show();
        $("#btn_exhibit").show();
        $('#panel-body-exhibit-view').show();
        $("#view-question-num").show();
        // $('#img_logo').show();

        $('#instructions').hide();
        var quesCount = <?php echo $numOfQues; ?>

        if (quesCount == 1) {
            $("#next_button").prop("disabled", true);
        }
    }


    function hideElementsForLinksInfooter() {
        $('#tinymce-div').hide();
        $("#view-question-num").hide();
    }


    function openScratchPad() {
        //var $j = jQuery.noConflict(true);
        $("#mydialog_scratchpad").dialog("open");
        return false;
    }

    function openCal() {
        $("#mydialog_cal").dialog("open");
        return false;
    }

    function openPreseen() {
        $("#mydialog_preseen").dialog("open");
        return false;
    }
    function openTable() {
        $("#mydialog_formulae").dialog("open");
        return false;
    }

    function openExamAttachemtn() {
        $("#mydialog_examAttachemtn").dialog("open");
        return false;
    }


    function validateJumpToNewSection() {
        var sectionNumberCount = new Array(); //number of questions in a section

<?php
for ($i = 0; $i < sizeof($essayExamSectionDetails); $i++) {
    ?>
            sectionNumberCount.push('<?php echo $essayExamSectionDetails[$i]['number_of_questions']; ?>');
    <?php
}
?>

        return sectionNumberCount;
    }
    //for next button
    function getLastQuestionNumberInSection(secNumCount) {
        var questionNumber = getNextQuestionNum();
        var qNUM = parseInt(questionNumber) - 1;
        var refreshCount = <?php echo $Session['refreshCount']; ?>;
        var sectionNumberForNextbtn;
        sectionNumberForNextbtn = localStorage.getItem('sectionNumForNextbtn');
        lastNumber = 0;
        if (sectionNumberForNextbtn == 0) {
            lastNumber = parseInt(secNumCount[sectionNumberForNextbtn]);
        } else {
            for (i = 0; i < sectionNumberForNextbtn; i++) {
                lastNumber += parseInt(secNumCount[i]);
            }
        }

        var firstNum = parseInt(lastNumber) + 1;
        if (qNUM == lastNumber) {

            if (refreshCount == 0) {
                lastQNumber[sectionNumberForNextbtn] = parseInt(firstNum);
                localStorage.setItem('lastQuestionNumArray', lastQNumber);
            } else {
                numArray = localStorage.getItem('lastQuestionNumArray');
                numArray[sectionNumberForNextbtn] = firstNum;
                localStorage.setItem('lastQuestionNumArray', numArray);
            }
            return 1;
        } else {
            return 0;
        }
    }

    //for previous button
    function getFirstQuestionNumberInSection() {
        var questionNumber = getPreviousQuestionNum();
        var qNUM = parseInt(questionNumber) + 1;
        var firstNumber = 0;
        var sectionNumberForNext = localStorage.getItem('sectionNumForNextbtn');
        var sectionNumberForNextbtn = parseInt(sectionNumberForNext) - 1;
        var lastQnumarray = new Array();
        lastQnumarray = localStorage.getItem('lastQuestionNumArray');
        if (lastQnumarray != null) {
            var arrayWithoutCommas = lastQnumarray.replace(/,/g, '');
        }

        if (sectionNumberForNextbtn == 0) {
            firstNumber = 1;
        } else if (arrayWithoutCommas.length == 1) {
            firstNumber = arrayWithoutCommas[0];
        }
        else {
            firstNumber = arrayWithoutCommas[(sectionNumberForNextbtn - 1)];
        }

        var latestSection = parseInt(sectionNumberForNext) - 1; //current section number
        var section = latestSection - 1;
        firstNumber = getLastSecNumber(section);
        if (qNUM == firstNumber) {
            return 1;
        } else {
            return 0;
        }
    }

    //for start exam btn
    function storeQuestionNumber() {
        var refreshCount = <?php echo $Session['refreshCount']; ?>;
        var refconditionCount = 0;
        if (refreshCount == 0) {
            if (refconditionCount == 0) {
                localStorage.setItem('storedQuestionNum', 1);
                localStorage.setItem('sectionNumForNextbtn', 1);
                refconditionCount++;
            }

        }
        var num = parseInt(localStorage.getItem('storedQuestionNum'));
        localStorage.setItem('storedQuestionNum', num);
        localStorage.setItem('prevStoredQuestionNum', num);
    }

    function getNextQuestionNum() {
        var qNum = localStorage.getItem('storedQuestionNum');
        return qNum;
    }

    function getPreviousQuestionNum() {
        var qNum = localStorage.getItem('prevStoredQuestionNum');
        return qNum;
    }

    function getQuestionNumForStart() {

        var rrcount = getRefreshCount(); //refresh count
        var qnum;
        if (rrcount == 0) {
            qnum = parseInt(getNextQuestionNum());
        } else {
            qnum = parseInt(getNextQuestionNum()) - 1;
        }

        return qnum;
    }

    function getRefreshCount() {
        var refreshCount = <?php echo $Session['refreshCount']; ?>;
        return refreshCount;
    }

    function isQuestionNoInSection(quesno) {
        getSectionNum(quesno);
        var qno = parseInt(quesno);
        var currentSection = parseInt(localStorage.getItem('sectionNumForNextbtn'));
        var firstQuestionNo = getFirstQuestionNo(currentSection);
        var lastQuestionNo = getLastQuestionNo(currentSection);

        if (qno >= firstQuestionNo && qno <= lastQuestionNo) {
            return 0;
        } else if (qno > lastQuestionNo) {
            return 1;
        } else {
            return 2;
        }

    }

    function getSectionNum(qnum) {
        var secNumbers = validateJumpToNewSection();
        var i;
        var count = 0;
        for (i = 0; i < secNumbers.length; i++) {
            count = count + parseInt(secNumbers[i]);
            if (qnum <= count) {
                break;
            }
        }

        var actualSecNum = parseInt(i) + 1;
        return actualSecNum;
    }


    function getFirstQuestionNo(currentSection) {
<?php $loop = 0; ?>
        var count = 1;
        for (var x = 1; x < currentSection; x++) {
            count = count + parseInt(essayExamSectionDetails[x - 1]['number_of_questions']);
        }
        return count;
    }
    function getLastQuestionNo(currentSection) {
<?php $loop = 0; ?>
        var count = 0;
        for (var x = 0; x < currentSection; x++) {
            count = count + parseInt(essayExamSectionDetails[x]['number_of_questions']);
        }
        return count;
    }
    function increaseSectionNo(quesno) {
        var qno = parseInt(quesno);
<?php $loop = 0; ?>
//        var count = 0;
//        var add = 0;
//        var sizeOfSection = parseInt('<?php //echo sizeof($essayExamSectionDetails);                                              ?>');
//        for (var x = 0; x < sizeOfSection; x++) {
//            count = count + parseInt("<?php
//echo $essayExamSectionDetails[$loop]['number_of_questions'];
//$loop++;
?>//");
//            if (count >= qno) {
//                add = x;
//                break;
//            }
//        }

        var secNum = getSectionNum(qno);
//        alert("increase "+secNum);
//        var currentSection = parseInt(localStorage.getItem('sectionNumForNextbtn'));
        //currentSection = add + 1;
        localStorage.setItem("sectionNumForNextbtn", parseInt(secNum));
    }
    function getSectionLastNumbers() {

        var secNumCount = validateJumpToNewSection();
        var storeLastQuestionNumber = new Array();
        for (i = 0; i < secNumCount.length; i++) {
            if (i == 0) {
                storeLastQuestionNumber[i] = parseInt(secNumCount[i]);
            } else {
                storeLastQuestionNumber[i] = parseInt(secNumCount[i]) + parseInt(secNumCount[i - 1]);
            }
        }
        return storeLastQuestionNumber;
    }

    function getSectionNumberForQuestionNumber(questionNum) {

        var sectionLastNumbers = getSectionLastNumbers();
        var secNumber = 0;
        for (i = 0; i < sectionLastNumbers.length; i++) {
            if (i == 0) {
                if (questionNum <= sectionLastNumbers[i]) {
                    secNumber = i;
                }
            }
            if (i == (sectionLastNumbers.length - 1)) {
                if (questionNum >= sectionLastNumbers[i]) {
                    secNumber = i;
                }
            }
            else {
                if ((questionNum <= sectionLastNumbers[i]) && (questionNum >= sectionLastNumbers[i])) {
                    secNumber = i;
                }
            }
        }

        return secNumber;
    }


    function setFlaged() {
        $.ajax({
            url: '<?php echo CController::createUrl('Exam/setFlagedQuestion'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                flag: document.getElementById("flag").checked,
                question_count_key: getQuestionCountKey()

            }

        });
    }

</script>

<script type="text/javascript">

    var count = 0;
    var timeforEachQuestion = 0;
    var message = "Your time has exceeded. You will be redirected to the exam status";
    var exceedSectionTimeMessage = "Time has exceeded for this section. you will be directed to next section";
    var mins = 0, seconds = 0;
    var timerID;
    var updateSecTimer;
    var fiveMinutesInSeconds = 5 * 60;
    var totalExamTime = 0;
    var sectionChange = "true";
    var finishedExam = false;
    function getSectionTime() {
        var sectionTimeArray = new Array(); //stores time for a section in a essay exam 

<?php
for ($i = 0; $i < sizeof($essayExamSectionDetails); $i++) {
    ?>
            sectionTimeArray.push('<?php echo $essayExamSectionDetails[$i]['section_time']; ?>');
    <?php
}
?>
        return sectionTimeArray;
    }

    var timeInSeconds;
    if (count == 0) {
        function timer() {
            var refreshCount = <?php echo $Session['refreshCount']; ?>;
            if (refreshCount == 0) {
                var timeInSeconds = 60 * <?php echo $exam_time; ?>;
                //   var timeInSeconds = 60 * 1;
                localStorage.setItem('timer', timeInSeconds);
                totalExamTime = parseInt(timeInSeconds);
                localStorage.setItem("lastFiveMinMessage", "FALSE");
            } else {
                var timeInSeconds = 60 * <?php echo $exam_time; ?>;
                totalExamTime = parseInt(timeInSeconds);
            }
            timerID = setInterval(updateTimer, 1000);
            timerForEachQuestion();
        }
        count++;
        //trigger time for each question 
    }

    var updateTimer = function () {
        if (!blocked) {
            timeInSeconds = localStorage.getItem('timer') || 0;
            display = document.getElementById("display_time");
            timeInSeconds--;
            moveToNextSection();
            if (localStorage.getItem("lastFiveMinMessage") == "FALSE") {
                if (fiveMinutesInSeconds == timeInSeconds) {
                    localStorage.setItem("lastFiveMinMessage", "TRUE");
                    bootbox.alert({
                        title: "5 Minute Warning",
                        message: "You have 5 minutes remaining.",
                        callback: function (result) {

                        }
                    });
                }
            }

            localStorage.setItem('timer', timeInSeconds);
            if (timeInSeconds < 0) {
                clearInterval(timerID);
                finishedExam = true;
                $('#display_time_remaining').hide();
                $('#display_time').hide();
                $('#view-question-num').hide();
                bootbox.alert({
                    title: "Time Expired",
                    message: "Your time has expired. Click OK to continue.",
                    callback: function (result) {
                        $.post(
                                '<?php echo $this->createUrl("Exam/essayExamStatus"); ?>',
                                {'answer_id': getAnswerId(),
                                    'question_count_key': getQuestionCountKey(),
                                    'flag': flag.checked,
                                    'exam_id': <?php echo $exam_id; ?>,
                                    'time_status': <?php echo Consts::STATUS_TIME_OVER; ?>,
                                    'timetaken': timerForEachQuestion()},
                        function (data) {
                            document.getElementById("display_time_remaining").style.display = "none";
                            document.getElementById("display_time").style.display = "none";
                            document.getElementById("view-question-num").style.display = "none";
                            $('#panel-body').html(data);
                        }
                        );
                    }
                });
            }
        }
    };
    var eachTime;
    var numOfQues = <?php echo $numOfQues; ?>;
    var questionTime = new Array(numOfQues);
    var refconditionCountforTime = 0;
    function timerForEachQuestion() {

        var startTime;
        var endTime;
        var refreshCountforTime = <?php echo $Session['refreshCount']; ?>;
        if (refreshCountforTime == 0) {
            if (refconditionCountforTime == 0) {
                var time = 60 * <?php echo $exam_time; ?>;
                localStorage.setItem('timerforeachQuestion', time);
            }
            refconditionCountforTime++;
        }

        startTime = localStorage.getItem('timerforeachQuestion') || 0;
        endTime = timeInSeconds;
        if (typeof endTime !== "undefined") {
            var timeTaken = startTime - endTime;
            localStorage.setItem('timerforeachQuestion', endTime);
            var questionNumber = document.getElementById("question_number_for_time").value;
            if (typeof questionTime[questionNumber] == 'undefined') {
                questionTime[questionNumber] = new Array(1);
                questionTime[questionNumber][0] = timeTaken;
            } else {
                questionTime[questionNumber][0] = timeTaken;
            }

            return questionTime[questionNumber][0];
        } else {
            return 0;
        }
    }
    function getTotalTimeTakenForExamLoggedIn() {
        var savedTime = parseInt(localStorage.getItem('timer'));
        var timer = 0;
        if (savedTime < 0) {

            timer = totalExamTime;
        } else {
            timer = totalExamTime - savedTime;
        }


        return timer;
    }
</script>


<script type="text/javascript">
    var movetoNextQuestion = false;
    function moveToNextSection() {
        sectionQuestionArray = getSectionTime(); //get section time in a array
        var latestSection;
        var questionNumber = getNextQuestionNum();
        index = getPreviousQuestionNum();
        document.getElementById("current_question_id").value = index;
        var sectionNumberForNext = localStorage.getItem('sectionNumForNextbtn');
        latestSection = parseInt(sectionNumberForNext) - 1; //current section number

        var nextSectionNum = parseInt(sectionNumberForNext) + 1;

        var latestTime = localStorage.getItem('newSectionTime'); //current time in count down timer  
        var questionCountKEy = parseInt(questionNumber) - 1;
        if (typeof latestTime !== "undefined") {

            var secTimeinMinutes = 0;
            for (i = 0; i <= latestSection; i++) {
                secTimeinMinutes += parseInt(sectionQuestionArray[i]);
            }


            if (latestTime < 0) {   //check section time 
                movetoNextQuestion = true;
                var lastN = getLastSecNumber(latestSection);
                var prevN = lastN - 1;
                var lastNumOfExam = getLastQuestionNumber(); //get last number of the exam

                if (lastNumOfExam == prevN) {   //check for last number of the exam
                    finishedExam = true;
                    clearInterval(timerID);
                    clearInterval(updateSecTimer);
                    $("#display_time").hide();
                    bootbox.alert({
                        title: "Time Expired",
                        message: "Your time has expired. Click OK to continue.",
                        callback: function (result) {
                            $.post(
                                    '<?php echo $this->createUrl("Exam/essayExamStatus"); ?>',
                                    {'answer_id': getAnswerId(),
                                        'question_count_key': getQuestionCountKey(),
                                        'flag': flag.checked,
                                        'exam_id': <?php echo $exam_id; ?>,
                                        'time_status': <?php echo Consts::STATUS_TIME_OVER; ?>,
                                        'timetaken': timerForEachQuestion()},
                            function (data) {
                                document.getElementById("display_time_remaining").style.display = "none";
                                $('#panel-body').html(data);
                            }
                            );
                        }
                    });
                } else {
                    bootbox.alert(exceedSectionTimeMessage, function () {
                        $.post(
                                '<?php echo $this->createUrl("Exam/viewNextEssayQuestion"); ?>',
                                {'question_number_count': getFirstQuestionNo(parseInt(nextSectionNum)),
                                    'question_count_key': getQuestionCountKey(),
                                    'previous_question_number_count': getPreviousQuestionNum(),
                                    'flag': 'document.getElementById("flag").value',
                                    'timetaken': timerForEachQuestion(),
                                    'answer_id': getAnswerId()
                                },
                        function (response) {
                            $("#tinymce-div").show();
                            var data = jQuery.parseJSON(response);

                            tinyMCE.activeEditor.setContent(data.answer);
                            $("#question_number_for_time").val(data.next_question_number - 1);
                            if (data.previous_question_number_count >= 1)
                            {
                                $("#previous").removeAttr("disabled");
                            }
                            if (data.next_question_number - 1 >= data.no_of_questions)
                            {
                                $("#next_button").prop("disabled", true);
                            }

                            var sectionNumber = localStorage.getItem("sectionNumForNextbtn");
                            sectionNumber++;
                            localStorage.setItem("sectionNumForNextbtn", sectionNumber);
                            var sectionNumberForNext = localStorage.getItem("sectionNumForNextbtn");
                            latestSection = parseInt(sectionNumberForNext); //current section number                                    
                            var numofSections = localStorage.getItem("numberOfSections");
                            $("#view-question-num").text("Section " + (latestSection) + " of " + numofSections);
//                            $("#view-question-num").text("Section " + (data.next_question_number - 1) + " of " + data.no_of_questions);
                            localStorage.setItem("storedQuestionNum", data.next_question_number);
                            localStorage.setItem("prevStoredQuestionNum", data.previous_question_number_count);
                            document.getElementById("question-body").innerHTML = data.exam_questions;
                        }
                        );

                    });
                    localStorage.setItem('sectionChange', "true");
                }
            }
        }
        // }
    }


    //last question number in section
    function getLastSecNumber(latestSecNum) {
        var secNumCount = validateJumpToNewSection();
        var lastNum = 0;
        for (i = 0; i <= latestSecNum; i++) {
            lastNum += parseInt(secNumCount[i]);
        }

        return (lastNum + 1);
    }

    //last question number in exam
    function getLastQuestionNumber() {
        var secNumCount = validateJumpToNewSection();
        var lastNum = 0;
        for (i = 0; i < secNumCount.length; i++) {
            lastNum += parseInt(secNumCount[i]);
        }
        return lastNum;
    }

</script>

<script type="text/javascript">

    //display the time for section
    var secTimerId;
    var startCount = 0;
    if (startCount == 0) {
        function setSectiontime() {
            sectionQuestionArray = getSectionTime(); //get section time in a array            

            var refreshCount = <?php echo $Session['refreshCount']; ?>;
            if (refreshCount == 0) {
                var secTimeinSeconds = parseInt(sectionQuestionArray[0]) * 60;
                localStorage.setItem('newSectionTime', secTimeinSeconds);
                localStorage.setItem('sectionChange', sectionChange);
                localStorage.setItem('sectionChange', "false");
                var secNumCount = validateJumpToNewSection();
                var numberOfSections = secNumCount.length;
                localStorage.setItem('numberOfSections', numberOfSections);
            }
            secTimerId = setInterval(updateSecTimer, 1000);
        }
        startCount++;
    }

    updateSecTimer = function () {
        if (!blocked) {
            if (localStorage.getItem('sectionChange') === "true") {
                var sectionNumberForNext = localStorage.getItem('sectionNumForNextbtn');
                if (movetoNextQuestion == true) {
                    var currentSection = parseInt(sectionNumberForNext); //current section number
                    movetoNextQuestion = false;
                } else {
                    var currentSection = parseInt(sectionNumberForNext) - 1; //current section number
                }

                sectionQuestionArray = getSectionTime(); //get section time in a array 

                var secTimeinSeconds = parseInt(sectionQuestionArray[currentSection]) * 60;
                localStorage.setItem('newSectionTime', secTimeinSeconds);
                localStorage.setItem('sectionChange', "false");
            }

            sectimeInSeconds = localStorage.getItem('newSectionTime') || 0;
            display = document.getElementById("display_time");
            mins = parseInt(sectimeInSeconds / 60);
            seconds = parseInt(sectimeInSeconds % 60);
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.innerHTML = mins + ":" + seconds;
            sectimeInSeconds--;
            localStorage.setItem('newSectionTime', sectimeInSeconds);
            if (localStorage.getItem("lastFiveMinMessage") == "FALSE") {

                var latestSection = localStorage.getItem('sectionNumForNextbtn'); //current section number
                var secNumCount = validateJumpToNewSection();
                var lastSectionNum = secNumCount.length;
                if (lastSectionNum == latestSection) {
                    if (fiveMinutesInSeconds == sectimeInSeconds) {
                        localStorage.setItem("lastFiveMinMessage", "TRUE");
                        bootbox.alert({
                            title: "5 Minute Warning",
                            message: "You have 5 minutes remaining.",
                            callback: function (result) {

                            }
                        });
                    }
                }
            }

            if (sectimeInSeconds < 0) {
                clearInterval(updateSecTimer);
            }


            if (finishedExam == true) {
                clearInterval(updateSecTimer);
            }
        }
    }

</script>


<script>
    window.onbeforeunload = function (e) {
        e = e || window.event;
        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = 'You are on the exam! If you choose to leave this page, no longer you can attend this exam.';
        }

        // For Safari
        return 'You are on the exam! If you choose to leave this page, no longer you can attend this exam.';
    };</script>



<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script>

    tinymce.init({
        selector: "textarea",
        theme: "modern",
//        width: 1110,
//        height: 250,
        //resize: "both",
        plugins: "autoresize",
        editor_selector: "mceEditor",
        editor_deselector: "mceNoEditor",
        //        plugins: [
        //            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        //            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        //            "save table contextmenu directionality emoticons template paste textcolor"
        //        ],
        // content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image |  | forecolor backcolor",
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
