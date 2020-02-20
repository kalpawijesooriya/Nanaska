<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("course_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Courses'=>array('index'),
            $model->course_id=>array('view','id'=>$model->course_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Course', 'url'=>array('index')),
            array('label'=>'Create Course', 'url'=>array('create')),
            array('label'=>'View Course', 'url'=>array('view', 'id'=>$model->course_id)),
            array('label'=>'Manage Course', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Update Course <?php echo $model->course_id; ?></h2><br/>

<?php echo $this->renderPartial('_form', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>