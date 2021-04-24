<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("temporary_users") == 1)
{
    
    $this->breadcrumbs=array(
            'Temporary Users'=>array('index'),
            $model->id=>array('view','id'=>$model->id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Temporary User','url'=>array('index')),
            array('label'=>'Create Temporary User','url'=>array('create')),
            array('label'=>'View Temporary User','url'=>array('view','id'=>$model->id)),
            array('label'=>'Manage Temporary User','url'=>array('admin')),
    );
?>

<h2>Update Temporary User <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>