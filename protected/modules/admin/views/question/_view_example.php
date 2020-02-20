<div id="dialog_data">

    <?php
    if ($qtype == "SINGLE_ANSWER") {
        echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/SINGLE_ANSWER.png', "", array("width" => "700px", "height" => "auto"));
    } else if ($qtype == "MULTIPLE_ANSWER") {
        echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/MULTIPLE_ANSWER.png', "", array("width" => "700px", "height" => "auto"));
    
        
    }else if($qtype == "SHORT_WRITTEN"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/SHORT_WRITTEN_ANSWER.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "DRAG_DROP_TYPEA_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/DRAG_TYPE_A.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "DRAG_DROP_TYPEB_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/DRAG_TYPE_B.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "DRAG_DROP_TYPEC_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/DRAG_TYPE_C.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "DRAG_DROP_TYPED_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/DRAG_TYPE_D.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "DRAG_DROP_TYPEE_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/DRAG_TYPE_E.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "TRUE_OR_FALSE_ANSWER"){
         echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/TRUEORFALSE.png', "", array("width" => "700px", "height" => "auto"));
    
    }else if($qtype == "MULTIPLE_CHOICE_ANSWER"){
        echo CHtml::image(Yii::app()->request->baseUrl . '/images/example_question_images/MULTIPLE_CHOICE_ANSWER.png', "", array("width" => "700px", "height" => "auto"));
    } 
    else if($qtype == "HOT_SPOT_ANSWER"){
         echo '<h4>Please refer to the instructions given below. </h4>';
    }   
    else{        
        echo '<h4>Please select a question type. </h4>';
    }
    ?>

</div>