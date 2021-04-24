<?php
$this->breadcrumbs=array(
	'Takes'=>array('index'),
	$model->take_id=>array('view','id'=>$model->take_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Take','url'=>array('index')),
	array('label'=>'Create Take','url'=>array('create')),
	array('label'=>'View Take','url'=>array('view','id'=>$model->take_id)),
	array('label'=>'Manage Take','url'=>array('admin')),
);
?>

<h1>Update Take <?php echo $model->take_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>