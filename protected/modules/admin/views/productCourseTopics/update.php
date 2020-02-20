<?php
$this->breadcrumbs=array(
	'Product Course Topics'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductCourseTopics', 'url'=>array('index')),
	array('label'=>'Create ProductCourseTopics', 'url'=>array('create')),
	array('label'=>'View ProductCourseTopics', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductCourseTopics', 'url'=>array('admin')),
);
?>

<h1>Update ProductCourseTopics <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>