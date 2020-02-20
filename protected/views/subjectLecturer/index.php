<?php
$this->breadcrumbs=array(
	'Subject Lecturers',
);

$this->menu=array(
	array('label'=>'Create SubjectLecturer', 'url'=>array('create')),
	array('label'=>'Manage SubjectLecturer', 'url'=>array('admin')),
);
?>

<h1>Subject Lecturers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
