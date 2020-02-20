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




<div id="paper_<?php echo $count; ?>" class="span10"  style="display: none">
    <div class="well_paper">
        <div class="row">
            <div class="span0" style="margin-top: 5px;">
                 <?php echo '<span class="paper_order_label"><strong>' . $count . '.&nbsp; </strong></span>'; ?>
            </div>    
            <div class="span4" style="width:320px; margin-left: 0px;"> 
                <?php
                echo '<span class=""><strong>Exam Type</strong></span>&nbsp;&nbsp;';
                echo CHtml::dropDownList('exam_type_' . $count, '', array('PRESET' => 'Preset', 'SAMPLE' => 'Sample', 'DYNAMIC' => 'Dynamic'), array(
                    'prompt' => 'Select Exam Type',
                    'class' => 'form-control',
                    
                    'ajax' => array(
                        'data' => array('exam_type' => 'js:exam_type_' . $count . '.value', 'subject_id' => $subject_id),
                        'type' => 'POST', //request type
                        'url' => CController::createUrl('Exam/getExamsByType'),
                        'update' => '#exam_id_' . $count,
                    ),
                ));
                
                ?>

            </div>

            <div class="span3">
                <?php
                echo '<span class=""><strong>Exam</strong></span>&nbsp;&nbsp;';
//        echo '<br>';
                echo CHtml::dropDownList('exam_id_' . $count, '', array(), array(
                    'prompt' => 'Select Exam',
//        'ajax' => array(
//            'data' => array('level_id' => 'js:level_id.value'),
//            'type' => 'POST', //request type
//            'url' => CController::createUrl('Subject/getSubjects'),
//            'update' => '#subject_id',
//        )
                ));
                ?>         
            </div>

            <!--</div>-->
            <div class="span1">
                <?php
                $nextcount = $count + 1;
                echo CHtml::ajaxButton('Add Paper', CController::createUrl('SubjectExamOrder/addPaperPosition'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array('exam_type' => 'js:exam_type_' . $count . '.value',
                        'exam_id' => 'js:exam_id_' . $count . '.value',
                        'subject_id' => $subject_id,
                        'count' => $count,
                    ),
                    'success' => 'function(data){ 
                               if(data[0].status=="success"){
                                document.getElementById("paper_' . $nextcount . '").style.display = "block";
                                    removeHighlight("exam_type_' . $count . '");
                                    removeHighlight("exam_id_' . $count . '");
                                        
                                     document.getElementById("paperErrorDisplay_' . $count . '").innerHTML="";
                                    document.getElementById("paperErrorDisplay_' . $count . '").style.display="none";
                                    document.getElementById("add_paper_' . $count . '").value="Added";
                               }else if(data[0].status=="fail"){
                        
                                        document.getElementById("paperErrorDisplay_' . $count . '").innerHTML="";
                                        document.getElementById("paperErrorDisplay_' . $count . '").style.display="none";

                                        removeHighlight("exam_type_' . $count . '");
                                    removeHighlight("exam_id_' . $count . '");


                                        for(var x=0;x<data[1].length;x++){
                                            var element =  data[1][x];
                                            hightlightTextBox(element);
                                        }
                                       

                                        for(var x=0;x<data[2].length;x++){
                                            var msg =  data[2][x];
                                            document.getElementById("paperErrorDisplay_' . $count . '").innerHTML=document.getElementById("paperErrorDisplay_' . $count . '").innerHTML+msg+"<br />";

                                        }

                                     document.getElementById("paperErrorDisplay_' . $count . '").style.display="block";
                               }
                                    }'
                        ), array('class' => 'btn btn-checkout',
                    'id' => 'add_paper_' . $count,
                    'name' => 'add_paper_' . $count,
                        )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="control-group">
    <p style="display:none" id="paperErrorDisplay_<?php echo $count; ?>" class="alert alert-danger"></p>
    </div>
</div>
<script>
    document.getElementById("paper_1").style.display = "block";
</script>