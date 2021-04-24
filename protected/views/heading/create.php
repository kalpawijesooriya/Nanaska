<?php
$this->breadcrumbs=array(
	'Headings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Heading','url'=>array('index')),
	array('label'=>'Manage Heading','url'=>array('admin')),
);
?>

<h1>Create Heading</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>