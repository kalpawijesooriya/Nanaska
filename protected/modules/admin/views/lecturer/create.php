<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("lecturer_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Lecturers'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List Lecturer', 'url'=>array('index')),
            array('label'=>'Manage Lecturer', 'url'=>array('admin')),
        array('label'=>'View Authored Questions', 'url'=>array('ViewAuthoredQuestions')),

    );
?>

<h2 class="light_heading">Create Lecturer</h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_lecturer'=>$model_lecturer));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>