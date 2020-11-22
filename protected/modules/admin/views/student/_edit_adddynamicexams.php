
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row">
    <h3 class="light_heading">Add Dynamic Exams</h3><br/>
</div>

<div class="row">
    <div class="span10">
        <div class="span5">
            <?php
            echo 'Level';
            echo '<br>';
            echo CHtml::dropDownList('level_id','', array(), array(
                'prompt' => 'Select Level',
                'class' => 'form-control',
                'ajax' => array(
                    //'data' => array('level_id' => 'js:level_id2.value'),
                    'type' => 'POST',
                    'url' => CController::createUrl('Subject/getSubjects'),
                    'update' => '#subject_id',
                )
            ));
            ?> 
        </div>    
    </div>    
</div>

<div class="row">
    <?php
    echo 'Subject';
    echo '<br>';
    echo CHTML::dropDownList('subject_id','',array(),array(
        'prompt' => 'Select Subject',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('Exam/GetDynamicExams'),
            'update' => '#dexams',
    )
    ));
    ?>  
<br>
</div>
<div class="row">
    <h4 class="light_heading">Dynamic Exam List</h4><br/>
    <select id="dexams" name="dexams" multiple="multiple" style="width:250px;height:50px;">

        <?php
//        foreach ($exams as $exam) {
//            $examType = $exam['exam_type'];
//            if ($exam['exam_type'] == "DYNAMIC") {
//                $examType = "Dynamic";
//            } else if ($exam['exam_type'] == "SAMPLE") {
//                $examType = "Sample";
//            } else if ($exam['exam_type'] == "PRESET") {
//                $examType = "Preset";
//            }
//            echo '<option value=' . $exam['exam_id'] . '>' . $exam['exam_name'] . '(<strong>' . $examType . '</strong>)</option>';
//        }
        ?>
    </select>
</div>
<br/>
<div class="row">
    <?php 
    echo 'Number of papers'.'<br>';
    echo CHtml::textField('num_of_papers','',array('placeholder'=>'Add amount of papers'));
    echo '<INPUT type="button" value="Add Dates" onclick="repeat()" />';
    ?>
  <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" /><br/><br/>  
</div><br/><br/>

<!--<INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />-->

 
<!--    <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" /><br/><br/>-->
 
    <TABLE id="dataTable">
       
         <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>             
            <TD><INPUT type="text" name="date[]" id="date_1" placeholder="Start Date" /></TD>
            <TD><INPUT type="text" name="date[]" id="date_2" placeholder="Expire Date"/></TD>
            
        </TR>
    </TABLE>   
   


<script type="text/javascript">

var a=3;

$(function() {

    var myDate = ""; 
        $('#date_0').datepicker();
    //$('#date_0').datepicker('setDate', myDate);



});

function repeat(){
    var num_of_papers = document.getElementById('num_of_papers').value;
   
    for(var c=1; c<num_of_papers; c++) {
    addRow('dataTable');
    }
}

function addRow(tableID) {
    
            

            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            
           
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
               
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    
                    case "text":                              
                            newcell.childNodes[0].id = "date_"+a;
                            $('#date_'+a).datepicker();
                            newcell.childNodes[0].name = "date[]";
                            a++;                            
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
        
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }

</script>
 
