<?php
$this->breadcrumbs=array(
	'Student Exams',
);

$this->menu=array(
//	array('label'=>'Create Student Exam','url'=>array('create')),
//	array('label'=>'Manage Student Exam','url'=>array('admin')),
        array('label'=>'Add Preset Exam','url'=>array('presetexam')),
        array('label'=>'Add Dynamic Exam','url'=>array('dynamicexam')),        
);
?>

<h1>Student Exams</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
