<?php
$this->breadcrumbs=array(
	'Audits'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>

<h1>Create Audit</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>