<div class="control-group">
    <br/>
    <strong>Example:</strong><br/><br/>
    <table>
        <tr>
            <td width="100">
        <center>
            8
        </center> 
        </td>
        <td width="100">
        <center>
            =
        </center> 
        </td>
        <td width="120">
        <center>
            5
        </center> 
        </td>
        <td width="100">
        <center>
            +
        </center> 
        </td>
        <td width="100">
        <center>
            4
        </center> 
        </td>
        <td width="100">
        <center>
            -
        </center> 
        </td>
        <td width="100">
        <center>
            1
        </center> 
        </td>
        </tr>
        <tr>
            <td width="100">
        <center>
            <strong>{Result Text}</strong>
        </center> 
        </td>
        <td width="100">
        <center>
            <strong>=</strong>
        </center> 
        </td>
        <td width="120">
        <center>
            <strong>{Question Part}</strong>
        </center> 
        </td>
        <td width="100">
        <center>
            <strong>{Operator 1}</strong>
        </center> 
        </td>
        <td width="100">
        <center>
            <strong>{Answer 1}</strong>
        </center> 
        </td>
        <td width="100">
        <center>
            <strong>{Operator 2}</strong>
        </center> 
        </td>
        <td width="100">
        <center>
            <strong>{Answer 2}</strong>
        </center> 
        </td>
        </tr>
    </table>
</div>

<br/>

<div class="control-group">
    <table>
        <tr>
            <td width="100">
                Result Text
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?> <textarea id="result_text" name="result_text" placeholder="Result Text"><?php echo $result_text ?></textarea><?php
            } else {
                    ?> <textarea id="result_text" name="result_text" placeholder="Result Text"></textarea><?php
            }
                ?>
            </td>
        </tr>
        <tr>
            <td width="100">
                Question Part
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?> <textarea id="question_part" name="question_part" placeholder="Question Part" ><?php echo $question_part ?></textarea><?php
            } else {
                    ?> <textarea id="question_part" name="question_part" placeholder="Question Part"></textarea><?php
            }
                ?>
            </td>
        </tr>
        <tr>
            <td width="100">
                Operator 1
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?> <textarea id="operator_1" name="operator_1" placeholder="Operator 1" ><?php echo $operator_1 ?></textarea><?php
            } else {
                    ?> <textarea id="operator_1" name="operator_1" placeholder="Operator 1"></textarea><?php
            }
                ?>
            </td>
        </tr>
        <tr>
            <td width="100">
                Answer 1
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?><textarea id="answer_1" name="answer_1" placeholder="Answer 1"><?php echo $answer_1 ?></textarea><?php
            } else {
                    ?><textarea id="answer_1" name="answer_1" placeholder="Answer 1"></textarea><?php
            }
                ?>
            </td>
        </tr>
        <tr>
            <td width="100">
                Operator 2
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?> <textarea id="operator_2" name="operator_2" placeholder="Operator 2"><?php echo $operator_2 ?></textarea><?php
            } else {
                    ?> <textarea id="operator_2" name="operator_2" placeholder="Operator 2"></textarea><?php
            }
                ?>
            </td>
        </tr>
        <tr>
            <td width="100">
                Answer 2
            </td>
            <td>
                <?php
                if ($edit != null) {
                    ?><textarea id="answer_2" name="answer_2" placeholder="Answer 2"><?php echo $answer_2 ?></textarea><?php
            } else {
                    ?><textarea id="answer_2" name="answer_2" placeholder="Answer 2"></textarea><?php
            }
                ?>
            </td>
        </tr>
    </table>
</div>


<!--<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->



<script type="text/javascript">
    function checkDragnDropType_D(){
        var resultText = document.getElementById("result_text");
        var qpart = document.getElementById("question_part");
        var opertaor_1 = document.getElementById("operator_1");
        var answer_1 = document.getElementById("answer_1");
        var opertaor_2 = document.getElementById("operator_2");
        var answer_2 = document.getElementById("answer_2");  
        
        error = checkElement(resultText);
        error = checkElement(qpart);
        error = checkElement(opertaor_1);
        error = checkElement(answer_1);
        error = checkElement(opertaor_2);
        error = checkElement(answer_2); 
        
       
        var checkCount=0;        
        checkCount = deleteCount+1; 
        //alert(checkCount);
        var newAnswerElement = document.getElementById("other_answer_"+checkCount);
         
        error = checkElement(newAnswerElement); 
        
        if(checkElement(resultText)==1 || checkElement(opertaor_1)==1 || checkElement(qpart)==1 || checkElement(answer_1)==1 || checkElement(opertaor_2)==1 || checkElement(answer_2)==1 || checkElement(newAnswerElement)==1){
            //alert("Please enter answer");
            return false;
        }else{
            return true;
        }
       
    }   
    
   
</script>