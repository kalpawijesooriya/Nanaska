<?php
$this->breadcrumbs=array(
	'Question Parts'=>array('index'),
	$model->question_part_id=>array('view','id'=>$model->question_part_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuestionPart','url'=>array('index')),
	array('label'=>'Create QuestionPart','url'=>array('create')),
	array('label'=>'View QuestionPart','url'=>array('view','id'=>$model->question_part_id)),
	array('label'=>'Manage QuestionPart','url'=>array('admin')),
);
?>

<h1>Update QuestionPart <?php echo $model->question_part_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>