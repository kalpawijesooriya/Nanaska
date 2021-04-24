<?php

if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("country_management") == 1)
{
    $this->breadcrumbs=array(
            'Testimonials',
    );
    

    $this->menu=array(
            array('label'=>'Create Country', 'url'=>array('create')),
            array('label'=>'Manage Country', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Countries</h2>

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
