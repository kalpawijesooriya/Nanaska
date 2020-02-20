<?php
$this->breadcrumbs=array(
	'Question Part Texts'=>array('index'),
	$model->question_part_text_id,
);

$this->menu=array(
	array('label'=>'List QuestionPartText','url'=>array('index')),
	array('label'=>'Create QuestionPartText','url'=>array('create')),
	array('label'=>'Update QuestionPartText','url'=>array('update','id'=>$model->question_part_text_id)),
	array('label'=>'Delete QuestionPartText','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->question_part_text_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage QuestionPartText','url'=>array('admin')),
);
?>

<h1>View QuestionPartText #<?php echo $model->question_part_text_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'question_part_text_id',
		'question_id',
		'question_part_text',
	),
)); ?>
