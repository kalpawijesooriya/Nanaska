<?php
$this->breadcrumbs=array(
	'Takes',
);

$this->menu=array(
	array('label'=>'Create Take','url'=>array('create')),
	array('label'=>'Manage Take','url'=>array('admin')),
);
?>

<h1>Takes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
