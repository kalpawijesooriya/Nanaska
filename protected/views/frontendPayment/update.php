<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FrontendPayment','url'=>array('index')),
	array('label'=>'Create FrontendPayment','url'=>array('create')),
	array('label'=>'View FrontendPayment','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage FrontendPayment','url'=>array('admin')),
);
?>

<h1>Update FrontendPayment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>