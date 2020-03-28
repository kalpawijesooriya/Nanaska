<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/slick.css" />-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/advancedticker.css" />-->
<!---->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easing.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easy-ticker.js"></script>-->
<br>
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

                            <span>Date: <span><?php echo $strategicCommencement; ?></span></span>
                        </div>
                        <p>This is the  final hurdle of CIMA students. We offer a range of products with individual attention & complete 24/7 service support  to pass this level with flying colours. Click below for more details. <br> <br></p>

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

                            <span>Date: <span><?php echo $managerialCommencement; ?></span></span>
                        </div>
                        <p>Our MCS Course once produced World's No 1 and we make you pass. Click below to learn more about our range of products which consits of 10 steps & key is 6 mock exams based on current pre seen in the real exam engine.	 </p>

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

                            <span>Date: <span><?php echo $foundationCommencement; ?></span></span>
                        </div>
                        <p>With the full emphasis of E1, P1 and F1 where we revise all key theory aspects and with a detailed past paper analysis, we are offering a course for OCS. Click below for learn more. <br> <br>  </p>

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
<div class="testimonial-area" style="height: 50% !important;">
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
                <div class="testimonial-text-slider text-center" style="width: 100%">
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
<br/>
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
                        <a ><img src="themes/bootstrap/img/latest/1.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >LEAD LECTURER</a></h3>

                        <p style="margin-bottom: 15px"> Mr. Channa leads a panel  of 23 lectures <br> <br> <br><br></p>

                        <?php echo CHtml::link('READ MORE', array('Site/leadLecture'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/2.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >OUR SPECIALTY</a></h3>

                        <p style="margin-bottom: 15px">Our commitments for your success.<br> <br> <br><br>  </p>

                        <?php echo CHtml::link('READ MORE', array('Site/ourSpecialty'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/3.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >OUR FORUM</a></h3>
                        <p style="margin-bottom: 15px"> Virtual space to access all study materials, videos & clarify doubts. <br> <br> <br>  </p>
                        <a href="http://learncima.co.uk/nanaska/" class="button-default">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/4.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >SYLLABUS</a></h3>
                        <p style="margin-bottom: 15px">CIMA Syllabus 2020	<br> <br> <br> <br></p>
                        <?php echo CHtml::link('READ MORE', array('Site/syllabus'), array('class' => 'button-default')); ?>
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



