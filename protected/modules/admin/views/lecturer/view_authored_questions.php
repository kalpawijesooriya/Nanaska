<?php
$this->breadcrumbs = array(
    'Lecturers',
);

$this->menu = array(
    array('label' => 'Create Lecturer', 'url' => array('create')),
    array('label' => 'Manage Lecturer', 'url' => array('admin')),
        //array('label' => 'View Authored Questions', 'url' => array('ViewAuthoredQuestions')),
);
?>
<h2 class="light_heading">View Authored Questions</h2>

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
        'url' => CController::createUrl('Lecturer/showAuthoredQuestions'),
        'beforeSend' => 'function(){               
                $("#answer-rows").addClass("loading");}',
        'complete' => 'function(){                
                 $("#answer-rows").removeClass("loading");}',
        'update' => '#answer-rows',
    )
)) . '</div>';
?>
</div>


<div id="answer-rows">

</div>


<br/>

<br/>

