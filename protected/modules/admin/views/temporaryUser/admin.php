<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("temporary_users") == 1)
{
    
$this->breadcrumbs=array(
	'Temporary Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Temporary User','url'=>array('index')),
	//array('label'=>'Create TemporaryUser','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('temporary-user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<h2 class="light_heading">Manage Temporary Users</h2>



<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p><!--

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    
    
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
//));

//echo $model->country_id.'xxx';  die;
?>
</div> search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'temporary-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'first_name',
		'last_name',
		'phone_number',
		'email',
		array('name' => 'country_id', 'value' => '$data->country->country_name'),
		/*
		'email',
		'course_id',
		'level_id',
		'sitting_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
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
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
