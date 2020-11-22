<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("course_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Courses',
    );

    $this->menu=array(
            array('label'=>'Create Course', 'url'=>array('create')),
            array('label'=>'Manage Course', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Courses</h2>

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
