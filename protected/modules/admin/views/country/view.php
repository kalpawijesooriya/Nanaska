<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("country_management") == 1)
{

    $this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->country_id,
    );

    $this->menu=array(
            array('label'=>'List Country', 'url'=>array('index')),
            array('label'=>'Create Country', 'url'=>array('create')),
            array('label'=>'Update Country', 'url'=>array('update', 'id'=>$model->country_id)),
    //	array('label'=>'Delete Country', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->country_id),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=>'Manage Country', 'url'=>array('admin')),
    );
    ?>

    <h2 class="light_heading">View Country <?php echo $model->country_id; ?></h2><br/>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'country_id',
		'country_name',
	),
    ));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
