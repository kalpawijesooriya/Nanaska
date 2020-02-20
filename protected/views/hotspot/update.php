<?php
$this->breadcrumbs=array(
	'Hotspots'=>array('index'),
	$model->hotspot_id=>array('view','id'=>$model->hotspot_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Hotspot','url'=>array('index')),
	array('label'=>'Create Hotspot','url'=>array('create')),
	array('label'=>'View Hotspot','url'=>array('view','id'=>$model->hotspot_id)),
	array('label'=>'Manage Hotspot','url'=>array('admin')),
);
?>

<h1>Update Hotspot <?php echo $model->hotspot_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>