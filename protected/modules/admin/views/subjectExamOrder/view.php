<?php
$this->breadcrumbs=array(
	'Subject Exam Orders'=>array('index'),
	$model->subject_exam_order_id,
);

$this->menu=array(
	array('label'=>'List SubjectExamOrder','url'=>array('index')),
	array('label'=>'Create SubjectExamOrder','url'=>array('create')),
	array('label'=>'Update SubjectExamOrder','url'=>array('update','id'=>$model->subject_exam_order_id)),
	array('label'=>'Delete SubjectExamOrder','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->subject_exam_order_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubjectExamOrder','url'=>array('admin')),
);
?>

<h1>View SubjectExamOrder #<?php echo $model->subject_exam_order_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'subject_exam_order_id',
		'subject_id',
		'exam_id',
		'position',
	),
)); ?>
