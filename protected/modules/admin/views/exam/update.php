<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("exam_management") == 1)
{
    
$this->breadcrumbs=array(
	'Exams'=>array('index'),
	$model->exam_id=>array('view','id'=>$model->exam_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Exam','url'=>array('index')),
	array('label'=>'Create Exam','url'=>array('create')),
	array('label'=>'View Exam','url'=>array('view','id'=>$model->exam_id)),
	array('label'=>'Manage Exams','url'=>array('admin')),
);
?>

<h2 class="light_heading">Update Exam <?php echo $model->exam_id; ?></h2>

<?php echo $this->renderPartial('_updateForm',array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>