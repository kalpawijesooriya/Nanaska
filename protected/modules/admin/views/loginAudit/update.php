<?php
$this->breadcrumbs=array(
	'Login Audits'=>array('index'),
	$model->login_audit_id=>array('view','id'=>$model->login_audit_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Login Activity', 'url'=>array('index')),
	array('label'=>'Create Login Activity', 'url'=>array('create')),
	array('label'=>'View Login Activity', 'url'=>array('view', 'id'=>$model->login_audit_id)),
	array('label'=>'Manage Login Activity', 'url'=>array('admin')),
);
?>

<h1>Update LoginAudit <?php echo $model->login_audit_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>