<?php
$this->breadcrumbs=array(
	'Paper Questions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PaperQuestion','url'=>array('index')),
	array('label'=>'Manage PaperQuestion','url'=>array('admin')),
);
?>

<h1>Create PaperQuestion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>