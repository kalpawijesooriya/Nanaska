<div class="container">
    <?php
//$this->menu=array(
//	array('label'=>'View Account','url'=>array('view','id'=>$model->user_id)),
//	array('label'=>'Edit Account','url'=>array('update','id'=>$model->user_id)),
//	array('label'=>'Change Password','url'=>array('updatepass','id'=>$model->user_id)),
    //array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
    //array('label'=>'Manage User','url'=>array('admin')),
//);
    $this->renderpartial('_level_news_sidemenu');
    ?>
    <div class="span6"> 

        <h3 class="master_heading">Change Password</h3>
        <div class="well well-no-background">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'updatepass-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal'),
            ));
            ?>

            <div class="control-group">
                <?php
                foreach (Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="alert alert-danger">' . $message . "</div>\n";
                }
                ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'current_password', array('class' => 'control-label')); ?>
                <div class="controls"><?php echo $form->passwordField($model, 'current_password', array('size' => 32, 'maxlength' => 32, 'placeholder' => 'type your current password')); ?></div>
<?php echo $form->error($model, 'current_password'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'new_password', array('class' => 'control-label')); ?>
                <div class="controls"><?php echo $form->passwordField($model, 'new_password', array('size' => 32, 'maxlength' => 32, 'placeholder' => 'type new password here')); ?></div>
<?php echo $form->error($model, 'new_password'); ?>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'repeat_new_password', array('class' => 'control-label')); ?>
                <div class="controls"><?php echo $form->passwordField($model, 'repeat_new_password', array('size' => 32, 'maxlength' => 32, 'placeholder' => 're-type new password here')); ?></div>
<?php echo $form->error($model, 'repeat_new_password'); ?>
            </div>

            <div class="form-actions form-actions-no-background">
                <?php
                //$this->widget('bootstrap.widgets.TbButton', array(
                //'buttonType'=>'submit',
                //'type'=>'primary',
                //'label'=>$model->isNewRecord ? 'Create' : 'Save',
                //));
                ?>
<?php echo CHtml::submitButton('Save', array('class' => 'button button-news')); ?>	</div>


<?php $this->endWidget(); ?>
        </div>
    </div>
</div>