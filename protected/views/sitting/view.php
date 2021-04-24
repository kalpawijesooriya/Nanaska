<?php
$this->breadcrumbs=array(
	'Sittings'=>array('index'),
	$model->sitting_id,
);

$this->menu=array(
	array('label'=>'List Sitting', 'url'=>array('index')),
	array('label'=>'Create Sitting', 'url'=>array('create')),
	array('label'=>'Update Sitting', 'url'=>array('update', 'id'=>$model->sitting_id)),
	array('label'=>'Delete Sitting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sitting_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sitting', 'url'=>array('admin')),
);
?>

<h1>View Sitting #<?php echo $model->sitting_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sitting_id',
		'sitting_name',
	),
)); ?>
