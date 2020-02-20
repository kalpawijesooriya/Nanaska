<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_area_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Subject Areas'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List Subject Area','url'=>array('index')),
            array('label'=>'Manage Subject Area','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Create Subject-Area</h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>