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

<?php  
    if($model->news_type=="BROADCAST_NEWS"){?>
        <h2 class="light_heading">View Broadcast News <?php echo $model->news_id; ?></h2>
    <?php }else{ ?>
        <h2 class="light_heading">View Level News <?php echo $model->news_id; ?></h2>
  <?php  }

?>

<?php
    $levelData = Level::model()->getLevelForNews($model->level_id);
    $url=Yii::app()->baseUrl. '/images/NewsImageAttachments/' . $model->news_id . '/'.$model->attachment;
    $path =Yii::app()->baseUrl. '/images/NewsImageAttachments/' . $model->news_id . '/'; 
    
    if($levelData!=NULL){
        
       if($model->news_type=="BROADCAST_NEWS"){
            $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'news_id',
               // array('name' => 'Course', 'value' =>  Course::model()->getCourseNameForNews($levelData['course_id'])),
              //  array('name' => 'Level', 'value' => Level::model()->getLevelNameForNews($model->level_id)),
		'subject',
		'message',
		'send_date_time',
              //  'news_type',
               
          //  array('label'=>'Attachment',
           //             'type'=>'raw',
           //             'value'=>CHtml::link(CHtml::encode($model->attachment), $path .$model->attachment)),
                       
		//'attachment',
		
	),
));
           
       } else{
        
    $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'news_id',
                array('name' => 'Course', 'value' =>  Course::model()->getCourseNameForNews($levelData['course_id'])),
                array('name' => 'Level', 'value' => Level::model()->getLevelNameForNews($model->level_id)),
		'subject',
		'message',
		'send_date_time',
              //  'news_type',
               
            array('label'=>'Attachment',
                        'type'=>'raw',
                        'value'=>CHtml::link(CHtml::encode($model->attachment), $path .$model->attachment)),
                       
		//'attachment',
		
	),
));
       }
    }
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
