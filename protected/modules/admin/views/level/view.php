<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("level_management") == 1)
{
    
    $this->breadcrumbs = array(
        'Levels' => array('index'),
        $model->level_id,
    );

    $this->menu = array(
        array('label' => 'List Level', 'url' => array('index')),
        array('label' => 'Create Level', 'url' => array('create')),
        array('label' => 'Update Level', 'url' => array('update', 'id' => $model->level_id)),
    //	array('label'=>'Delete Level', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->level_id),'confirm'=>'Are you sure you want to delete this item?')),
        array('label' => 'Manage Level', 'url' => array('admin')),
    );
?>

<h2 class="light_heading">View Level <?php echo $model->level_id; ?></h2><br/>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'level_id',
        array('name' => 'Level ID', 'value' => $model->level_id),
        'level_name',
//        'course_id',
        array('name' => 'Course', 'value' => Course::model()->getCourseName($model->course_id)),
    ),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
