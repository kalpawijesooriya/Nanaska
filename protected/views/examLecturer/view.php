<?php
$this->breadcrumbs=array(
	'Exam Lecturers'=>array('index'),
	$model->exam_lecturer_id,
);

$this->menu=array(
	array('label'=>'List ExamLecturer', 'url'=>array('index')),
	array('label'=>'Create ExamLecturer', 'url'=>array('create')),
	array('label'=>'Update ExamLecturer', 'url'=>array('update', 'id'=>$model->exam_lecturer_id)),
	array('label'=>'Delete ExamLecturer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_lecturer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExamLecturer', 'url'=>array('admin')),
);
?>

<h1>View ExamLecturer #<?php echo $model->exam_lecturer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'exam_lecturer_id',
		'lecturer_id',
		'exam_id',
	),
)); ?>
