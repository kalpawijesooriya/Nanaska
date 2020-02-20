<style>
    #dynamicexam-form label.error{
        color: #B40404;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Student Exams',
);

$this->menu = array(
//	array('label'=>'Create StudentExam','url'=>array('create')),
//        array('label' => 'View Student', 'url' => array('student/view', 'id' => $id)),
//	array('label'=>'Manage StudentExam','url'=>array('admin')),
    array('label' => 'Add Preset Exam', 'url' => array('studentExam/presetexam', 'id' => $id)),
    array('label' => 'Add Essay Exam', 'url' => array('studentExam/essayExam', 'id' => $id)),
        //array('label'=>'Add dynamic exam','url'=>array('dynamicexam')),        
);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => array('studentExam/CreateDynamicexam'),
    'id' => 'dynamicexam-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
    //'class'=>'form-horizontal form-control',
    //'role'=>'form'
    )
        ));
?>

<?php
$student_id = $id;
?>

<?php
$studentDetails = Student::model()->getStudentById($student_id);
$levelDetails = Level::model()->getLevel($studentDetails['level_id']);
$courseDetails = Course::model()->getCourseDetails($levelDetails['course_id']);
?>


<h4>Dynamic Exam for Student Id <?php echo $student_id; ?></h4>

<input type="hidden" value="<?php echo $student_id; ?>" id="student_id" name="student_id" />

<div class="control-group">
    <label class="control-label" for="inputPassword">Course <span class="required">*</span></label>
    <input type="text" id="course_id" value="<?php echo $courseDetails['course_name']; ?>" readonly="true" />

    <?php
//    echo '<label class="control-label" for="inputEmail">Course <span class="required">*</span></label>';
//    echo '<div class="controls">';
//    echo CHtml::dropDownList('course_id', '', CHtml::listData(Course::model()->findAll(), 'course_id', 'course_name'), array(
//        'prompt' => 'Select Course',
//        'ajax' => array(
//            'type' => 'POST', //request type
//            'data' => array('course_id' => 'js:course_id.value'),
//            'url' => CController::createUrl('Level/GetLevelsforStudentCreation'),
//            'update' => '#dynamic_level_id',
//            'beforeSend' => 'function() {  
//                       if(dynamic_subject_id.value!=""){                
//                        dynamic_subject_id.options.length = 1;                                
//                         } 
//
//                }',
//            )));
//    echo '</div>';
    ?> 
    <?php //echo $form->error($model, 'course_id', array('class' => 'alert alert-danger')); ?>
</div>

<div class="control-group">
    <label class="control-label" for="inputPassword">Level <span class="required">*</span></label>
    <input type="text" id="course_id" value="<?php echo $levelDetails['level_name']; ?>" readonly="true" />

    <?php
//    echo '<label class="control-label" for="inputPassword">Level <span class="required">*</span></label>';
//    echo '<div class="controls">';
//    echo CHtml::dropDownList('dynamic_level_id', '', array(), array(
//        'prompt' => 'Select Level',
//        'class' => 'form-control',
//        'ajax' => array(
//            'data' => array('dynamic_level_id' => 'js:dynamic_level_id.value'),
//            'type' => 'POST',
//            'url' => CController::createUrl('Subject/GetSubjectsforDynamicExams'),
//            'update' => '#dynamic_subject_id',
//        )
//    ));
//    echo '</div>';
    ?> 
</div> 

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Subject <span class="required">*</span></label>';
    echo '<div class="controls">';
    echo CHTML::dropDownList('dynamic_subject_id', '', array(), array(
        'prompt' => 'Select Subject',
        'ajax' => array(
            'data' => array('dynamic_subject_id' => 'js:dynamic_subject_id.value'),
            'type' => 'POST',
            'url' => CController::createUrl('Exam/GetDynamicExams'),
            'update' => '#dexams',
        )
    ));
    echo '</div>';
    ?>  
</div>

<div class="control-group">
    <label class="control-label" for="inputPassword">Exam <span class="required">*</span></label>
    <div class="controls">
        <select id="dexams" name="dexams" multiple="multiple" style="width:250px;height:50px;">


        </select>
    </div>
</div>

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">No. Of Papers <span class="required">*</span></label>';
    echo '<div class="controls">';
    echo CHtml::textField('num_of_papers', '', array('placeholder' => 'Add amount of papers'));
    echo '<INPUT type="button" class="btn" id="btn_add_dates" value="Add Dates" onclick="repeat()" />';
    echo '</div>';

    echo '<div id ="error_date"></div>';
    ?>
</div>
<div>

    <table id="adddates">
        <tr id="tr_0" style="display: none">
            <td id="td_left_0">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'startdate_0',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'minDate' => 0,
                    ),
                    'htmlOptions' => array(
                        'class' => 'date',
                        'style' => 'height:20px;',
                        'id' => 'startdate_0',
                        'placeholder' => 'Select Starting Date'
                    ),
                ));
                ?>
            </td>

            <td id="td_right_0">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'expiredate)0',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'minDate' => 0,
                    ),
                    'htmlOptions' => array(
                        'class' => 'date',
                        'style' => 'height:20px;',
                        'id' => 'expiredate_0',
                        'placeholder' => 'Select Expiry Date'
                    ),
                ));
                ?>
            </td>    
        </tr>

    </table>

</div>

<div class="control-groupx">


</div>
<span class="exp">

</span>

<?php
echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button button-news', 'id' => 'bttsubmit', 'onclick' => 'return dynamicsubmit()'));
?>


<?php $this->endWidget(); ?>


<script type="text/javascript">
    $(document).ready(function() {
        findSubjects();   //for typeahead
    })
    
    
    function findSubjects(){    
       
        $.ajax({
            url:'<?php echo CController::createUrl('Subject/getSubjectsForPresetExam'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data:{
                level_id:<?php echo $levelDetails['level_id']; ?>
            },
            success: function(data){
                if(data.status=="success"){                        
                    var arr = new Array();
                    arr = data.subjectDetails;
                    var lenght = arr.length;
                    for(i=0; i< lenght;i++){                          
                        $('#dynamic_subject_id').append($(data.subjectDetails[i]));
                    } 
                }
            }
        });
    }
        

</script>

<script type="text/javascript">

    $('.del').live('click',function(){
        $(this).parent().parent().remove();
    });
 
    var m = 0;
    var validated = false;
    function repeat()
    {
        
        var text_box_val = document.getElementById('num_of_papers').value;
        var text_box_count = Number(text_box_val);
        if(text_box_count > 0){
            validated = true;
            removeHighlight('num_of_papers');
        }else{
            hightlightTextBox('num_of_papers');
        }
        
        if(m < text_box_count){
            for(var i=m+1;i<=text_box_count;i++)
            {
                addDates(i); 
            }
            m = text_box_count;

        } else if(m > text_box_count){

            for(var i= Number(text_box_count)+1;i<=m;i++)
            {

                removeDates(i); 
            }
            m = text_box_count;
        }
        
        
    
    }
    
    function addDates(i)
    {
        
        
        var clone = $('#tr_0').clone().attr('id', 'tr_'+i);
        clone.find('[id=td_left_0]').attr('id', 'td_left_'+i);
        clone.find('[id=td_right_0]').attr('id', 'td_right_'+i);
        clone.find('[id=startdate_0]').attr('name', 'startdate[]');
        clone.find('[id=startdate_0]').attr('id', 'startdate_'+i);
        clone.find('[id=expiredate_0]').attr('name', 'expiredate[]');
        clone.find('[id=expiredate_0]').attr('id', 'expiredate_'+i); 
        $('#adddates').append(clone);
        
        clone.find('.date').each(function() {
            $(this).removeClass('hasDatepicker'); // added the removeClass part.
            $('.date').datepicker({minDate: 0});
        });
        
        clone.show();
        
        //$("#adddates").append('<tr><td><input type="date" class="getdate" id="getdate" name="start_date[]" placeholder="add exam start date"></td><td><input type="date" class="getdate" name="expiry_date[]" placeholder="add exam expiry date"></td><td><input type="button" value="Delete" class="del"></td></tr>'); 
    }
    function removeDates(i){
        
        $('#tr_'+i).remove();
        
    }
    
</script>

<script>
    $(function() { 
        $.validator.addMethod("greaterThan", 
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params).val());
            }
            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
            
        },'Must be greater than {0}.');  
  
        // Setup form validation on the #register-form element
        $("#dynamicexam-form").validate({     //main form id
    
            // Specify the validation rules
            rules: {
                course_id: "required",		//field ids
                dynamic_level_id: "required",
                dynamic_subject_id: "required",
                dexams: "required",
                num_of_papers:{
                    required:true,
                    number: true
                    
                },
            
                'start_date[]':{
                    required:true
                },
                'expiry_date[]':{
                    required:true,
                    greaterThan: "#getdate"              
                }  
            
            },
        
            // Specify the validation error messages
            messages: {
                course_id: "Please select a course",		//field ids
                dynamic_level_id: "Please select level",
                dynamic_subject_id: "Please select subject",
                dexams: "Please select an exam",
                num_of_papers:{
                    required:"Please enter no of papers",
                    number: "Please enter a number"
                    
                },
                'start_date[]':"Please enter start date of exam",
                'expiry_date[]':
                    { 
                    required:"Please enter expire date of exam",
                    greaterThan:"Exam end date should be greater than exam start date"
                }
            },
            
            submitHandler: function(form) {                
                form.submit();                
            }
            
        });
        
        $('#adddates').find('.date').each(function() {
            $(this).removeClass('hasDatepicker'); // added the removeClass part.
            $('.date').datepicker({minDate: 0});
        });
    
    });

</script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/ajax_validation/ajaxvalidation.js"></script>


<script type="text/javascript">
    function dynamicsubmit(){
        if(validated){
            var validCondition =true;
            for(var i = 1; i<=m; i++){

                removeHighlight('startdate_'+i);          
                removeHighlight('expiredate_'+i);      
            }
            for(var i = 1; i<=m; i++){
                if(document.getElementById('startdate_'+i).value == null || document.getElementById('startdate_'+i).value == ""){
                    validCondition = false;
                    break;
                }
                if(document.getElementById('expiredate_'+i).value == null || document.getElementById('expiredate_'+i).value == ""){
                    validCondition = false;
                    break;
                }
            }
            //        if(validCondition==false){
            //            if(document.getElementById("getdate")==null){
            //                alert("Please add dates for dynamic exams");
            //                $('#btn_add_dates').css('border-size', '1px');
            //                $('#btn_add_dates').css('border-color', '#B40404');            
            //                validCondition =false;
            //                return false;
            //            }else{
            //                return true;
            //            }
            //        }else{
            //            validCondition = true;
            //            return true;
            //             
            //        }
            if(!validCondition){
                for(var i = 1; i<=m; i++){
                    if(document.getElementById('startdate_'+i).value == null || document.getElementById('startdate_'+i).value == ""){
                        hightlightTextBox('startdate_'+i);

                    }
                    if(document.getElementById('expiredate_'+i).value == null || document.getElementById('expiredate_'+i).value == ""){
                        hightlightTextBox('expiredate_'+i);

                    }
                }
            }
            if(validCondition){
                for(var i = 1; i<=m; i++){
                    if(document.getElementById('startdate_'+i).value > document.getElementById('expiredate_'+i).value){
                        hightlightTextBox('startdate_'+i);
                        hightlightTextBox('expiredate_'+i);
                        validCondition = false;
                    }

                }
            }

            return validCondition;
        }else{
            if(document.getElementById('num_of_papers').value==null || document.getElementById('num_of_papers').value==""){
                return true;
            }else{
                return false;
            }
           
        }
    }

</script>
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

