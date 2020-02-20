<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("temporary_users") == 1) {

    $this->breadcrumbs = array(
        'Temporary Users' => array('index'),
        $model->id,
    );

    $this->menu = array(
        array('label' => 'List Temporary User', 'url' => array('index')),
        //array('label'=>'Create TemporaryUser','url'=>array('create')),
        //array('label'=>'Update TemporaryUser','url'=>array('update','id'=>$model->id)),
        array('label' => 'Delete Temporary User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Temporary User', 'url' => array('admin')),
    );
    ?>

    <h2>View Temporary User #<?php echo $model->id; ?></h2>

    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'first_name',
            'last_name',
            'phone_number',
            'address',           
            array('name' => 'Country', 'value' => TemporaryUser::model()->getCountruByID($model->country_id)),
            'email',
            array('name' => 'Course', 'value' => Course::model()->getCourseName($model->course_id)),
            array('name' => 'Level', 'value' => Level::getLevelName($model->level_id)),
            array('name' => 'Session', 'value' => Sitting::model()->getSittingByID($model->sitting_id)),
        ),
    ));
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
