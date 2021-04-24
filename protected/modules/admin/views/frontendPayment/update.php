<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Frontend Payment','url'=>array('index')),
	//array('label'=>'Create FrontendPayment','url'=>array('create')),
	array('label'=>'View Frontend Payment','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Frontend Payment','url'=>array('admin')),
);
?>

<h2 class="light_heading">Update FrontendPayment <?php echo $model->id; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>