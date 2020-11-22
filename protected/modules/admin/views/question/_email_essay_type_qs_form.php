<br />
<div class="span8">
    <div class="well">
        <h2 class="light_heading">Email information</h2>
        <br />

        <div class="row">
            <div class="span1" style="float: left"> From : <span class="asterix">*</span></div> <div class="span2"><input type="text" id="email_from" name="email_from" placeholder="From" /></div>
            <div class="span3" style="margin-left: 100px;"><p id="error_email_from" style="color: red"></p></div> 
        </div>
        <br />


        <div class="row">
            <div class="span1" style="float: left"> To : <span class="asterix">*</span></div> <div class="span2"><input type="text" id="email_to" name="email_to" placeholder="To" /></div>
            <div class="span3" style="margin-left: 100px;"><p id="error_email_to" style="color: red"></p></div> 
        </div>

        <br />
        <div class="row">
            <div class="span1" style="float: left">Cc : </div><div class="span2"> <input type="text" id="email_cc" name="email_cc" placeholder="Cc" /></div>
            <div class="span3" style="margin-left: 100px;"><p id="error_email_cc" style="color: red"></p></div> 
        </div>
        <br />
        <div class="row">
            <div class="span1" style="float: left">Subject : <span class="asterix">*</span></div> <div class="span2"><input type="text" id="email_subject" name="email_subject" placeholder="Subject" /></div>    
            <div class="span3" style="margin-left: 100px;"><p id="error_email_subject" style="color: red"></p></div> 
        </div>
    </div>
</div>


<script type="text/javascript">
    function validateEmailEssay(){
        var error=0;
        var select_essay_type = document.getElementById("essay_type");
        var selectvalue_qt = select_essay_type.options[select_essay_type.selectedIndex].value;
        if(selectvalue_qt=="EMAIL_TYPE"){
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
            
            if(subject_element.value==""){
                error=1;
                subject_element.style.borderColor="red";
            }else{
                subject_element.style.borderColor="#cccccc";
            }
        }    
        
        if(error==1){
            return false;
        }else{
            return true;
        }
        
        
    };
    
    
    function validateEmail(email){
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
</script>
