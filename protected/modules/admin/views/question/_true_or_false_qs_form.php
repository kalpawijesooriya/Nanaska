<?php ?>
<br/>

<div class="well span9 no-left-margin">

    <h4 class="light_heading">Select Answer</h4><br/>

    <?php
    if ($is_true == null) {
        ?>
        <input type="radio" id="answer1" name="answer" value="true"/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" id="answer2" name="answer" value="false"/>&nbsp;&nbsp;False
        <?php
    } else {
        if ($is_true == 1) {
            ?>
            <input type="radio" id="answer1" name="answer" value="true" checked=""/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="answer2" name="answer" value="false"/>&nbsp;&nbsp;False
            <?php
        } else if ($is_true == 0) {
            ?>
            <input type="radio" id="answer1" name="answer" value="true"/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="answer2" name="answer" value="false" checked=""/>&nbsp;&nbsp;False
            <?php
        } else if ($is_true == 3) {
            ?>
            <input type="radio" id="answer1" name="answer" value="true"/>&nbsp;&nbsp;True &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="answer2" name="answer" value="false"/>&nbsp;&nbsp;False
            <?php
        }
    }
    ?>
    <br/>
    
    
</div>
<div class="span8 no-left-margin" id="trueFalseErrorDisplayRow" style="display:none">
        <label id="trueFalseErrorDisplay" class="error"></label>
</div>
<br/>
<script type="text/javascript">
        function checkTrueFalse(){            
                       
            var radioBtn1 = document.getElementById("answer1");
            var radioBtn2 = document.getElementById("answer2");
            if(radioBtn1.checked || radioBtn2.checked){
                return true;
            }else{
                document.getElementById("trueFalseErrorDisplay").innerHTML="Please enter the answer";
                document.getElementById("trueFalseErrorDisplayRow").style.display="block";
                return false;
            }
            
            
        }
    
</script>