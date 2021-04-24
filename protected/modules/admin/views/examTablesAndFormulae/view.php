<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulaes'=>array('index'),
	$model->exam_tables_and_formulae_id,
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulae','url'=>array('index')),
	array('label'=>'Create ExamTablesAndFormulae','url'=>array('create')),
	array('label'=>'Update ExamTablesAndFormulae','url'=>array('update','id'=>$model->exam_tables_and_formulae_id)),
	array('label'=>'Delete ExamTablesAndFormulae','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_tables_and_formulae_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExamTablesAndFormulae','url'=>array('admin')),
);
?>

<h1>View ExamTablesAndFormulae #<?php echo $model->exam_tables_and_formulae_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'exam_tables_and_formulae_id',
		'exam_id',
		'tables_and_formulae_text',
		'tab_position',
	),
)); ?>
