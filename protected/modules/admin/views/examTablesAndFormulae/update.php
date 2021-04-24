<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulaes'=>array('index'),
	$model->exam_tables_and_formulae_id=>array('view','id'=>$model->exam_tables_and_formulae_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulae','url'=>array('index')),
	array('label'=>'Create ExamTablesAndFormulae','url'=>array('create')),
	array('label'=>'View ExamTablesAndFormulae','url'=>array('view','id'=>$model->exam_tables_and_formulae_id)),
	array('label'=>'Manage ExamTablesAndFormulae','url'=>array('admin')),
);
?>

<h1>Update ExamTablesAndFormulae <?php echo $model->exam_tables_and_formulae_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>