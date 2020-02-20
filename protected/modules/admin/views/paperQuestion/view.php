<?php
$this->breadcrumbs=array(
	'Paper Questions'=>array('index'),
	$model->paper_question_id,
);

$this->menu=array(
	array('label'=>'List PaperQuestion','url'=>array('index')),
	array('label'=>'Create PaperQuestion','url'=>array('create')),
	array('label'=>'Update PaperQuestion','url'=>array('update','id'=>$model->paper_question_id)),
	array('label'=>'Delete PaperQuestion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->paper_question_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaperQuestion','url'=>array('admin')),
);
?>

<h1>View PaperQuestion #<?php echo $model->paper_question_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'paper_question_id',
		'take_id',
		'question_id',
		'question_part_id',
		'answer_id',
		'time_taken',
		'question_marked',
	),
)); ?>
