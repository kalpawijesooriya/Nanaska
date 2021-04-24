<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("student_management") == 1)
{
    $this->breadcrumbs = array(
        'Students' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List Student', 'url' => array('index')),
        array('label' => 'Create Student', 'url' => array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('student-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<h2 class="light_heading">Manage Students</h2>

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
// $this->widget('zii.widgets.grid.CGridView', array(
//	'id'=>'student-grid',
//	'dataProvider'=>$model->search(),
//	'filter'=>$model,
//	'columns'=>array(
//		'student_id',
//		'user_id',
//		'level_id',
//		'sitting_id',
//		'note',
//                'status',
//		array(
//			'class'=>'CButtonColumn',
//		),
//	),
//)); 
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'student-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'student_id',
        array('name' => 'first_name', 'value' => 'Student::TruncateText($data->user->first_name, 8)', 'htmlOptions' => array('alt' => '$data->user->first_name')),
        array('name' => 'last_name', 'value' => 'Student::TruncateText($data->user->last_name, 12)', 'htmlOptions' => array('alt' => '$data->user->last_name')),
        array('name' => 'email', 'value' => 'Student::TruncateText($data->user->email, 12)', 'htmlOptions' => array('alt' => '$data->user->email')),
        array('name' => 'phone_number', 'value' => 'Student::TruncateText($data->user->phone_number, 12)', 'htmlOptions' => array('alt' => '$data->user->phone_number')),
        //array('name'=>'address', 'value'=>'$data->user->address'),
        //array('name'=>'note', 'value'=>'$data->note'),
        array('name' => 'status', 'value' => 'Student::model()->getStatusLabel($data->status, 15)'),
//        array('name' => 'status', 'value' => '$data->status'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {view}'
        //'template'=>'{view} {update} {delete} {reg}',
        //'header'=>'Actions',
        //'buttons'=>array('reg' => array(
        //'label'=>'suspend', 
        //'url'=>'',
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
