<?php
$this->breadcrumbs=array(
	'Subject Lecturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubjectLecturer', 'url'=>array('index')),
	array('label'=>'Manage SubjectLecturer', 'url'=>array('admin')),
);
?>

<h1>Create SubjectLecturer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>