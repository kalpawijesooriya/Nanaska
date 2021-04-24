<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulae Tab Titles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulaeTabTitle','url'=>array('index')),
	array('label'=>'Manage ExamTablesAndFormulaeTabTitle','url'=>array('admin')),
);
?>

<h1>Create ExamTablesAndFormulaeTabTitle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>