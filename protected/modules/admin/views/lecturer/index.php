<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("lecturer_management") == 1)
{
    
    $this->breadcrumbs=array(
            'Lecturers',
    );

    $this->menu=array(
            array('label'=>'Create Lecturer', 'url'=>array('create')),
            array('label'=>'Manage Lecturer', 'url'=>array('admin')),
            array('label'=>'View Authored Questions', 'url'=>array('ViewAuthoredQuestions')),
            array('label'=>'View Unapproved Questions', 'url'=>array('question/approve')),

    );
?>

<h2 class="light_heading">Lecturers</h2>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
