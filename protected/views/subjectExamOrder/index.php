<?php
$this->breadcrumbs=array(
	'Subject Exam Orders',
);

$this->menu=array(
	array('label'=>'Create SubjectExamOrder','url'=>array('create')),
	array('label'=>'Manage SubjectExamOrder','url'=>array('admin')),
);
?>

<h1>Subject Exam Orders</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
