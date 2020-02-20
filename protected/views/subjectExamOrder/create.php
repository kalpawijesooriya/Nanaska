<?php
$this->breadcrumbs=array(
	'Subject Exam Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubjectExamOrder','url'=>array('index')),
	array('label'=>'Manage SubjectExamOrder','url'=>array('admin')),
);
?>

<h1>Create SubjectExamOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>