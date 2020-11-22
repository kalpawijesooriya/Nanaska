<?php
$this->breadcrumbs=array(
	'Sittings'=>array('index'),
	$model->sitting_id=>array('view','id'=>$model->sitting_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sitting', 'url'=>array('index')),
	array('label'=>'Create Sitting', 'url'=>array('create')),
	array('label'=>'View Sitting', 'url'=>array('view', 'id'=>$model->sitting_id)),
	array('label'=>'Manage Sitting', 'url'=>array('admin')),
);
?>

<h1>Update Sitting <?php echo $model->sitting_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>