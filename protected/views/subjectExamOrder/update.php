<?php
$this->breadcrumbs=array(
	'Subject Exam Orders'=>array('index'),
	$model->subject_exam_order_id=>array('view','id'=>$model->subject_exam_order_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubjectExamOrder','url'=>array('index')),
	array('label'=>'Create SubjectExamOrder','url'=>array('create')),
	array('label'=>'View SubjectExamOrder','url'=>array('view','id'=>$model->subject_exam_order_id)),
	array('label'=>'Manage SubjectExamOrder','url'=>array('admin')),
);
?>

<h1>Update SubjectExamOrder <?php echo $model->subject_exam_order_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>