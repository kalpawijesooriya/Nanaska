<?php
$this->breadcrumbs=array(
	'Lecturer Privileges'=>array('index'),
	$model->lecturer_privilege_id=>array('view','id'=>$model->lecturer_privilege_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LecturerPrivilege','url'=>array('index')),
	array('label'=>'Create LecturerPrivilege','url'=>array('create')),
	array('label'=>'View LecturerPrivilege','url'=>array('view','id'=>$model->lecturer_privilege_id)),
	array('label'=>'Manage LecturerPrivilege','url'=>array('admin')),
);
?>

<h1>Update LecturerPrivilege <?php echo $model->lecturer_privilege_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>