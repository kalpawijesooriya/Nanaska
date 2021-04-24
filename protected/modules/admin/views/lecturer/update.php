<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("lecturer_management") == 1)
{
    
$lectureData = User::getLecturerInfoByUserId($model->user_id);

$this->breadcrumbs = array(
    'Lecturers' => array('index'),
    $lectureData['lecturer_id'] => array('view', 'id' => $lectureData['lecturer_id']),
    'Update',
);

$this->menu = array(
    array('label' => 'List Lecturer', 'url' => array('index')),
    array('label' => 'Create Lecturer', 'url' => array('create')),
    array('label' => 'View Lecturer', 'url' => array('view', 'id' => $lectureData['lecturer_id'])),
    array('label' => 'Manage Lecturer', 'url' => array('admin')),
    array('label' => 'View Authored Questions', 'url' => array('ViewAuthoredQuestions')),
);
?>

<h2 class="light_heading">Update Lecturer <?php echo $lectureData['lecturer_id']; ?></h2><br/>

<?php echo $this->renderPartial('_edit', array('model' => $model, 'lecturer_model' => $lecturer_model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>