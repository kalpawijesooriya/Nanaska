<?php
$this->breadcrumbs=array(
	'Subject Lecturers'=>array('index'),
	$model->subject_lecturer_id,
);

$this->menu=array(
	array('label'=>'List SubjectLecturer', 'url'=>array('index')),
	array('label'=>'Create SubjectLecturer', 'url'=>array('create')),
	array('label'=>'Update SubjectLecturer', 'url'=>array('update', 'id'=>$model->subject_lecturer_id)),
	array('label'=>'Delete SubjectLecturer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subject_lecturer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubjectLecturer', 'url'=>array('admin')),
);
?>

<h1>View SubjectLecturer #<?php echo $model->subject_lecturer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subject_lecturer_id',
		'lecturer_id',
		'subject_id',
	),
)); ?>
