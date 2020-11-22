<script>
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }
</script>

<?php
$this->breadcrumbs = array(
    'Lecturers',
);

$this->menu = array(
    array('label' => 'List Lecturer', 'url' => array('Lecturer/index')),
    array('label' => 'Create Lecturer', 'url' => array('Lecturer/create')),
    array('label' => 'View Authored Questions', 'url' => array('Lecturer/ViewAuthoredQuestions')),
);
?>
<h2 class="light_heading">View Unapproved Questions</h2><br/>

<h4 class="light_heading">Select the Lecturer Code to Proceed</h4><br/>

<!--<h3 class="light_heading">View Un-Approved Questions</h>-->


<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword"><strong>Lecturer Code</strong></label>';

    echo '<div class="controls">' . CHtml::dropDownList('lecturer_id', '', CHtml::listData(Lecturer::model()->findAll(), 'lecturer_code', 'lecturer_code'), array(
        'prompt' => 'Select Lecturer Code',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array(
                'lecturer_code' => 'js:lecturer_id.value'
            ),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Question/showUnapprovedQuestions'),
            'beforeSend' => 'function(){               
                $("#answer-rows").addClass("loading");}',
            'complete' => 'function(){                
                 $("#answer-rows").removeClass("loading");}',
            'update' => '#answer-rows',
        )
    )) . '</div>';

//    echo CHtml::dropDownList('question_type','', array(
//            'empty' => 'Select Question Type',
//            'SINGLE_ANSWER' => 'Single Answer Questions',
//            'MULTIPLE_ANSWER' => 'Multiple Answer Questions',
//            'SHORT_WRITTEN' => 'Short Written Answer Questions',
//            'DRAG_DROP_TYPEA_ANSWER' => 'Drag & Drop Type A Answer Questions',
//            'DRAG_DROP_TYPEB_ANSWER' => 'Drag & Drop Type B Answer Questions',
//            'DRAG_DROP_TYPEC_ANSWER' => 'Drag & Drop Type C Answer Questions',
//            'DRAG_DROP_TYPED_ANSWER' => 'Drag & Drop Type D Answer Questions',
//            'DRAG_DROP_TYPEE_ANSWER' => 'Drag & Drop Type E Answer Questions',
//            'MULTIPLE_CHOICE_ANSWER' => 'Multiple Choice Answer Questions',
//            'TRUE_OR_FALSE_ANSWER' => 'True Or false Answer Questions',
//            'HOT_SPOT_ANSWER' => 'Hot Spot Answer Questions'
//                ), array(
//            'class' => 'form-control',
//            'ajax' => array(
//                'type' => 'POST', //request type
//                'url' => CController::createUrl('Question/getAnswerForms'),
//                'update' => '#answer-rows',
//        )));

    echo '<br/>';

//    echo CHtml::ajaxButton('Show Questions', CController::createUrl('Question/showUnapprovedQuestions'), array(
//        'type' => 'POST', //request type
//        'dataType' => 'json',
//        'data' => array(
//            'lecturer_id' => 'js:lecturer_id.value',
//        ),
//        'success' => 'function(data){ 
//            if(data[0].status=="success"){
//                    removeHighlight("lecturer_id");
//                    if(data[1].length==0){
//                        alert("No Un-Approved Questions For the Selected Lecturer");
//                    }else{
//                        
//                    }
//            }else if(data[0].status=="fail"){
//                   hightlightTextBox("lecturer_id");
//            }
//
//                                    }'
//            ), array('class' => 'btn btn-checkout',
//        'id' => 'remove_question_part_',
//        'name' => 'remove_question_part_',
//        'class' => 'greybtn',
//            )
//    );
    ?> 

</div>

<div id="answer-rows">

</div>


<!--<table border="1">
    <tr>
        <th width="200">Question ID</th>
        <th width="200">Type</th>
        <th width="200">Date Created</th>
        <th width="200">Action</th>
    <tr>
<?php
?>    

</table>-->
