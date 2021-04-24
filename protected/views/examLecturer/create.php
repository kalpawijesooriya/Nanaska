<?php
$this->breadcrumbs=array(
	'Exam Lecturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamLecturer', 'url'=>array('index')),
	array('label'=>'Manage ExamLecturer', 'url'=>array('admin')),
);
?>

<h1>Create ExamLecturer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>