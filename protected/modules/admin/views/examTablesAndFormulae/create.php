<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulaes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulae','url'=>array('index')),
	array('label'=>'Manage ExamTablesAndFormulae','url'=>array('admin')),
);
?>

<h1>Create ExamTablesAndFormulae</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>