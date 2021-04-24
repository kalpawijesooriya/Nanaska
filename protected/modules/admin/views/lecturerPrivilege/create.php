<?php
$this->breadcrumbs=array(
	'Lecturer Privileges'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LecturerPrivilege','url'=>array('index')),
	array('label'=>'Manage LecturerPrivilege','url'=>array('admin')),
);
?>

<h1>Create LecturerPrivilege</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>