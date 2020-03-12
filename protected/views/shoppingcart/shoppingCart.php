<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bootbox.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles-small.css', 'only screen and (max-width: 800px)');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--Breadcrumb Banner Area Start-->
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/test/jquery-confirm.min.css"/>
<div class="breadcrumb-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h1 class="text-center">cart</h1>
                    <div class="breadcrumb-bar">
                        <ul class="breadcrumb text-center">
                            <li><a href="index.html">Home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<br>
<br>
<br>
<div class="row-fluid">
    <div class="container">

        <div id="req_res">
            <table id="table-shopping-cart" class="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Level Name</th>
                        <th>Subject Name</th>
                        <th>Exam Name</th>
                        <th class="numeric" id="exam_price">Price (GBP)</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>

                <?php
                $shopping_cart_exams = Yii::app()->session[Consts::STR_SHOPPING_CART][Consts::STR_EXAMS];
                $counter = 0;
                $total_price = 0.00;
                if (isset($shopping_cart_exams)) {
                    echo '<tbody>';
                    foreach ($shopping_cart_exams as $shopping_cart_exam) {
                        echo '<tr id="item_' . $shopping_cart_exam['shopping_cart_exam_id'] . '">';
//                            echo '<td>' . $shopping_cart_exam['exam_id'] . '</td>';
                        $subject_id = Exam::model()->getSubjectForExam($shopping_cart_exam['exam_id']);
                        $exam_name = Exam::model()->getExamName($shopping_cart_exam['exam_id']);
                        $sub_name = Subject::model()->getSubjectName($subject_id);
                        $level_name = Level::model()->getLevelName(Subject::model()->getLevelOfSubject($subject_id));
                        $course_name = Course::model()->getCourseName(Level::model()->getCourseOfLevelID(Subject::model()->getLevelOfSubject($subject_id)));
                        $exam_price = Exam::model()->getExamPrice($shopping_cart_exam['exam_id']);
                        $exam_price_float = floatval($exam_price);
                        $total_price = $total_price + $exam_price_float;
                        $dynamic_exam_no = '';

                        echo '<td data-title="Course Name">' . $course_name . '</td>';
                        echo '<td data-title="Level Name">' . $level_name . '</td>';
                        echo '<td data-title="Subject Name">' . $sub_name . '</td>';
                        if (Exam::model()->findByPk($shopping_cart_exam['exam_id'])->exam_type === TYPE_DYNAMIC) {
                            $dynamic_exam_no = $counter;
                            echo '<td data-title="Exam Name">' . $course_name . '-' . $level_name . '-' . $sub_name . '-' . $exam_name . '_' . $dynamic_exam_no . '</td>';
                            $counter++;
                        } else if (Exam::model()->findByPk($shopping_cart_exam['exam_id'])->exam_type === TYPE_PRESET) {
                            echo '<td data-title="Exam Name">' . $exam_name . '</td>';
                        } else if (Exam::model()->findByPk($shopping_cart_exam['exam_id'])->exam_type === TYPE_ESSAY) {
                            echo '<td data-title="Exam Name">' . $exam_name . '</td>';
                        }


                        echo '<td class="numeric" data-title="Price (GBP)" style="text-align:right;">' . number_format($exam_price_float, 2, '.', '') . '</td>';

                        echo '<td style="text-align:right;">';
                        ?> 
                        <button  onclick="ConfirmMess(<?php echo $shopping_cart_exam['shopping_cart_exam_id'] ?>);
                                false;" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
                           <?php
                           echo '</td>';
                           echo '</tr>';
                       }
                       echo '</tbody>';
                   }
                   ?>
<!--                <tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td style="text-align:right;"><strong>Total (GBP): </strong></td>
<td style="text-align:right; padding-right:80px;"><span id="total_price"><strong></strong></span></td>
</tr>-->


                <tfoot>
                    <tr><td id="empty-cart-message" style="display:none;" colspan="6">
                            <p>Your shopping cart is empty!</p>
                            <?php if (!isset($shopping_cart_exams) || empty($shopping_cart_exams) || count($shopping_cart_exams) === 0) { ?>
                                <script type="text/javascript">
                                    $('#empty-cart-message').show();
                                </script>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right;"class="hidden-phone"><span ><strong>Total (GBP):</strong></span></td>
                        <td style="text-align: right; width: 8%;"><span class="visible-phone pull-left"><strong>Total (GBP):</strong></span><span id="total_price"><strong><?php echo number_format($total_price, 2, '.', ''); ?></strong></span></td>
                        <td class="hidden-phone"></td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <!--        <div class="pull-right" id="wrapper-total-price">
                    <span id="total_price"><strong>Total (GBP): </strong></span>
                </div>-->



        <?php //print_r($exam_price); ?>

        <div id="btn_checkout" style="margin-top: 60px;">
            <div class="pull-right">
                <?php if (!empty($shopping_cart_exams)) { ?>
                    <form name="merchantForm" method="post" action="https://<?php echo Yii::app()->params['payment']['pgdomain']; ?>/AccosaPG/verify.jsp">
                        <?php
                        $price_parts = explode('.', $total_price);

                        if (count($price_parts) > 1) {
                            $total_amount = (int) $price_parts[0] . str_pad($price_parts[1], 2, "0", STR_PAD_RIGHT);
                        } else {
                            $total_amount = (int) $price_parts[0] . "00";
                        }
                        $merchantReferenceNo = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 20);
                        $merchantResponseUrl = Yii::app()->createAbsoluteUrl('shoppingcart/Pgresponse');
                        $messageHash = Yii::app()->params['payment']['pgInstanceId'] . "|" . Yii::app()->params['payment']['merchantId'] . "|" . Yii::app()->params['payment']['perform'] . "|" . Yii::app()->params['payment']['currencyCode'] . "|" . $total_amount . "|" . $merchantReferenceNo . "|" . $merchantResponseUrl . "|" . Yii::app()->params['payment']['hashKey'] . "|";
                        $message_hash = "DYNAMIC-URL:8:" . base64_encode(sha1($messageHash, true));
                        ?>
                        <input type="hidden" name="pg_instance_id" value="<?php echo Yii::app()->params['payment']['pgInstanceId']; ?>" />
                        <input type="hidden" name="merchant_id" value="<?php echo Yii::app()->params['payment']['merchantId']; ?>" />

                        <input type="hidden" name="perform" value="<?php echo Yii::app()->params['payment']['perform']; ?>" />
                        <input type="hidden" name="currency_code" value="<?php echo Yii::app()->params['payment']['currencyCode']; ?>" />
                        <input type="hidden" name="amount" value="<?php echo $total_amount; ?>" id="amount_pay"/>
                        <input type="hidden" name="merchant_reference_no" value="<?php echo $merchantReferenceNo; ?>" />
                        <input type="hidden" name="order_desc" value="<?php echo $course_name; ?>" />
                        <input type="hidden" name="merchant_response_url" value="<?php echo $merchantResponseUrl; ?>" />

                        <input type="hidden" name="message_hash" value="<?php echo $message_hash; ?>" />

                        <noscript>
                        <br />&nbsp;<br />
                        <center>
                            <font size="3" color="#3b4455">
                            JavaScript is currently disabled or is not supported by your browser.<br />
                            Please click Submit to continue the processing of your transaction.<br />&nbsp;<br />
                            <input type="submit" />
                            </font>
                        </center>
                        </noscript>
                        <?php
                        echo CHtml::submitButton("Checkout", array('class' => 'button button-news'));
                        ?>
                    </form>
                <?php } ?>

                <?php
//                echo CHtml::ajaxButton('Checkout', array('shoppingcart/checkout'), array(
//                                    'type' => 'POST',
//                                    'dataType' => 'json',
//                                    'data' =>  array('id' => Yii::app()->user->getId()),
//                                    'success' => 'js:function(data){
//                                        if(data.status === "'.Consts::STATUS_EMPTY.'"){
////                                           bootbox.alert(data.message);
//                                             bootbox.dialog({
//                                                message: data.message,
//                                                title: "Warning",
//                                                buttons: {
//                                                    danger: {
//                                                        label: "OK",
//                                                        className: "btn-danger"
//                                                    }
//                                                }
//                                             
//                                             });
//                                       } else if (data.status === "'.Consts::STATUS_SUCCESS.'"){
//                                           document.location.href = data.message;
//                                       }
//                                    }'
//                                        ), array(
//                                    'class' => 'button button-news',                                    
//                                ));
//                echo CHtml::button('Checkout', array('class' => 'button button-news',
//                                                     'submit' => array('shoppingcart/test', 'id' => Yii::app()->user->getId()),
//                                                     'success' => 'js:function(data){
//                                                                        if(data.status === "empty"){
//                                                                            bootbox.alert(data.message);
//                                                                        }
//                                                                    }'
//                    ));
                ?>
            </div>
        </div>

        <br /><br /><br />
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/test/jquery-3.3.1.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/test/jquery-ui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/test/jquery-confirm.min.js"></script>
<script>
    function ConfirmMess(shoppingCartExamId) {
        //return false;
//         bootbox.confirm("Are you sure you want to remove the item from shopping cart? ", function (result) {
//             if (result) {
//
//
//                 $.ajax({
//                     url: "index.php?r=shoppingcart/RemoveRequest",
//                     type: "POST",
//                     dataType: "json",
//                     data: {'removeItem': shoppingCartExamId},
//                     context: document.body
//                 }).done(function (data) {
// //                    $("#shopping_cart_total").html(data.shopping_cart_total);
//
//                     if (data.status === "success") {
//                         jQuery("#item_" + shoppingCartExamId).slideUp("slow");
//                         jQuery("#quantityWidget").text(data.shopping_cart_qty);
//                         if (data.shopping_cart_qty == 0) {
//                             $('#empty-cart-message').show();
//                         }
//                         jQuery("#total_price").html('<strong>' + data.total_price + '</strong>');
//                         $('input[name="amount"]').val(data.total_price_pay);
//                         $('input[name="merchant_reference_no"]').val(data.ref);
//                         $('input[name="message_hash"]').val(data.message_hash);
//                     }
//                     else {
//                         alert(data.message);
//                     }
//
// //                    document.getElementById("quantityWidget").innerHTML = data.totalCartQuantity;
// //                    document.getElementById("totalP").innerHTML = data.shopping_cart_total;
//
//                 });
//
//             }
//
//         });



        $.confirm({
            title:'Remove the course form the cart?',
            content:'Please confirm your action within 8 seconds',
            autoClose:'cancelAction|8000',
            type:'blue',
            draggable: true,
            buttons: {
                deleteUser: {
                    text:'Confirm',
                    btnClass:'btn-primary',
                    action: function () {
                        $.ajax({
                            url: "index.php?r=shoppingcart/RemoveRequest",
                            type: "POST",
                            dataType: "json",
                            data: {'removeItem': shoppingCartExamId},
                            context: document.body
                        }).done(function (data) {
//                    $("#shopping_cart_total").html(data.shopping_cart_total);

                            if (data.status === "success") {
                                jQuery("#item_" + shoppingCartExamId).slideUp("slow");
                                jQuery("#quantityWidget").text(data.shopping_cart_qty);
                                if (data.shopping_cart_qty == 0) {
                                    $('#empty-cart-message').show();
                                }
                                jQuery("#total_price").html('<strong>' + data.total_price + '</strong>');
                                $('input[name="amount"]').val(data.total_price_pay);
                                $('input[name="merchant_reference_no"]').val(data.ref);
                                $('input[name="message_hash"]').val(data.message_hash);
                            }
                            else {
                                alert(data.message);
                            }

//                    document.getElementById("quantityWidget").innerHTML = data.totalCartQuantity;
//                    document.getElementById("totalP").innerHTML = data.shopping_cart_total;

                        });
                    }
                },cancelAction: function () {
                    $.alert('Action is canceled!');
                }
            }
        });
    }
</script>
