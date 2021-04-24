<?php
$this->breadcrumbs=array(
	'Product Courses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductCourses', 'url'=>array('index')),
	array('label'=>'Create ProductCourses', 'url'=>array('create')),
	array('label'=>'View ProductCourses', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductCourses', 'url'=>array('admin')),
);
?>

<h1>Update ProductCourses <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>