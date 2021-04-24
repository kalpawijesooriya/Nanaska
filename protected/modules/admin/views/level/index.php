<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("level_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Levels',
    );

    $this->menu=array(
            array('label'=>'Create Level', 'url'=>array('create')),
            array('label'=>'Manage Level', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Levels</h2>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
