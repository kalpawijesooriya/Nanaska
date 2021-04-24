<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("student_management") == 1)
{
    $this->breadcrumbs=array(
            'Students'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List Student', 'url'=>array('index')),
            array('label'=>'Manage Student', 'url'=>array('admin')),
            //array('label'=>'Add Exam', 'url'=>array('')),
    );
?>

           <div>
            <h2 class="light_heading"> Create Student</h2>
            <p class="note">Fields with <span class="required">*</span> are required.</p>
          </div>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>