<?php
$this->breadcrumbs=array(
	'Exam Tables And Formulaes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ExamTablesAndFormulae','url'=>array('index')),
	array('label'=>'Create ExamTablesAndFormulae','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('exam-tables-and-formulae-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Exam Tables And Formulaes</h1>

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
	'id'=>'exam-tables-and-formulae-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'exam_tables_and_formulae_id',
		'exam_id',
		'tables_and_formulae_text',
		'tab_position',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
