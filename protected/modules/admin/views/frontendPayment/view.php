<?php
$this->breadcrumbs=array(
	'Frontend Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Frontend Payment','url'=>array('index')),
	array('label'=>'Manage Frontend Payment','url'=>array('admin')),
        array('label'=>'Edit','url'=>array('update','id'=>$model->id)),
);
?>
    <h2 class="light_heading">View Payments</h2>

            <?php
            $this->widget('bootstrap.widgets.TbDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'id',
                    'first_name',
                    'last_name',
                    'address',
                    'cima_id',
                    'email',
                    'contact_no',
                    'course',
                    'amount',
                    'ref_no',
                    'transaction_id',
                    'status',
                ),
            ));
            ?>
<!--            <p class="well">Please confirm your amount of GBP<?php //echo $model->amount; ?> by pressing the 'confirm payment' button</p>
            <form method="post" action="https://<?php //echo Yii::app()->params['payment']['pgdomain']; ?>/AccosaPG/verify.jsp">
                <?php
//                $price_parts = explode('.', $model->amount);
//
//                $total_amount=0;
//                if (count($price_parts) > 1) {
//                    $total_amount = (int) $price_parts[0] . str_pad($price_parts[1], 2, "0", STR_PAD_RIGHT);
//                } else {
//                    $total_amount = (int) $price_parts[0] . "00";
//                }
//                $merchantResponseUrl = Yii::app()->createAbsoluteUrl('user/Pgresponse');
//                
//                $messageHash = Yii::app()->params['payment']['pgInstanceId']."|".Yii::app()->params['payment']['merchantId']."|".Yii::app()->params['payment']['perform']."|".Yii::app()->params['payment']['currencyCode']."|".$total_amount."|".$model->ref_no."|".$merchantResponseUrl."|".Yii::app()->params['payment']['hashKey']."|";
//                //$message_hash = "DYNAMIC-URL:8:".base64_encode(custom_sha1($messageHash, true));
//                $message_hash = "DYNAMIC-URL:8:".base64_encode(sha1($messageHash, true));

                ?>
                
                <input type="hidden" name="pg_instance_id" value="<?php //echo Yii::app()->params['payment']['pgInstanceId']; ?>" />
                        <input type="hidden" name="merchant_id" value="<?php //echo Yii::app()->params['payment']['merchantId']; ?>" />

                        <input type="hidden" name="perform" value="<?php //echo Yii::app()->params['payment']['perform']; ?>" />
                        <input type="hidden" name="currency_code" value="<?php //echo Yii::app()->params['payment']['currencyCode']; ?>" />
                        <input type="hidden" name="amount" value="<?php //echo $total_amount; ?>" />
                        <input type="hidden" name="merchant_reference_no" value="<?php //echo $model->ref_no; ?>" />
                        <input type="hidden" name="order_desc" value="<?php //echo 'ssssss'; ?>" />
                        <input type="hidden" name="merchant_response_url" value="<?php //echo $merchantResponseUrl;?>" />
                        
                        <input type="hidden" name="message_hash" value="<?php //echo $message_hash; ?>" />
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
                <center><input type="submit" value="Confirm Payment" class="button button-news"></center>
            </form>-->
        <!--</div>-->
