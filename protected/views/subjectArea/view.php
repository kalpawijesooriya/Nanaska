<?php
$this->breadcrumbs=array(
	'Subject Areas'=>array('index'),
	$model->subject_area_id,
);

$this->menu=array(
	array('label'=>'List SubjectArea','url'=>array('index')),
	array('label'=>'Create SubjectArea','url'=>array('create')),
	array('label'=>'Update SubjectArea','url'=>array('update','id'=>$model->subject_area_id)),
	array('label'=>'Delete SubjectArea','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->subject_area_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubjectArea','url'=>array('admin')),
);
?>

<h1>View SubjectArea #<?php echo $model->subject_area_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'subject_area_id',
		'subject_id',
		'subject_area_name',
	),
)); ?>
