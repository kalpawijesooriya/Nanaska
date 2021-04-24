<?php
$this->breadcrumbs=array(
	'Student Exams'=>array('index'),
	$model->student_exam_id=>array('view','id'=>$model->student_exam_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Student Exam','url'=>array('index')),
//	array('label'=>'Create Student Exam','url'=>array('create')),
//	array('label'=>'View Student Exam','url'=>array('view','id'=>$model->student_exam_id)),
//	array('label'=>'Manage Student Exam','url'=>array('admin')),
);
?>

<h1>Update StudentExam <?php echo $model->student_exam_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>