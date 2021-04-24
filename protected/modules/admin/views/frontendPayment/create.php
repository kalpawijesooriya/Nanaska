<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Frontend Payment','url'=>array('index')),
	array('label'=>'Manage Frontend Payment','url'=>array('admin')),
);
?>

<!--<h2 class="light_heading">Create FrontendPayment</h2>-->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>