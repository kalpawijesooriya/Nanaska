<?php
$this->breadcrumbs=array(
	'Question Part Texts',
);

$this->menu=array(
	array('label'=>'Create QuestionPartText','url'=>array('create')),
	array('label'=>'Manage QuestionPartText','url'=>array('admin')),
);
?>

<h1>Question Part Texts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
