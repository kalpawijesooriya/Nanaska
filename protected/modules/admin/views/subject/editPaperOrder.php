<?php
$this->breadcrumbs = array(
    'Subjects' => array('index'),
    $model->subject_id => array('view', 'id' => $model->subject_id),
    'Update',
);

$this->menu = array(
//    array('label' => 'List Subject', 'url' => array('index')),
//    array('label' => 'Create Subject', 'url' => array('create')),
    array('label' => 'View Subject', 'url' => array('view', 'id' => $model->subject_id)),
//    array('label' => 'Manage Subject', 'url' => array('admin')),
//    array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
);
?>

<h2 class="light_heading">Edit Paper Order</h2><br/>

<h4 class="light_heading">Current Order</h4><br/>


<table border="1">
    <tr>
        <th width="200">Order</th>
        <th width="200">Exam ID</th>
        <th width="200">Exam Name</th>
        <th width="200">Exam Type</th>
    <tr>
        <?php
        $subject_exam_order_details = SubjectExamOrder::model()->getSubjectExamOrderDetails($model->subject_id);

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
        ?>    

</table>

<br/>
<h4 class="light_heading">New Order</h4>

<div class="control-group">
    <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
</div>

<?php
$numberOfSetPapers = 20;

for ($count = 1; $count <= $numberOfSetPapers; $count++) {
    echo $this->renderPartial('_addPaperToSubjectEdit', array('count' => $count, 'subject_id' => $model->subject_id));
}

$level = Subject::model()->getLevelOfSubject($model->subject_id);
$course = Level::model()->getCourseOfLevelID($level);

echo CHtml::ajaxButton('Save Order', CController::createUrl('subjectExamOrder/savePaperOrderEdit'), array(
    'type' => 'POST', //request type
    'dataType' => 'json',
    'data' => array('subject_id' => $model->subject_id,
        'course_id' => $course,
        'level_id' => $level
    ),
    'success' => 'function(data){ 
                                   if(data[0].status=="success"){
                                        document.location.href = data[0].redirect_url; 
                                        
                                   }else if(data[0].status=="fail"){
                                        document.getElementById("errorDisplay").innerHTML="";
                                        document.getElementById("errorDisplay").style.display="none";

                                        for(var x=0;x<data[2].length;x++){
                                            var msg =  data[2][x];
                                            document.getElementById("errorDisplay").innerHTML=document.getElementById("errorDisplay").innerHTML+msg+"<br />";

                                        }

                                        document.getElementById("errorDisplay").style.display="block";

                                    }
                 
                                    }'
        ), array('class' => 'button button-news',
    'id' => 'create_exam')
);
?>