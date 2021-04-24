<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Frontend Payment','url'=>array('index')),
	//array('label'=>'Create FrontendPayment','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('frontend-payment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2 class="light_heading">Manage Frontend Payments</h2>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php 
//echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!--<div class="search-form" style="display:none">-->
<?php 
//$this->renderPartial('_search',array(
//	'model'=>$model,
//));
?>
<!--</div> search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'frontend-payment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'first_name',
		//'last_name',
		//'address',
		'cima_id',
		'email',
		
		//'contact_no',
		'course',
		'amount',
		'ref_no',
                'transaction_id',
		'status',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{update} {view}'
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
)); ?>
