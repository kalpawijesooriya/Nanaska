<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_area_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Subject Areas' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List Subject Area', 'url' => array('index')),
        array('label' => 'Create Subject Area', 'url' => array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('subject-area-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<h2 class="light_heading">Manage Subject Areas</h2><br/>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
//echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    //<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'subject-area-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'subject_area_id',
//        'subject_id',
         array('name' => 'course_id', 'value' => '$data->subject->level->course->course_name'),
        array('name' => 'level_id', 'header' => 'Level', 'value' => '$data->subject->level->level_name'),
        array('name' => 'subject_id', 'value' => 'Subject::model()->getSubjectName($data->subject_id, 15)'),
        
        'subject_area_name',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {view}'
        ),
    ),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
