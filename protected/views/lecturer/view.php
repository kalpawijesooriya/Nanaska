<?php
$this->breadcrumbs=array(
	'Lecturers'=>array('index'),
	$model->lecturer_id,
);

$this->menu=array(
	array('label'=>'List Lecturer', 'url'=>array('index')),
	array('label'=>'Create Lecturer', 'url'=>array('create')),
	array('label'=>'Update Lecturer', 'url'=>array('update', 'id'=>$model->lecturer_id)),
	array('label'=>'Delete Lecturer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lecturer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>View Lecturer #<?php echo $model->lecturer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lecturer_id',
		'user_id',
	),
)); ?>
