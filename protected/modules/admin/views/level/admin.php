<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("level_management") == 1)
{

$this->breadcrumbs = array(
    'Levels' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label' => 'List Level', 'url' => array('index')),
    array('label' => 'Create Level', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('level-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2 class="light_heading">Manage Levels</h2><br/>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php 
//echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    //<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'level-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'level_id',
        'level_name',
//        'course_id',
        array('name' => 'course_id', 'value' => 'Course::getCourseName($data->course_id, 15)'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {view} {delete}'
        ),
    ),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
