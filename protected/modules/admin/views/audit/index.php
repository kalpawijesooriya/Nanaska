<?php
$this->breadcrumbs = array(
    'Audits',
);

$this->menu = array(
//    array('label' => 'Create Audit', 'url' => array('create')),
    array('label' => 'Manage Activity', 'url' => array('admin')),
);
?>

<h2 class="light_heading">Activity Log</h2>

<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
        )
);
?>
