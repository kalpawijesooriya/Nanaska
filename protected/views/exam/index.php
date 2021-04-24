<?php
$this->breadcrumbs=array(
	'Exams',
);

$this->menu=array(
	array('label'=>'Create Exam','url'=>array('create')),
	array('label'=>'Manage Exam','url'=>array('admin')),
);
?>

<h1>Exams</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
