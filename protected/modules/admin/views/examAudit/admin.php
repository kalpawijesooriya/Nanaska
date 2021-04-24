<?php
$this->breadcrumbs = array(
    'Exam Audits' => array('index'),
    'Manage',
);

$this->menu = array(
//	array('label'=>'List ExamAudit','url'=>array('index')),
//	array('label'=>'Create ExamAudit','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('exam-audit-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2 class="light_heading">Exam Audits</h2>



<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'exam-audit-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'exam_audit_id',
        'exam_id',
        'user_id',
        'action',
        'date',
        'time',
//        'status',
//        array('name' => 'status', 'value' => 'ExamAudit::getStatus($data->status)'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}'
        ),
    ),
));
?>
