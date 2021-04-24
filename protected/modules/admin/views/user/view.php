<?php
//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	$model->user_id,
//);
//
//$this->menu=array(
////	array('label'=>'List User', 'url'=>array('index')),
////	array('label'=>'Create User', 'url'=>array('create')),
////	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->user_id)),
////	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
////	array('label'=>'Manage User', 'url'=>array('admin')),
//);
//?>
<!---->
<!--<h1 class="light_heading">View User --><?php //echo $model->user_id; ?><!--</h1>-->
<!--</br>-->
<?php //$this->widget('bootstrap.widgets.TbDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
//		'user_id',
//		'first_name',
//		'last_name',
//		'email',
////		'password',
//		'phone_number',
//		'address',
//		'country_id',
//		'user_type',
//	),
//)); ?>

<br>
<div class="span6">
    <h4 class="master_heading"> Password Change </h4>
    <br>
    <div class="well">
        <p> Your Password Has Successfully Changed </p>
    </div>
    <a href="?r=admin">
        <button class="bluebtn pull-right" style="margin-left: 20px; width: 110px !important;" type="button"><i
                    class="icon-arrow-left icon-white"></i> Dashboard
        </button>
    </a>
</div>
