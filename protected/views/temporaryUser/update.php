<?php
$this->breadcrumbs=array(
	'Temporary Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TemporaryUser','url'=>array('index')),
	array('label'=>'Create TemporaryUser','url'=>array('create')),
	array('label'=>'View TemporaryUser','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TemporaryUser','url'=>array('admin')),
);
?>

<h1>Update TemporaryUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>