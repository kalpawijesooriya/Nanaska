<?php
$this->breadcrumbs=array(
	'Login Audits'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LoginAudit', 'url'=>array('index')),
	array('label'=>'Manage LoginAudit', 'url'=>array('admin')),
);
?>

<h1>Create LoginAudit</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>