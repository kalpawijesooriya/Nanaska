
<?php
Yii::app()->session['exam_session'] = array();
$examSession = Yii::app()->session['exam_session'];
?>
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

<?php
//$exams = Exam::model()->getExamsOfLevel($level_id);
//echo '<pre>';
//print_r($questions);
//echo '</pre>';
?>
<script>
    $(function() {
        $("option").bind("dblclick", function() {
            window.location.href = "index.php?r=admin/exam/view&id=" + document.getElementsByName('exams')[0].value;
        });
    });
</script>
 
<div class="span9">
  
<!--<div class="row">
    <h3 class="light_heading">Add Preset/Sample Exams</h3><br/>
</div>-->

<div class="control-group">    
            <?php
            echo '<label class="control-label" for="inputPassword">Level</label>';
            echo '<div class="controls">';
            echo CHtml::dropDownList('level_id','', array(), array(
                'prompt' => 'Select Level',
                'class' => 'form-control',
                'ajax' => array(
                    'data' => array('level_id'=>'js:level_id.value'),
                    'type' => 'POST',
                    'url' => CController::createUrl('Subject/GetSubjects'),
                    'update' => '#subject_id',
                )
            ));
            echo '</div>';
            ?>        
</div>

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Subject</label>';
    echo '<div class="controls">';
    echo CHTML::DropDownList('subject_id','',array(),array(
        'prompt' => 'Select Subject',
        'ajax' => array(
            'data' => array('subject_id'=>'js:subject_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Exam/GetExams'),
            'update' => '#exams',
    )
    ));
    echo '</div>';
    ?>  
</div>


<div class="control-group">
    <label class="control-label" for="inputPassword">Exam List</label>
    <div class="controls">
        <select id="exams" name="exams" multiple="multiple" style="width:400px;height:100px;">

        </select>
     </div>
</div>


        <div class="row">
            <p style="display:none" id="examErr" class="alert alert-danger"/>
        </div>

<div class="control-group">
    <label class="control-label" for="inputPassword">Start Date</label>
    <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'publishDate',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'minDate' => 0,
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;',
                'id' => 'startingDate',
                'placeholder' => 'Select Starting Date'
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputPassword">End Date</label>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'publishDate',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'minDate' => 0,
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;',
                    'id' => 'expiryDate',
                    'placeholder' => 'Select Expiry Date'
                ),
            ));
            ?>
         </div>
</div>

    <?php
    echo CHtml::ajaxSubmitButton('Add Exam', CController::createUrl('Student/addExamToStudent'), array(
        'type' => 'POST', //request type        
        'dataType' => 'json',
        'data' => array('exams' => 'js:exams.value', 'publishDate' => 'js:expiryDate.value'),
        'success' => 'function(data){                                       
                                       if(data.status=="success"){
                                            var examList = document.getElementById("selected_exams");
                                            var option = document.createElement("option");
                                            option.text = data.exam_name;
                                            option.value = data.exam_id;
                                            examList.add(option);
                                            removeHighlight("exams");
                                            removeHighlight("expiryDate");
                                            document.getElementById("expiryDate").value="";
                                            document.getElementById("examErr").innerHTML="";
                                            document.getElementById("examErr").style.display="none";
                                       }else if(data.status=="fail"){
                                            if(data.errorCode==1){
                                                hightlightTextBox("exams");
                                                removeHighlight("expiryDate");
                                                document.getElementById("examErr").style.display="block";
                                                document.getElementById("examErr").innerHTML="";
                                                document.getElementById("examErr").innerHTML=data.message;
                                            }else if(data.errorCode==3){
                                                hightlightTextBox("exams");
                                                removeHighlight("expiryDate");
                                                document.getElementById("examErr").style.display="block";
                                                document.getElementById("examErr").innerHTML="";
                                                document.getElementById("examErr").innerHTML=data.message;
                                            }else if(data.errorCode==2){
                                                hightlightTextBox("expiryDate");
                                                removeHighlight("exams");
                                                document.getElementById("examErr").style.display="block";
                                                document.getElementById("examErr").innerHTML="";
                                                document.getElementById("examErr").innerHTML=data.message;
                                            }
                                            
                                        }
                                    }'
            ), array('class' => 'btn btn-checkout','style'=>'margin-left: 140px;')
    );
    
   ?>
</div>
<div class="span6" style="margin-left: 200px;">
    <h4 class="light_heading">Selected Exams</h4><br/>

    <select id="selected_exams" name="selected_exams" multiple="multiple" style="width:400px;height:100px;">
        <!--<option disabled selected>Selected Exams</option>-->
        <?php
        if (!empty($examSession)) {
            foreach ($examSession as $item) {
                $examDets = Exam::getExamInfoById($item['exam_id']);
                echo '<option value=' . $item['exam_id'] . '>' . $examDets->exam_name . '</option>';
            }
        }

        if (!empty($exams_of_student)) {
            foreach ($exams_of_student as $exam_of_student) {
                $examDets = Exam::getExamInfoById($exam_of_student['exam_id']);
                $examSession[] = array('exam_id' => $exam_of_student['exam_id'], 'expiry_date' => $exam_of_student['expiry_date']);

                echo '<option value=' . $exam_of_student['exam_id'] . '>' . $examDets->exam_name . '</option>';
            }
        }
        Yii::app()->session['exam_session'] = $examSession;
        
        ?>
    </select>

<?php
    echo CHtml::ajaxSubmitButton('Remove Selected Exam', CController::createUrl('Student/removeExam'), array(
        'type' => 'POST', //request type
        'dataType' => 'json',
        'data' => array('exam_id' => 'js:selected_exams.value'),
        'success' => 'function(data){                                       
                                        if(data.status=="success" && data.examSelected!="Selected Exams"){
                                            var examList = document.getElementById("selected_exams");
                                            examList.remove(examList.selectedIndex);
                                            removeHighlight("selected_exams");
                                        }else if(data.status=="fail"){
                                            hightlightTextBox("selected_exams");
                                        }
                                    }'
            ), array('class' => 'btn btn-checkout','style'=>'margin-left: 120px; margin-top: 10px;')
    );
    ?>
   
</div>


