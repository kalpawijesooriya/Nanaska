<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>

<div class="container">
    <div class="span12">
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Course Management</span>', array('/admin/course'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Level Management</span>', array('/admin/level'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Subject Management</span>', array('/admin/subject'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Subject Area Management</span>', array('/admin/subjectArea'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Session Management</span>', array('/admin/sitting'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">News Management</span>', array('/admin/news'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Country Management</span>', array('/admin/country'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Frontend Payment</span>', array('/admin/frontendPayment'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
        
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Products</span>', array('/admin/productCategories'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
    </div>

    <div class="span12">
        <hr class="hrstyle">
    </div>

    <div class="span12">
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Student Management</span>', array('/admin/student'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Lecture Management</span>', array('/admin/lecturer'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Temporary Users</span>', array('/admin/temporaryUser'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Exam Management</span>', array('/admin/exam'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Question Management</span>', array('/admin/question'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>

        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Result Management</span>', array('/admin/result'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Essay Answer Management</span>', array('/admin/essayAnswer'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Change Password</span>',array('/admin/user/updatepass','id'=>Yii::app()->user->id),array('class'=>'shortcutadmin')); ?>
<!--                --><?php //echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Change Password</span>', array('/admin/changePassword'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->
        </div>
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Testimonials</span>', array('/admin/testimonials'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->
        </div>
    </div>

    <div class="span12">
        <hr class="hrstyle">
    </div>

    <div class="span12">
        <div class="span3">
            <div class="shortcutsadmin">
                <?php
                $is_new = "";

                $new_logs = ExamAudit::model()->getNewExamAudits();

                if (sizeof($new_logs) > 0) {
                    $is_new = "NEW!";
                }
                ?>

                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Activity Log <strong>' . $is_new . '</strong></span>', array('/admin/audit'), array('class' => 'shortcutadmin')); ?>

            </div> <!-- /shortcuts -->	
        </div>
        
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">User Log</span>', array('/admin/loginAudit'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
        
        
        
        <div class="span3">
            <div class="shortcutsadmin">
                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Log Per 60 min</span>', array('/admin/examAudit/viewLogPer60Mins/'), array('class' => 'shortcutadmin')); ?>
            </div> <!-- /shortcuts -->	
        </div>
        
        
        
        
        
        
<!--        <div class="span3">
            <div class="shortcutsadmin">
                <?php //echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">Question Statistics</span>', array('/admin/question/QuestionStatistics/'), array('class' => 'shortcutadmin')); ?>
            </div>  /shortcuts 	
        </div>-->
    </div>


</div>  
