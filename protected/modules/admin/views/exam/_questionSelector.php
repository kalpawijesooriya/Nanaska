<?php
//Yii::app()->clientScript->scriptMap = array(
//    'jquery.js' => false,
//    //'jquery.min.js' => false,
//    'jquery-ui.min.js' => false
//);
?>
<script>
    //    $(function() {
    //        $("#questions").bind("dblclick", function() {
    ////            window.location.href = "index.php?r=admin/question/view&id=" + $(this).text();
    //            var question_id = this.value;
    //            $("#mydialog_" + question_id).dialog("open");
    //            return false;
    //        });
    //    });
</script>



<div class="control-group">       
    <?php
    $criteria = new CDbCriteria;
    $criteria->condition = "subject_id= " . $subject_id;
    $subject_areas = SubjectArea::model()->findAll($criteria);

    echo 'Subject Area';
    echo '<br>';
    echo CHtml::dropDownList('subject_area_id', '', CHtml::listData($subject_areas, 'subject_area_id', 'subject_area_name'), array(
        'prompt' => 'Select Subject Area',
        'class' => 'form-control',
        'onchange' => 'function() {
                        if(document.getElementById("questions")!=null){
                            $("#questions").find("option").remove().end().append("<option></option>").val();
                        }
                        
                        if(question_type.value!=""){                              
                         $("#question_type option:eq(0)").attr("selected","selected");
                     } 
                     
                   var element = document.getElementById("questions");
                     if(element!=null){
                     resetMultipleSelect();
                    }         
                    

      
            }',
        
    ));
    ?> 

</div>

<div class="control-group"> 
    <?php
    echo 'Question Type';
    echo '<br>';
    echo CHtml::dropDownList('question_type', '', array(
        '' => 'Select Question Type',
        'SINGLE_ANSWER' => 'Single Answer Questions',
        'MULTIPLE_ANSWER' => 'Multiple Answer Questions',
        'SHORT_WRITTEN' => 'Short Written Answer Questions',
        'DRAG_DROP_TYPEA_ANSWER' => 'Drag & Drop Type A Answer Questions',
        'DRAG_DROP_TYPEB_ANSWER' => 'Drag & Drop Type B Answer Questions',
        'DRAG_DROP_TYPEC_ANSWER' => 'Drag & Drop Type C Answer Questions',
        'DRAG_DROP_TYPED_ANSWER' => 'Drag & Drop Type D Answer Questions',
        'DRAG_DROP_TYPEE_ANSWER' => 'Drag & Drop Type E Answer Questions',
        'MULTIPLE_CHOICE_ANSWER' => 'Multiple Choice Answer Questions',
        'TRUE_OR_FALSE_ANSWER' => 'True Or false Answer Questions',
        'HOT_SPOT_ANSWER' => 'Hot Spot Answer Questions'
            ), array(
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'data' => array('subject_id' => 'js:subject_id.value',
                'subject_area_id' => 'js:subject_area_id.value',
                'question_type' => 'js:question_type.value',
                'selected_id' => 'js:getSelectedIDs()'
            ),
            'url' => CController::createUrl('Exam/getFinalQuestionSelector'),
            'beforeSend' => 'function() {
                        if(document.getElementById("questions")!=null){
                            $("#questions").find("option").remove().end().append("<option></option>").val();

                        }
            }',
            'update' => '#final_render_view',
            )));
    ?>   </div>  


<div id="final_render_view">

</div>

<script type="text/javascript">
    function getSelectedIDs(){
       
        var elem = document.getElementById("selected_questions_1");
        if(elem!=null){
            var arr = new Array()
            var i = 0;
            for(i;i<elem.options.length;i++){           
                arr[i] = elem[i].value;
            }       
            var myJsonString = JSON.stringify(arr);
            return myJsonString;
        }else{
            return null;
        }
    }

</script>