<?php
$this->breadcrumbs=array(
	'Final Results',
);

$this->menu=array(
	array('label'=>'Create FinalResult','url'=>array('create')),
	array('label'=>'Manage FinalResult','url'=>array('admin')),
);
?>

<h1>Final Results</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
