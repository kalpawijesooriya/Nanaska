<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel-export/tableExport.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel-export/jquery.base64.js" type="text/javascript"></script>

<script type="text/javascript">
    
    $(document).ready(function() {
        ajaxCall();     //for typeahead
    })
    

    function ajaxCall(){
        $.ajax({
            url:'<?php echo CController::createUrl('Student/getAllStudentEmails'); ?>',
            type: 'POST', //request type
            dataType: 'json',         
            success: function(data){
                if(data){
                    $('#product_search').typeahead({
                        source: function(query, process) {
                            return data;
                        }
                    });
                }
            }
        });
    }
    
    
    function findCourse(){
        var typehead = document.getElementById("product_search");
        if(typehead.value!=""){
            $.ajax({
                url:'<?php echo CController::createUrl('Take/getExamsForEmails'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    email:typehead.value
                },
                beforeSend: function (xhr) {
                    document.getElementById("exam_id").options.length = 1;
                },
                success: function(data){
                    if(data.status=="success"){
//                        var courseElement = document.getElementById("course_name");
//                        courseElement.value = data.courseName;
//                        var levelElement = document.getElementById("level_name");
//                        levelElement.value= data.levelName;

                        document.getElementById('exam_id').options.length = 1;

                        var arr = new Array();
                        arr = data.examDetails;
                        var lenght = arr.length;
                        for(i=0; i< lenght;i++){                          
                            $('#exam_id').append($(data.examDetails[i]));
                        } 
                    }
                }
            });
        }
        
    }

</script>

<script>
    function setFormValues(){
        //set selected student email
        var student_email_obj = document.getElementById('product_search');
        var student_email = student_email_obj.value; 
        var selected_student_email_obj = document.getElementById('selected_student_email');
        selected_student_email_obj.value=student_email;           
        
        //get selected exam
        var exam_id_obj = document.getElementById('exam_id');
        var exam = exam_id_obj.options[exam_id_obj.selectedIndex].value;    
        var selected_exam_obj = document.getElementById('selected_exam');
        selected_exam_obj.value=exam;        
        
        //get results
        var result_content_obj = document.getElementById('paper');
        var pdf_content_obj = document.getElementById('pdf_content');
        pdf_content_obj.value=result_content_obj.innerHTML;
    
        //check exam is selected
        if(exam==""){
            alert("Please Select Exam");
            return false;
        }else{
            return true;
        }
        
    }
</script>


<h3>Export Results to Excel</h3>

<?php /*?>
<?php
$form = $this->beginWidget('CActiveForm', array(       
    'id' => '',
    'action'=>Yii::app()->createUrl('admin/result/generatePDF'),
    'method'=>'POST',
    'enableAjaxValidation'=>false,

)); ?>

<input type="hidden" name="pdf_type" value="export">
<input type="hidden" name="selected_exam" id="selected_exam">
<input type="hidden" name="selected_student_email" id="selected_student_email">
<input type="hidden" name="pdf_content" id="pdf_content">


<input type="submit" value="Export To PDF" class="smallbluebtn" id="submit_pdf" onclick="return setFormValues()">

<?php $this->endWidget(); ?> 
<?php */?>

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Student Code</label>';

    echo '<input type="text" id="product_search" data-provide="typeahead">';
    echo '<input type="button" id="find_course" value="Find" class="btn" onclick="findCourse(),resetRenderView()">';


//    echo '<div class="controls">' . CHtml::dropDownList('student_id', '', CHtml::listData(Student::model()->findAll(), 'student_id', 'student_id'), array(
//        'prompt' => 'Select Student ID',
//        'class' => 'form-control',
//        'ajax' => array(
//            'data' => array('student_id' => 'js:student_id.value'),
//            'type' => 'POST',
//            'url' => CController::createUrl('Take/getExamIdsforStudentId'),
//            'update' => '#exam_id',
//        )
//    )) . '</div>';
    ?> 

</div>

<div class="control-group">
    <?php
    echo 'Exam';
    echo '<br>';
    echo CHtml::dropDownList('exam_id', '', array(), array(
        'prompt' => 'Select Exam',
        'id' => 'exam_id',
        'ajax' => array(
            'data' => array('student_email' => 'js:product_search.value',
                'exam_id' => 'js:exam_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Take/getPaperForTakeIds'),
            'update' => '#paper',
        )
    ));
    ?>         
</div>

<div class="control-group">
    <input type="button" id="btnExport" value="Export to Excel" onClick ="$('#paper_questions').tableExport({type:'excel',escape:'false'});">
    <!--<input type="button" value="Export to Excel">-->
</div>

<div class="control-group" id="paper">

</div>

<script type="text/javascript">

    function resetRenderView(){ 
        if(document.getElementById("paper").innerHTML.replace(/^\s*/, "").replace(/\s*$/, "") != "") {
            $.ajax({
                url:'<?php echo CController::createUrl('Result/renderBlank'); ?>',
                type: 'POST', //request type
                dataType: 'json',
                data:{
                    //question_id:question_id
                },          
                success: function(data){
                    $("#exam_id option:eq(0)").attr("selected","selected");
                    $('#paper').html(data.output);
                }
            });
        }
    }

</script>


