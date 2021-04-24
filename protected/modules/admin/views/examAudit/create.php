<?php
$this->breadcrumbs=array(
	'Exam Audits'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExamAudit','url'=>array('index')),
	array('label'=>'Manage ExamAudit','url'=>array('admin')),
);
?>

<h2 class="light_heading">Create ExamAudit</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>