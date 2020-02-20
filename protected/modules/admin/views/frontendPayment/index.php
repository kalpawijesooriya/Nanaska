<?php
$this->breadcrumbs=array(
	'Frontend Payments',
);

$this->menu=array(
	//array('label'=>'Create FrontendPayment','url'=>array('create')),
	array('label'=>'Manage Frontend Payment','url'=>array('admin')),
);
?>

<h2 class="light_heading">Frontend Payments</h2>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
