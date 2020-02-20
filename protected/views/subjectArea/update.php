<?php
$this->breadcrumbs=array(
	'Subject Areas'=>array('index'),
	$model->subject_area_id=>array('view','id'=>$model->subject_area_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubjectArea','url'=>array('index')),
	array('label'=>'Create SubjectArea','url'=>array('create')),
	array('label'=>'View SubjectArea','url'=>array('view','id'=>$model->subject_area_id)),
	array('label'=>'Manage SubjectArea','url'=>array('admin')),
);
?>

<h1>Update SubjectArea <?php echo $model->subject_area_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>