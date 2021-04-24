

<!--<div class="row">
    <h3 class="light_heading">Add Dynamic Exams</h3><br/>
</div>-->
<div class="span6">

  <div class="control-group">
            <?php
            echo '<label class="control-label" for="inputPassword">Level</label>';
            echo '<div class="controls">';
            echo CHtml::dropDownList('dynamic_level_id','', array(), array(
                'prompt' => 'Select Level',
                'class' => 'form-control',
                'ajax' => array(
                    'data' => array('dynamic_level_id' => 'js:dynamic_level_id.value'),
                    'type' => 'POST',
                    'url' => CController::createUrl('Subject/GetSubjectsforDynamicExams'),
                    'update' => '#dynamic_subject_id',
                )
            ));
            echo '</div>';
            ?> 
   </div>    
   

<div class="control-group">
    <?php
    echo '<label class="control-label" for="inputPassword">Subject</label>';
   echo '<div class="controls">';
    echo CHTML::dropDownList('dynamic_subject_id','',array(),array(
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
    <label class="control-label" for="inputPassword"> Exam</label>
    <div class="controls">
        <select id="dexams" name="dexams" multiple="multiple" style="width:250px;height:50px;">


        </select>
    </div>
</div>
<br/>
<div class="control-group">
    <?php 
    echo '<label class="control-label" for="inputPassword"> No. Of Papers</label>';
    echo '<div class="controls">';
    echo CHtml::textField('num_of_papers','',array('placeholder'=>'Add amount of papers'));
    echo '<INPUT type="button" class="btn" value="Add Dates" onclick="repeat()" />';
    echo '</div>';
    ?>
</div>   
</div>
<div class="span6">    
    <TABLE id="dataTable">     
         <TR>
            <TD><INPUT type="checkbox" name="chk"/></TD>             
            <TD><INPUT type="text" name="date[]" id="date_1" placeholder="Start Date" /></TD>
            <TD><INPUT type="text" name="date[]" id="date_2" placeholder="Expire Date"/></TD>            
        </TR>      
    </TABLE>  
         
    <br/><br/>
    <INPUT type="button" class="btn" value="Add Row" onclick="addRow('dataTable')" />
    <INPUT type="button" class="btn" value="Delete Row" onclick="deleteRow('dataTable')" />
 </div> 
    
<script type="text/javascript">

var a=3;

$(function() {

    var myDate = ""; 
     //   $('#date_0').datepicker();
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
 
