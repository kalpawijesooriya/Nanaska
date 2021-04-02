<?php
$single_answer_data = Answer::getQuestionPartsforQuestionView($id);
?>

<h4>Type answers for the Single answer question</h4>
<table class="table">
    <?php
    $count = 0;
    $text_count = 0;
    $image_count = 0;

    foreach ($single_answer_data as $single_answer) {

        echo '<tr id=' . $count . '>';
        if ($single_answer->image_answer == NULL) {
            echo '<input type="hidden" name="text_answer_edit" value="1">';
           // echo '<td><input type="text" id="txt_' . $count . '" name="answer[' . $single_answer->answer_text_id . ']" value="' . AnswerText::getAnswerTextById($single_answer->answer_text_id) . '" /></td>';
            echo '<td><textarea id="txt_' . $count . '" name="answer[' . $single_answer->answer_text_id . ']">' . AnswerText::getAnswerTextById($single_answer->answer_text_id) . '</textarea></td>';
            if ($single_answer->is_correct == 1) {
                echo '<td><input type="checkbox" id="acheck_' . $count . '" name="correct[' . $count . ']" checked="checked" class="text_answer_check"></td>';
                echo "<td><input type='button' class='greybtn' value='Delete' onclick='RemoveAnswer($single_answer->answer_text_id, $count)' /></td>";
            } else {
                echo '<td><input type="checkbox" id="acheck_' . $count . '" name="correct[' . $count . ']" class="text_answer_check"></td>';
                echo "<td><input type='button' class='greybtn' value='Delete' onclick='RemoveAnswer($single_answer->answer_text_id, $count)' /></td>";
            }

            $text_count++;
        } else {
            echo '<input type="hidden" name="image_answer_edit" value="1">';
            echo '<td><input type="hidden" id="imgfile_' . $count . '" name="imageanswer[' . $single_answer->answer_id . ']" value=' . $single_answer->image_answer . ' />' . CHtml::image(Yii::app()->request->baseUrl . '/images/single_answer_images/' . $single_answer->image_answer, "", array("width" => "200px", "height" => "72px")) . '</td>';
            if ($single_answer->is_correct == 1) {
                echo '<td><input type="checkbox" id="imgch_' . $count . '" name="correctimg[' . $single_answer->answer_id . ']" checked="checked" class="image_answer_check"></td>';
                echo "<td><input type='button' class='greybtn' value='Delete' onclick='RemoveAnswer($single_answer->answer_id, $count)' /></td>";
            } else {
                echo '<td><input type="checkbox" id="imgch_' . $count . '" name="correctimg[' . $single_answer->answer_id . ']" class="image_answer_check"></td>';
                echo "<td><input type='button' class='greybtn' value='Delete' onclick='RemoveAnswer($single_answer->answer_id, $count)' /></td>";
            }
            $image_count++;
        }
        echo '</tr>';
        $count++;
    }
    ?>

</table>

<?php
$image_answer_data = Answer::getImageAnswers($id);
if ($image_answer_data != null) {
    foreach ($image_answer_data as $image) {
        $img = $image;
    }
} else {
    ?>
    <input type="hidden" name="text_answer_edit" value="1"><input type="hidden" name="image_answer_edit" value="1">
    <table id="text-answer-table">
        <tr id="first_tr"><td><input type="button" class="add bluebtn" value="Add Text" /></td></tr>    
    </table>
    <table id="image-answer-table">
        <tr id="first_trimg"><td><input type="button" class="addimg bluebtn" value="Add image" /></td></tr>    
    </table>
<?php }
?>

<?php
if ($image_count > 0 && $text_count > 0) {
    ?>
    <table id="text-answer-table">
        <tr id="first_tr"><td><input type="button" class="add bluebtn" value="Add Text" /></td></tr>    
    </table>
    <table id="image-answer-table">
        <tr id="first_trimg"><td><input type="button" class="addimg bluebtn" value="Add image" /></td></tr>    
    </table>
    <?php
} else if ($image_count > 0) {
    ?>

    <table id="image-answer-table">
        <tr id="first_trimg"><td><input type="button" class="addimg bluebtn" value="Add image" /></td></tr>    
    </table>

    <?php
} else if ($text_count > 0) {
    ?>

    <table id="text-answer-table">
        <tr id="first_tr"><td><input type="button" class="add bluebtn" value="Add more" /></td></tr>    
    </table>

<?php } ?>


<script type="text/javascript">
    
    var deletedImageAnswer = new Array();
    var j=0;
    function RemoveAnswer(ans_id, count)
    { 
       
        $("#removed_answers").append('<input type="hidden" name="deleted_answer['+count+']"  value="' + ans_id +'"/>');
        document.getElementById(count).style.display = "none";
        $("#acheck_"+count).attr("checked",false);
        $("#imgch_"+count).attr("checked",false);
        deletedImageAnswer[j] = count;        
        j++;       
    }
    
</script>

<script type="text/javascript">
    var a = 0;
    var k= 0;
    var ccount = <?php echo count($single_answer_data); ?>;
    $(document).ready(function(){    
            
        $('.del').on('click',function(){
            $(this).parent().parent().remove();
        });

        $('.add').on('click',function(){
            $("#first_tr").hide();
            $(this).val('Delete Answer');
            $(this).attr('class','del');
            var appendTxt = "<tr><td><textarea id='txt_"+ccount+"' name='newanswer[]' /></td> <td><input type='checkbox' name='newcorrect["+a+"]' id='acheck_"+ccount+"' class='text_answer_check'></td> <td><input type='button' class='add' value='Add More' class='btn'/></td></tr>";
                                         
            $("#text-answer-table tr:last").after(appendTxt);
            ccount++;
            a++;
        });

        $('.delimg').on('click',function(){
            $(this).parent().parent().remove();
        });

        $('.addimg').on('click',function(){
            $("#first_trimg").hide();
            $(this).val('Delete Answer');
            $(this).attr('class','delimg');
            var appendTxt = "<tr><td><input type='file' id='imgfile_"+ccount+"' name='newimageanswer[]' /></td> <td><input type='checkbox' name='imgcorrect["+k+"]' id='imgch_"+ccount+"' class='image_answer_check'></td> <td><input type='button' class='addimg' value='Add image' class='btn'/></td></tr>";
                                         
            $("#image-answer-table tr:last").after(appendTxt);
            ccount++;
            k++;
        });   
                
    });

</script>


<script type="text/javascript">
    
    var lastCount = <?php echo count($single_answer_data); ?>;
    
    function checkSingleAnswer(){
        var addedTextBox=0;   // answer text box count  
        var addedImage = 0;   //answer image count
        var emptyTxtBox = 0;   
        var errortextBox = 0;
        var errorCheckBox = 0;
        var isText=0;
        var countCheckBoxValue = 0;
        var countImageCheckBox = 0;
        
        $('input[name^="answer"]').each(function() { 
            addedTextBox++;
        });
        
        $('textarea[name^="answer"]').each(function() { 
            addedTextBox++;
        });
        
        $('input[name^="imageanswer"]').each(function() { 
            addedImage++;
        }); 
        
        if(addedTextBox>0 && addedImage==0){
            isText=0;
            emptyTxtBox = validateTextAns(addedTextBox,emptyTxtBox);   
        }else if(addedTextBox==0 && addedImage>0){
            isText=1;
            emptyTxtBox = validateImgAnswers(addedTextBox,emptyTxtBox);
        }else{
            emptyTxtBox = validateTextAns(addedTextBox,emptyTxtBox);
            emptyTxtBox = validateImgAnswers(addedTextBox,emptyTxtBox);
            isText=2;
        }  
        
        if(emptyTxtBox==0){
            errortextBox=1;
            alert("Please enter answers");
        }        
     
        if(isText==0){
            countCheckBoxValue = vaidateTextCheckBox(countCheckBoxValue);   
           
            if(emptyTxtBox != 0){       
                if(countCheckBoxValue == 0){
                    alert("You have not marked any correct answers");
                    errorCheckBox=1;            
                }else if(countCheckBoxValue == 1){
                    errorCheckBox=0;            
                }else{
                    errorCheckBox=1;
                    alert("You have marked more than one correct answer");             
                }        
            }
            
        }else if(isText==1){ 
           
            countCheckBoxValue = validateImageCheckBox(countCheckBoxValue);  
            
            if(emptyTxtBox != 0){       
                if(countCheckBoxValue == 0){
                    alert("You have not marked any correct answers");
                    errorCheckBox=1;            
                }else if(countCheckBoxValue == 1){
                    errorCheckBox=0;            
                }else{
                    errorCheckBox=1;
                    alert("You have marked more than one correct answer");             
                }        
            }
        }else{          
         
            countCheckBoxValue = vaidateTextCheckBox(countCheckBoxValue);            
            countImageCheckBox = validateImageCheckBox(countImageCheckBox);
            
            if(emptyTxtBox != 0){       
                if(countCheckBoxValue == 0 && countImageCheckBox==0){
                    alert("You have not marked any correct answers");
                    errorCheckBox=1;            
                }else if(countCheckBoxValue == 1 && countImageCheckBox==0){
                    errorCheckBox=0;            
                }else if(countCheckBoxValue == 0 && countImageCheckBox==1){
                    errorCheckBox=0;
                              
                }else{
                    errorCheckBox=1;
                    alert("You have marked more than one correct answer");   
                }        
            }            
        }       
       
       
        
        if(errortextBox==1 || errorCheckBox==1){
            return false;
        }else{
            return true;
        }
    }
    
    
    function validateTextAns(addedTextBox,emptyTxtBox){     
        addedTextBox = a + lastCount ;
        if(deletedImageAnswer[0] ===undefined){           
            for(k=0;k<addedTextBox;k++){ 
                if(document.getElementById("txt_"+k)!=null){                
                    if(document.getElementById("txt_"+k).value != ""){
                        emptyTxtBox++;
                    } 
                }
            }
        }else{
            var  deleteCount = deletedImageAnswer.length;            
            if(deleteCount==lastCount){
                for(k=0; k<a;k++){
                    lastCount = lastCount + k;
                    if(document.getElementById("txt_"+(lastCount)).value != ""){ 
                        emptyTxtBox++;
                    }
                }
            }else{
                for(k=0;k<addedTextBox;k++){ 
                    if(document.getElementById("txt_"+k)!=null){                
                        if(document.getElementById("txt_"+k).value != ""){
                            emptyTxtBox++;
                        } 
                    }
                }
            }
        } 
        return emptyTxtBox;
    }
    
    function validateImgAnswers(addedImage,emptyTxtBox){
        addedImage = a + lastCount ;
         
        if(deletedImageAnswer[0] ===undefined){
            for(k=0;k<addedImage;k++){ 
                if(document.getElementById("imgfile_"+k)!=null){                
                    if(document.getElementById("imgfile_"+k).value != ""){
                        emptyTxtBox++;
                    } 
                }
            }
        }else{
            var  deleteCount = deletedImageAnswer.length; 
            if(deleteCount==lastCount){
                for(k=0; k<a;k++){
                    lastCount = lastCount + k;
                    if(document.getElementById("imgfile_"+(lastCount)).value != ""){ 
                        emptyTxtBox++;
                    }
                }
            }else{
                for(k=0;k<addedImage;k++){ 
                    if(document.getElementById("imgfile_"+k)!=null){                
                        if(document.getElementById("imgfile_"+k).value != ""){
                            emptyTxtBox++;
                        } 
                    }
                }
            }
            
        }  
        return emptyTxtBox;
    }
    
</script>

<script type="text/javascript">
    function vaidateTextCheckBox(countCheckBoxValue){
        
        $('input.text_answer_check:checkbox').each(function() {
           
            var checkboxValue = $(this).prop('checked');
           
            if(checkboxValue == true){
                countCheckBoxValue++;
            }           
        });
        
        return countCheckBoxValue;
    }
</script>


<script type="text/javascript">
    function validateImageCheckBox(countImageCheckBox){        
        $('input.image_answer_check:checkbox').each(function() {
           
            var checkboxValue = $(this).prop('checked');
           
            if(checkboxValue == true){
                countImageCheckBox++;
            }           
        });
        
        return countImageCheckBox;
    }
</script>