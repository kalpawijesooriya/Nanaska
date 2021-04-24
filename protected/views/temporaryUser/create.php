<?php
$this->breadcrumbs=array(
	'Temporary Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TemporaryUser','url'=>array('index')),
	array('label'=>'Manage TemporaryUser','url'=>array('admin')),
);
?>

<h1>Create TemporaryUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>