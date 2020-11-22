<?php
$this->breadcrumbs=array(
	'Lecturers'=>array('index'),
	$model->lecturer_id=>array('view','id'=>$model->lecturer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lecturer', 'url'=>array('index')),
	array('label'=>'Create Lecturer', 'url'=>array('create')),
	array('label'=>'View Lecturer', 'url'=>array('view', 'id'=>$model->lecturer_id)),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>Update Lecturer <?php echo $model->lecturer_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>