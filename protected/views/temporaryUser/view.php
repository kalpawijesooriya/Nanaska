<?php
$this->breadcrumbs=array(
	'Temporary Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TemporaryUser','url'=>array('index')),
	array('label'=>'Create TemporaryUser','url'=>array('create')),
	array('label'=>'Update TemporaryUser','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TemporaryUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TemporaryUser','url'=>array('admin')),
);
?>

<h1>View TemporaryUser #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'phone_number',
		'address',
		'country_id',
		'email',
		'course_id',
		'level_id',
		'sitting_id',
	),
)); ?>
