<?php
$this->breadcrumbs=array(
	'Lecturer Privileges',
);

$this->menu=array(
	array('label'=>'Create LecturerPrivilege','url'=>array('create')),
	array('label'=>'Manage LecturerPrivilege','url'=>array('admin')),
);
?>

<h1>Lecturer Privileges</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
