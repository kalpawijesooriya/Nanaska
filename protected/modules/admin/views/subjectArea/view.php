<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_area_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Subject Areas' => array('index'),
        $model->subject_area_id,
    );

    $this->menu = array(
        array('label' => 'List Subject Area', 'url' => array('index')),
        array('label' => 'Create Subject Area', 'url' => array('create')),
        array('label' => 'Update Subject Area', 'url' => array('update', 'id' => $model->subject_area_id)),
    //    array('label' => 'Delete SubjectArea', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->subject_area_id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Subject Area', 'url' => array('admin')),
    );
?>

<h2 class="light_heading">View Subject-Area <?php echo $model->subject_area_id; ?></h2><br/>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'subject_area_id',
        array('name' => 'Subject-Area ID', 'value' =>$model->subject_area_id),
        array('name' => 'Course', 'value' =>Course::model()->getCourseName(Subject::model()->getCourseOfSubject($model->subject_id))),
        array('name' => 'Level', 'value' =>Level::model()->getLevelName(Subject::model()->getLevelOfSubject($model->subject_id))),
        
//        'subject_id',
        array('name' => 'Subject', 'value' => Subject::model()->getSubjectName($model->subject_id)),
        'subject_area_name',
    ),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
