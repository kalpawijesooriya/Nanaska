<?php
$this->breadcrumbs=array(
	'Final Results'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FinalResult','url'=>array('index')),
	array('label'=>'Manage FinalResult','url'=>array('admin')),
);
?>

<h1>Create FinalResult</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>