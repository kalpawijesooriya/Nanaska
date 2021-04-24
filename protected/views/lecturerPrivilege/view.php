<?php
$this->breadcrumbs=array(
	'Lecturer Privileges'=>array('index'),
	$model->lecturer_privilege_id,
);

$this->menu=array(
	array('label'=>'List LecturerPrivilege','url'=>array('index')),
	array('label'=>'Create LecturerPrivilege','url'=>array('create')),
	array('label'=>'Update LecturerPrivilege','url'=>array('update','id'=>$model->lecturer_privilege_id)),
	array('label'=>'Delete LecturerPrivilege','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lecturer_privilege_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LecturerPrivilege','url'=>array('admin')),
);
?>

<h1>View LecturerPrivilege #<?php echo $model->lecturer_privilege_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'lecturer_privilege_id',
		'lecturer_id',
		'course_management',
		'level_management',
		'subject_management',
		'subject_area_management',
		'sitting_management',
		'news_management',
		'country_management',
		'student_management',
		'lecturer_management',
		'temporary_users',
		'exam_management',
		'question_management',
		'result_management',
	),
)); ?>
