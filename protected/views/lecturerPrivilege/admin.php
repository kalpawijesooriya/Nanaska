<?php
$this->breadcrumbs=array(
	'Lecturer Privileges'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LecturerPrivilege','url'=>array('index')),
	array('label'=>'Create LecturerPrivilege','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lecturer-privilege-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lecturer Privileges</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'lecturer-privilege-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lecturer_privilege_id',
		'lecturer_id',
		'course_management',
		'level_management',
		'subject_management',
		'subject_area_management',
		/*
		'sitting_management',
		'news_management',
		'country_management',
		'student_management',
		'lecturer_management',
		'temporary_users',
		'exam_management',
		'question_management',
		'result_management',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
