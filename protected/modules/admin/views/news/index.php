<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("news_management") == 1)
{
    
    $this->breadcrumbs = array(
        'News',
    );

    $this->menu = array(
        array('label' => 'Create Level News', 'url' => array('create')),
        array('label' => 'Create Broadcast News', 'url' => array('createBroadcast')),
        array('label' => 'View Level News', 'url' => array('viewLevelNews')),
        array('label' => 'View Broadcast News', 'url' => array('viewBroadcastNews')),
        array('label' => 'Manage News', 'url' => array('admin')),
    );
?>


<h2 class="light_heading">News</h2> <!-- heading  -->

<?php
    if ($type == '<h2 class="light_heading">News</h2>') {
    $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    ));
      
    }else if($type=='<h2 class="light_heading">Level News</h2>'){
         $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    ));
    }else{
        $this->widget('bootstrap.widgets.TbListView',array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_viewBroadcast',
));
    }
//$this->widget('bootstrap.widgets.TbListView',array(
//'dataProvider'=>$dataProvider,
//'itemView'=>'_view',
//));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
