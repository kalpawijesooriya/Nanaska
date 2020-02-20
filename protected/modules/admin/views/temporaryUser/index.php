<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("temporary_users") == 1)
{
    
    $this->breadcrumbs=array(
            'Temporary Users',
    );

    $this->menu=array(
            //array('label'=>'Create TemporaryUser','url'=>array('create')),
            array('label'=>'Manage Temporary User','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Temporary Users</h2>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
