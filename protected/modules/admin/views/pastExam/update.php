<?php
$this->breadcrumbs=array(
	'Past Exams'=>array('index'),
	$model->past_exam_id=>array('view','id'=>$model->past_exam_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PastExam','url'=>array('index')),
	array('label'=>'Create PastExam','url'=>array('create')),
	array('label'=>'View PastExam','url'=>array('view','id'=>$model->past_exam_id)),
	array('label'=>'Manage PastExam','url'=>array('admin')),
);
?>

<h1>Update PastExam <?php echo $model->past_exam_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>