<?php
$this->breadcrumbs=array(
	'Headings',
);

$this->menu=array(
	array('label'=>'Create Heading','url'=>array('create')),
	array('label'=>'Manage Heading','url'=>array('admin')),
);
?>

<h1>Headings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
