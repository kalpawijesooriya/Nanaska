<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
    $this->breadcrumbs=array(
            'News'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List News','url'=>array('index')),
            array('label'=>'Manage News','url'=>array('admin')),
    );
?>

<h2 class="light_heading">Create Broadcast News</h2><br/>

<?php echo $this->renderPartial('_formBroadcast', array('model'=>$model));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>

