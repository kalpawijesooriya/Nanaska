<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("subject_management") == 1)
{
    
$subject_exam_order_details = SubjectExamOrder::model()->getSubjectExamOrderDetails($model->subject_id);


$this->breadcrumbs = array(
    'Subjects' => array('index'),
    $model->subject_id,
);


if ($subject_exam_order_details == null) {
    $this->menu = array(
        array('label' => 'List Subject', 'url' => array('index')),
        array('label' => 'Create Subject', 'url' => array('create')),
        array('label' => 'Update Subject', 'url' => array('update', 'id' => $model->subject_id)),
//	array('label'=>'Delete Subject', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subject_id),'confirm'=>'Are you sure you want to delete this item?')),
        array('label' => 'Manage Subject', 'url' => array('admin')),
        array('label' => 'Set Paper Order', 'url' => array('setPapersForSubject')),
    );
}else{
    $this->menu = array(
    array('label' => 'List Subject', 'url' => array('index')),
    array('label' => 'Create Subject', 'url' => array('create')),
    array('label' => 'Update Subject', 'url' => array('update', 'id' => $model->subject_id)),
//	array('label'=>'Delete Subject', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subject_id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label' => 'Manage Subject', 'url' => array('admin')),
    array('label' => 'Edit Paper Order', 'url' => array('editPaperOrder', 'id' => $model->subject_id)),
);
}
?>

<h2 class="light_heading">View Subject <?php echo $model->subject_id; ?></h2><br/>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'subject_id',
        array('name' => 'Subject ID', 'value' => $model->subject_id),
//        'level_id',
        array('name' => 'Level', 'value' => Level::getLevelName($model->level_id)),
        'subject_name',
    ),
));
?>
<h3 class="light_heading">Paper Order</h3>
<table border="1">
    <tr>
        <th width="200">Order</th>
        <th width="200">Exam ID</th>
        <th width="200">Exam Name</th>
        <th width="200">Exam Type</th>
    <tr>
        <?php
//        echo '<pre>';
//        print_r($subject_exam_order_details);
//        echo '</pre>';

        foreach ($subject_exam_order_details as $subject_exam_order_detail) {
            $examDetails = Exam::getExamInfoById($subject_exam_order_detail['exam_id']);

            echo '<tr>';
            echo '<td><center>';
            echo $subject_exam_order_detail['position'];
            echo '</td></center>';
            echo '<td><center>';
            echo $subject_exam_order_detail['exam_id'];
            echo '</td></center>';
            echo '<td><center>';
            echo $examDetails['exam_name'];
            echo '</td></center>';
            echo '<td><center>';
            if ($examDetails['exam_type'] == "PRESET") {
                echo 'Preset';
            } else if ($examDetails['exam_type'] == "SAMPLE") {
                echo 'Sample';
            } else if ($examDetails['exam_type'] == "DYNAMIC") {
                echo 'Dynamic';
            }
            echo '</td></center>';
            echo '</tr>';
        }
}
else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
        ?>    

</table>