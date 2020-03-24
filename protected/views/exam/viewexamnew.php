<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toastr.css" />
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js-old/plugins/toastr/toastr.min.js"></script>



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


<form class="form-exam-details" style="margin-left: 0px!important;">
    <?php
    $data = Exam::model()->getSubjectsForLevelId($id);  //get subject details
    $userCount = 0;

    $arr = Array();
    $examIDs = Array();
    if (count($data) != 0) {
        echo '<div class="course-area section-padding" style="padding-top: 0px !important;padding-left: 0px !important;">';
        //check data array is not empty
        foreach ($data as $sub) {

            $oder_details = Exam::model()->getSubjectExamOrderForSubjectId($sub['subject_id']);

      echo '<div class="container" >';
            echo ' <div class="section-title-wrapper" id="view-exam-subject-heading">
                        <div class="section-title" style="margin-bottom: 50px">  
                         <h3 style="text-align: left">' . $sub['subject_name'] . '</h3>
                        </div>
                    </div>';    //end of subject heading

            echo '<!-- Start of search button and text -->
                         <div class="main" style="margin-bottom: 5%">
                           <h5 class="mt-4 heading">Here You can Purchase the exams in Bulk</a></h5>
                           <br>
                           <!-- Actual search box -->
                               <div class="form-group has-search ">
                                 <span class="form-control-feedback"></span>
                                 <div class="row text-center">
                                 <div class="col-lg-4 col-mg-4 col-sm-4"></div>
                                  <div class="col-lg-4 col-mg-4 col-sm-4 ">
                                      <input type="text" class="form-control" placeholder="Enter the Number of Papers" class="button-bottom">
                                  </div>
                                 </div>
                                 <br>
                                 <div class="button-bottom-2" style="margin-left: 12%">
                                     <button  class="button-default purchase">Purchase</button>
                                 </div>
                                 <!--this is sample button button type="button" name="button" style="padding-left:60px;padding-right:60px;padding-top:10px; padding-bottom:10px;  align-items: center;margin-left: 20%;margin-right: 20%;margin-bottom: 10px;margin-top: 10px;background-color: #2D3E50;border-radius: 8px;color: #FFFFFF; " >Purchase</button--->
                               </div>
                               <br>
                               <!-- Another variation with a button -->
                             </div><!-- end of search button and text -->';






//            echo '<div class="view-exam-purchase-details">';
//
//            echo '<div id="view-exam-purchasebulk-heading">
//                        <span id="purchasebulk_heading"><h4 style="margin-top:0px">Purchase dynamic exams in bulk</h4></span>
//                   </div>
//
//                    <div id="view-exam-noofpapers">
//                        <input type="text" name="no_of_papers" id="noofpapers_' . $sub['subject_id'] . '" placeholder="Number of Papers">
//                    </div>';
//
//            echo'<div id="view-exam-purchase-btn">';
//
//
//            echo CHtml::ajaxButton('Purchase', array('shoppingcart/purchaseBulk'), array(
//                'type' => 'POST',
//                'dataType' => 'json',
//                'data' => array('exam_id' => 'js:document.getElementById("examID_for_cart' . $sub['subject_id'] . '").value',
//                    'no_of_papers' => 'js:document.getElementById("noofpapers_' . $sub['subject_id'] . '").value'),
//                'success' => 'js:function(data){
//                    $("#quantityWidget").text(data.shopping_cart_qty);
//                    cartAnimationForBulk(data.response, data.added_papers);
//                }'
//                    ), array(
//                'class' => 'lightgreybtn',
////                'id' => 'purchase_exam_' . $sub['subject_id']
//                'id' => Util::getRandomID('purchase_exam_' . $sub['subject_id'])
//            ));
//
//            echo'  </div>'; //view-exam-purchase-btn
//            echo '</div>';  //view-exam-purchase-details
//            echo'  <br/>';

         //   echo '<div class="view-exam-wrapper abc_' . $sub['subject_id'] . '">';
            echo'<div class="row">';

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



       echo '</div></div></div>';  //end of class view-exam-wrapper
            echo '<br />';

            echo '<hr />';
        }
        echo '</div>';
    } else {

        echo '<div class="error-messages-exam3"><h4>No Exams available for this Level</h4>';
        echo '<br />';
        echo '<br />';
    }
    ?>

</form>


<?php

function uiCSS($detail, $courseName, $sub) {
    echo '<div class="col-md-6 col-sm-3 col-lg-3" style="margin-bottom: 50px">';
    echo'<div class="single-item">';
    echo'<div class="single-item-image overlay-effect">';

    if ($detail['exam_image'] == null) {
        echo'<a href="#"><img src="' . Yii::app()->request->baseUrl . '/themes/bootstrap/img/course/6.jpg"></a>';
    } else {
        echo'<a href="#"><img src="' . Yii::app()->request->baseUrl . '/images/exam_images/' . $detail['exam_image'] . '"></a>';
    }
    //echo '<img src="" style="height: 200px; width:120px; border:1px solid #021a40;  ">';
    echo '</div>';    //end of view-exam-image


    echo '<div class="single-item-text">';
    echo '<input type="hidden" id="examid' . $detail['exam_id'] . ' value="' . $detail['exam_id'] . '">';
    echo '<h4 title="' .  $detail['exam_name'] . '"><a href="#">'.Exam::TruncateText($detail['exam_name'],20) .'</a></h4><br>';
    echo '<div class="single-item-text-info" style="margin-bottom: 10px!important;">';
    echo '<span>Type : <span>' . $detail['exam_type'] . '</span>';
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

            'id' => Util::getRandomID('viewexam_' . $detail['exam_id']),
        )
    );
    echo '</div>';

    echo  '</span>';
    echo '<div class="single-item-text-info">';
    echo '<span>Description : <span>'. Exam::TruncateText($detail['exam_description'], 15) .'</span></span></div>';
    echo ' <div class="single-item-text-info"><span>Time : <span>' . $detail['time'] . '</span></span></div>';
    echo '<p class="price_para"><b> Price :&nbsp;</b><span id="price-change' . $detail['exam_id'] . '"> GPB ' . $detail['exam_price'] . '</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  echo ' <div class="button-bottom">
          <button  type="button" class="button-default boder" style="width: 170px" data-examid="'.$detail['exam_id'].'" onclick="cart(this)">Add to cart</button>
        </div>';
echo' <div id="view-exam-viewexam-btn">';



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


   // echo'</div>';  //end of view-exam-viewexam-btn
    echo '</div>'; //end of view-exam-cart-view-btns


    echo '</div>';  //end of view-exam-description

    echo '</div>';    //end of class item
    echo '</div>';
}
?>
<style>
    .boder{
        border: none;
    }



    .purchase{
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        color: #fff;
        background-color: #507281;
        width:250px; ;
        margin-right: 10%;
        border-radius: 30px;
        border: none;
    }
</style>
<div class="test">

</div>

