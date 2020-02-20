<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toastr.css" />
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/toastr/toastr.min.js"></script>

<script type="text/javascript">

    function cartAnimation(status) {
        toastr.options.timeOut = 2500; // 2.5s
        toastr.options.closeButton = true;

        if (status === true) {
            toastr.success('Exam successfully added to cart');
        } else if (status === false) {
            toastr.warning('Exam already added to cart');
        } else {
            toastr.error('Error occured while adding the exam to the cart');
        }

    }

    function cartAnimationForBulk(status, noOfPapers) {
        toastr.options.timeOut = 2500; // 2.5s
        toastr.options.closeButton = true;

        if (status === true) {
            toastr.success(noOfPapers + ' exams successfully added to cart');
        } else if (status === false) {
            toastr.warning('Exam already added to cart');
        } else {
            toastr.error('Error occured while adding the exam to the cart');
        }

    }

</script>


<style>
    .anim{
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        color: #ffffff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        background-color: #c2a202;
        border-radius: 10px;
    }

    .exitAnim{
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        color: #ffffff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        background-color: #999999;
        border-radius: 10px;

    }
    .read-more a, .read-less a { color: #2E64FE; }

</style>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/jquery-stepper/jquery.stepper.css" />

<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery-stepper/jquery.stepper.min.js" type="text/javascript"></script>-->
<script type="text/javascript" src="http://plugins.learningjquery.com/expander/jquery.expander.js"></script>
<script>

    $(function () {
        $('div.readmore').expander({
            slicePoint: 200,
            expandText: 'Read More',
            userCollapseText: 'Hide Text'
        });
    });

    function animateWidget() {
        $('#quantityWidget').addClass('anim', 10000).animate({
            opacity: '0.7'
        });

        var delay = setTimeout(function () {
            $("#quantityWidget").removeClass("anim").animate({
                opacity: '2'
            });
        }, 1500);

    }

</script>


<form class="form-exam-details">
    <?php
    $data = Exam::model()->getSubjectsForLevelId($id);  //get subject details
    $userCount = 0;

    $arr = Array();
    $examIDs = Array();
    if (count($data) != 0) {            //check data array is not empty
        foreach ($data as $sub) {

            $oder_details = Exam::model()->getSubjectExamOrderForSubjectId($sub['subject_id']);

            echo '  <div id="view-exam-subject-heading">
                                        <span><h3>' . $sub['subject_name'] . '</h3></span> 
                                    </div>';    //end of subject heading
            echo'      <br/>';

            echo '<div class="view-exam-purchase-details">';

            echo '   <div id="view-exam-purchasebulk-heading">
                        <span id="purchasebulk_heading"><h4 style="margin-top:0px">Purchase dynamic exams in bulk</h4></span>
                    </div>

                    <div id="view-exam-noofpapers">
                        <input type="text" name="no_of_papers" id="noofpapers_' . $sub['subject_id'] . '" placeholder="Number of Papers">
                    </div>';

            echo'      <div id="view-exam-purchase-btn">';


            echo CHtml::ajaxButton('Purchase', array('shoppingcart/purchaseBulk'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('exam_id' => 'js:document.getElementById("examID_for_cart' . $sub['subject_id'] . '").value',
                    'no_of_papers' => 'js:document.getElementById("noofpapers_' . $sub['subject_id'] . '").value'),
                'success' => 'js:function(data){
                    $("#quantityWidget").text(data.shopping_cart_qty);
                    cartAnimationForBulk(data.response, data.added_papers);
                }'
                    ), array(
                'class' => 'lightgreybtn',
//                'id' => 'purchase_exam_' . $sub['subject_id']
                'id' => Util::getRandomID('purchase_exam_' . $sub['subject_id'])
            ));

            echo'      </div>'; //view-exam-purchase-btn
            echo '</div>';  //view-exam-purchase-details 
//            echo'  <br/>';

            echo '<div class="view-exam-wrapper abc_' . $sub['subject_id'] . '">';

            echo '<div class="view-exam-inner">';

            $count = 1;
            $last_dynamic = null;
            if (count($oder_details) != 0) {    //check if exam order details are not empty
                foreach ($oder_details as $oder) {

                    $details = Exam::model()->getExamDetailsForExamID($oder['exam_id']);
                    //var_dump($details);


                    foreach ($details as $detail) {

                        if ($detail['exam_name'] != NULL) {
                            if ($detail['status'] != 0) {
                                if ($count <= 10) {
                                    uiCSS($detail, $courseName, $sub);
                                    $examIDs[] = $detail['exam_id'];
                                }
                                $count++;

                                if ($detail['exam_type'] == 'DYNAMIC') {
                                    $last_dynamic = $detail;
                                }
                            }
                        }
                    }
                }
                if ($last_dynamic != NULL) {

                    echo '<input type="hidden" id="examID_for_cart' . $sub['subject_id'] . '" value="' . $last_dynamic['exam_id'] . '">';


                    for ($i = 0; $i < 10 - $count; $i++) {
                        uiCSS($last_dynamic, $courseName, $sub);
                    }
                } else {
                    $examID = null;
                    $no_order_details = Exam::model()->getExamDetailsForSubjectID($sub['subject_id']);

                    if (count($no_order_details) != 0) {
                        $is_dynamic_available = " ";

                        foreach ($no_order_details as $exam_details) {
                            if ($exam_details['exam_name'] == 'DYNAMIC') {
                                $is_dynamic_available = TRUE;
                            }
                        }
                        if ($is_dynamic_available == TRUE) {
                            foreach ($no_order_details as $detail) {
                                if ($detail['exam_name'] != NULL) {
                                    if ($detail['status'] != 0) {
                                        for ($k = 0; $k < count($examIDs); $k++) {
                                            if ($detail['exam_id'] == $examIDs[$k]) {
                                                $examID = $examIDs[$k];
                                                $k++;
                                                break;
                                            }
                                        }

                                        if ($detail['exam_id'] != $examID) {
                                            if ($count <= 10) {
                                                uiCSS($detail, $courseName, $sub);
                                            }
                                            $count++;

                                            if ($detail['exam_type'] == 'DYNAMIC') {
                                                $last_dynamic = $detail;
                                            }
                                        }
                                    }
                                }
                            }


                            if ($last_dynamic != NULL) {
                                echo '<input type="hidden" id="examID_for_cart' . $sub['subject_id'] . '" value="' . $last_dynamic['exam_id'] . '">';

                                for ($i = 0; $i < 10 - $count; $i++) {
                                    //echo '<div class="view-exam-details">
                                    uiCSS($last_dynamic, $courseName, $sub);
                                }
                            }
                        }
                    }
                }
            } else {

                $no_order_details = Exam::model()->getExamDetailsForSubjectID($sub['subject_id']);

                if (count($no_order_details) != 0) {

                    $is_dynamic_available = " ";
                    foreach ($no_order_details as $exam_details) {
                        if ($exam_details['exam_name'] == 'DYNAMIC') {
                            $is_dynamic_available = TRUE;
                        }
                    }

                    if ($is_dynamic_available == TRUE) {

                        foreach ($no_order_details as $detail) {
                            if ($detail['exam_name'] != NULL) {
                                if ($detail['status'] != 0) {

                                    if ($count <= 10) {
                                        uiCSS($detail, $courseName, $sub);
                                    }
                                    $count++;

                                    if ($detail['exam_type'] == 'DYNAMIC') {
                                        $last_dynamic = $detail;
                                    }
                                }
                            }
                        }
                        if ($last_dynamic != NULL) {
                            echo '<input type="hidden" id="examID_for_cart' . $sub['subject_id'] . '" value="' . $last_dynamic['exam_id'] . '">';

                            for ($i = 0; $i < 10 - $count; $i++) {
                                //echo '<div class="view-exam-details">
                                uiCSS($last_dynamic, $courseName, $sub);
                            }
                        }
                    }
                } else {

                    echo '<div><h4>No Exam papers for this subject</h4></div>';
                    ?>
                    <style>
                        .abc_<?php echo $sub['subject_id'] ?>{
                            overflow-x: hidden;
                            height:100px;
                        }
                    </style>
                    <?php
                }
            }

            echo '</div>';  //end of class view-exam-inner

            echo '</div>';  //end of class view-exam-wrapper
            echo '<br />';

            echo '<hr />';
        }
    } else {

        echo '<div class="error-messages-exam3"><h4>No Exams available for this Level</h4></div>';
        echo '<br />';
        echo '<br />';
    }
    ?>

</form>


<?php

function uiCSS($detail, $courseName, $sub) {
    echo

    '<div class="view-exam-item">';

    echo'<div id="view-exam-image">';

    if ($detail['exam_image'] == null) {
        echo'<img src="' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png">';
    } else {
        echo'<img src="' . Yii::app()->request->baseUrl . '/images/exam_images/' . $detail['exam_image'] . '">';
    }
    //echo '<img src="" style="height: 200px; width:120px; border:1px solid #021a40;  ">';
    echo '</div>';    //end of view-exam-image


    echo '<div id="view-exam-descriptions">';
    echo '<input type="hidden" id="examid' . $detail['exam_id'] . ' value="' . $detail['exam_id'] . '">';
    echo '<p title="' . $detail['exam_name'] . '"><b> Name :&nbsp;</b>' . Exam::TruncateText($detail['exam_name'], 15) . '</p>';
    echo '<p><b> Type :&nbsp;</b>' . $detail['exam_type'] . '</p>';
    echo '<p><b> Description  :&nbsp;</b>' . Exam::TruncateText($detail['exam_description'], 10) . '</p>';
    echo '<p class="price_para"><b> Price :&nbsp;</b><span id="price-change' . $detail['exam_id'] . '">' . $detail['exam_price'] . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '</p>';


    echo CHtml::dropDownList('currency_id' . $detail['exam_id'], '', array('LKR' => 'LKR', 'GBP' => 'GBP', 'USD' => 'USD'), array(
        'options' => array('GBP' => array('selected' => true)),
        'empty' => 'Select',
        'class' => 'drop',
        'ajax' => array(
            'type' => 'POST',
            'url' => Yii::app()->createUrl('exam/convertCurrency'), //or $this->createUrl('loadcities') if '$this' extends CController
            'update' => '#price-change' . $detail['exam_id'], //or 'success' => 'function(data){...handle the data in the way you want...}',
            'data' => array(
                'currency' => 'js:document.getElementById("currency_id' . $detail['exam_id'] . '").value',
                'price' => 'js:document.getElementById("price-change' . $detail['exam_id'] . '").innerHTML',
                // 'examid' => 'js:document.getElementById("examid'. $detail['exam_id'] .'").value',
                'examid' => $detail['exam_id']
            ),
        )), array(
        'id' => 'drop_' . $detail['exam_id']
    ));




    echo '<p class="time_exam"><b> Time  :&nbsp;</b>' . $detail['time'] . '</p>';


    //  echo '<br />';
    echo ' <div id="view-exam-cart-view-buttons">';

    echo '<div id="view-exam-cart-btn">';
    echo CHtml::ajaxButton('Add to cart', array('shoppingcart/addExam'), array(
        'type' => 'POST',
        'dataType' => 'json',
        'data' => array('exam_id' => $detail['exam_id']),
        'success' => 'js:function(data){
                                    $("#quantityWidget").text(data.shopping_cart_qty);
                                    cartAnimation(data.response);
                                }'
            ), array(
        'class' => 'tinybluebtn',
//        'id' => 'exam_' . $detail['exam_id']
        'id' => Util::getRandomID('exam_' . $detail['exam_id']),
    ));
    echo'  </div>'; //end of view-exam-cart-btn
//    echo '&nbsp;';

    echo' <div id="view-exam-viewexam-btn">';

    echo CHtml::ajaxLink('View exam', Yii::app()->createUrl('Exam/ViewEachAvailabelExam'), array(
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
        'class' => 'tinygreybtn hidden-for-phone',
        'style' => 'text-decoration:none',
//        'id' => 'viewexam_' . $detail['exam_id']
        'id' => Util::getRandomID('viewexam_' . $detail['exam_id']),
            )
    );

//    echo CHtml::ajaxLink('View exam', Yii::app()->createUrl('Exam/ViewEachAvailabelExam'), array(
//        'type' => 'POST',
//        //'dataType' => 'json',
//        'data' => array(
//            'viewexam_coursename' => $courseName,
//            'viewexam_subject' => $sub['subject_name'],
//            'viewexam_exam_id' => $detail['exam_id'],
//            'viewexam_examtitle' => $detail['exam_name'],
//            'viewexam_examtype' => $detail['exam_type'],
//            'viewexam_description' => $detail['exam_description'],
//            'viewexam_examprice' => $detail['exam_price'],
//            'viewexam_examtime' => $detail['time'],
//            'viewexam_image' => $detail['exam_image']
//        ),
//        'update' => '#req_res_phone',
//            ), array(
//        'class' => 'tinygreybtn hidden-for-phone',
//        'style' => 'text-decoration:none',
////        'id' => 'viewexam_' . $detail['exam_id']
//        'id' => Util::getRandomID('viewexam_' . $detail['exam_id']),
//            )
//    );
//    echo CHtml::link('View Exam', array('Exam/ViewEachAvailabelExam',
//        'courseID'=>$courseID,
//        'levelID'=>$id,
//        'viewexam_coursename' => $courseName,        
//        'viewexam_subject' => $sub['subject_name'],
//        'viewexam_exam_id' => $detail['exam_id'],
//        'viewexam_examtitle' => $detail['exam_name'],
//        'viewexam_examtype' => $detail['exam_type'],
//        'viewexam_description' => $detail['exam_description'],
//        'viewexam_examprice' => $detail['exam_price'],
//        'viewexam_examtime' => $detail['time']), array('class' => 'btn'));


    echo'</div>';  //end of view-exam-viewexam-btn
    echo '</div>'; //end of view-exam-cart-view-btns


    echo '</div>';  //end of view-exam-description

    echo '</div>';    //end of class item
}
?>


