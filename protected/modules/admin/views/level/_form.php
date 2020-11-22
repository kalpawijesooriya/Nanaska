<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'level-form',
        'enableAjaxValidation' => false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php //echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'course_id'); ?>
        <?php // echo $form->textField($model, 'course_id'); ?>

        <?php
        echo $form->dropDownList($model, 'course_id', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
            'prompt' => 'Select Course',
            'class' => 'form-control',
//            'ajax' => array(
//                'type' => 'POST',
//                'url' => CController::createUrl('Level/getLevels'),
//                'update' => '#level_id',
//        )
        ));
        ?>
        <?php echo $form->error($model, 'course_id', array('style' => 'color:#B40404;')); ?>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'level_name'); ?>
        <?php echo $form->textField($model, 'level_name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Level Name')); ?>
        <?php echo $form->error($model, 'level_name',array('style' => 'color:#B40404;')); ?>
    </div>



    <div class="controls">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button button-news')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->