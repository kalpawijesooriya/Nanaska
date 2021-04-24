<?php
$this->breadcrumbs=array(
	'Exam Subject Areas',
);

$this->menu=array(
	array('label'=>'Create ExamSubjectArea','url'=>array('create')),
	array('label'=>'Manage ExamSubjectArea','url'=>array('admin')),
);
?>

<h1>Exam Subject Areas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
