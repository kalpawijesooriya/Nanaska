<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("essay_answer_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Essay Exam Answers',
    );

?>

<h2 class="light_heading">Essay Exam Answer Scripts</h2>

<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'exam-grid',
    'dataProvider' => $model->searchForEssayExams(),
    'filter' => $model,
    'columns' => array(
        'take_id',
        array('name' => 'email', 'value' => 'Student::model()->TruncateText($data->student->user->email, 12)', 'htmlOptions' => array('alt' => '$data->student->user->email')),
        array('name' => 'student_name', 'value' => 'Student::model()->TruncateText(Student::model()->getStudentNameByUserID($data->student->user_id), 15)'),
        'exam_id',
        'date',
        array('name' => 'status', 'value' => 'Take::model()->getMarkOrUnmark($data->status)'),
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
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>