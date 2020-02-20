<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("course_management") == 1)
{

$this->breadcrumbs = array(
    'Courses' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label' => 'List Course', 'url' => array('index')),
    array('label' => 'Create Course', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('course-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2 class="light_heading">Manage Courses</h2><br/>

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
    'id' => 'course-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'course_id',
        'course_name',
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
