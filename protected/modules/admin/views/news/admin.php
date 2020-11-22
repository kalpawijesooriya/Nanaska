<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
    $this->breadcrumbs = array(
        'News' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List News', 'url' => array('index')),
        array('label' => 'Create Level News', 'url' => array('create')),
        array('label' => 'Create Broadcast News', 'url' => array('createBroadcast')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('news-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<h2 class="light_heading">Manage News</h2><br/>

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
    'id' => 'news-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'news_id',
        'subject',
        //'message',
        //'send_date_time',
        //'attachment',
        array('name' => 'course_id', 'value' => 'News::model()->getCourseOfNewsForAdmin($data->level_id)'),
        array('name' => 'level_id', 'value' => 'Level::model()->getLevelNameForNewsAdmin($data->level_id)'),
        //'level_id',		
        //'news_type',
        array('name' => 'news_type', 'value' => 'News::model()->changeNewsTypeName($data->news_type)'),
        //'course_id',

        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
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
