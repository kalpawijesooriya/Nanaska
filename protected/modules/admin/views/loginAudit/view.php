<?php
$this->breadcrumbs = array(
    'Login Audits' => array('index'),
    $model->login_audit_id,
);

$this->menu = array(
    array('label' => 'List Login Activity', 'url' => array('index')),
//    array('label' => 'Create Login Activity', 'url' => array('create')),
//    array('label' => 'Update LoginAudit', 'url' => array('update', 'id' => $model->login_audit_id)),
    array('label' => 'Delete Login Activity', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->login_audit_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Login Activity', 'url' => array('admin')),
);
?>

<h2 class="light_heading">View Login Activity <?php echo $model->login_audit_id; ?></h2>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'login_audit_id',
        'user_id',
        array('name' => 'First Name', 'value' => User::model()->getFirstName($model->user_id)),
        array('name' => 'Last Name', 'value' => User::model()->getLastName($model->user_id)),
        'action',
        'date',
        'time',
//        'status',
    ),
));
?>
