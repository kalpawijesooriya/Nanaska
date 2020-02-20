<?php
$this->breadcrumbs=array(
	'Exam Audits'=>array('index'),
	$model->exam_audit_id=>array('view','id'=>$model->exam_audit_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamAudit','url'=>array('index')),
	array('label'=>'Create ExamAudit','url'=>array('create')),
	array('label'=>'View ExamAudit','url'=>array('view','id'=>$model->exam_audit_id)),
	array('label'=>'Manage ExamAudit','url'=>array('admin')),
);
?>

<h2 class="light_heading">Update ExamAudit <?php echo $model->exam_audit_id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>