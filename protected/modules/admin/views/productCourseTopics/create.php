<?php
$this->breadcrumbs=array(
	'Product Course Topics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductCourseTopics', 'url'=>array('index')),
	array('label'=>'Manage ProductCourseTopics', 'url'=>array('admin')),
);
?>

<h1>Create ProductCourseTopics</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>