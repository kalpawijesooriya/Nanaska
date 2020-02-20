<?php
$this->breadcrumbs=array(
	'Audits'=>array('index'),
	$model->audit_id,
);

$this->menu=array(
	array('label'=>'List Audit', 'url'=>array('index')),
	array('label'=>'Create Audit', 'url'=>array('create')),
	array('label'=>'Update Audit', 'url'=>array('update', 'id'=>$model->audit_id)),
	array('label'=>'Delete Audit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->audit_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Audit', 'url'=>array('admin')),
);
?>

<h1>View Audit #<?php echo $model->audit_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'audit_id',
		'user_id',
		'action_id',
		'action_name',
		'action',
		'date',
		'time',
		'status',
	),
)); ?>
