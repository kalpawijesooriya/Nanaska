<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_area_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Subject Areas'=>array('index'),
            $model->subject_area_id=>array('view','id'=>$model->subject_area_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Subject Area','url'=>array('index')),
            array('label'=>'Create Subject Area','url'=>array('create')),
            array('label'=>'View Subject Area','url'=>array('view','id'=>$model->subject_area_id)),
            array('label'=>'Manage Subject Area','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Update Subject-Area <?php echo $model->subject_area_id; ?></h2><br/>

<?php echo $this->renderPartial('_edit',array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>