<?php
$this->breadcrumbs=array(
	'Past Exams'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PastExam','url'=>array('index')),
	array('label'=>'Manage PastExam','url'=>array('admin')),
);
?>

<h1>Create PastExam</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>