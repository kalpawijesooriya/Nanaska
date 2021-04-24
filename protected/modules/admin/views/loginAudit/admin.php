<?php
$this->breadcrumbs = array(
    'Login Audits' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Login Activity', 'url' => array('index')),
//	array('label'=>'Create LoginAudit', 'url'=>array('create')),
);
?>

<h2 class="light_heading">Manage Login Activity</h2>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'login-audit-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'login_audit_id',
//        'user_id',
        'first_name' => array(
            'name' => 'user_id',
            'header' => 'First Name',
            'value' => 'User::model()->getFirstName($data->user_id)',
        ),
        'action' => array(
            'name' => 'action',
            'header' => 'Action',
            'value' => 'LoginAudit::TruncateText(LoginAudit::model()->getLoginAuditActionNameByLabel($data->action),30)',
            'filter' => CHtml::listData(LoginAudit::model()->findAll(), 'action', 'action')
        ),
//        'action',
        'date',
        'time',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}'
        ),
    ),
    'pager' => array(
//        'cssFile'=>Yii::app()->theme->baseUrl."/css/pagination.css",
        'header' => '',
        'prevPageLabel' => 'Previous',
        'nextPageLabel' => 'Next',
        'firstPageLabel'=>'First',
        'lastPageLabel'=>'Last',
        //'footer'=>'End',//defalut empty
       // 'maxButtonCount'=>4 // defalut 10                   
        ),
));
?>
