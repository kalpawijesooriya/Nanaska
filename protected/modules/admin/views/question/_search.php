<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="control-group">
    <?php echo $form->textFieldRow($model, 'question_id', array('class' => 'span5')); ?>
</div>

<div class="control-group">
    <?php
    echo $form->labelEx($model, 'Course', array('class' => 'col-sm-2 control-label'));

    echo $form->dropDownList($model, 'course_id', Course::model()->getCoursesForUserAdvancedSearch(), array(
        'prompt' => 'Select Course',
        'class' => 'span5',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Level/getLevelsForUserAdvancedSearchInQuestionManagement'),
            'update' => '#Question_level_id',
        )
    ));
    ?>
</div>

<div class="control-group">
    <?php
    echo $form->labelEx($model, 'Level', array('class' => 'col-sm-2 control-label'));

    echo $form->dropDownList($model, 'level_id', array(), array(
        'prompt' => 'Select Level',
        'class' => 'span5',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjectsForUserAdvancedSearchInQuestionManagement'),
            'update' => '#Question_subject_id',
        )
    ));
    ?>
</div>

<div class="control-group">
    <?php
    echo $form->labelEx($model, 'Subject', array('class' => 'col-sm-2 control-label'));
    echo $form->dropDownList($model, 'subject_id', array(), array(
        'prompt' => 'Select Subject',
        'class' => 'span5',
        'ajax' => array(
            'type' => 'POST', //request type
            'url' => CController::createUrl('SubjectArea/getSubjectAreasForAdvancedSearchInQuestionManagement'),
            'update' => '#Question_subject_area_id',
        )
    ));
    ?>
</div>

<div class="control-group">
    <?php
    echo $form->labelEx($model, 'Subject Area', array('class' => 'col-sm-2 control-label'));
    echo $form->dropDownList($model, 'subject_area_id', array(), array(
        'prompt' => 'Select Subject Area',
        'class' => 'span5',
    ));
    ?>
</div>


<div class="control-group">
    <?php
    echo $form->labelEx($model, 'Question type', array('class' => 'col-sm-2 control-label'));
    echo $form->dropDownList($model, 'question_type', array(
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
        'HOT_SPOT_ANSWER' => 'Hot Spot Answer Questions'
            ), array(
        'class' => 'form-control',
        
                ));
    ?>

</div>

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
