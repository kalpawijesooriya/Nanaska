<?php
$this->breadcrumbs=array(
	'Hotspots'=>array('index'),
	$model->hotspot_id,
);

$this->menu=array(
	array('label'=>'List Hotspot','url'=>array('index')),
	array('label'=>'Create Hotspot','url'=>array('create')),
	array('label'=>'Update Hotspot','url'=>array('update','id'=>$model->hotspot_id)),
	array('label'=>'Delete Hotspot','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->hotspot_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hotspot','url'=>array('admin')),
);
?>

<h1>View Hotspot #<?php echo $model->hotspot_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'hotspot_id',
		'image_name',
		'coordinates',
		'question_id',
	),
)); ?>
