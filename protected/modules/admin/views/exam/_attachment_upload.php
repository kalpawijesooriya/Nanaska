<?php
$this->menu = array(
    array('label' => 'List Exam', 'url' => array('index')),
    array('label' => 'Create Exam', 'url' => array('create')),
    array('label' => 'Update Exam', 'url' => array('update', 'id' => $model->exam_id)),
    array('label' => 'View Exam', 'url' => array('view', 'id' => $model->exam_id)),
    //array('label' => 'Set Instructions', 'url' => array('setExamInstruction', 'id' => $model->exam_id)),
    //array('label' => 'Update Instructions', 'url' => array('editExamInstruction', 'id' => $model->exam_id)),
    //    array('label' => 'Delete Exam', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->exam_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Exams', 'url' => array('admin')),
    array('label' => 'Export To PDF', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
);
?>
<h2 class="light_heading">Set Attachments For Exam <?php echo $model->exam_id; ?></h2>
</br>
<div class="well_dashboard">
    <div class="row">
        <div class="span9">
            <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/setExamInstruction', array('id' => $model->exam_id)); ?>">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Set Instructions </div>  </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/editExamInstruction', array('id' => $model->exam_id)); ?>">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Update Instructions </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/setTables', array('id' => $model->exam_id)); ?>">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Set Tables & Formulae </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/updateTables', array('id' => $model->exam_id)); ?>">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Update Tables & Formulae </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/setExamImage', array('id' => $model->exam_id)); ?>">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Set Image </div> </div>
                </a> </div>
            <?php
            if ($model->exam_type == "ESSAY") {
                ?>
        <!--                <div class="span4"> <a class="user_text" href="<?php //echo CController::createUrl('exam/uploadAttachments', array('id' => $model->exam_id));           ?>">
    <div class="sub_well-settings">
    <div class="dashbord-sub-menu"> Upload Attachments </div> </div>
    </a> </div>-->
            <div class="span5"></div>

                <div class="span4"> <a class="user_text" href="<?php echo CController::createUrl('exam/setPreseen', array('id' => $model->exam_id)); ?>">
                        <div class="sub_well-settings">
                            <div class="dashbord-sub-menu"> Set Pre-Seen Materials </div> </div>
                    </a> </div>
                <?php
            }
            ?>

        </div>
    </div>       

</div>
