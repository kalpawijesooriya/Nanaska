<?php
$this->breadcrumbs=array(
	'Exam Questions'=>array('index'),
	$model->exam_question_id=>array('view','id'=>$model->exam_question_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamQuestion','url'=>array('index')),
	array('label'=>'Create ExamQuestion','url'=>array('create')),
	array('label'=>'View ExamQuestion','url'=>array('view','id'=>$model->exam_question_id)),
	array('label'=>'Manage ExamQuestion','url'=>array('admin')),
);
?>

<h1>Update ExamQuestion <?php echo $model->exam_question_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>