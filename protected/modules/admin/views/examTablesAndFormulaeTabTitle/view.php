<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulae Tab Titles'=>array('index'),
	$model->exam_tables_and_formulae_tab_title_id,
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulaeTabTitle','url'=>array('index')),
	array('label'=>'Create ExamTablesAndFormulaeTabTitle','url'=>array('create')),
	array('label'=>'Update ExamTablesAndFormulaeTabTitle','url'=>array('update','id'=>$model->exam_tables_and_formulae_tab_title_id)),
	array('label'=>'Delete ExamTablesAndFormulaeTabTitle','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_tables_and_formulae_tab_title_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExamTablesAndFormulaeTabTitle','url'=>array('admin')),
);
?>

<h1>View ExamTablesAndFormulaeTabTitle #<?php echo $model->exam_tables_and_formulae_tab_title_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'exam_tables_and_formulae_tab_title_id',
		'exam_tables_and_formulae_id',
		'tab_title',
	),
)); ?>
