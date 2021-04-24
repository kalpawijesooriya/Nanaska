<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
$dataProvider = new CActiveDataProvider('News', array(
    'criteria'=>array(
        'condition'=>"news_type='LEVEL_NEWS'",
        //'pagination'=>array('pageSize'=>10,),
    )
));

$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,        
	'itemView'=>'_view',
        
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>