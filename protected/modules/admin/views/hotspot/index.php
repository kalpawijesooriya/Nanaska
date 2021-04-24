<?php
$this->breadcrumbs=array(
	'Hotspots',
);

$this->menu=array(
	array('label'=>'Create Hotspot','url'=>array('create')),
	array('label'=>'Manage Hotspot','url'=>array('admin')),
);
?>

<h1>Hotspots</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
