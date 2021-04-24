<?php
$this->breadcrumbs=array(
	'Subject Areas',
);

$this->menu=array(
	array('label'=>'Create SubjectArea','url'=>array('create')),
	array('label'=>'Manage SubjectArea','url'=>array('admin')),
);
?>

<h1>Subject Areas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
