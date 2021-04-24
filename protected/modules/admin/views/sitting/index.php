<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("sitting_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Sittings',
    );

    $this->menu=array(
            array('label'=>'Create Session', 'url'=>array('create')),
            array('label'=>'Manage Sessions', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Sessions</h2>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
