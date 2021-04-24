<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1) {
    $this->breadcrumbs = array(
        'Questions' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List Questions', 'url' => array('index')),
        array('label' => 'Create Question', 'url' => array('create')),
            //array('label' => 'View Un-Approved Questions', 'url' => array('approve')),
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('question-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <h2 class="light_heading">Manage Questions</h2>

    <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

    <?php ?>
    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
    <div class="search-form" style="display:none">
        <?php
        $this->renderPartial('_search', array(
            'model' => $model,
        ));
        ?>
    </div><!-- search-form -->
    <?php ?>

    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'question-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'question_id',
            'course_id' => array(
                'name' => 'course_id',
                'header' => 'Course',
                'value' => '$data->subjectArea->subject->level->course->course_name',
                'filter' => CHtml::listData(Course::model()->findAll(array('order' => 'course_name')), 'course_id', 'course_name')
            ),
            'level_id' => array(
                'name' => 'level_id',
                'header' => 'Level',
                'value' => '$data->subjectArea->subject->level->level_name',
                'filter' => CHtml::listData(Level::model()->findAll(array('order' => 'level_name')), 'level_id', 'level_name')
            ),
            'subject_id' => array(
                'name' => 'subject_id',
                'header' => 'Subject',
                'value' => 'Question::TruncateText($data->subjectArea->subject->subject_name, 15)',
                'filter' => CHtml::listData(Subject::model()->findAll(), 'subject_id', 'subject_name')
            ),
            'subject_area_id' => array(
                'name' => 'subject_area_id',
                'header' => 'Subject Area',
                'value' => 'Question::TruncateText(SubjectArea::model()->getSubjectAreaName($data->subject_area_id), 15)',
                'filter' => CHtml::listData(SubjectArea::model()->findAll(), 'subject_area_id', 'subject_area_name')
            ),
           /// array('name' => 'subject_area_id', 'value' => 'Question::TruncateText(SubjectArea::model()->getSubjectAreaName($data->subject_area_id), 15)', 'htmlOptions' => array('alt' => '$data->subject_area_id')),
            array('name' => 'question_type', 'value' => 'Question::model()->getQuestionTypeLabel($data->question_type, 15)'),
            array('name' => 'status', 'value' => 'Question::model()->getStatusLabel($data->status)'),
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
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
