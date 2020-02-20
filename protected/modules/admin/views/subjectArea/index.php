<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_area_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Subject Areas',
    );

    $this->menu=array(
            array('label'=>'Create Subject Area','url'=>array('create')),
            array('label'=>'Manage Subject Area','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Subject Areas</h2>

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
