<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/slick.css" />-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/advancedticker.css" />-->
<!---->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easing.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easy-ticker.js"></script>-->
<br><br>
<?php $this->pageTitle = Yii::app()->name; ?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/news.css"/>
<div class="slider-area">
    <div class="preview-2">
        <div id="nivoslider" class="slides">
            <img src="themes/bootstrap/img/slider/1.jpg" alt="" title="#slider-1-caption1"/>
            <img src="themes/bootstrap/img/slider/2.jpg" alt="" title="#slider-1-caption2"/>
        </div>
        <div id="slider-1-caption1" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content">
                                    <h1 class="title1 wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="0s">SMILE WITH<br>
                                        RESULTS</h1>
                                    <p class="sub-title wow fadeInUp hidden-sm hidden-xs" data-wow-duration="2900ms" data-wow-delay=".5s"> There are many variations of passages of Lorem Ipsum available, but the majority have<br>
                                        suffered alteration in some form, by injected humour, or randomised words which<br>
                                        don't look even slightly believable.</p>
                                    <div class="banner-readmore wow fadeInUp" data-wow-duration="3600ms" data-wow-delay=".6s">
                                        <?php echo CHtml::link('View our products', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slider-1-caption2" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content slide-2">
                                    <h1 class="title1 wow rotateInDownLeft" data-wow-duration="1000ms" data-wow-delay="0s">LEARN CMMA WITH<br>
                                        WORLD NO.1 CASE STUDY</h1>
                                    <p class="sub-title wow rotateInDownLeft hidden-sm hidden-xs" data-wow-duration="1800ms" data-wow-delay="0s"> There are many variations of passages of Lorem Ipsum available, but the majority have<br>
                                        suffered alteration in some form, by injected humour, or randomised words which<br>
                                        don't look even slightly believable.</p>
                                    <div class="banner-readmore wow rotateInDownLeft" data-wow-duration="1800ms" data-wow-delay="0s">

                                        <?php echo CHtml::link('View our products', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="about-container">
                    <h3>WHY NANASKA ?</h3>
                    <h5>Our Mission</h5>
                    <p>To be the preferred online tuition provider, with personalized service and value for money.</p>

                    <h5>What we strive for ?</h5>
                    <p>To develop a student who enjoys studying, we enjoy teaching, CIMA enjoys passing, companies working with.</p>
                    <?php echo CHtml::link('Discover More', array('Site/viewAboutus'), array('class' => 'button-default')); ?>
<!--                    <a class="button-default" href="about.html">Discover More</a>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Course Area Start-->
<div class="course-area section-padding bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-wrapper">
                    <div class="section-title">
                        <br> <br>
                        <h3>Our Products</h3>
                        <br>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="single-item">
                    <div class="single-item-image overlay-effect">
                        <a href="#"><img src="themes/bootstrap/img/course/1.jpg" alt=""></a>
                    </div>
                    <div class="single-item-text">
                        <h4><a href="#">STRATEGIC LEVEL</a></h4>
                        <div class="single-item-text-info">
                            <span>By: <span>M S Nawaz</span></span>
                            <span>Date: <span>Feb 2020</span></span>
                        </div>
                        <p>There are many variations of sages of Lorem Ipsum available, but the mrity have suffered alteration in some orm, by injected humo ur,There are many but the mri have suffered alteration in some </p>

                    </div>
                    <div class="button-bottom">
                        <?php echo CHtml::link('Learn Now', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>

                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="single-item">
                    <div class="single-item-image overlay-effect">
                        <a href="#"><img src="themes/bootstrap/img/course/2.jpg" alt=""></a>
                    </div>
                    <div class="single-item-text">
                        <h4><a href="#">MANAGEMENT LEVEL</a></h4>
                        <div class="single-item-text-info">
                            <span>By: <span>Subas Das</span></span>
                            <span>Date: <span>Feb 2020</span></span>
                        </div>
                        <p>There are many variations of sages of Lorem Ipsum available, but the mrity have suffered alteration in some orm, by injected humo ur,There are many but the mri have suffered alteration in some </p>

                    </div>
                    <div class="button-bottom">
                        <?php echo CHtml::link('Learn Now', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-sm">
                <div class="single-item">
                    <div class="single-item-image overlay-effect">
                        <a href="#"><img src="themes/bootstrap/img/course/3.jpg" alt=""></a>
                    </div>
                    <div class="single-item-text">
                        <h4><a href="#">FOUNDATION LEVEL</a></h4>
                        <div class="single-item-text-info">
                            <span>By: <span>Momin Boss</span></span>
                            <span>Date: <span>Not Available</span></span>
                        </div>
                        <p>There are many variations of sages of Lorem Ipsum available, but the mrity have suffered alteration in some orm, by injected humo ur,There are many but the mri have suffered alteration in some </p>

                    </div>
                    <div class="button-bottom">
                        <?php echo CHtml::link('Learn Now', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 text-center">
                <?php echo CHtml::link('DISCOVER ALL PRODUCTS', array('Site/viewOurProduct'), array('class' => 'button-default button-large')); ?>

            </div>
        </div>
    </div>
</div>
<!--End of Course Area-->


<!--Testimonial Area Start-->
<div class="row">
    <div class="col-md-12">
        <div class="section-title-wrapper">
            <div class="section-title">
                <br> <br>
                <h3>Testimonials</h3>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="testimonial-area">
    <div class="container">


        <div class="row">
            <div class="col-lg-12 col-lg-offset-0 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                        <div class="testimonial-image-slider text-center">

                            <?php
                            $modeltestimonials = new Testimonials();
                            $data=  $modeltestimonials->getTestimonials();
                                 if (empty($data)) {
                                     echo '<div class="well">';
                                     echo '<center><b>Testimonials not available</b></center>';
                                     echo '</div>';
                                 } else {
                                     foreach ($data as $item) {
                                          echo '<div class="sin-testiImage">
                                                   <img src="'.$item['image_url'].'" alt="testimonial 1" />
                                                 </div>';
                                     }

                                 }

                            ?>
                        </div>
                    </div>
                </div>
                <div class="testimonial-text-slider text-center">
                    <?php
                    if (!empty($data)) {

                         foreach ($data as $item)
                         {
                             echo '<div class="sin-testiText">
                            <h2>'.$item['testimonials_name'].'</h2>
                            <p>'.$item['testimonials_description'].'</p>
                        </div>';
                         }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<br/><br/><br/>
<!--End of Testimonial Area-->
<!--Latest News Area Start-->
<div class="latest-area section-padding bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-wrapper">
                    <div class="section-title">
                        <h3>What we really do ?</h3>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a href="#"><img src="themes/bootstrap/img/latest/1.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a href="#">LEAD LECTURE</a></h3>

                        <p>There are many variaons of passages of Lorem Ipsuable, amrn in some by injected humour, </p>
                        <a href="#" class="button-default">Lead Lecturer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a href="#"><img src="themes/bootstrap/img/latest/2.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a href="#">OUR SPECIALTY</a></h3>

                        <p>There are many variaons of passages of Lorem Ipsuable, amrn in some by injected humour, </p>
                        <a href="#" class="button-default">Read MORE</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a href="#"><img src="themes/bootstrap/img/latest/3.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a href="#">OUR FORUM</a></h3>
                        <p>There are many variaons of passages of Lorem Ipsuable, amrn in some by injected humour, </p>
                        <a href="#" class="button-default">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a href="#"><img src="themes/bootstrap/img/latest/4.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a href="#">SYLLABUS</a></h3>
                        <p>There are many variaons of passages of Lorem Ipsuable, amrn in some by injected humour, </p>
                        <a href="#" class="button-default">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Latest News Area-->
<!--Event Area Start-->
<br> <br>
<div class="event-area section-padding"style="background-Color:#2d3e50;min-height: 250px;">
    <div class="container"style="background-color:#2d3e50">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text "style="color:white !important;">
                    <div class="breadcrumb-text"style=",color:White;font-weight:bold;text-align:center;padding-bottom: 10px;">
                        <br> <br>
                        <h3>OUR LATEST NEWS</h3>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>

        #inner1{
            float:left;
        }
        #inner2{
            float:left;
            clear: left;
        }
    </style>

    <div class="row">
        <section id="carousel">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12 col-md-offset text-center">

                        <div class="carousel slide text-center" style="color:white;" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
                            <?php
                                $msgs = News::model()->getBroadcastNews();
                                if (empty($msgs)) {
                                    echo '<div class="well">';
                                    echo '<center><b>News not available</b></center>';

                                    echo '</div>';
                               } else {
                            ?>


                            <!-- Carousel items -->

                            <div class="carousel-inner text-center" style="Color:white;">
                                <?php
                                $count = 0;
                                foreach ($msgs as $msg) {

                                    if ($count == 0) {
                                        echo '<div class="active item text-center">
                                                    <blockquote>
                                                        <p>' . $msg['message'] . '</p>
                                                    </blockquote>
                                                </div>';
                                    } else {
                                        echo ' <div class="item">
                                    <blockquote>
                                     <p>' . $msg['message'] . '</p>
                                    </blockquote>

                                </div>';
                                    }
                                    ++$count;
                                }
                                }
                                ?>

                            </div>
                            <!-- Carousel indicators -->

                                <ol class="carousel-indicators text-center" style="margin-top:150px;">
                                    <?php
                                    $counter = 0;

                                    foreach ($msgs as $msg) {

                                        if ($counter == 0) {
                                            echo '<li data-target="#fade-quote-carousel text-center" data-slide-to="' . $counter . '" class="active"></li>';
                                        } else {
                                            echo '<li data-target="#fade-quote-carousel text-center" data-slide-to="' . $counter . '"></li>';
                                        }
                                        ++$counter;
                                    }

                                    ?>
                                </ol>
                            </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!--End of Event Area-->
<br/><br/><br/>


<!--Fun Factor Area Start-->
<div class="fun-factor-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-wrapper white">
                    <div class="section-title">
                        <h3>IMPORTANT FACTS</h3>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h4>Tutors</h4>
                    <h2><span class="counter">15</span>+</h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h4>Students</h4>
                    <h2><span class="counter">1000</span>+</h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h4>Courses</h4>
                    <h2><span class="counter">8</span>+</h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h4>Countries</h4>
                    <h2><span class="counter">20</span>+</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Fun Factor Area-->

<br/><br/><br/>

<!--<div class="container footer-stable">-->
<!--    <div class="row"> -->
<!---->
<!--        <div class="span4">-->
<!--            --><?php
//            $msgs = News::model()->getBroadcastNews();
//            if (empty($msgs)) {
//                echo '<div class="well">';
//                echo '<center><b>News not available</b></center>';
//
//                echo '</div>';
//            } else {
//                ?>
<!--                           <div style="text-align: center;">-->
<!--                                    <i class="icon-arrow-up" id="nt-example1-prev"></i>-->
<!--                                </div>-->
<!--                <div id="nt-example1-container">-->
<!---->
<!--                    <ul id="nt-example1">-->
<!--                        --><?php
//                        foreach ($msgs as $msg) {
//                            ?>
<!--                            <li class="news-row">--><?php //echo $msg['message']; ?><!--</li>-->
<!--                            --><?php
//                        }
//                        ?>
<!--                    </ul>-->
<!--                </div>-->
            <!-- <div style="text-align: center;">-->
<!--                                    <i class="icon-arrow-down" id="nt-example1-next"></i>-->
<!--                      </div>-->
<!--                --><?php
//            }
//            ?>
<!--        </div>-->
<!--    </div>-->


<!--    <div class="row">-->
<!--        <div class="span8">-->
<!--            <div class="span3 text-align-center" id="syllabus_logo"><img id="syllabus_img" name="syllabus_img" src="assets/img/syllabus.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"><h4>2015 Syllabus</h4> </div>-->
<!--            <div class="span3 text-align-center" id="lecturer_logo"><img id="lecturer_img" name="lecturer_img" src="assets/img/lead_lecture.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"> <h4>Lead Lecturer</h4></div>-->
<!--            <div class="span3 text-align-center" id="speciality_logo"><img id="speciality_img" name="speciality_img" src="assets/img/our_strengths.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"><h4>Our Specialty</h4></div>-->
<!--            <div class="span3 text-align-center" id="forum_logo"> <a href="http://forum.learncima.com/forum" target="_blank"><img src="assets/img/forum.jpg" class="img-responsive circle-border" alt="Responsive image"></a><h4>Our Forum</h4> </div>-->
<!---->
<!--        </div>-->
<!--        <div class="span4 videoWrapper" id="youtubevid">-->
<!--            <iframe width="380" height="240" src="//www.youtube.com/embed/ku3Wo0Ul4-0" frameborder="0" allowfullscreen></iframe>-->
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <div id="lead_lecturer_info" style="display: none">-->
<!--        <h2>Lead Lecturer</h2>-->
<!--        <br />-->
<!--        <div class="row">-->
<!--            <div class="span1"></div>-->
<!---->
<!--            <div class="span3">-->
<!--                <div id="pic-channa">                        -->
<!--                    <img src="--><?php //echo Yii::app()->baseUrl; ?><!--/assets/img/mrchanna3.jpg" />-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="span5">-->
<!--                <ul id="ul-qualifications1">-->
<!--                    <br /><br />-->
<!--                    <li>Fellow Member of CIMA.</li>-->
<!--                    <li>Fellow Member of the Institute of Chartered Accountants of Sri Lanka.</li>-->
<!--                    <li>MBA from University of Southern Queensland, Australia.</li>-->
<!--                    <li>First Class Degree from University of Sri Jayewardenepura, Sri Lanka.</li>                        -->
<!--                </ul>-->
<!--            </div>                -->
<!--        </div>-->
<!--        <br />-->
<!---->
<!--        <div class="row">-->
<!--            <div class="span11">-->
<!--                <div class="span7">-->
<!--                    <ul id="ul-qualifications2">-->
<!--                        <li>Over 17 years of lecturing experience.</li>-->
<!--                        <li>The lecturer for P3 (Performance Strategy), E3 (Enterprise Strategy) and T4 at one of the largest CIMA Institutes in the world.</li>-->
<!--                        <li>Conducted revision programmes in Malaysia, Singapore, India, Hong Kong & Indonesia for P3 and for T4 as invited by CIMA Malaysia & CIMA Singapore.</li>-->
<!--                        <li>Ex-Part Time Lecturer for MBA at Post Graduate Institute of Management, University of Sri Jayewardenepura.</li>-->
<!--                    </ul>-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="span5">-->
<!--                    <h4 align="justify" id="heading-prfessionalexp">Professional Experiences</h4>-->
<!--                    <ul id="ul-qualifications1">-->
<!--                        <br />-->
<!--                        <li>Country Manager for Ernst and Young, Maldives. (2000 to 2002)</li>-->
<!--                        <li>CFO for a multinational manufacturing entity. (2003 to up to date)</li>-->
<!--                        <li>With his experiences and knowledge, a great mixture of theory and application for CIMA is assured.</li>-->
<!--                    </ul>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <div id="syllabus_info" style="display: none">-->
<!--        <h2>2015 Syllabus</h2><br/>-->
<!--        <img src="assets/img/syllabus_pic.jpg" class="img-responsive" alt="Responsive image"> -->
<!--    </div>-->
<!--    <div id="specialty_info" style="display: none">-->
<!--        <h2>Our Specialty</h2>-->
<!--        <div class="span5">-->
<!--            <ul id="ul-qualifications1">-->
<!--                <br /><br />-->
<!--                <li>Personalized attention</li>-->
<!--                <li>1-2-1 coaching</li>-->
<!--                <li>Practice exams</li>-->
<!--                <li>Live classrooms</li>-->
<!--                <li>Best technology</li>-->
<!--                <li>Speedy response</li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!---->
<!--</div>-->

<!--    /container -->

<!--<div class="bottom_container_newsletter">-->
<!--    <div class="container"> <h2> For Free Materials  </h2> <p> by submitting your email address we will be able to send you free materials </p>-->
<!--        <form class="form-search">-->
<!--            <div class="span5"></div>-->
<!--            <div class="span3" style="margin-left: 0px;">-->
<!--                <input id="news_text_box" type="email" class="input-medium search-query" placeholder="Your Email Address" required>-->
<!--                                        <button type="submit" class="button button-signin">Submit</button>-->
<!--                --><?php
//                echo CHtml::ajaxButton('Submit', array('User/sendMaterialMail'), array(
//                    'type' => 'POST',
//                    'dataType' => 'json',
//                    'data' => array('mail' => 'js:news_text_box.value'),
//                    'beforeSend' => 'function(){
//                $("#loading").addClass("loading_front");}',
//                    'complete' => 'function(){
//                 $("#loading").removeClass("loading_front");}',
//                    'success' => 'js:function(data){
//                                    var google_conversion_id = 962159633;
//                                    var google_conversion_language = "en";
//                                    var google_conversion_format = "3";
//                                    var google_conversion_color = "ffffff";
//                                    var google_conversion_label = "4OI5CIPOhVkQkcjlygM";
//                                    var google_remarketing_only = false;
//
//                                    $.getScript( "http://www.googleadservices.com/pagead/conversion.js" );
//
//                                    bootbox.alert(data.msg);
//                                    document.getElementById("news_text_box").value="";
//                                }'
//                        ), array(
//                    'class' => 'button button-signin',
//                    'id' => 'material_submit' . rand(0, 99),
//                ));
//                ?>
<!--            </div>-->
<!--            <div class="span1" style="margin-left: -10px;">-->
<!--                <div id="loading" style="width: 32px; height: 32px;"></div>-->
<!--            </div>-->
<!--        </form>-->
<!---->
<!--    </div>-->
<!--</div>-->

<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/slick.min.js"></script> -->
<!--<script>-->
<!--                //	$(document).ready(function(){-->
<!--                //		$('.slider').slick({-->
<!--                //		  slidesToShow: 5,-->
<!--                //		  slidesToScroll: 1,-->
<!--                //		  autoplay: true,-->
<!--                //		  autoplaySpeed: 2000,		-->
<!--                //		  vertical:true-->
<!--                //		});-->
<!--                //	});-->
<!--</script>-->

<!--<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 962159633;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "4OI5CIPOhVkQkcjlygM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/962159633/?label=4OI5CIPOhVkQkcjlygM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>-->




<!--<script type="text/javascript">-->
<!---->
<!--    function renderRest(element) {-->
<!--        //alert(element.name);-->
<!--        var options = {};-->
<!--        if (element.name == "syllabus_img") {-->
<!--            $('#lead_lecturer_info').hide();-->
<!--            $('#specialty_info').hide();-->
<!--            $('#syllabus_info').slideDown(1000);-->
<!--            //if(document.getElementById('syllabus_info').style.visibility == "hidden"){-->
<!--            $('html, body').animate({-->
<!--                scrollTop: $('#syllabus_info').offset().top-->
<!--            }, 1200);-->
<!--            //}-->
<!---->
<!--        } else if (element.name == "lecturer_img") {-->
<!--            $('#syllabus_info').hide();-->
<!--            $('#specialty_info').hide();-->
<!--            $('#lead_lecturer_info').slideDown(1000);-->
<!--            $('html, body').animate({-->
<!--                scrollTop: $('#lead_lecturer_info').offset().top-->
<!--            }, 1000);-->
<!---->
<!--        } else if (element.name == "speciality_img") {-->
<!--            $('#syllabus_info').hide();-->
<!--            $('#lead_lecturer_info').hide();-->
<!--            $('#specialty_info').slideDown(1000);-->
<!--            $('html, body').animate({-->
<!--                scrollTop: $('#specialty_info').offset().top-->
<!--            }, 1000);-->
<!---->
<!--        }-->
<!--    }-->
<!--</script>-->


<!--<script type="text/javascript">-->
<!--    $(document).ready(function () {-->
<!---->
<!--        var dd = $('#nt-example1-container').easyTicker({-->
<!--            direction: 'up',-->
<!--            easing: 'easeInExpo',-->
<!--            speed: 'slow',-->
<!--            interval: 3000,-->
<!--            height: 350,-->
<!--            visible: 4,-->
<!--            mousePause: 1,-->
<!--            controls: {-->
<!--                up: '#nt-example1-prev',-->
<!--                down: '#nt-example1-next'-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->
