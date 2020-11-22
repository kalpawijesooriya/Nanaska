<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->news_id=>array('viewBroadcast','id'=>$model->news_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List News','url'=>array('index')),
	array('label'=>'Create News','url'=>array('create')),
	array('label'=>'View News','url'=>array('view','id'=>$model->news_id)),
	array('label'=>'Manage News','url'=>array('admin')),
);
?>

<h2 class="light_heading">Update News <?php echo $model->news_id; ?></h2>

<?php echo $this->renderPartial('_formBroadcast',array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
