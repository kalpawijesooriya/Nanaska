<?php
$this->breadcrumbs=array(
	'Product Courses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductCourses', 'url'=>array('index')),
	array('label'=>'Create ProductCourses', 'url'=>array('create')),
	array('label'=>'Update ProductCourses', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductCourses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductCourses', 'url'=>array('admin')),
);
?>

<h1>View ProductCourses #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'prod_cat_id',
		'product_course_name',
	),
)); ?>
