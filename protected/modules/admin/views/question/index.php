<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1) {

    $this->breadcrumbs = array(
        'Questions',
    );

    $this->menu = array(
        array('label' => 'Create Question', 'url' => array('create')),
        array('label' => 'Manage Questions', 'url' => array('admin')),
        //array('label' => 'View Un-Approved Questions', 'url' => array('approve')),
        array('label' => 'Bulk Upload Questions', 'url' => array('bulkupload')),
        array('label' => 'Question Statistics', 'url' => array('questionStatistics')),
    );
    ?>

    <h2 class="light_heading">Questions</h2>
    <span class="filterby">You can filter the questions by course, level, subject, subject area and question type.</span>
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'question-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'question_id' => array(
                'name' => 'question_id',
                'header' => 'Question id',
                'htmlOptions' => array('style' => 'width: 50px; font-size:13px;')
               ),
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
                'filter' => CHtml::listData(Level::model()->findAll(), 'level_id', 'level_name')
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
            'question_type' => array(
                'name' => 'question_type',
                'header' => 'Question Type',
                'htmlOptions'=>array('style'=>'width: 265px'),
              //  'htmlOptions' => array('style' => 'width: 185px; font-size:13px;'),
              //  'htmlOptions'=>array('style'=>'word-wrap: break-word;'),
                'value' => 'Question::TruncateText(Question::model()->getQuestionTypeLabel($data->question_type),30)',
                'filter' => CHtml::listData(Question::model()->findAll(), 'question_type', 'question_type')
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view}'
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
<?php
//$this->widget('bootstrap.widgets.TbListView', array(
//    'dataProvider' => $dataProvider,
//    'itemView' => '_view',
//));
?>
