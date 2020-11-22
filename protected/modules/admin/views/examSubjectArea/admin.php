<?php
$this->breadcrumbs=array(
	'Exam Subject Areas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ExamSubjectArea','url'=>array('index')),
	array('label'=>'Create ExamSubjectArea','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('exam-subject-area-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Exam Subject Areas</h1>

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
	'id'=>'exam-subject-area-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'exam_subject_area_id',
		'exam_id',
		'subject_area_id',
		'weightage',
		'single_answer_weightage',
		'multiple_answer_weightage',
		/*
		'short_written_answer_weightage',
		'drag_drop_typea_answer_weightage',
		'drag_drop_typeb_answer_weightage',
		'multiple_choice_answer_weightage',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
