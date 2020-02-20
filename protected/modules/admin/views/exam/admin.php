<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("exam_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Exams' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List Exam', 'url' => array('index')),
        array('label' => 'Create Exam', 'url' => array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('exam-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>

<h2 class="light_heading">Manage Exams</h2>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
   ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'exam-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'exam_id',
       // array('name' => 'course_id','header' => 'Course', 'value' => '$data->subject->level->course->course_name'),
        'course_id'=> array(
			'name' => 'course_id',
                        'header' => 'Course',
			'value' => '$data->subject->level->course->course_name',
			'filter'=> CHtml::listData(Course::model()->findAll(array('order'=>'course_name')), 'course_id', 'course_name')
                      ),
       // array('name' => 'level_id', 'header' => 'Level', 'value' => '$data->subject->level->level_name'),
        'level_id'=> array(
			'name' => 'level_id',
                        'header' => 'Level',
			'value' => '$data->subject->level->level_name',
			'filter'=> CHtml::listData(Level::model()->findAll(array('order'=>'level_name')), 'level_id', 'level_name')
                      ),
      //  array('name' => 'subject_id', 'value' => '$data->subject->subject_name'),
        'subject_id'=> array(
			'name' => 'subject_id',
                        'header' => 'Subject',
			'value' => 'Question::TruncateText($data->subject->subject_name, 15)',
			'filter'=> CHtml::listData(Subject::model()->findAll(), 'subject_id', 'subject_name')
                      ),
        'exam_name',   
        'exam_type'=> array(
			'name' => 'exam_type',
                        'header' => 'Exam Type',
			'value' => '$data->exam_type',
			'filter'=> CHtml::listData(Exam::model()->findAll(), 'exam_type', 'exam_type')
                      ),
        'number_of_questions',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {view}'
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
