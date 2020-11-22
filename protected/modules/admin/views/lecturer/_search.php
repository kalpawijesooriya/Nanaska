<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <!--
            <div class="row">
    <?php // echo $form->label($model,'lecturer_id');  ?>
    <?php // echo $form->textField($model,'lecturer_id');  ?>
            </div>-->

    <div class="control-group">
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id'); ?>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name'); ?>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name'); ?>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'phone_number'); ?>
        <?php echo $form->textField($model, 'phone_number'); ?>
    </div>
<!--    <div class="control-group">
        <?php // echo $form->label($model, 'address'); ?>
        <?php // echo $form->textField($model, 'address'); ?>
    </div>-->
<!--    <div class="control-group">
        <?php // echo $form->label($model, 'country_id'); ?>
        <?php // echo $form->textField($model, 'country_id'); ?>
    </div>-->

   <div class="control-group">
        <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
        <div class="controls"><?php echo $form->dropDownList($model, 'country_id', Country::model()->getCountries(), array('empty' => 'Select Country'));
        ?>
            <?php echo $form->error($model, 'country_id', array('class' => 'alert alert-danger')); ?></div>
    </div>

    <div class="controls">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->