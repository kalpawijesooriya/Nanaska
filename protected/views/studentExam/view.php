<?php
$this->breadcrumbs=array(
	'Student Exams'=>array('index'),
	$model->student_exam_id,
);

$this->menu=array(
	array('label'=>'List StudentExam','url'=>array('index')),
	array('label'=>'Create StudentExam','url'=>array('create')),
	array('label'=>'Update StudentExam','url'=>array('update','id'=>$model->student_exam_id)),
	array('label'=>'Delete StudentExam','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->student_exam_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StudentExam','url'=>array('admin')),
);
?>

<h1>View StudentExam #<?php echo $model->student_exam_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'student_exam_id',
		'student_id',
		'exam_id',
		'expiry_date',
	),
)); ?>
