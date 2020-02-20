<?php
$this->breadcrumbs=array(
	'Final Results'=>array('index'),
	$model->final_result_id,
);

$this->menu=array(
	array('label'=>'List FinalResult','url'=>array('index')),
	array('label'=>'Create FinalResult','url'=>array('create')),
	array('label'=>'Update FinalResult','url'=>array('update','id'=>$model->final_result_id)),
	array('label'=>'Delete FinalResult','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->final_result_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FinalResult','url'=>array('admin')),
);
?>

<h1>View FinalResult #<?php echo $model->final_result_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'final_result_id',
		'take_id',
		'question_id',
		'mark',
	),
)); ?>
