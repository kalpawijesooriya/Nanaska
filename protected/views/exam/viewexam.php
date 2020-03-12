<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/tabs.css" />

<script type="text/javascript">
    function clearFunction() {        
        x=document.getElementsByClassName("req_res");  // Find the elements
        for(var i = 0; i < x.length; i++){
            x[i].innerHTML="<div id='course-description'><div class='span4'></div><div class='span6'><br /><br /><div class='master_heading'> <h4>Instructions<h4></div><li>Please click on courses to see the relevant levels.</li><li>Select levels from the left hand side navigation to view exams relent to each level.</li><li>You have to purchase exams before taking them.</li> </div> </div>";    // Change the content
        }
        
    }
    
    function hideFunction(){
        $('.course-description').hide();
    }

</script>

<?php
$courses = $courseModel;
$levels = $courseLevelModel;
$list_data = array();

foreach ($courses as $course) {
    $list_data[$course->course_id] = $course->course_name;
}
?>

<div class="row-fluid">

    <div class="container footer-stable">
        <div class="btn-group text-center">
            <ul class="hidden-for-phone dropdown-menu dr-breakout text-center">
                <?php
                foreach ($courses as $key => $course) {
                    if ($key === 0) {
                        echo '<li class="button" ><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt" onclick="clearFunction()">' . $course->course_name . '</a></li>';
                    } else {
                        echo '<li class="button"><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt" onclick="clearFunction()">' . $course->course_name . '</a></li>';
                    }
                }
                ?>

            </ul>
        </div>
        <div class="tab-content hidden-for-phone">
            <?php
            foreach ($courses as $key => $course) {

                if ($key === 0) {
                    echo '<div class="tab-pane active" id="' . $course->course_id . '">';
                } else {
                    echo '<div class="tab-pane" id="' . $course->course_id . '">';
                }
                echo '<div class="col-xs-6 col-sm-3 col-lg-3" id="sidebar" role="navigation">';
                echo '<div class="level-names style="style="float:left; height: auto;">';

                echo '<ul class="levels-nav level-ul">';
                foreach ($levels as $course_id => $courseLevels) {
                    if ($course->course_id == $course_id) {
                        foreach ($courseLevels as $courseLevel) {
                            echo CHtml::ajaxLink('<li>' . $courseLevel->level_name . '</li>', Yii::app()->createUrl('exam/viewDetails'), array(
                                'type' => 'POST',
                                //'dataType' => 'json',
                                'onClick' => 'js:hideFunction()',
                                'data' => array('levelId' => $courseLevel->level_id, 'courseID' => $course_id),
                                'update' => '.req_res',
                                    ), array('class' => 'link-background '));
                        }
                    }
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
            ?>
        </div>

            <div class="req_res" style="margin-top: -5%">

                

            <?php
            if (!empty($courses)) {
                ?>
                <div class="span4"></div><div class='span6'><div class='master_heading' style="margin-bottom: 10px"><h4>Instructions</h4></div><li>Please click on courses to see the relevant levels.</li><li>Select levels from the left hand side navigation to view exams relent to each level.</li><li>You have to purchase exams before taking them.</li> </div> </div><br><br><br>
            <?php
        } else {
            ?>
            <div class='span1'></div><div class='span4'><br /><br /><p>Sorry, this content is not currently available.</p></div> </div>
        <?php
    }
    ?>

</div>
</div>


<div class="hidden-for-desktop text-center">
    <?php
    echo CHtml::dropDownList('course-list', '', $list_data, array(
        'prompt' => 'Select Course',
        'ajax' => array(
            'type' => 'POST',
            'url' => Yii::app()->createUrl('exam/loadCourseLevels'), //or $this->createUrl('loadcities') if '$this' extends CController
            'update' => '#level-list', //or 'success' => 'function(data){...handle the data in the way you want...}',
            'data' => array('course_id' => 'js:this.value'),
            )));
    ?>

    <br /><br />

    <?php
    $level_list = array();

    echo CHtml::dropDownList('level-list', '', array(), array('prompt' => 'Select Level',
        'ajax' => array(
            'type' => 'POST',
            'url' => Yii::app()->createUrl('exam/viewDetails'), //or $this->createUrl('loadcities') if '$this' extends CController
            'update' => '.req_res', //or 'success' => 'function(data){...handle the data in the way you want...}',
            'data' => array('levelId' => 'js:this.value'),
            )));
    ?>

    <div class="req_res">

    </div>
</div>

</div>


<?php
//    Yii::app()->session['userViewDetails'] = array();
?>
<br/><br/><br/><br/><br/><br/><br/><br/>

<script type="text/javascript">
    $('.level-ul li').click(function () {
        $('.highlight').removeClass('highlight');
        $(this).addClass('highlight');

    });
</script>
<style>
    @media (min-width: 700px) {
        .dr-breakout-btn {
            display: none;
        }
        .dr-breakout {
            display: inline;
            background: transparent;
            box-shadow:none;
            border:none;
            position: relative;
            margin:0;
        }
        .dr-breakout li {
            align-content: center;
            display:inline;
        }
        .dr-breakout li a {
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
        }
    }

    body {
        background-color:#83a5b4;
    }
    .btn-group {

        alignment: center;
        margin: 50px 17%;
    }
    .container{
        width: 90% !important;
    }
</style>
<style>
    .courses{
        margin-right: 5%;
    }
    button{
        padding-left: 5%;
        padding-right: 5%;
        width:250px;
    }
</style>

<script>
    function cart(param) {

        var examId = $(param).data('examid');
        $.ajax({
            type: 'POST',
            async:false,
            url: '<?php echo Yii::app()->createUrl('shoppingcart/addExam'); ?>',
            data:{'exam_id':examId},
            success:function(data){
                console.log(data)
                data= $.parseJSON(data)
                $("#quantityWidget").text(data.shopping_cart_qty);
                document.getElementById("quantityWidget").style.visibility = "visible";
                cartAnimation(data.response);
            },
            error: function(data) {
                console.log(data)
            },


        });
    }
</script>
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



