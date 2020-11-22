<div class="container">
<?php
//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	$model->user_id=>array('view','id'=>$model->user_id),
//	'Update',
//);

//$this->menu=array(
//	array('label'=>'View Account','url'=>array('view','id'=>$model->user_id)),
//	array('label'=>'Edit Account','url'=>array('update','id'=>$model->user_id)),
//	array('label'=>'Change Password','url'=>array('updatepass','id'=>$model->user_id)),
//	//array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
//	//array('label'=>'Manage User','url'=>array('admin')),
//);
$this->renderpartial('_level_news_sidemenu');
?>
<div class="span8"> 


<?php echo $this->renderPartial('_edit',array('model'=>$model)); ?>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br>