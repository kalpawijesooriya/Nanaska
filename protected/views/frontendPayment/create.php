<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FrontendPayment','url'=>array('index')),
	array('label'=>'Manage FrontendPayment','url'=>array('admin')),
);
?>

<!--<h1>Create FrontendPayment</h1>-->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>