<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("level_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Levels'=>array('index'),
            $model->level_id=>array('view','id'=>$model->level_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Level', 'url'=>array('index')),
            array('label'=>'Create Level', 'url'=>array('create')),
            array('label'=>'View Level', 'url'=>array('view', 'id'=>$model->level_id)),
            array('label'=>'Manage Level', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Update Level <?php echo $model->level_id; ?></h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>