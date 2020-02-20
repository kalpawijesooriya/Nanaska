<form class="form-exam-details">
    <?php
    $data = Exam::model()->getSubjectsForLevelId($id);  //get subject details    

    $arr = Array();

    if (count($data) != 0) {            //check data array is not empty
        foreach ($data as $sub) {

            echo '  <div id="view-exam-subject-heading">
                                        <span><h3>' . $sub['subject_name'] . '</h3></span> 
                                    </div>';    //end of subject heading



            $count = 0;
            $exam_details = Exam::model()->getExamDetailsForSubjectID($sub['subject_id']);

            $sampleCount = 0;

            if (count($exam_details) != "0") {


                foreach ($exam_details as $detail) {

                    if ($detail['exam_type'] == "SAMPLE") {

                        if ($detail['status'] != 0) {
                            $sampleCount++;
                        }
                    }
                }
                if ($sampleCount == 0) {
                    echo '<div>';
                    echo '<div>';
                    echo '<div class="error-messages-exam2"><h4>No Exams available for this Subject.</h4></div>';
                } else {
                    $sampleCount = 0;
                    echo '<div class="view-exam-wrapper abc_' . $sub['subject_id'] . '">';

                    echo '<div class="view-exam-inner2">';
                    foreach ($exam_details as $detail) {

                        if ($detail['exam_type'] == "SAMPLE") {
                            if ($detail['status'] != 0) {
                                if ($sampleCount < 10) {
                                    uiCSS($detail, $courseName, $sub);
                                }
                            }
                            $sampleCount++;
                        }
                    }
                }

                if ($sampleCount < 3) {
                    ?>
                    <style>
                        .abc_<?php echo $sub['subject_id'] ?>{
                            overflow-x: hidden;
                        }
                    </style>

                    <?php
                }
            } else {
                echo '<div>';

                echo '<div>';
                echo '<div class="error-messages-exam2"><h4>No Exams available for this Subject.</h4></div>';
                ?>

                <style>
                    .abc_<?php echo $sub['subject_id'] ?>{
                        overflow-x: hidden;
                    }
                </style>

                <?php
            }
            echo '</div>';  //end of class view-exam-inner

            echo '</div>';  //end of class view-exam-wrapper
            echo '<br />';
            echo '<hr />';
        }
    } else {
        ?>
        <style>
            .abc_<?php echo rand(99, 99999) ?>{
                overflow-x: hidden;
            }
        </style>

        <?php
        echo '<div class="error-messages-exam3"><h4>No Exams available for this Level.</h4></div>';
        echo '<br />';
        echo '<br />';
    }
    ?>

</form>


<?php

function uiCSS($detail, $courseName, $sub) {
    echo

    '<div class="view-exam-item">';
    echo '<div id="view-exam-image">';

    if ($detail['exam_image'] == null) {
        echo'<img src="' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png" style="border:1px solid #BDBDBD;">';
    } else {
        echo'<img src="' . Yii::app()->request->baseUrl . '/images/exam_images/' . $detail['exam_image'] . '" style="border:1px solid #BDBDBD;">';
    }

    echo '      </div>';    //end of view-exam-image


    echo '<div id="view-exam-descriptions">';
    echo '<p title="' . $detail['exam_name'] . '"><b> Name :&nbsp;</b>' . Exam::TruncateText($detail['exam_name'], 8) . '</p>';
    echo '<p><b> Type :&nbsp;</b>' . $detail['exam_type'] . '</p>';
    echo '<p><b> Description  :&nbsp;</b> ' . Exam::TruncateText($detail['exam_description'], 8) . '</p>';
//    echo '<p><b> Price  :</b><span id="price-change' . $detail['exam_id'] . '">GBP ' . $detail['exam_price'] . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//    echo CHtml::dropDownList('currency_id' . $detail['exam_id'], '', array('LKR' => 'LKR', 'GBP' => 'GBP'), array(
//        'prompt' => 'Select',
//        'class' => 'drop',
//        'ajax' => array(
//            'type' => 'POST',
//            'url' => Yii::app()->createUrl('exam/convertCurrency'), //or $this->createUrl('loadcities') if '$this' extends CController
//            'update' => '#price-change' . $detail['exam_id'], //or 'success' => 'function(data){...handle the data in the way you want...}',
//            'data' => array(
//                'currency' => 'js:document.getElementById("currency_id' . $detail['exam_id'] . '").value',
//                'price' => 'js:document.getElementById("price-change' . $detail['exam_id'] . '").innerHTML',
//                // 'examid' => 'js:document.getElementById("examid'. $detail['exam_id'] .'").value',
//                'examid' => $detail['exam_id']
//            ),
//            )), array(
//        'id' => 'drop_' . $detail['exam_id']
//    ));

    echo '</p>';


    echo '<p><b> Time  :&nbsp;</b>' . $detail['time'] . '</p>';

    echo '<br />';
    echo ' <div id="view-exam-cart-view-buttons2">';

    echo '<div id="view-exam-cart-btn">';

//    echo CHtml::link('Add to cart', array('controller/action'), array('class' => 'tinybluebtn'));
//    echo $detail['exam_id'];

    echo CHtml::ajaxButton('Take Exam', array('Exam/takeExam'), array(
        'type' => 'POST', //request type
        'dataType' => 'json',
        'data' => array(
            'exam_id' => $detail['exam_id'],
            'starting_date' => 'null',
            'expiry_date' => 'null',
            'exam_type' => 'SAMPLE'
        ),
        'success' => 'function(data){ 
                        if(data.status=="success"){
                        clearSession();
                        document.location.href = data.redirect_url;
                            
                        }

                                    }'
            ), array('class' => 'tinybluebtn',
        'id' => 'take_exam_' . $detail['exam_id'])
    );



    echo'  </div>'; //end of view-exam-cart-btn

    echo' <div id="view-exam-viewexam-btn">';
    echo CHtml::ajaxLink('View Exam', Yii::app()->createUrl('Exam/ViewEachAvailabelExam'), array(
        'type' => 'POST',
        //'dataType' => 'json',
        'data' => array(
            'viewexam_coursename' => $courseName,
            'viewexam_subject' => $sub['subject_name'],
            'viewexam_exam_id' => $detail['exam_id'],
            'viewexam_examtitle' => $detail['exam_name'],
            'viewexam_examtype' => $detail['exam_type'],
            'viewexam_description' => $detail['exam_description'],
            'viewexam_examprice' => $detail['exam_price'],
            'viewexam_examtime' => $detail['time'],
            'viewexam_image' => $detail['exam_image']
        ),
        'update' => '.req_res',
            ), array(
        'class' => 'tinygreybtn',
        'style' => 'text-decoration:none',
        'id' => 'viewexam_' . $detail['exam_id']));
    echo'</div>';  //end of view-exam-viewexam-btn
    echo '</div>'; //end of view-exam-cart-view-btns


    echo '</div>';  //end of view-exam-description

    echo '</div>';    //end of class item
}
?>

<script type="text/javascript">

    function clearSession() {

        $.ajax({
            url: '<?php echo CController::createUrl('Exam/destroySession'); ?>',
            type: 'POST', //request type
            dataType: 'json',
            data: {
                session_name: 'exam_time'
            },
            success: function (data) {
                //alert("k");
            }
        });
    }

</script>