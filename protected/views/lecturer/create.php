<?php
$this->breadcrumbs=array(
	'Lecturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lecturer', 'url'=>array('index')),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>Create Lecturer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>