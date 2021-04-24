<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("lecturer_management") == 1)
{
    
$this->breadcrumbs = array(
    'Lecturers' => array('index'),
    $model->lecturer_id,
);

$isPrivilegeSet = LecturerPrivilege::model()->isPrivilegeSet($model->lecturer_id);

if (!$isPrivilegeSet) {
    $this->menu = array(
        array('label' => 'List Lecturer', 'url' => array('index')),
        array('label' => 'Create Lecturer', 'url' => array('create')),
        array('label' => 'Update Lecturer', 'url' => array('update', 'id' => $model->lecturer_id)),
//    array('label' => 'Delete Lecturer', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->lecturer_id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Lecturer', 'url' => array('admin')),
        array('label' => 'View Authored Questions', 'url' => array('ViewAuthoredQuestions')),
        array('label' => 'Set Privilege Levels', 'url' => array('setPrivilegeLevels', 'id' => $model->lecturer_id)),
    );
} else {
    $this->menu = array(
        array('label' => 'List Lecturer', 'url' => array('index')),
        array('label' => 'Create Lecturer', 'url' => array('create')),
        array('label' => 'Update Lecturer', 'url' => array('update', 'id' => $model->lecturer_id)),
//    array('label' => 'Delete Lecturer', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->lecturer_id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Lecturer', 'url' => array('admin')),
        array('label' => 'View Authored Questions', 'url' => array('ViewAuthoredQuestions')),
        array('label' => 'Edit Privilege Levels', 'url' => array('editPrivilegeLevels', 'id' => $model->lecturer_id)),
    );
}
?>

<h2 class="light_heading">View Lecturer <?php echo $model->lecturer_id; ?></h2><br/>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array('name' => 'Lecturer ID', 'value' => $model->lecturer_id),
        'lecturer_code',
        'user.first_name',
        'user.last_name',
        'user.email',
        'user.address',
        'user.phone_number',
        array('name' => 'Phone Number 2', 'value' => $model->extra_number),
//        array('name' => 'Level', 'value' => Level::getLevelName($model->level_id)),
        array('name' => 'Country', 'value' => Country::getCountryByID($model->user->country_id)),
        'note',
//        array('name' => 'Sitting On', 'value' => Sitting::getSittingByID($model->sitting_id)),
//        //'user_id',
//        //'level_id',
//        //'sitting_id',
//        'note',
    //'status'
    ),
));
?>


<?php
$userData = User::getUserInfoById($model->user_id);
?>

<!--<div class="well">-->





<?php
$subjectData = SubjectLecturer::getSubjectsOfLecturerById($model->lecturer_id);
?>

<table border="1">
    <tr>
        <td width="300">
    <center><strong>Course</strong></center>
</td>
<td width="300">
<center><strong>Level</strong></center>
</td>
<td width="300">
<center><strong>Subject</strong></center>
</td>
</tr>

<?php
foreach ($subjectData as $subjectItem) {
    echo '<tr>';
    echo '<td width="300">';
    echo '<center>';
    echo $subjectItem['course_name'];
    echo '</center>';
    echo '</td>';
    echo '<td width="300">';
    echo '<center>';
    echo $subjectItem['level_name'];
    echo '</center>';
    echo '</td>';
    echo '<td width="300">';
    echo '<center>';
    echo $subjectItem['subject_name'];
    echo '</center>';
    echo '</td>';
    echo '</tr>';
}
?>
</table>

<br/>
<b>Status: </b>
<?php
if ($model->status == 1) {
    ?>
    <p id="status" style="display:inline">
    <?php echo 'Active<br/><br/>'; ?>
    </p>
        <?php
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Lecturer/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('lecturer_id' => $model->lecturer_id),
            'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:block')
        );
        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Lecturer/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('lecturer_id' => $model->lecturer_id),
            'success' => 'function(data){    

                               document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";         
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:none')
        );
    } else if ($model->status == 0) {
        ?>
    <p id="status" style="display:inline">
    <?php echo 'In-Active<br/><br/>'; ?>
    </p>
    <?php
    echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Lecturer/reactivate'), array(
        'type' => 'POST',
        'dataType' => 'json',
        'data' => array('lecturer_id' => $model->lecturer_id),
        'success' => 'function(){                                       
                                      document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";      
                                    }'
            ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:block')
    );
    echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Lecturer/suspend'), array(
        'type' => 'POST',
        'dataType' => 'json',
        'data' => array('lecturer_id' => $model->lecturer_id),
        'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
            ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:none')
    );
}
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
<br />
<!--</div>-->      