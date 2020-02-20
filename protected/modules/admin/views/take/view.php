<?php
$this->breadcrumbs=array(
	'Takes'=>array('index'),
	$model->take_id,
);

$this->menu=array(
	array('label'=>'List Take','url'=>array('index')),
	array('label'=>'Create Take','url'=>array('create')),
	array('label'=>'Update Take','url'=>array('update','id'=>$model->take_id)),
	array('label'=>'Delete Take','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->take_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Take','url'=>array('admin')),
);
?>

<h1>View Take #<?php echo $model->take_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'take_id',
		'student_id',
		'exam_id',
		'date',
	),
)); ?>
