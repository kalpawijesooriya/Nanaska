<!--<script src="<?php //echo Yii::app()->theme->baseUrl;                         ?>/js/bootstrap-modal.js" type="text/javascript"></script>-->
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles-small.css', 'only screen and (max-width: 800px)'); ?>


<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<?php Yii::app()->bootstrap->register(); ?>
<!-- custom style sheet of the site -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.blockUI.js"></script>
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/markerStyle.css" />

<script type="text/javascript">
    $('.navbar-inner').hide();
    $('.masthead').hide();
    $('.main_heading').hide();
    $('#img_logo').hide();
    $('#btn_exhibitt').show();


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
    document.onkeydown = fn;

</script>

<style type="text/css">
    body { margin:60px 0; padding:0; overflow: hidden;}
    #panel-heading { left:5px; right: 5px; position:fixed; top:0; }
    .panel-footer { left:5px; right: 5px; position:fixed; bottom:0 }
    .popover{
        position: absolute;
        max-width: 100px;
        background-color: #ffffff;
        margin-top: 0 !important;
    }

    .popover-title{
        color: #0066ff;
    //padding-top: 0px;
        background-color: #f7f7f7;
        border-bottom: 1px solid #ebebeb;
    }
</style>

<body>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles.css');

if (isset(Yii::app()->session['exam_question_session'])) {
    $session_question = Yii::app()->session['exam_question_session'];
} else {
    $this->redirect(array('/site/customError', Consts::STR_MESSAGE => 'Data not found'));
}

$user_id = Yii::app()->user->getID();
if ($user_id != "") { //get exam id from url
    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $parts = parse_url($url);
    parse_str($parts['query'], $query);

    $stu_exam_id = Exam::model()->getStudentIdForUserId($user_id, $query['id']);

    if ($stu_exam_id == null) {
        $this->redirect(array('exam/examError'));
    }
}


$question_array = array();

foreach ($session_question as $question) {
    $question_array[$question['question_number']] = $question['question_number'];
    $question_details = Question::model()->getHotspotQuestionsId($question['question_id']);
    $questiontype = Question::model()->getQuestionType($question['question_id']);
    $timeForQuestion = $question['time_taken'];
}
?>

<?php
$examID = $_GET['id'];
$exam_time = Exam::model()->getExamTime($examID);
$isAllowed_cal = Exam::model()->getExamCalAllowed($examID);
$isAllow_viewMarked = Exam::model()->getExamViewMarkedAllowed($examID);
$isAllow_goto_question = Exam::model()->getExamGotoQuestionAllowed($examID);
$view_unanswered_allowed = Exam::model()->getExamViewUnansweredAllowed($examID);
$answer_count = 0;
$numOfQues = sizeof($session_question);

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
?>

<script language="javascript" type="text/javascript">
    var blocked = false;
    function checkconnection() {
        var status = navigator.onLine;
        if (status) {
            if(blocked) {
                $.unblockUI();
                blocked = false;
            }
        } else {
            if(!blocked) {
                $.blockUI({ message: 'Connection Lost!' });
                blocked = true;
            }
        }
    }

    setInterval(checkconnection, 1000);

    qindex = 0;
    //$.noConflict();
    $(document).ready(function () {
        $('#footer_main').hide();
        $('#previous').hide();
        $('#next_button').hide();
        $('#question_num').hide();
        $('#display_time').hide();
        $('#end-exam-btn-place').hide();
        $('#exam-finish-btn').hide();
        $('#display_time_remaining').hide();
        $('#header-spacing').hide();
        $('#panel-body-exhibit').hide();

        var allowed = "<?php echo $isAllowed_cal; ?>";

        if (allowed != 1) {
            $("#calculator-btn").remove();
        }

        var allowed_goto = "<?php echo $isAllow_goto_question; ?>";

        if (allowed_goto != 1) {
            document.getElementById("goto").remove();
            document.getElementById("question_num").remove();
        } else {
            document.getElementById("question_num").disabled = false;
        }

        var allowed_viewmark = "<?php echo $isAllow_viewMarked; ?>";

        if (allowed_viewmark != 1) {
            document.getElementById("view-mark").remove();
        }

        var allowed_unanswered_questions = "<?php echo $view_unanswered_allowed; ?>";
        if (allowed_unanswered_questions != 1) {
            $('#all-unanswered-questions').remove();
        }

        var previous_initial_value = $('#previous_question_number_count').val();

        if (previous_initial_value == "")
        {
            $("#previous").prop("disabled", true);
        }
        else
        {
            $("#previous").removeAttr("disabled");
        }

        var Point = 0;
        var X1, Y1, X2, Y2, X3, Y3, X4, Y4;



        $('.sameImge').live('click', function (e) {

            answerCount = $('#answer_count').val();

            if (answerCount != ($('#crossCount_nail').val())) {

                //  e.preventDefault();

//                    var x = e.pageX - this.offsetLeft;
//                    var y = e.pageY - this.offsetTop;

                var wrapper = $('.sameImge');
                var parentOffset = wrapper.offset();
                var x = e.pageX - parentOffset.left + wrapper.scrollLeft();
                var y = e.pageY - parentOffset.top + wrapper.scrollTop();

                var uId = IDGenerator();
                $('<img />').attr({
                    src: '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png',
                    id: 'img' + uId,
                    'class': 'cross_img'
                }).css('top', (y - 7)).css('left', (x - 6)).css('width', 12).css('height', 14).appendTo($('<a />').attr({
                    href: '#',
                    id: 'link' + uId,
                    onClick: "return false;"
                }).appendTo($('.sameImge')));

                $('#img' + uId).popover({
                    offset: 100,
                    trigger: 'manual',
                    html: true,
                    title: 'Options',
                    placement: 'top',
                    template: '<div class="popover" onmouseover="clearTimeout(timeoutObj);$(this).mouseleave(function() {$(this).hide();});"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
                    content: '<input type="button" id="link' + uId + '" value="Remove" onclick="getLinkId(this,\'' + x + '-' + y + '\')">'
                }).mouseenter(function (e) {
                    $(this).popover('show');
                }).mouseleave(function (e) {
                    var ref = $(this);
                    timeoutObj = setTimeout(function () {
                        ref.popover('hide');
                    }, 100);
                }).parent().on('click', '#remove-btn', function () {
                });

                $('#crossCount_nail').val(function (i, oldval) {
                    return ++oldval;
                });

            } else {
                bootbox.alert("You cannot mark more than " + answerCount + " positions");
            }
        });
    });

    $('#panel-body').scroll(function () {
        if ($('#panel-body').scrollTop() + $('#panel-body').height() == $(document).height()) {
            //alert("bottom!");
        }
    });
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

    function IDGenerator() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
    }


</script>


<script type="text/javascript">

    var marks = 0;
    $(".sameImge").live("click", function (e) {
        marks = $('.cross_img').length;

        answerCount = $('#answer_count').val();
        var PosX = 0;
        var PosY = 0;
        var ImgPos;
        ImgPos = FindPosition(this);
        if (!e)
            var e = window.event;
        if (e.pageX || e.pageY)
        {
            PosX = e.pageX;
            PosY = e.pageY;
        }
        else if (e.clientX || e.clientY)
        {
            PosX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            PosY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        PosX = PosX - ImgPos[0];
        PosY = PosY - ImgPos[1];

        if (answerCount > marks) {
            if (e.target.nodeName == 'AREA') {
                if (answerCount != ($('#crossCount_nail').val())) {
                    document.getElementById("hotspot_areaId").value =
                        document.getElementById("hotspot_areaId").value + 'C' + PosX + "-" + PosY + ",";
                }
            } else {
                if (answerCount != ($('#crossCount_nail').val())) {
                    document.getElementById("hotspot_areaId").value =
                        document.getElementById("hotspot_areaId").value + PosX + "-" + PosY + ",";
                }
            }
        }
    });



    function FindPosition(oElement)
    {
        if (typeof (oElement.offsetParent) != "undefined")
        {
            for (var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent)
            {
                posX += oElement.offsetLeft;
                posY += oElement.offsetTop;
            }
            return [posX, posY];
        }
        else
        {
            return [oElement.x, oElement.y];
        }
    }


</script>
<script type="text/javascript" language="javascript">
    var scrolDown = false;
    $(function () {
        var $win = $('#panel-body');

        $win.scroll(function () {
            if ($win.scrollTop() == 0) {

                //alert('Scrolled to Page Top');
            } else if ($win.height() + $win.scrollTop()
                == $('#exam_question_container').height()) {
                //alert('Scrolled to Page Bottum');
                scrolDown = true;
            }
        });
    });
</script>
<div class="container">
    <div class="span12" style="margin-bottom: 0px">
        <div class="panel panel-default" style="margin-bottom: 0px">
            <div class="panel-heading" id="panel-heading">
                <div class="span2" id="img_logo" style="margin-left: 0px"> <img src="assets/img/logo.png" class="logo exam-page-logo" alt="Responsive image"> </div>
                <p class="questionofquestion"><span id="view-question-num"></span><br/><span id="display_time_remaining" style="display: none;">Time Remaining</span>&nbsp;<button class="btn btn-mock" id="display_time" type="button"  style="float: right; display: none;"> Timer</button></p>
                <br/>
                <button class="btn btn-mock" id="scratch-btn" type="button" onclick="openScratchPad()" style="display: none;">Scratch Pad</button>
                <button class="btn btn-mock" id="calculator-btn" type="button" style="display: none;" onclick="openCal()">Calculator</button>
                <button class="btn btn-mock" id="formula-btn" type="button" onclick="openTable()" style="display: none;">Tables & Formulae</button>
            </div>
            <input type="hidden" id="question_number_for_time" value="1">
            <input type="hidden" id="num_of_questions" value="0">
            <input type="hidden" id="question_number_count" name="question_number_count" value="1">
            <input type="hidden" id="previous_question_number_count" name="previous_question_number_count" value="">
            <input type="hidden" id="crossCount_nail" value="0">
            <input type="hidden" id="current_question_idd" name="current_question_idd" value="0">
            <div class="panel-body" id="panel-body-exhibit">
                <?php
                echo '<br>';
                echo CHtml::ajaxButton('Exhibit ', CController::createUrl('Exam/questionExhibit'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'question_id' => 'js:current_question_idd.value',
                        'question_session' => $session_question,
                    ),
                    'success' => 'js:function(data){ 
                        if(data.status=="success"){                            
                            $("#mydialog_exhibitt").dialog("open"); 
                            if(document.getElementById("dialog_data")!=null){
                                $("#dialog_data").remove();
                            }        
                            $("#mydialog_exhibitt").append(data.qoutput);
                            
                           
                        }else{
                            
                        }
                    }'
                ), array(
                        'id' => "btn_exhibitt",
                        'class' => 'tinybluebtn',
                    )
                );
                ?>
                <div>
                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'mydialog_exhibitt',
                        'options' => array(
                            'title' => 'Question Exhibit',
                            'width' => 800,
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


            <div class="panel-body" id="panel-body" style="height: 480px;overflow-y: auto;overflow-x: hidden; width: 100%;" >

                <div class="panel-body-inner">

                    <?php
                    $examInstruction = Exam::model()->getExamInstructionForExam($examID);
                    $extension = substr($examInstruction, strrpos($examInstruction, '.') + 1);
                    $extension = strtolower($extension);
                    ?>



                    <div class="span10" id="instructions">
                        <h4>Exam Instructions</h4>

                        <?php
                        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "JPG" || $extension == "JEPG" || $extension == "PNG") {
                            echo '<center>' . CHtml::image(Yii::app()->request->baseUrl . '/images/exam_instructions/' . $examID . '/' . $examInstruction, "", array("width" => "700px", "height" => "auto")) . '</center>';
                        } else {
                            echo $examInstruction;
                        }
                        ?>
                    </div>




                    <?php
                    echo CHtml::ajaxButton('Start', Yii::app()->createUrl('Exam/ViewNextQuestions'), array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'onClick' => 'js:timer()', 'js:multi()', 'js:timerForEachQuestion()',
                        //'update' => '#panel-body',
                        'data' => array(
                            'question_number_count' => 'js:question_number_count.value',
                            //'previous_question_number_count' => 'js:previous_question_number_count.value',
                            'answer_id' => 'js:getAnswerId()',
                            'question_count_key' => 'js:getQuestionCountKey()',
                        ),
                        'success' => 'function(data){
                                qindex=0;
                                   document.getElementById("current_question_idd").value = qindex; 
                                   
                                                    
                                                    scrolDown = false;
                                                    $("#question_number_count").val(data.next_question_number);
                                                    $("#question_number_for_time").val(data.next_question_number-1);
                                                  
                                                    
                                                    $("#previous_question_number_count").val(data.previous_question_number_count);                                                   
                                                    document.getElementById("panel-body").innerHTML = data.exam_questions; 
                                                    
                                                    if(data.previous_question_number_count >= 1)
                                                    {
                                                        $("#previous").removeAttr("disabled");                                                        
                                                    }
                                                    if(data.flag_value == 1)
                                                    {                                                    
                                                        $("#flag").prop("checked", true);
                                                    }
                                                    if(data.flag_value == 0)
                                                    {
                                                        $("#flag").prop("checked", false);
                                                    }
                                                    document.getElementById("crossCount_nail").value=0;
                                                   
                                                    $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                                                   
                                                    if(data.question_type == "HOT_SPOT_ANSWER"){
                                                        showImage();
                                                    }
                                                    
                                                }'
                    ), array(
                            'class' => 'round-button',
                            'id' => uniqid(),
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="panel-footer">
                    <span id="end-exam-btn-place"> &nbsp; &nbsp;
                        <?php
                        echo CHtml::ajaxButton('Review Exam', array('Exam/examStatus'), array(
                            'type' => 'POST',
                            'onClick' => 'js:hideElementsInFooter(), js:hideElementsInHeader()',
//                        'dataType' => 'json',
                            'data' => array(
                                'answer_id' => 'js:getAnswerId()',
                                'question_count_key' => 'js:getQuestionCountKey()',
                                'flag' => 'js:flag.checked',
                                'timetaken' => 'js:timerForEachQuestion()',
                                'exam_id' => $exam_id,
                                'time_status' => Consts::STATUS_TIME_REMAINS
                            ),
                            'update' => '#panel-body',
                        ), array(
//                        'confirm' => 'Are you sure you want to Review the exam?',
                            'class' => 'btn btn-mock',
                            'id' => 'exam-review'
                        ));
                        ?>  &nbsp; &nbsp;

                    </span>


                <span id="hide-links-footer-panel" style="display: none;">
                        <span id="view-mark">
                            <?php
                            echo CHtml::ajaxLink('View Marked Questions', Yii::app()->createUrl('exam/viewMarkedQuestions'), array(
                                'type' => 'POST',
                                'update' => '#panel-body',
                            ), array(
                                    'id' => 'all-marked-questions' . uniqid()
                                )
                            );
                            ?>
                        </span>

                        &nbsp; &nbsp;

                        <span id="all-unanswered-questions">
                            <?php
                            echo CHtml::ajaxLink('View Unanswered Questions', Yii::app()->createUrl('exam/viewUnansweredQuestions'), array(
                                'type' => 'POST',
                                //'dataType' => 'json',
                                'update' => '#panel-body',
                            ), array(
                                    'id' => 'all-unanswered-questions' . uniqid(),
                                )
                            );
                            ?>
                        </span>

                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <input type="checkbox" name="flaged" id="flag" class="checkbox-margined" onchange="setFlaged()">Flag Question
                        &nbsp; &nbsp;&nbsp; &nbsp;
                        <span id="goto" style="display: none;">Go to</span> &nbsp; &nbsp;

                    </span>

                <?php
                echo CHtml::dropDownList('question_num', '', $question_array, array('prompt' => 'Select Question',
                    'ajax' => array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'url' => Yii::app()->createUrl('Exam/viewDropdownQuestions'),
                        'data' => array('question_num' => 'js:this.value',
                            'answer_id' => 'js:getAnswerId()',
                            'question_count_key' => 'js:getQuestionCountKey()',
                            'flag' => 'js:flag.checked',
                            'timetaken' => 'js:timerForEachQuestion()'
                        ),
                        'beforeSend' => 'function(){  
                                                    var wet = document.getElementById("panel-body");
                                                    var checkReading= wet.scrollHeight - wet.scrollTop === wet.clientHeight;                                                    
                                                    if(!checkReading){
                                                        jqXHR.abort();
                                                        bootbox.alert({
                                                            title: "Unseen Content",
                                                            message: "You have not yet viewed the entire screen. Make sure you view all multi-media content, select every tab and scroll to every corner",
                                                            callback: function(result) {                                                            
                                                            }
                                                          });
                                                    }
                                                }',
                        'success' => 'js:function(data){
                                $("#panel-body").scrollTop(0);
                            scrolDown = false;
                            $("#question_number_count").val(data.next_question_number);                            
                            
                            if(data.previous_question_number_count == 0){
                                $("#previous").prop("disabled",true);
                            }else{
                                $("#previous").prop("disabled",false);
                            }
                            if(data.next_question_number > data.no_of_questions)
                            {
                                $("#next_button").prop("disabled",true);
                            } else{
                                $("#next_button").prop("disabled",false);
                            }
                            if(data.flag_value == 1)
                            {
                                $("#flag").prop("checked", true);
                            }
                            if(data.flag_value == 0)
                            {
                                $("#flag").prop("checked", false);
                            }
                            
                            $("#previous_question_number_count").val(data.previous_question_number_count);                                                   
                            document.getElementById("panel-body").innerHTML = data.exam_questions;
                            
                            $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                            
                            if(data.question_type == "HOT_SPOT_ANSWER"){
                                                        showImage();
                                                    }
                            var $win = $("#panel-body");
                            if ($win.height() >= $("#exam_question_container").height()) {

                                 scrolDown = true;
                            }
                            }',
                    )
                ), array('id' => 'question_num'));
                ?>


                <ul class="pager pull-right" id="btn-nav-pane">
                    <li>
                        <?php
                        echo CHtml::ajaxButton(
                            $text = 'Previous', $url = Yii::app()->createUrl('Exam/ViewPreviousQuestions'), $ajaxOptions = array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            //     'onClick' => 'js:hotspotCrossDisplay()',
                            //'update' => '#panel-body',
                            'data' => array(
                                'previous_question_number_count' => 'js:previous_question_number_count.value',
                                'answer_id' => 'js:getAnswerId()',
                                'question_count_key' => 'js:getQuestionCountKey()',
                                'flag' => 'js:flag.checked',
                                'timetaken' => 'js:timerForEachQuestion()'
                            ),
                            'beforeSend' => 'function(jqXHR, settings){
                                            var wet = document.getElementById("panel-body");
                                                    var checkReading= wet.scrollHeight - wet.scrollTop === wet.clientHeight;                                                    
                                                    if(!checkReading){
                                                        jqXHR.abort();
                                                        bootbox.alert({
                                                            title: "Unseen Content",
                                                            message: "You have not yet viewed the entire screen. Make sure you view all multi-media content, select every tab and scroll to every corner",
                                                            callback: function(result) {                                                            
                                                            }
                                                          });
                                                    }
                                        }',
                            'success' => 'function(data){
                                    if(qindex>0){
                                        qindex--;
                                    }
                                    
                                   document.getElementById("current_question_idd").value = qindex; 
                                                $("#panel-body").scrollTop(0);
                                                scrolDown = false;
                                                $("#previous_question_number_count").val(data.previous_question_number_count); 
                                                $("#question_number_for_time").val(data.next_question_number-1);
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
                                                $("#question_number_count").val(data.next_question_number);                        
                                                document.getElementById("panel-body").innerHTML = data.exam_questions;
                                               
                                                $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                                                 
                                                if(data.question_type == "HOT_SPOT_ANSWER"){
                                                    showImage();
                                                }
                                                
                                                }'
                        ), $htmlOptions = array(
                            'id' => 'previous',
                            'class' => 'btn btn-mock hide-btn',
                            'style' => 'width: 70px'
                        )
                        );
                        ?>
                    </li>

                    <li>
                        <?php
                        echo CHtml::ajaxButton('Next', Yii::app()->createUrl('Exam/ViewNextQuestions'), array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'data' => array(
                                'question_number_count' => 'js:document.getElementById("question_number_count").value',
                                //'previous_question_number_count' => 'js:previous_question_number_count.value',
                                'answer_id' => 'js:getAnswerId()',
                                'question_count_key' => 'js:getQuestionCountKey()',
                                'flag' => 'js:flag.checked',
                                'timetaken' => 'js:timerForEachQuestion()'
                            ),
                            'beforeSend' => 'function(jqXHR, settings){
                                                    var wet = document.getElementById("panel-body");
                                                    var checkReading= wet.scrollHeight - wet.scrollTop === wet.clientHeight;                                                    
                                                    if(!checkReading){
                                                        jqXHR.abort();
                                                        bootbox.alert({
                                                            title: "Unseen Content",
                                                            message: "You have not yet viewed the entire screen. Make sure you view all multi-media content, select every tab and scroll to every corner",
                                                            callback: function(result) {                                                            
                                                            }
                                                          });
                                                    }
                                                }',
                            'success' => 'function(data){
                                    qindex++;
                                    document.getElementById("current_question_idd").value = qindex; 
                                                    $("#panel-body").scrollTop(0);
                                                    scrolDown = false;
                                                    $("#question_number_count").val(data.next_question_number);                                                     
                                                  $("#question_number_for_time").val(data.next_question_number-1);
                                                    $("#previous_question_number_count").val(data.previous_question_number_count);                                                   
                                                    document.getElementById("panel-body").innerHTML = data.exam_questions; 
                                                    if(data.previous_question_number_count >= 1)
                                                    {
                                                        $("#previous").removeAttr("disabled");                                                        
                                                    }
                                                    if(data.next_question_number - 1 >= data.no_of_questions)
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
                                                    document.getElementById("crossCount_nail").value=0;
                                                   
                                                    $("#view-question-num").text("Question "+(data.next_question_number-1)+" of "+data.no_of_questions);
                                                    
                                                    if(data.question_type == "HOT_SPOT_ANSWER"){
                                                        showImage();
                                                    }
                                                }'
                        ), array(
                                'id' => 'next_button',
                                'class' => 'btn btn-mock',
                                'style' => 'width: 70px'
                            )
                        );
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--    <div id="session"></div>-->

</div>
<?php
// draggable script
Yii::app()->clientScript->registerScript('drag', "
    $('.btn').live('mouseover', function() {
    $(this).draggable({
            helper: 'clone',
            opacity: 0.8,            
            revert: 'invalid',
            cursor: 'move',
            //containment: '#right-column'
        });         
    });

    ");

// droppable script
Yii::app()->clientScript->registerScript('drop', "
        $('.btn').live('mousedown', function() {
                $('.droppable').droppable({ 
                accept: '.btn',
                activeClass: 'ui-droppable-active',
                hoverClass: 'ui-droppable-hover',
                drop: function(ev, ui) {
                    var id = ui.draggable.attr('id');
                    var selected = false;
//                    $('input[name=answer_id]').each(function() {
//                        if($(this).val() == id) {
//                            bootbox.alert('Already used!');
//                            selected = true;
//                        }
//                    });
                    
                    if(selected == false) {
                        this.value = $(ui.draggable).text();
                        this.title = $(ui.draggable).attr('title');
                        $(this).closest('td').find('input[name=answer_id]').val(id);                                                                       
                    }
                    return false;
                }
            });
        });
        
        ");
?>
<script lang="javascript" type="text/javascript">

    function resetDrag() {
        $('input[name=answer_id]').removeAttr('value');
        $('input[name=answer_text]').removeAttr('title');
        $('input[name=answer_text]').removeAttr('value');
    }

    function getAnswerId() {
        var type = '';
        if ($("[name=answer_id]").is("select")) {
            type = 'select';
        } else {
            type = $("input[name=answer_id]").attr('type');
        }

        if (type == 'radio') {
            var answer_id = $("input[name=answer_id]:checked").val();
        } else if (type == 'checkbox') {
            var answer_id = $("input[name=answer_id]:checked").map(function () {
                return $(this).val();
            }).get();
        } else if (type == 'text') {
            var answer_id = $("input[name=answer_id]:text").map(function () {
                return $(this).val();
            }).get();
        } else if (type == 'select') {
            var answer_id = $("[name=answer_id] option:selected").map(function () {
                return $(this).val();
            }).get();
        }

        //        if (type == 'radio') {
        //            var answer_id = $("input[name=answer_id]:checked").val();
        //        } else if (type == 'checkbox') {
        //            var answer_id = $("input[name=answer_id]:checked").map(function() {
        //                return $(this).val();
        //            }).get();
        //        } else if (type == 'text') {
        //            var answer_id = $("input[name=answer_id]:text").map(function() {
        //                return $(this).val();
        //            }).get();
        //        }

        if (answer_id == "" || typeof answer_id === "undefined") {
            answer_id = null;
        }

        return answer_id;
    }

    function getQuestionCountKey() {
        var question_count_key = $("#question_count_key").val();
        if (question_count_key == null) {
            question_count_key = -1;
        }
        return question_count_key;
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
    };
</script>


<script type="text/javascript">
    var count = 0;
    var timeforEachQuestion = 0;
    var message = "Your time has exceeded. You will be redirected to the exam status";
    var mins = 0, seconds = 0;
    var timerID;
    var totalExamTime = 0;
    var timeInSeconds;
    var five_min = 300;
    if (count == 0) {
        function timer() {
            var refreshCount = <?php echo $Session['refreshCount']; ?>;

            if (refreshCount == 0) {
                var timeInSeconds = 60 * <?php echo $exam_time; ?>;
                localStorage.setItem('timer', timeInSeconds);
                totalExamTime = parseInt(timeInSeconds);
            } else {

            }
            timerID = setInterval(updateTimer, 1000);
        }
        count++;
    }

    var updateTimer = function () {
        if(!blocked) {
            timeInSeconds = localStorage.getItem('timer') || 0;
            display = document.getElementById("display_time");

            mins = parseInt(timeInSeconds / 60);
            seconds = parseInt(timeInSeconds % 60);
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.innerHTML = mins + ":" + seconds;
            timeInSeconds--;
            localStorage.setItem('timer', timeInSeconds);
            // timeforEachQuestion = timeInSeconds;

            if (timeInSeconds < 0) {
                clearInterval(timerID);
                bootbox.alert({
                    title: "Time Expired",
                    message: "Your time has expired. Click OK to continue.",
                    callback: function (result) {
                        $.post(
                            '<?php echo $this->createUrl("Exam/examStatus"); ?>',
                            {'answer_id': getAnswerId(),
                                'question_count_key': getQuestionCountKey(),
                                'flag': flag.checked,
                                'exam_id': <?php echo $exam_id; ?>,
                                'time_status': <?php echo Consts::STATUS_TIME_OVER; ?>,
                                'timetaken': timerForEachQuestion()},
                            function (data) {
                                $('#panel-body').html(data);
                            }
                        );
                    }
                });

                //                bootbox.alert(message, function () {
                //                    $.post(
                //                            '<?php //echo $this->createUrl("Exam/examStatus");            ?>',
                //                            {'answer_id': getAnswerId(),
                //                                'question_count_key': getQuestionCountKey(),
                //                                'flag': flag.checked,
                //                                'exam_id': <?php //echo $exam_id;            ?>,
                //                                'time_status': <?php // echo Consts::STATUS_TIME_OVER;            ?>,
                //                                'timetaken': timerForEachQuestion()},
                //                    function (data) {
                //                        $('#panel-body').html(data);
                //                    }
                //                    );
                //                });
                //timeInSeconds = 60 * 5;
            } else if (timeInSeconds == five_min) {
                bootbox.alert({
                    title: "5 Minute Warning",
                    message: "You have 5 minutes remaining.",
                    callback: function (result) {

                    }
                });
            }
        }
    };


    var eachTime;
    var numOfQues = <?php echo $numOfQues; ?>;
    var questionTime = new Array(numOfQues);
    var refconditionCount = 0;

    function timerForEachQuestion() {
        var startTime;
        var endTime;
        var refreshCount = <?php echo $Session['refreshCount']; ?>;

        if (refreshCount == 0) {
            if (refconditionCount == 0) {
                var time = 60 * <?php echo $exam_time; ?>;
                localStorage.setItem('timerforeachQuestion', time);
            }
            refconditionCount++;
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


    function multi() {
        $("#scratch-btn").show();
        $("#calculator-btn").show();
        $("#formula-btn").show();
        $('#end-exam-btn-place').show();
        $('#question_num').show();
        $('#endexam-btn').show();
        $('#hide-links-footer-panel').show();
        $('#previous').show();
        $('#next_button').show();
        $('#view-question-num').show();
        $('#display_time').show();
        $('#goto').show();
        $('#view-mark').show();
        $('#display_time_remaining').show();
        $('#btn_exhibitt').show();
        $('#panel-body-exhibit').show();
        $('#img_logo').show();

        var quesCount = <?php echo $numOfQues; ?>

        if (quesCount == 1) {
            $("#next_button").prop("disabled", true);
        }

    }

</script>


<script type="text/javascript">
    function showConfirm() {
        bootbox.confirm("Are you sure you want to end the exam?", function (result) {
            if (result === true) {
                showFinishButton();
            }
        });
    }

    function showFinishButton() {
        $('#exam-finish-btn').show();
    }

    function hideElementsInFooter() {
        $('#end-exam-btn-place').hide();
        $('#hide-links-footer-panel').hide();
        $('#question_num').hide();
        $('#btn-nav-pane').hide();
    }

    function hideElementsInHeader() {
        $('#scratch-btn').hide();
        $('#formula-btn').hide();
        $('#calculator-btn').hide();
        $('#view-question-num').hide();
        $('#panel-body-exhibit').hide();

    }

    function showElementsInFooter() {
        //        $('#panel-footer').show();
        $('#end-exam-btn-place').show();
        $('#hide-links-footer-panel').show();
        $('#question_num').show();
        $('#btn-nav-pane').show();
        $('#btn_exhibitt').show();
    }

    function showElementsInHeader() {
        $('#scratch-btn').show();
        $('#formula-btn').show();
        $('#calculator-btn').show();
        $('#view-question-num').show();
        $('#btn_exhibitt').show();
        $('#panel-body-exhibit').show();

    }
    function getTotalTimeTakenForExam() {

        var savedTime = parseInt(localStorage.getItem('timer'));
        var timer = 0;
        if (savedTime < 0) {

            timer = totalExamTime;
        } else {
            timer = totalExamTime - savedTime;
        }
        //alert(timer);
        $('#timer').attr('value', timer);
        var exit = confirm("Are you sure?");
        if (exit) {
            return true;
        } else {
            return false;
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
    function openScratchPad() {
        //var $j = jQuery.noConflict(true);
        $("#mydialog_scratchpad").dialog("open");
        return false;
    }

    function openCal() {
        //var $j = jQuery.noConflict(true);
        $("#mydialog_cal").dialog("open");
        return false;
    }

    function openTable() {
        //var $j = jQuery.noConflict(true);
        $("#mydialog_formulae").dialog("open");
        return false;
    }


</script>



<div id="cal">
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'mydialog_cal',
        'options' => array(
            'title' => 'Calculator',
            'width' => 310,
            'height' => 428,
            'autoOpen' => false,
//            'show' => array(
//                'effect' => 'toggle',
//                'duration' => 1000,
//            ),
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
//            'show' => array(
//                'effect' => 'toggle',
//                'duration' => 400,
//            ),
            'resizable' => true,
            'modal' => false,
            'overlay' => array(
                'backgroundColor' => '#000',
                'opacity' => '0.5'
            ),
        ),
    ));

    echo $this->renderPartial('scratch_pad_for_preset');
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
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
//            'show' => array(
//                'effect' => 'toggle',
//                'duration' => 400,
//            ),
            'resizable' => true,
            'modal' => false,
            'overlay' => array(
                'backgroundColor' => '#000',
                'opacity' => '0.5'
            ),
        ),
    ));

    echo $this->renderPartial('tabels_formulae', array('examID' => $examID));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
</div>


<script type="text/javascript">

    function getLinkId(element, xy) {


        if (document.getElementById("hotspot_areaId") == null) {
            var coords = document.getElementById("nextHotspot_areaId").value;
            //alert("null " + coords+ " xy "+ xy);
            coords = coords.replace('nC' + xy + ',', '');
            coords = coords.replace('n' + xy + ',', '');
            coords = coords.replace('C' + xy + ',', '');
            coords = coords.replace(xy + ',', '');
            //alert("removed "+coords);
            document.getElementById("nextHotspot_areaId").value = coords;

        } else {
            var coords = document.getElementById("hotspot_areaId").value;
            // alert(coords+ " xy "+ xy);
            coords = coords.replace('C' + xy + ',', '');
            coords = coords.replace(xy + ',', '');
            // alert("removed "+coords);
            document.getElementById("hotspot_areaId").value = coords;
        }

        var elementId = element.id;
        var link_x = document.getElementById(elementId);
        link_x.parentNode.removeChild(link_x);

        $('#crossCount_nail').val(function (i, oldval) {
            return --oldval;
        });

    }

</script>


<script type="text/javascript">

    function getLinkIdForNextandPrevious(element, xy) {
        var coords = document.getElementById("hotspot_areaId").value;
        alert("getLInk " + coords)
        coords = coords.replace('nC' + xy + ',', '');
        coords = coords.replace('n' + xy + ',', '');
        coords = coords.replace('C' + xy + ',', '');
        coords = coords.replace(xy + ',', '');

        document.getElementById("hotspot_areaId").value = coords;

        var elementId = element.id;

        var link_x = document.getElementById(elementId);
        link_x.parentNode.removeChild(link_x);

        var corssCount = elementId.substr(4);       //starts with 0
        $('#hidden' + corssCount).remove();

        $('#crossCount_nail').val(function (i, oldval) {
            return --oldval;
        });
    }

</script>


<script type="text/javascript">

    function showImage() {

        var xCoordinates = new Array();
        var yCoordinates = new Array();

        if (document.getElementById("hotspot_areaId") != null) {

            if (document.getElementById("hotspot_areaId").value != '' && document.getElementById("hotspot_areaId").value != 'n') {
                var markedCoords = document.getElementById("hotspot_areaId").value;

                var splitcoords1 = markedCoords.split(",");

                var stringCoords = '';
                for (i = 0; i < splitcoords1.length; i++) {

                    splitCoords2 = splitcoords1[i].split("-");

                    for (k = 0; k < splitCoords2.length; k++) {

                        if (splitCoords2[k].charAt(0) == 'C') {
                            stringCoords += splitCoords2[k].slice(1) + ',';
                        } else if (splitCoords2[k].charAt(0) == 'n' && splitCoords2[k].charAt(1) != 'C') {
                            stringCoords += splitCoords2[k].slice(1) + ',';
                        } else if (splitCoords2[k].charAt(1) == 'C') {
                            stringCoords += splitCoords2[k].slice(2) + ',';
                        } else {
                            stringCoords += splitCoords2[k] + ',';
                        }
                    }

                }

                var finalCoords = stringCoords.substring(0, stringCoords.length - 2);

                var finalCoordssplit = finalCoords.split(',');


                for (j = 0; j < finalCoordssplit.length; j++) {
                    xCoordinates.push(finalCoordssplit[j]);
                    j++;
                    yCoordinates.push(finalCoordssplit[j]);

                }

                var image = document.getElementById('myImage2');

                margin = 0;

                // Location inside the image

                for (i = 0; i < xCoordinates.length; i++) {

                    l = image.clientLeft;
                    t = image.clientTop;
                    w = image.width;
                    h = image.height;

                    offX = parseInt(xCoordinates[i]);
                    offY = parseInt(yCoordinates[i]);

//                        if (offX > margin)
//                            offX -= margin;
//                        if (offY > margin)
//                            offY -= margin;

                    l += offX;
                    t += offY;

                    var uId = IDGenerator();
                    $('<img />').attr({
                        src: '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png',
                        id: 'img' + uId,
                        'class': 'cross_img'
                    }).css('top', (t - 7)).css('left', (l - 6)).css('width', 12).css('height', 14).appendTo($('<a />').attr({
                        href: '#',
                        id: 'link' + uId,
                        onClick: "return false;"
                    }).appendTo($('.sameImge')));


                    $('#img' + uId).popover({
                        offset: 100,
                        trigger: 'manual',
                        html: true,
                        title: 'Options',
                        placement: 'top',
                        template: '<div class="popover" onmouseover="clearTimeout(timeoutObj);$(this).mouseleave(function() {$(this).hide();});"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
                        content: '<input type="button" id="link' + uId + '" value="Remove" onclick="getLinkId(this,\'' + l + '-' + t + '\')">'
                    }).mouseenter(function (e) {
                        $(this).popover('show');
                    }).mouseleave(function (e) {
                        var ref = $(this);
                        timeoutObj = setTimeout(function () {
                            ref.popover('hide');
                        }, 100);
                    }).parent().on('click', '#remove-btn', function () {
                    });
                }

                $('#crossCount_nail').val(i);

            } else {

                $('#crossCount_nail').val(0);
            }
        }

    }

</script>
<script type="text/javascript">
    $('.bottom_container_sub_footer').hide();

</script>
