<?php
$this->breadcrumbs=array(
	'Sittings',
);

$this->menu=array(
	array('label'=>'Create Sitting', 'url'=>array('create')),
	array('label'=>'Manage Sitting', 'url'=>array('admin')),
);
?>

<h1>Sittings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
