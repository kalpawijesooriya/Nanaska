<?php
$this->breadcrumbs=array(
	'Product Courses',
);

$this->menu=array(
	array('label'=>'Create ProductCourses', 'url'=>array('create')),
	array('label'=>'Manage ProductCourses', 'url'=>array('admin')),
);
?>

<h1>Product Courses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
