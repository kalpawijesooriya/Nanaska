<script>
    function submitForm() {
        var error=validateLectureCreateForm();
        
        if(error==0){
            document.getElementById('lecturer-form').submit();
        }
    }
    
    function validateLectureCreateForm(){
        var error=0;
        var course_id_obj=document.getElementById('course_id');
        var level_id_obj=document.getElementById('level_id');
        var subject_obj=document.getElementById('subject');
        var selected_subject_obj=document.getElementById('subjects');
        
        
        if(course_id_obj.selectedIndex!=0){
            if(level_id_obj.selectedIndex==0){
                error=1;
                hightlightTextBox('level_id');
            }
            if(subject_obj.selectedIndex==0){
                error=1;
                hightlightTextBox('subject');
            }
            if(selected_subject_obj.length==0){
                error=1;
                hightlightTextBox('subjects');
            }
        }
        
        return error;   
    }
    
    function hightlightTextBox(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "Red";
        
        var objError = document.getElementById(id+"_error");
        objError.style.display="block";
    }

    function removeHighlight(id) {
        var objTXT = document.getElementById(id);
        objTXT.style.borderColor = "";
        
        var objError = document.getElementById(id+"_error");
        objError.style.display="none";
    }
    
    function removeHighlightSubjects() {
        var selected_subject_obj=document.getElementById('subjects');
        if(selected_subject_obj.length!=0){
            removeHighlight('subjects')
        }
    }

</script>