<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulae Tab Titles',
);

$this->menu=array(
	array('label'=>'Create ExamTablesAndFormulaeTabTitle','url'=>array('create')),
	array('label'=>'Manage ExamTablesAndFormulaeTabTitle','url'=>array('admin')),
);
?>

<h1>Exam Tables And Formulae Tab Titles</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
