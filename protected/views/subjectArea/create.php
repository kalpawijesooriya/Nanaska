<?php
$this->breadcrumbs=array(
	'Subject Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubjectArea','url'=>array('index')),
	array('label'=>'Manage SubjectArea','url'=>array('admin')),
);
?>

<h1>Create SubjectArea</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>