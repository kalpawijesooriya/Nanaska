<?php
//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	'Create',
//);

//$this->menu=array(
//	array('label'=>'View Account','url'=>array('view','id'=>$model->user_id)),
//	array('label'=>'Edit Account','url'=>array('update','id'=>$model->user_id)),
//	array('label'=>'Change Password','url'=>array('updatepass','id'=>$model->user_id)),
//	//array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
//	//array('label'=>'Manage User','url'=>array('admin')),
//);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
