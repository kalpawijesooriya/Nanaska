<?php
$this->breadcrumbs=array(
	'Product Course Topics',
);

$this->menu=array(
	array('label'=>'Create ProductCourseTopics', 'url'=>array('create')),
	array('label'=>'Manage ProductCourseTopics', 'url'=>array('admin')),
);
?>

<h1>Product Course Topics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
