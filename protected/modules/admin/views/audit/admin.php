<?php
$this->breadcrumbs = array(
    'Audits' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Activity', 'url' => array('index')),
//    array('label' => 'Create Audit', 'url' => array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('audit-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h2 class="light_heading">Manage Activity</h2>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
?>
</div> search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'audit-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'audit_id',
//        'user_id',
        'first_name' => array(
            'name' => 'user_id',
            'header' => 'First Name',
            'value' => 'User::model()->getFirstName($data->user_id)',
        ),
        'action_id',
        'action_name' => array(
                'name' => 'action_name',
                'header' => 'Action Name',             
                'value' => 'Audit::TruncateText(Audit::model()->getActionNameBylabel($data->action_name),30)',
                'filter' => CHtml::listData(Audit::model()->findAll(), 'action_name', 'action_name')
            ),
         'action' => array(
                'name' => 'action',
                'header' => 'Action',
                'filter' => CHtml::listData(Audit::model()->findAll(), 'action', 'action')
            ),
        'date',       
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}'
        ),
    ),
    'pager' => array(
//        'cssFile'=>Yii::app()->theme->baseUrl."/css/pagination.css",
        'header' => '',
        'prevPageLabel' => 'Previous',
        'nextPageLabel' => 'Next',
        'firstPageLabel'=>'First',
        'lastPageLabel'=>'Last',
        //'footer'=>'End',//defalut empty
       // 'maxButtonCount'=>4 // defalut 10                   
        ),
));
?>
