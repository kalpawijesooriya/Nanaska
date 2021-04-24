<?php
$this->breadcrumbs=array(
	'Product Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductCourses', 'url'=>array('index')),
	array('label'=>'Manage ProductCourses', 'url'=>array('admin')),
);
?>

<h1>Create ProductCourses</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>