<?php
$this->breadcrumbs=array(
	'Student Exams',
);

$this->menu=array(
	array('label'=>'Create StudentExam','url'=>array('create')),
	array('label'=>'Manage StudentExam','url'=>array('admin')),
);
?>

<h1>Student Exams</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
