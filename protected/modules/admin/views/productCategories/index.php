<?php
//$this->breadcrumbs=array(
//	'Product Categories',
//);
//
//$this->menu=array(
//	array('label'=>'Create ProductCategories', 'url'=>array('create')),
//	array('label'=>'Manage ProductCategories', 'url'=>array('admin')),
//);
?>

<!--<h1>Product Categories</h1>-->
<h1>Course Levels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
