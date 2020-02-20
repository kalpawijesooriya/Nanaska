<?php
$this->breadcrumbs=array(
	'Exam Subject Areas'=>array('index'),
	$model->exam_subject_area_id,
);

$this->menu=array(
	array('label'=>'List ExamSubjectArea','url'=>array('index')),
	array('label'=>'Create ExamSubjectArea','url'=>array('create')),
	array('label'=>'Update ExamSubjectArea','url'=>array('update','id'=>$model->exam_subject_area_id)),
	array('label'=>'Delete ExamSubjectArea','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_subject_area_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExamSubjectArea','url'=>array('admin')),
);
?>

<h1>View ExamSubjectArea #<?php echo $model->exam_subject_area_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'exam_subject_area_id',
		'exam_id',
		'subject_area_id',
		'weightage',
		'single_answer_weightage',
		'multiple_answer_weightage',
		'short_written_answer_weightage',
		'drag_drop_typea_answer_weightage',
		'drag_drop_typeb_answer_weightage',
		'multiple_choice_answer_weightage',
	),
)); ?>
