<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("exam_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Exams'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List Exam','url'=>array('index')),
            array('label'=>'Manage Exams','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Create Exam</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>