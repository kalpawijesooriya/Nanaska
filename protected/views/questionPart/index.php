<?php
$this->breadcrumbs=array(
	'Question Parts',
);

$this->menu=array(
	array('label'=>'Create QuestionPart','url'=>array('create')),
	array('label'=>'Manage QuestionPart','url'=>array('admin')),
);
?>

<h1>Question Parts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
