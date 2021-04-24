<?php
$this->breadcrumbs=array(
	'Exam Subject Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamSubjectArea','url'=>array('index')),
	array('label'=>'Manage ExamSubjectArea','url'=>array('admin')),
);
?>

<h1>Create ExamSubjectArea</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>