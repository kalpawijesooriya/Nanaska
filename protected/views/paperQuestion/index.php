<?php
$this->breadcrumbs=array(
	'Paper Questions',
);

$this->menu=array(
	array('label'=>'Create PaperQuestion','url'=>array('create')),
	array('label'=>'Manage PaperQuestion','url'=>array('admin')),
);
?>

<h1>Paper Questions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
