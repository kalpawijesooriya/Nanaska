<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("student_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Students'=>array('index'),
            $model->student_id=>array('view','id'=>$model->student_id),
            'Update',
    );

    $this->menu=array(
            array('label'=>'List Student', 'url'=>array('index')),
            array('label'=>'Create Student', 'url'=>array('create')),
            array('label'=>'View Student', 'url'=>array('view', 'id'=>$model->student_id)),
            array('label'=>'Add Preset Exam','url'=>array('studentExam/presetExam','id' => $model->student_id)),
            array('label'=>'Add Dynamic Exam','url'=>array('studentExam/dynamicExam','id' => $model->student_id)),  
            array('label'=>'Add Essay Exam','url'=>array('studentExam/essayExam','id' => $model->student_id)),  
            array('label'=>'Manage Student', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">Update Student <?php echo $model->student_id; ?></h2><br/>

<?php echo $this->renderPartial('_edit', array('model'=>$model/*'model_user'=>$model_user8*/));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>