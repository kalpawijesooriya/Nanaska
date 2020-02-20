<?php
$this->breadcrumbs=array(
	'Question Parts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuestionPart','url'=>array('index')),
	array('label'=>'Manage QuestionPart','url'=>array('admin')),
);
?>

<h1>Create QuestionPart</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>