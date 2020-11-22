<?php
$this->breadcrumbs=array(
	'Question Parts'=>array('index'),
	$model->question_part_id,
);

$this->menu=array(
	array('label'=>'List QuestionPart','url'=>array('index')),
	array('label'=>'Create QuestionPart','url'=>array('create')),
	array('label'=>'Update QuestionPart','url'=>array('update','id'=>$model->question_part_id)),
	array('label'=>'Delete QuestionPart','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->question_part_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage QuestionPart','url'=>array('admin')),
);
?>

<h1>View QuestionPart #<?php echo $model->question_part_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'question_part_id',
		'question_part_name',
		'question_id',
	),
)); ?>
