<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
    $this->breadcrumbs=array(
            'News'=>array('index'),
            $model->news_id,
    );

    $this->menu=array(
            array('label'=>'List News','url'=>array('index')),
            array('label'=>'Create Level News','url'=>array('create')),
            array('label'=>'Create Broadcast News','url'=>array('createBroadcast')),
            array('label'=>'Update News','url'=>array('update','id'=>$model->news_id)),
            array('label'=>'Delete News','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->news_id),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=>'Manage News','url'=>array('admin')),
    );
?>

<h2 class="light_heading">View Broadcast News <?php echo $model->news_id; ?></h2>

<?php
  //  $levelData = Level::model()->getLevel($model->level_id);
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'news_id',
               // array('name' => 'Course', 'value' =>  Course::model()->getCourseName($levelData['course_id'])),
               // array('name' => 'Level', 'value' => Level::model()->getLevelName($model->level_id)),
		'subject',
		'message',
		//'send_date_time',
              //  'news_type',
		//'attachment',
	),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>

