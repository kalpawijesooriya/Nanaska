<h4>Add answers for Multiple answer questions</h4>
<div class="span2">
    <input type="checkbox" id="text_answer1" value="text_answer1" name="single_answer" class="checkbox-margined"><span id="answercheck-text">Text Answers</span>
</div>
<div class="span2">
    <input type="checkbox" id="image_answer1" value="image_answer1" name="single_answer" class="checkbox-margined"><span id="answercheck-text">Image Answers</span>
</div>
<div class="span2">
    <input type="checkbox" id="both" value="both" name="single_answer" class="checkbox-margined"><span id="answercheck-text">Both</span>
</div>
<br/>
<div id="text-answer" class="span5" style="margin-left: 0px;">
    <table id="options-table" class="table"> 
        <tr id="tr_0" class="span5" style="margin-left: 0px;">
            <td><textarea id="txt_0"  name="answer[]" /></td>
            <td><input type="checkbox" name="correct[0]" id="acheck_0"></td>                        
            <td><input type="button" class="del" value='Delete Answer' class="btn" onclick="deleteAnswer('tr_0','txt_0')"/></td>
        </tr>                  
        <tr id="tr_1" class="span5" style="margin-left: 0px;">
            <td><textarea id="txt_1"  name="answer[]" /></td>
            <td><input type="checkbox" name="correct[1]" id="acheck_1"></td>
            <td><input type="button" class="addm" value="Add Answer" class="btn"/></td>
        </tr>
    </table>
</div>

<div id="image-answer" class="span5" style="margin-left: 0px;">
    <table id="image-answer-table" class="table">
        <tr id="imgtr_0" class="span5" style="margin-left: 0px;">
            <td><input type="file" id="imgfile_0"   name="imageanswer[]" style="width: 220px;"/></td>
            <td><input type="checkbox" name="correctimg[0]" id="imgch_0"></td>                        
             <td><input type="button" class='imgdel' value='Delete Answer' onclick="deleteImageAnswers('imgtr_0','imgfile_0')" class="btn"/></td>
        </tr>                  
        <tr id="imgtr_1" class="span5" style="margin-left: 0px;">
            <td><input type="file" id="imgfile_1"  name="imageanswer[]" style="width: 220px;"/></td>
            <td><input type="checkbox" name="correctimg[1]" id="imgch_1"></td>
            <td><input type="button" class="imgaddm" value="Add Answer" class="btn"/></td>
        </tr>
    </table>
    <div id="deleted_images"><input type="hidden" name="deleted_img[]" value="dummy_value"></div>
</div>

<script type="text/javascript">
    
    var deletedImageAnswer = new Array();
    var imageCount=0;
    
    $(document).ready(function(){
        $('#image-answer').hide();
       
        $("#text_answer1").attr("checked",true);
        
        $('input:checkbox[name=single_answer]').click(function() 
        {    
            if($(this).is(':checked'))
                if($(this).val() == 'text_answer1')
            {
                $("#both").attr("checked",false);
                $("#image_answer1").attr("checked",false);
                $('#image-answer').hide();
                $('#text-answer').show();
                
                $('input[name^="correct"]').each(function() {  
                    $(this).attr("checked",false);
                })
                

            }
            else if($(this).val() == 'image_answer1')
            {
                $("#text_answer1").attr("checked",false);
                $("#both").attr("checked",false);
                $('#image-answer').show();
                $('#text-answer').hide();
                
                $('input[name^="correct"]').each(function() {  
                    $(this).attr("checked",false);
                })

            }
            else if($(this).val() == 'both')
            {
                $("#text_answer1").attr("checked",false);
                $("#image_answer1").attr("checked",false);
                $('#image-answer').show();
                $('#text-answer').show();
                
                $('input[name^="correct"]').each(function() {  
                    $(this).attr("checked",false);
                })
            }
        });
        
        
    });
    
    function deleteAnswer(tr,txt)
    {
        document.getElementById(txt).value = '';
        document.getElementById(tr).style.display = "none";       
    }
    
    function deleteImageAnswers(imgtr,imgfile)
    {   
        var value = document.getElementById(imgfile).files[0].name;
        //var value = document.getElementById(imgfile).value;
        $('#deleted_images').append('<input type="hidden" name="deleted_img[]" value="'+value+'">');
        document.getElementById(imgtr).style.display = "none";
        
        var substr = imgfile.substr(8);
        $("#imgch_"+substr).attr("checked",false);
        deletedImageAnswer[imageCount] = substr;
        imageCount++;
    }
    
    //    $('.imgdel').live('click',function(){
    //        $(this).parent().parent().hide();
    //    });
    
    
</script> 

<script type="text/javascript">
    function checkMultipleAnswer(){
        var addedTextBox=0;   // answer text box count  
        var addedImage = 0;   //answer image count
        var emptyTxtBox = 0;   
        var errortextBox = 0;
        var errorCheckBox = 0; 
        
        
        $('textarea[name^="answer"]').each(function() { 
            addedTextBox++;
        });
        
        $('input[name^="imageanswer"]').each(function() { 
            addedImage++;
        });
        
        var textAnswerCheckBox = document.getElementById("text_answer1").checked;       
        var bothCheckBox = document.getElementById("both").checked;
        
        if(textAnswerCheckBox==true){ 
           
            emptyTxtBox= validateTextAns(addedTextBox,emptyTxtBox);
            
        }else if(bothCheckBox==true){
            emptyTxtBox= validateTextAns(addedTextBox,emptyTxtBox);            
            emptyTxtBox = validateImgAnswers(addedImage,emptyTxtBox);            
        }        
        else{ 
            emptyTxtBox = validateImgAnswers(addedImage,emptyTxtBox);
        }
        
        if(emptyTxtBox==0){
            errortextBox=1;
            alert("Please enter answers");
        }        
     
        var countCheckBoxValue = 0;
        $('input[name^="correct"]').each(function() {            
            var checkboxValue = $(this).prop('checked');
           
            if(checkboxValue == true){
                countCheckBoxValue++;
            }           
        });
        
        if(emptyTxtBox != 0){       
            if(countCheckBoxValue == 0){
                alert("You have not marked any correct answers");
                errorCheckBox=1;            
            }
            //            else if(countCheckBoxValue == 1){
            //                errorCheckBox=0;            
            //            }
            else{
                errorCheckBox=0;
                // alert("You have marked more than one correct answer");             
            }        
        }
        
        if(errortextBox==1 || errorCheckBox==1){
            return false;
        }else{
            return true;
        }       
    }
    
    function validateTextAns(addedTextBox,emptyTxtBox){ 
        for(k=0;k<addedTextBox;k++){ 
            if(document.getElementById("txt_"+k)!=null){                
                if(document.getElementById("txt_"+k).value != ""){
                    emptyTxtBox++;
                } 
            }
        }
        return emptyTxtBox;
    }
    
    function validateImgAnswers(addedImage,emptyTxtBox){
        if(deletedImageAnswer[0] ===undefined){     //if any answer not been deleted
            for(k=0;k<addedImage;k++){                
                if(document.getElementById("imgfile_"+k)!=null){              
                    if(document.getElementById("imgfile_"+k).value != ""){                                
                        emptyTxtBox++;
                    }        
                }
            }
        }else{
            for(k=0;k<addedImage;k++){                
                if(document.getElementById("imgfile_"+k)!=null){                    
                    for(m=0; m<deletedImageAnswer.length; m++){                       
                        if(deletedImageAnswer[m] != k){                               
                            if(document.getElementById("imgfile_"+k).value != ""){                                    
                                emptyTxtBox++;
                            }
                        }                        
                    }                    
                }
            }
        }
        
        return emptyTxtBox;
    }
    
    
</script>
