<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("country_management") == 1)
{

    $this->breadcrumbs=array(
            'Countries'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List Country', 'url'=>array('index')),
            array('label'=>'Manage Country', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Create Country</h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model)); 
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>