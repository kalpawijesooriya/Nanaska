<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulaes',
);

$this->menu=array(
	array('label'=>'Create ExamTablesAndFormulae','url'=>array('create')),
	array('label'=>'Manage ExamTablesAndFormulae','url'=>array('admin')),
);
?>

<h1>Exam Tables And Formulaes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
