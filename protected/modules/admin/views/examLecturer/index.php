<?php
$this->breadcrumbs=array(
	'Exam Lecturers',
);

$this->menu=array(
	array('label'=>'Create ExamLecturer', 'url'=>array('create')),
	array('label'=>'Manage ExamLecturer', 'url'=>array('admin')),
);
?>

<h1>Exam Lecturers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
