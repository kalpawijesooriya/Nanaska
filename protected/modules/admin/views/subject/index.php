<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Subjects',
    );

    $this->menu = array(
        array('label' => 'Create Subject', 'url' => array('create')),
        array('label' => 'Manage Subject', 'url' => array('admin')),
        array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
    );
?>

<h2 class="light_heading">Subjects</h2>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
