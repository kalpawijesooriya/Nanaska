<style>
    .ans_typec_col{
        float: left;
    }
    .ans_typec_row{
        display: none;
    }
</style>

<div id="answer_row<?php echo $id ?>" <?php if ($id != 1) { ?> class="ans_typec_row"<?php } ?> >
    <div class="ans_typec_col">Answer </div>
    <div class="ans_typec_col"><input type="text" name="answer_<?php echo $id ?>"></div>
    <div class="ans_typec_col"><button type="button" onclick="displayTR()">Add</button></div>
    

    
    <?php
    /*
    echo CHtml::ajaxButton('Add another answer', CController::createUrl('question/dragAndDropTypeCAnswer'), 
            array(
                'type' => 'POST', //request type
                'dataType' => 'json',
                

            ), 
            array(
                'id'=>$id,
                'class' => 'btn btn-checkout'
            )
            );
    
   */ ?>

</div>
<br/>