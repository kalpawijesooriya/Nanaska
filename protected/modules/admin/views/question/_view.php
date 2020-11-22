<div class="well">

    <b>Question ID:</b>
    <?php echo CHtml::encode($data->question_id); ?>
    <br />

    <?php
    $subjectAreaDetails = SubjectArea::model()->getSubjectAreaDetails($data->subject_area_id);

    $subject = Subject::model()->getSubjectDetails($subjectAreaDetails['subject_id']);

    $level = Level::model()->getLevel($subject['level_id']);

    $course = Course::model()->getCourseDetails($level['course_id']);
    ?>

    <b>Course: </b>
    <?php echo $course['course_name']; ?><br/>
    
    <b>Level: </b>
    <?php echo $level['level_name']; ?><br/>
    
    <b>Subject: </b>
    <?php echo $subject['subject_name']; ?><br/>
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('subject_area_id')); ?>:</b>
<?php // echo CHtml::encode($data->subject_area_id);  ?>
    <?php
    $subjectAreaName = SubjectArea::model()->getSubjectAreaName($data->subject_area_id);
    echo $subjectAreaName;
    ?>

    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('question_type')); ?>:</b>
<?php // echo CHtml::encode($data->question_type);  ?>
    <?php
    if ($data->question_type == "SINGLE_ANSWER") {
        echo 'Single Answer';
    } else if ($data->question_type == "MULTIPLE_ANSWER") {
        echo 'Multiple Answer';
    } else if ($data->question_type == "SHORT_WRITTEN") {
        echo 'Short Written Answer';
    } else if ($data->question_type == "DRAG_DROP_TYPEA_ANSWER") {
        echo 'Drag & Drop Type A Answer';
    } else if ($data->question_type == "DRAG_DROP_TYPEB_ANSWER") {
        echo 'Drag & Drop Type B Answer';
    } else if ($data->question_type == "DRAG_DROP_TYPEC_ANSWER") {
        echo 'Drag & Drop Type C Answer';
    } else if ($data->question_type == "DRAG_DROP_TYPED_ANSWER") {
        echo 'Drag & Drop Type D Answer';
    } else if ($data->question_type == "DRAG_DROP_TYPEE_ANSWER") {
        echo 'Drag & Drop Type E Answer';
    } else if ($data->question_type == "MULTIPLE_CHOICE_ANSWER") {
        echo 'Multiple Choice Answer';
    } else if ($data->question_type == "TRUE_OR_FALSE_ANSWER") {
        echo 'True or False Answer';
    } else if ($data->question_type == "HOT_SPOT_ANSWER") {
        echo 'Hot-Spot Answer';
    }
    ?>
    <br />

        <!--<b><?php //echo CHtml::encode($data->getAttributeLabel('number_of_marks'));  ?>:</b>-->
<?php //echo CHtml::encode($data->number_of_marks);  ?>
    <!--<br />-->

        <!--<b><?php //echo CHtml::encode($data->getAttributeLabel('question_text'));  ?>:</b>-->
<?php //echo html_entity_decode($data->question_text);  ?>  
    <!--<br />-->

    <!--<b><?php // echo CHtml::encode($data->getAttributeLabel('exclude_from_dynamic')); ?>:</b>-->
<?php //echo CHtml::encode($data->exclude_from_dynamic);  ?>
    <?php
//    if ($data->exclude_from_dynamic == 1) {
//        echo 'Yes';
//    } else if ($data->exclude_from_dynamic == 0) {
//        echo 'No';
//    }
    ?>

    <br />
    <!--<br/>-->
<?php echo CHtml::link(CHtml::encode("View In Detail"), array('view', 'id' => $data->question_id)); ?>

</div>