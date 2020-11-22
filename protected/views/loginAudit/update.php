<?php
$this->breadcrumbs=array(
	'Login Audits'=>array('index'),
	$model->login_audit_id=>array('view','id'=>$model->login_audit_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LoginAudit', 'url'=>array('index')),
	array('label'=>'Create LoginAudit', 'url'=>array('create')),
	array('label'=>'View LoginAudit', 'url'=>array('view', 'id'=>$model->login_audit_id)),
	array('label'=>'Manage LoginAudit', 'url'=>array('admin')),
);
?>

<h1>Update LoginAudit <?php echo $model->login_audit_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>