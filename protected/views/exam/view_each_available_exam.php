<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/tabs.css" />

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
<script type="text/javascript">

    $(function() {
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

        var delay = setTimeout(function() {
            $("#quantityWidget").removeClass("anim").animate({
                opacity: '2'
            });
        }, 1500);

    }

</script>

<?php
$courses = $courseModel;
?>


<div class="row exam-view">

    <div class="span11">

        <div class="registration-signin content-wrapper">

            <h3 class="heading_alignment" style="text-align:left;"> <?php echo $viewexam_coursename; ?> </h3>
            <br/>

            <div class="row">

                <div class="span5" >
                    <?php
                    if ($viewexam_image == null) {
                        echo '<div class="exam-image"><img src="' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png"></div>';
                    } else {
                        echo '<div class="exam-image"><img src="' . Yii::app()->request->baseUrl . '/images/exam_images/' . $viewexam_image . '" style="width:100%; height:100%; margin: auto;" /></div>';
                    }
                    ?>                   

<!--                    <div class="exam-image"><img src="<?php echo Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png'; ?>"></div>-->
                </div>


                <div class="span6"><div class="caption">

                        <span class="font_heading_products"><?php echo $viewexam_subject; ?></span> <br/>
                        <br>

                        <p>

                            <?php
                            $viewexam_description;


                            echo '<div class="readmore"><p>' . $viewexam_description . '<p></div>';
                            ?>

                        </p>

                        <br>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong> Exam Title </strong></td>
                                    <td><?php echo $viewexam_examtitle; ?></td>
                                </tr>

                                <tr>
                                    <td><strong> Exam Type </strong></td>
                                    <td><?php echo $viewexam_examtype; ?></td>
                                </tr>

                                <tr>
                                    <td><strong> Exam Price </strong></td>
                                    <td>
                                        <div id="ppp">
                                            <?php echo 'GBP ' . $viewexam_examprice; ?>
                                        </div>    
                                    </td>


                                </tr>

                                <tr>
                                    <td><strong> Exam Time </strong></td>
                                    <td><?php echo $viewexam_examtime; ?></td>
                                </tr>
                            </tbody>
                        </table>


                        <?php
                        if ($viewexam_examtype != 'SAMPLE') {
                            echo CHtml::ajaxButton('Add to cart', array('shoppingcart/addExam'), array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'data' => array('exam_id' => $viewexam_exam_id),
                                'success' => 'js:function(data){
                                    $("#quantityWidget").text(data.shopping_cart_qty);
                                    cartAnimation(data.response);
                                }'
                                    ), array(
                                'class' => 'smallbluebtn',
//                               'id' => 'exam_' . $viewexam_exam_id
                                'id' => Util::getRandomID('exam_view_' . $viewexam_exam_id),
                            ));
                        }
                        ?>

                        <br /><br /><br />

                    </div></div>

            </div>


        </div> 

    </div>
</div>
