<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_management") == 1)
{
    
$this->breadcrumbs = array(
    'Subjects' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label' => 'List Subject', 'url' => array('index')),
    array('label' => 'Create Subject', 'url' => array('create')),
    array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('subject-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2 class="light_heading">Manage Subjects</h2>

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
    'id' => 'subject-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'subject_id',
//        'level_id',
        array('name' => 'course_id', 'header'=>'Course','value' => '$data->level->course->course_name'),
        array('name' => 'level_id', 'value' => 'Level::getLevelName($data->level_id, 15)'),
        
        'subject_name',
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
