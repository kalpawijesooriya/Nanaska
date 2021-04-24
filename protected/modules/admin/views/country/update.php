<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("country_management") == 1)
{

    $this->breadcrumbs=array(
            'Countries'=>array('index'),
            $model->country_id=>array('view','id'=>$model->country_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Country', 'url'=>array('index')),
            array('label'=>'Create Country', 'url'=>array('create')),
            array('label'=>'View Country', 'url'=>array('view', 'id'=>$model->country_id)),
            array('label'=>'Manage Country', 'url'=>array('admin')),
    );
?>

    <h2 class="light_heading">Update Country <?php echo $model->country_id; ?></h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>