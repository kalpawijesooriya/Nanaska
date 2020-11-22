<?php
$this->breadcrumbs=array(
	'Product Course Topics'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductCourseTopics', 'url'=>array('index')),
	array('label'=>'Create ProductCourseTopics', 'url'=>array('create')),
	array('label'=>'Update ProductCourseTopics', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductCourseTopics', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductCourseTopics', 'url'=>array('admin')),
);
?>

<h1>View ProductCourseTopics #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'prod_course_id',
		'price',
		'contents',
	),
)); ?>
