<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("sitting_management") == 1)
{
    $this->breadcrumbs=array(
            'Sittings'=>array('index'),
            $model->sitting_id,
    );

    $this->menu=array(
            array('label'=>'List Sessions', 'url'=>array('index')),
            array('label'=>'Create Session', 'url'=>array('create')),
            array('label'=>'Update Session', 'url'=>array('update', 'id'=>$model->sitting_id)),
    //	array('label'=>'Delete Sitting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sitting_id),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=>'Manage Sessions', 'url'=>array('admin')),
    );
?>

<h2 class="light_heading">View Session <?php echo $model->sitting_id; ?></h2><br/>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sitting_id',
		'sitting_name',
	),
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
