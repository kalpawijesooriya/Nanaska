<div class="control-group"> 
    <?php
    $essayType = EssayQuestion::model()->findByAttributes(array('question_id' => $question_id));
    if (isset($essayType)) {
        $essayType = $essayType->essay_type . "_TYPE";

        echo 'Essay Type <span class="asterix">*</span>';
        echo '<br>';
        echo CHtml::dropDownList('essay_type', '', array(
            '' => 'Select Essay question Type',
            'NORMAL_TYPE' => 'Normal Essay Question',
            'EMAIL_TYPE' => 'Email Essay Question'
                ), array(
            'options' => array($essayType => array('selected' => true)),
            'style' => 'pointer-events:none; curser:default;',
            'class' => 'form-control',
            'ajax' => array(
                'type' => 'POST', //request type
                'data' => array('essay_type' => 'js:this.value'),
                'url' => CController::createUrl('Question/getEssayType'),
                'update' => '#essay-type-row',
            )
        ));
    }
    ?>   </div>

<br />

<hr class="hrstyle" style="margin-left: 00px;"></hr>

<?php
if ($essayType == "EMAIL_TYPE") {
    $emailHeaderDetail = EmailEssayHeader::model()->getEmailEssayHeaderDetailsByQuestionId($question_id);

    if (!empty($emailHeaderDetail)) {
        ?>
        <br />  <br />
        <div class="span8">
            <div class="well">
                <h2 class="light_heading">Email information</h2>
                <br />

                <div class="row">
                    <div class="span1" style="float: left"> From :</div> <div class="span2"><input type="text" id="email_from" name="email_from" placeholder="From" value="<?php echo is_null($emailHeaderDetail['from_field']) ? "" : $emailHeaderDetail['from_field'] ?>" /></div>
                    <div class="span3" style="margin-left: 100px;"><p id="error_email_from" style="color: red"></p></div> 
                </div>
                <br />
                <div class="row">
                    <div class="span1" style="float: left"> To :</div> <div class="span2"><input type="text" id="email_to" name="email_to" placeholder="To" value="<?php echo is_null($emailHeaderDetail['to_field']) ? "" : $emailHeaderDetail['to_field'] ?>" /></div>
                    <div class="span3" style="margin-left: 100px;"><p id="error_email_to" style="color: red"></p></div> 
                </div>
                <br />
                <div class="row">
                    <div class="span1" style="float: left">Cc :</div> <div class="span2"><input type="text" id="email_cc" name="email_cc" placeholder="Cc" value="<?php echo is_null($emailHeaderDetail['cc_field']) ? "" : $emailHeaderDetail['cc_field'] ?>" /></div>
                    <div class="span3" style="margin-left: 100px;"><p id="error_email_cc" style="color: red"></p></div> 
                </div>
                <br />
                <div class="row">
                    <div class="span1" style="float: left">Subject :</div> <div class="span2"><input type="text" id="email_subject" name="email_subject" placeholder="Subject" value="<?php echo is_null($emailHeaderDetail['subject_field']) ? "" : $emailHeaderDetail['subject_field'] ?>" /></div>
                    <div class="span3" style="margin-left: 100px;"><p id="error_email_subject" style="color: red"></p></div> 
                </div>
            </div>
        </div>

        <?php
    }
}
?>

<script type="text/javascript">
    function validateEmailEssay() {
        var error = 0;
        var select_essay_type = document.getElementById("essay_type");
        var selectvalue_qt = select_essay_type.options[select_essay_type.selectedIndex].value;
      
        if (selectvalue_qt == "EMAIL_TYPE") {
            var from_element = document.getElementById("email_from");
            var to_element = document.getElementById("email_to");
            var subject_element = document.getElementById("email_subject");            
            
            if(from_element.value==""){
                error=1;
                from_element.style.borderColor="red";
            }else if(!validateEmail(from_element.value)){
                error=1;
                document.getElementById("error_email_from").innerHTML="Please enter a valid email";
                from_element.style.borderColor="red";
            }            
            else{
                from_element.style.borderColor="#cccccc";
            }
            
            if(to_element.value==""){
                error=1;
                to_element.style.borderColor="red";
            }else if(!validateEmail(to_element.value)){
                error=1;
                document.getElementById("error_email_to").innerHTML="Please enter a valid email";
                to_element.style.borderColor="red";
            }  
            else{
                to_element.style.borderColor="#cccccc";
            }
            if (subject_element.value == "") {
                error = 1;
                subject_element.style.borderColor = "red";
            } else {
                subject_element.style.borderColor = "#cccccc";
            }
        }

        if (error == 1) {
            return false;
        } else {
            return true;
        }


    }
   
   
    function validateEmail(email){
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
</script>


