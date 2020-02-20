<?php
$this->breadcrumbs=array(
	'Lecturers',
);

$this->menu=array(
	array('label'=>'Create Lecturer', 'url'=>array('create')),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>Lecturers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
