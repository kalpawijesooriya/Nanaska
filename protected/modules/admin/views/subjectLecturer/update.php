<?php
$this->breadcrumbs=array(
	'Subject Lecturers'=>array('index'),
	$model->subject_lecturer_id=>array('view','id'=>$model->subject_lecturer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubjectLecturer', 'url'=>array('index')),
	array('label'=>'Create SubjectLecturer', 'url'=>array('create')),
	array('label'=>'View SubjectLecturer', 'url'=>array('view', 'id'=>$model->subject_lecturer_id)),
	array('label'=>'Manage SubjectLecturer', 'url'=>array('admin')),
);
?>

<h1>Update SubjectLecturer <?php echo $model->subject_lecturer_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>