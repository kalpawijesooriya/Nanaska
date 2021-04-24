<?php
$this->breadcrumbs=array(
	'Past Exams'=>array('index'),
	$model->past_exam_id,
);

$this->menu=array(
	array('label'=>'List PastExam','url'=>array('index')),
	array('label'=>'Create PastExam','url'=>array('create')),
	array('label'=>'Update PastExam','url'=>array('update','id'=>$model->past_exam_id)),
	array('label'=>'Delete PastExam','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->past_exam_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PastExam','url'=>array('admin')),
);
?>

<h1>View PastExam #<?php echo $model->past_exam_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'past_exam_id',
		'student_id',
		'exam_id',
		'take_id',
	),
)); ?>
