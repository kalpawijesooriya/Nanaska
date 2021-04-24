<?php
$this->breadcrumbs=array(
	'Product Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductCategories', 'url'=>array('index')),
	//array('label'=>'Create ProductCategories', 'url'=>array('create')),
	array('label'=>'Update Commencement Date', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete ProductCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage ProductCategories', 'url'=>array('admin')),
);
?>

<h1>View Course Level #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_name',
		'commencement',
	),
)); ?>
