<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("testimonials") == 1)
{

    $this->breadcrumbs=array(
        'Courses',
    );

    $this->menu=array(
            array('label'=>'Create Testimonial', 'url'=>array('create')),
            array('label'=>'Manage Testimonial', 'url'=>array('admin')),
    );
    ?>

    <h2 class="light_heading">Testimonials</h2>

    <?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
