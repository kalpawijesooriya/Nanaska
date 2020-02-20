<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Subjects' => array('index'),
        'Create',
    );

    $this->menu = array(
        //array('label' => 'List Subject', 'url' => array('index')),
        array('label' => 'Manage Subject', 'url' => array('admin')),
        array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
    );
?>

<h2 class="light_heading">Create Subject</h2>

<?php echo $this->renderPartial('_form', array('model' => $model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>