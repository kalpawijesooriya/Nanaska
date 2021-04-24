<?php
$this->breadcrumbs=array(
	'Takes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Take','url'=>array('index')),
	array('label'=>'Manage Take','url'=>array('admin')),
);
?>

<h1>Create Take</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>