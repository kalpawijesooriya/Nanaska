<?php
$this->breadcrumbs = array(
    'Audits' => array('index'),
    $model->audit_id,
);

$this->menu = array(
    array('label' => 'List Activity', 'url' => array('index')),
//	array('label'=>'Create Audit', 'url'=>array('create')),
//	array('label'=>'Update Audit', 'url'=>array('update', 'id'=>$model->audit_id)),
    array('label' => 'Delete Activity', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->audit_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Activity', 'url' => array('admin')),
);
?>

<h2 class="light_heading">View Activity Log <?php echo $model->audit_id; ?></h2>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'audit_id',
        'user_id',
        array('name' => 'First Name', 'value' => User::model()->getFirstName($model->user_id)),
        array('name' => 'Last Name', 'value' => User::model()->getLastName($model->user_id)),
        'action_id',      
        array('name' => 'Action Name', 'value' => Audit::model()->getActionNameBylabel($model->action_name)),
        'action',
        'date',
        'time',
    ),
));
?>
