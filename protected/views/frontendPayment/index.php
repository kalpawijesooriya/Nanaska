<?php
$this->breadcrumbs=array(
	'Frontend Payments',
);

$this->menu=array(
	array('label'=>'Create FrontendPayment','url'=>array('create')),
	array('label'=>'Manage FrontendPayment','url'=>array('admin')),
);
?>

<h1>Frontend Payments</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
