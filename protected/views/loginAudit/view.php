<?php
$this->breadcrumbs=array(
	'Login Audits'=>array('index'),
	$model->login_audit_id,
);

$this->menu=array(
	array('label'=>'List LoginAudit', 'url'=>array('index')),
	array('label'=>'Create LoginAudit', 'url'=>array('create')),
	array('label'=>'Update LoginAudit', 'url'=>array('update', 'id'=>$model->login_audit_id)),
	array('label'=>'Delete LoginAudit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->login_audit_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LoginAudit', 'url'=>array('admin')),
);
?>

<h1>View LoginAudit #<?php echo $model->login_audit_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'login_audit_id',
		'user_id',
		'action',
		'date',
		'time',
		'status',
	),
)); ?>
