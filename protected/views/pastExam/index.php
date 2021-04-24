<?php
$this->breadcrumbs=array(
	'Past Exams',
);

$this->menu=array(
	array('label'=>'Create PastExam','url'=>array('create')),
	array('label'=>'Manage PastExam','url'=>array('admin')),
);
?>

<h1>Past Exams</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
