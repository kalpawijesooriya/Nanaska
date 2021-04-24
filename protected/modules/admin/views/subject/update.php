<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Subjects' => array('index'),
        $model->subject_id => array('view', 'id' => $model->subject_id),
        'Update',
    );

    $this->menu = array(
        array('label' => 'List Subject', 'url' => array('index')),
        array('label' => 'Create Subject', 'url' => array('create')),
        array('label' => 'View Subject', 'url' => array('view', 'id' => $model->subject_id)),
        array('label' => 'Manage Subject', 'url' => array('admin')),
        array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
    );
?>

<h2 class="light_heading">Update Subject <?php echo $model->subject_id; ?></h2><br/>

<?php echo $this->renderPartial('_edit', array('model' => $model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>