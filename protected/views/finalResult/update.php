<?php
$this->breadcrumbs=array(
	'Final Results'=>array('index'),
	$model->final_result_id=>array('view','id'=>$model->final_result_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FinalResult','url'=>array('index')),
	array('label'=>'Create FinalResult','url'=>array('create')),
	array('label'=>'View FinalResult','url'=>array('view','id'=>$model->final_result_id)),
	array('label'=>'Manage FinalResult','url'=>array('admin')),
);
?>

<h1>Update FinalResult <?php echo $model->final_result_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>