<?php
$this->breadcrumbs=array(
	'Headings'=>array('index'),
	$model->heading_id,
);

$this->menu=array(
	array('label'=>'List Heading','url'=>array('index')),
	array('label'=>'Create Heading','url'=>array('create')),
	array('label'=>'Update Heading','url'=>array('update','id'=>$model->heading_id)),
	array('label'=>'Delete Heading','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->heading_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Heading','url'=>array('admin')),
);
?>

<h1>View Heading #<?php echo $model->heading_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'heading_id',
		'question_id',
		'heading_text',
		'heading_position',
	),
)); ?>
