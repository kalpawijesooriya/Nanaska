<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Questions'=>array('index'),
            $model->question_id=>array('view','id'=>$model->question_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Questions','url'=>array('index')),
            array('label'=>'Create Question','url'=>array('create')),
            array('label'=>'View Question','url'=>array('view','id'=>$model->question_id)),
            array('label'=>'Manage Questions','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Update Question <?php echo $model->question_id; ?></h2><br/>

<?php echo $this->renderPartial('_edit',array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>