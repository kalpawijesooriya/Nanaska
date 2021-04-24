<script>
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
    }
</script>

<style>
    .asterix{
        color: red;
    }
</style>


<?php
$this->breadcrumbs = array(
    'Subjects',
);

$this->menu = array(
    array('label' => 'Create Subject', 'url' => array('create')),
    array('label' => 'Manage Subject', 'url' => array('admin')),
//    array('label' => 'Set Papers For Subject', 'url' => array('setPapersForSubject')),
);
?>


<h2 class="light_heading">Set Papers For Subject</h2><br/>

<?php ?>

<div class="control-group"><br/>
    <p style="display:none" id="errorDisplay" class="alert alert-danger"></p>
</div>

<div class="control-group">       
    <?php
    echo 'Course <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
        'prompt' => 'Select Course',
        'class' => 'form-control',
        'ajax' => array(
            'data' => array('course_id' => 'js:course_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Level/getLevels'),
            'update' => '#level_id',
             'beforeSend' => 'function() {           
                if(subject_id.value!=""){
                    subject_id.options.length = 1;
                }
            
        }',
    )));
    ?> 

</div>

<div class="control-group">
    <?php
    echo 'Level <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('level_id', '', array(), array(
        'prompt' => 'Select Level',
        'ajax' => array(
            'data' => array('level_id' => 'js:level_id.value'),
            'type' => 'POST', //request type
            'url' => CController::createUrl('Subject/getSubjects2'),
            'update' => '#subject_id',
    )));
    ?>         
</div>

<div class="control-group">
    <?php
    echo 'Subject <span class="asterix">*</span>';
    echo '<br>';
    echo CHTML::dropDownList('subject_id', '', array(), array(
        'prompt' => 'Select Subject',
//        'ajax' => array(
//            'type' => 'POST',
//            'url' => CController::createUrl('SubjectArea/getSubjectAreas'),
//            'update' => $updateDropDowns,
//    )
    ));
    ?>  


<!--    <br>-->
    <b id="subjectErr"></b>
</div>


<?php
$numberOfSetPapers = 20;

for ($count = 1; $count <= $numberOfSetPapers; $count++) {
    echo $this->renderPartial('_addPaperToSubject', array('count' => $count));
}

echo CHtml::ajaxButton('Save Order', CController::createUrl('subjectExamOrder/savePaperOrder'), array(
    'type' => 'POST', //request type
    'dataType' => 'json',
    'data' => array('subject_id' => 'js:subject_id.value',
        'course_id' => 'js:course_id.value',
        'level_id' => 'js:level_id.value'
    ),
    'success' => 'function(data){ 
                                   if(data[0].status=="success"){
                                        document.location.href = data[0].redirect_url; 
                                        
                                        removeHighlight("course_id");
                                        removeHighlight("level_id");
                                        removeHighlight("subject_id");
                                   }else if(data[0].status=="fail"){
                                        document.getElementById("errorDisplay").innerHTML="";
                                        document.getElementById("errorDisplay").style.display="none";

                                        removeHighlight("course_id");
                                        removeHighlight("level_id");
                                        removeHighlight("subject_id");


                                        for(var x=0;x<data[1].length;x++){
                                            var element =  data[1][x];
                                            hightlightTextBox(element);
                                        }

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
