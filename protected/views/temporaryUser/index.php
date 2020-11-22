<?php
$this->breadcrumbs=array(
	'Temporary Users',
);

$this->menu=array(
	array('label'=>'Create TemporaryUser','url'=>array('create')),
	array('label'=>'Manage TemporaryUser','url'=>array('admin')),
);
?>

<h1>Temporary Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
