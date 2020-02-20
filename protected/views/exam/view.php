<?php
$this->breadcrumbs=array(
	'Exams'=>array('index'),
	$model->exam_id,
);

$this->menu=array(
	array('label'=>'List Exam','url'=>array('index')),
	array('label'=>'Create Exam','url'=>array('create')),
	array('label'=>'Update Exam','url'=>array('update','id'=>$model->exam_id)),
	array('label'=>'Delete Exam','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Exam','url'=>array('admin')),
);
?>

<h1>View Exam #<?php echo $model->exam_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'exam_id',
		'subject_id',
		'exam_name',
		'number_of_questions',
		'exam_type',
		'time',
		'calculator_allowed',
	),
)); ?>
