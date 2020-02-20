<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("activity_logs") == 1) {

$this->breadcrumbs=array(
	'Exam Audits',
);

$this->menu=array(
	array('label'=>'Create ExamAudit','url'=>array('create')),
	array('label'=>'Manage ExamAudit','url'=>array('admin')),
);
?>

<h2 class="light_heading">Exam Audits</h2>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 

}

?>

