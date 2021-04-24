<?php
$this->breadcrumbs=array(
	'Exam Questions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamQuestion','url'=>array('index')),
	array('label'=>'Manage ExamQuestion','url'=>array('admin')),
);
?>

<h1>Create ExamQuestion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>