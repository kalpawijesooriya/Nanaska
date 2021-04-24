<?php
$this->breadcrumbs=array(
	'Audits'=>array('index'),
	$model->audit_id=>array('view','id'=>$model->audit_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Create Activity', 'url'=>array('create')),
	array('label'=>'View Activity', 'url'=>array('view', 'id'=>$model->audit_id)),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>

<h1>Update Audit <?php echo $model->audit_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>