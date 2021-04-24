<?php
$this->breadcrumbs=array(
	'Student Exams'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StudentExam','url'=>array('index')),
	array('label'=>'Manage StudentExam','url'=>array('admin')),
);
?>

<h1>Create StudentExam</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>