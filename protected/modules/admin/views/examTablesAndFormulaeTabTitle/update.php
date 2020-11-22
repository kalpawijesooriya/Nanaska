<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulae Tab Titles'=>array('index'),
	$model->exam_tables_and_formulae_tab_title_id=>array('view','id'=>$model->exam_tables_and_formulae_tab_title_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulaeTabTitle','url'=>array('index')),
	array('label'=>'Create ExamTablesAndFormulaeTabTitle','url'=>array('create')),
	array('label'=>'View ExamTablesAndFormulaeTabTitle','url'=>array('view','id'=>$model->exam_tables_and_formulae_tab_title_id)),
	array('label'=>'Manage ExamTablesAndFormulaeTabTitle','url'=>array('admin')),
);
?>

<h1>Update ExamTablesAndFormulaeTabTitle <?php echo $model->exam_tables_and_formulae_tab_title_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>