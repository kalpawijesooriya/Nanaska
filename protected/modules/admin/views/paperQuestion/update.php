<?php
$this->breadcrumbs=array(
	'Paper Questions'=>array('index'),
	$model->paper_question_id=>array('view','id'=>$model->paper_question_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PaperQuestion','url'=>array('index')),
	array('label'=>'Create PaperQuestion','url'=>array('create')),
	array('label'=>'View PaperQuestion','url'=>array('view','id'=>$model->paper_question_id)),
	array('label'=>'Manage PaperQuestion','url'=>array('admin')),
);
?>

<h1>Update PaperQuestion <?php echo $model->paper_question_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>