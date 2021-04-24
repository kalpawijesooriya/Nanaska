<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->question_id,
);

$this->menu=array(
	array('label'=>'List Question','url'=>array('index')),
	array('label'=>'Create Question','url'=>array('create')),
	array('label'=>'Update Question','url'=>array('update','id'=>$model->question_id)),
	array('label'=>'Delete Question','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->question_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1>View Question #<?php echo $model->question_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'question_id',
		'subject_area_id',
		'question_type',
		'number_of_marks',
		'question_text',
		'exclude_from_dynamic',
	),
)); ?>
