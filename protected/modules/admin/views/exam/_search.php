<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));

//$user_id = Yii::app()->user->loadUser()->user_id;
?>

<?php echo $form->textFieldRow($model, 'exam_id', array('class' => 'span5')); ?>

<?php
//echo $form->textFieldRow($model, 'course_id', array('class' => 'span5')); 

echo $form->labelEx($model, 'Course', array('class' => 'col-sm-2 control-label'));

echo $form->dropDownList($model, 'course_id', Course::model()->getCoursesForUserAdvancedSearch(), array(
    'prompt' => 'Select Course',
    'class' => 'span5',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('Level/GetLevelsForUserAdvancedSearch'),
        'update' => '#Exam_level_id',
    )
));
?>

<?php
//echo $form->textFieldRow($model, 'level_id', array('class' => 'span5'));
echo $form->labelEx($model, 'Level', array('class' => 'col-sm-2 control-label'));

echo $form->dropDownList($model, 'level_id', array(), array(
    'prompt' => 'Select Level',
    'class' => 'span5',
    'ajax' => array(
        'type' => 'POST', //request type
        'url' => CController::createUrl('Subject/getSubjectsForUserAdvancedSearch'),
        'update' => '#Exam_subject_id',
    )
));
?>

<?php
//echo $form->textFieldRow($model, 'subject_id', array('class' => 'span5'));
echo $form->labelEx($model, 'Subject', array('class' => 'col-sm-2 control-label'));
echo $form->dropDownList($model, 'subject_id', array(), array(
    'prompt' => 'Select Subject',
    'class' => 'span5',
));
?>

<?php echo $form->textFieldRow($model, 'exam_name', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php //echo $form->textFieldRow($model, 'number_of_questions', array('class' => 'span5'));  ?>

<br/>

<?php
// echo $form->textFieldRow($model,'exam_type',array('class'=>'span5','maxlength'=>7)); 
echo 'Exam Type<br/>';
echo $form->dropDownList($model, 'exam_type', array('PRESET' => 'Preset', 'SAMPLE' => 'Sample', 'DYNAMIC' => 'Dynamic','ESSAY'=>'Essay'), array(
    'prompt' => 'Select Exam  Type',
    'class' => 'form-control',
//        'ajax' => array(
//            'data' => array('exam_type' => 'js:exam_type.value', 'numberOfSubjectAreas' => $numberOfSubjectAreas, 'subject_id' => 'js:subject_id.value'),
//            'type' => 'POST',
//            'url' => CController::createUrl('Exam/getViewByType'),
//            'update' => '#render_view',
//    )
));
?>

<?php // echo $form->textFieldRow($model,'time',array('class'=>'span5'));  ?>

<?php // echo $form->textFieldRow($model,'calculator_allowed',array('class'=>'span5'));   ?>

<div class="form-actions">
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => 'Search',
));
?>
</div>

<?php $this->endWidget(); ?>
