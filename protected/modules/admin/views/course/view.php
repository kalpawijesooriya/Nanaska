<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("course_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Courses'=>array('index'),
            $model->course_id,
    );

    $this->menu=array(
            array('label'=>'List Course', 'url'=>array('index')),
            array('label'=>'Create Course', 'url'=>array('create')),
            array('label'=>'Update Course', 'url'=>array('update', 'id'=>$model->course_id)),
    //	array('label'=>'Delete Course', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->course_id),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=>'Manage Course', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">View Course <?php echo $model->course_id; ?></h2><br/>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'course_id',
		'course_name',
	),
    ));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
