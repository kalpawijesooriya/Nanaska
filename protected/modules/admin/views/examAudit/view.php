<?php
$this->breadcrumbs = array(
    'Exam Audits' => array('index'),
    $model->exam_audit_id,
);

$this->menu = array(
//	array('label'=>'List ExamAudit','url'=>array('index')),
//	array('label'=>'Create ExamAudit','url'=>array('create')),
//	array('label'=>'Update ExamAudit','url'=>array('update','id'=>$model->exam_audit_id)),
//	array('label'=>'Delete ExamAudit','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->exam_audit_id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label' => 'Exam Audit Log', 'url' => array('index')),
);
?>

<h2 class="light_heading">View Exam Audit <?php echo $model->exam_audit_id; ?></h2><br/>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'exam_audit_id',
        array('label'=>'Exam ID', 'type'=>'raw', 'value'=>CHtml::link($model->exam_id, array('exam/view','id'=>$model->exam_id))),
        array('label'=>'User ID', 'type'=>'raw', 'value'=>CHtml::link($model->user_id, array('user/view','id'=>$model->user_id))),
        'action',
        'date',
        'time',
//        array('label' => 'exam_id',
//            'value' => CHtml::link(CHtml::encode(''),array('exam/view'))),
//		'status',
    ),
));
?>
