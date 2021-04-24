<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("lecturer_management") == 1)
{
    $this->breadcrumbs = array(
        'Lecturers' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List Lecturer', 'url' => array('index')),
        array('label' => 'Create Lecturer', 'url' => array('create')),
        array('label'=>'View Authored Questions', 'url'=>array('ViewAuthoredQuestions')),
        array('label' => 'View Unapproved Questions', 'url' => array('Question/approve')),//CHtml::link('Registration', array('user/create'))
        //CHtml::link('Registration', array('user/create')),
        );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('lecturer-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <h2 class="light_heading">Manage Lecturers</h2>

    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

    <?php 
    //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
    <div class="search-form" style="display:none">
    //<?php
    //$this->renderPartial('_search', array(
    //    'model' => $model,
    //));
    ?>
    </div><!-- search-form -->


    <?php
    //$dataProvider = new CActiveDataProvider('User', array(
    //    'criteria' => array(
    //        'condition' => 'user_type="LECTURER"',
    //        'order' => 'user_id',
    //    ),
    //        ));

    //$this->widget('bootstrap.widgets.TbGridView', array(
    //    'id' => 'lecturer-grid',
    //    'dataProvider' => $model->searchByCondition('user_type="LECTURER"'),
    //    'filter' => $model,
    //    'columns' => array(
    ////		'lecturer_id',
    //        'user_id',
    //        'first_name',
    //        'last_name', 
    //        'email',
    //        'phone_number',
    //        'address',
    //        'country_id',
    //        array(
    //            'class' => 'bootstrap.widgets.TbButtonColumn',
    //            'deleteConfirmation' => 'Are you sure that you want to delete this Lecturer?',
    //            'updateButtonUrl' => 'CHtml::normalizeUrl( [ "Lecturer/update", "id" => User::getLecturerIdByUserId($data->user_id)] )',
    //            'deleteButtonUrl' => 'CHtml::normalizeUrl( [ "Lecturer/delete", "id" => User::getLecturerIdByUserId($data->user_id) ] )',
    //            'viewButtonUrl' => 'CHtml::normalizeUrl( [ "Lecturer/view", "id" => User::getLecturerIdByUserId($data->user_id) ] )',
    //        
    //            ),
    //    ),
    //));

    $this->widget('bootstrap.widgets.TbGridView', array(
            'id'=>'lecturer-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'columns'=>array(
                    'lecturer_code',
                    array('name' => 'first_name', 'value' => '$data->user->first_name'),               
                    array('name'=>'last_name', 'value'=>'$data->user->last_name'),
                    array('name'=>'email', 'value'=>'$data->user->email'),              
                    array('name'=>'phone_number', 'value'=>'$data->user->phone_number'),
                    array('name'=>'address', 'value'=>'$data->user->address'),
    //                array('name'=>'note', 'value'=>'$data->note'),
    //                array('name'=>'status', 'value'=>'$data->status'),

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
    ));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
