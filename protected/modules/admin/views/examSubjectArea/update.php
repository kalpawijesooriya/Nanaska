<?php
$this->breadcrumbs=array(
	'Exam Subject Areas'=>array('index'),
	$model->exam_subject_area_id=>array('view','id'=>$model->exam_subject_area_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExamSubjectArea','url'=>array('index')),
	array('label'=>'Create ExamSubjectArea','url'=>array('create')),
	array('label'=>'View ExamSubjectArea','url'=>array('view','id'=>$model->exam_subject_area_id)),
	array('label'=>'Manage ExamSubjectArea','url'=>array('admin')),
);
?>

<h1>Update ExamSubjectArea <?php echo $model->exam_subject_area_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>