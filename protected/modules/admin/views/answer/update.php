<?php
$this->breadcrumbs=array(
	'Answers'=>array('index'),
	$model->answer_id=>array('view','id'=>$model->answer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Answer','url'=>array('index')),
	array('label'=>'Create Answer','url'=>array('create')),
	array('label'=>'View Answer','url'=>array('view','id'=>$model->answer_id)),
	array('label'=>'Manage Answer','url'=>array('admin')),
);
?>

<h1>Update Answer <?php echo $model->answer_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>