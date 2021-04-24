<?php
$this->breadcrumbs=array(
	'Exam Lecturers'=>array('index'),
	$model->exam_lecturer_id=>array('view','id'=>$model->exam_lecturer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamLecturer', 'url'=>array('index')),
	array('label'=>'Create ExamLecturer', 'url'=>array('create')),
	array('label'=>'View ExamLecturer', 'url'=>array('view', 'id'=>$model->exam_lecturer_id)),
	array('label'=>'Manage ExamLecturer', 'url'=>array('admin')),
);
?>

<h1>Update ExamLecturer <?php echo $model->exam_lecturer_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>