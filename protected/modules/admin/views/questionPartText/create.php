<?php
$this->breadcrumbs=array(
	'Question Part Texts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuestionPartText','url'=>array('index')),
	array('label'=>'Manage QuestionPartText','url'=>array('admin')),
);
?>

<h1>Create QuestionPartText</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>