<?php

if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("course_management") == 1)
{
$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Testimonials', 'url'=>array('index')),
	array('label'=>'Manage Testimonials', 'url'=>array('admin')),
);
?>

<h1 class="light_heading">Create Testimonials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));

}
else
{
$this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>