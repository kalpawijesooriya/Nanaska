<?php
$this->breadcrumbs=array(
	'Login Audits',
);

$this->menu=array(
	array('label'=>'Create LoginAudit', 'url'=>array('create')),
	array('label'=>'Manage LoginAudit', 'url'=>array('admin')),
);
?>

<h1>Login Audits</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
