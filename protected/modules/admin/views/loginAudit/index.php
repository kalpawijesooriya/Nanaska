<?php
$this->breadcrumbs=array(
	'Login Audits',
);

$this->menu=array(
//	array('label'=>'Create LoginAudit', 'url'=>array('create')),
	array('label'=>'Manage Login Activity', 'url'=>array('admin')),
);
?>

<h2 class="light_heading">Login Details</h2>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
