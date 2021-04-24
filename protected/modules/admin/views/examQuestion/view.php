<?php
$this->breadcrumbs=array(
	'Exam Questions'=>array('index'),
	$model->exam_question_id,
);

$this->menu=array(
	array('label'=>'List ExamQuestion','url'=>array('index')),
	array('label'=>'Create ExamQuestion','url'=>array('create')),
	array('label'=>'Update ExamQuestion','url'=>array('update','id'=>$model->exam_question_id)),
	array('label'=>'Delete ExamQuestion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_question_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExamQuestion','url'=>array('admin')),
);
?>

<h1>View ExamQuestion #<?php echo $model->exam_question_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'exam_question_id',
		'exam_id',
		'question_id',
	),
)); ?>
