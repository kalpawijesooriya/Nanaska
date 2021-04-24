<?php
$this->breadcrumbs=array(
	'Sittings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sitting', 'url'=>array('index')),
	array('label'=>'Manage Sitting', 'url'=>array('admin')),
);
?>

<h1>Create Sitting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>