<?php
$this->breadcrumbs=array(
	'Headings'=>array('index'),
	$model->heading_id=>array('view','id'=>$model->heading_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Heading','url'=>array('index')),
	array('label'=>'Create Heading','url'=>array('create')),
	array('label'=>'View Heading','url'=>array('view','id'=>$model->heading_id)),
	array('label'=>'Manage Heading','url'=>array('admin')),
);
?>

<h1>Update Heading <?php echo $model->heading_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>