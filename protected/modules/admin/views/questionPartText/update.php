<?php
$this->breadcrumbs=array(
	'Question Part Texts'=>array('index'),
	$model->question_part_text_id=>array('view','id'=>$model->question_part_text_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuestionPartText','url'=>array('index')),
	array('label'=>'Create QuestionPartText','url'=>array('create')),
	array('label'=>'View QuestionPartText','url'=>array('view','id'=>$model->question_part_text_id)),
	array('label'=>'Manage QuestionPartText','url'=>array('admin')),
);
?>

<h1>Update QuestionPartText <?php echo $model->question_part_text_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>