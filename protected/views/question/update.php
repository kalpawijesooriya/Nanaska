<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->question_id=>array('view','id'=>$model->question_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Question','url'=>array('index')),
	array('label'=>'Create Question','url'=>array('create')),
	array('label'=>'View Question','url'=>array('view','id'=>$model->question_id)),
	array('label'=>'Manage Question','url'=>array('admin')),
);
?>

<h1>Update Question <?php echo $model->question_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>