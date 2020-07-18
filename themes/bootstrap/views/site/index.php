<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/slick.css" />-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/css/advancedticker.css" />-->
<!---->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easing.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/js/jquery.easy-ticker.js"></script>-->
<div class="logo hidden-for-desktopView">

<br>
</div>
<style>
        @media (min-width: 1024px) {
            .hidden-for-desktopViews {
                display: none;
            }
            .button{
                margin-left:-10px
            }
            .products{
                display: none;
            }
        }
        @media (max-width:629px) {
            .hidden-for-mobileViews {
                display: none;
            }

            .button{
                margin-left:-10px
            }
            .title{
                font-size:20px
            }
            .products{
                display: block;
            }
        }
    </style>
<?php $this->pageTitle = Yii::app()->name; ?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/news.css"/>

<div class="slider-area"  >
    <div class="preview-2">
        <div id="nivoslider" class="slides">
            <img src="themes/bootstrap/img/slider/Slider 1.jpg" alt="" title="#slider-1-caption1"/>
            <img src="themes/bootstrap/img/slider/Slider 6.jpg" alt="" title="#slider-1-caption2"/>
            <img src="themes/bootstrap/img/slider/Slider 2.jpg" alt="" title="#slider-1-caption3"/>
            <img src="themes/bootstrap/img/slider/Slider 3.jpg" alt="" title="#slider-1-caption4"/>
            <img  src="themes/bootstrap/img/slider/Slider 4 .jpg" alt="" title="#slider-1-caption5"/>
            <img  src="themes/bootstrap/img/slider/Slider 5.jpg" alt="" title="#slider-1-caption6"/>
        </div>
        <div id="slider-1-caption1" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content">
                                    <h1 class="title1 title wow fadeInUp slide1" data-wow-duration="1000ms" data-wow-delay="0s" >LEARN CIMA WITH<br>
                                   <spain  class="slide2"> WORLD NO. 1 CASE STUDY PROVIDER </spain></h1>
                                    <p class="sub-title wow fadeInUp hidden-sm hidden-xs" data-wow-duration="1900ms" data-wow-delay=".5s"> Join with the best online provider for Case Study exams with inspirational individual support!<br>
                                      </p>
                                    <div class="banner-readmore wow fadeInUp" data-wow-duration="6600ms" data-wow-delay=".6s">
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
                                <div class="text-content">
                                   
                                    <p class="sub-title wow fadeInUp hidden-sm hidden-xs" data-wow-duration="2900ms" data-wow-delay=".5s"> 
                                        </p>
                                    <div class="banner-readmore wow fadeInUp" data-wow-duration="600ms" data-wow-delay=".1s" style="margin-right:550px;margin-top:370px">
                                      <a href="https://forms.gle/LbsJKeVRpEa7xd418" class="button-default" target="_blank">Register Now</a>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="slider-1-caption3" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content slide-2 hidden-for-mobileViews" >
                                  
                                  
                                   
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="slider-1-caption4" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content">
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slider-1-caption5" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slider-1-caption5" class="nivo-html-caption nivo-caption">
            <div class="banner-content slider-6">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-content-wrapper">
                                <div class="text-content">
                                   
                                    <p class="sub-title wow fadeInUp hidden-sm hidden-xs" data-wow-duration="2900ms" data-wow-delay=".5s"> 
                                        </p>
                                    <div style="margin-top:180px"  class="banner-readmore wow fadeInUp" data-wow-duration="2000ms" data-wow-delay=".6s">
                                      <a class="button-default"  href="#testimonial-area">Success Stories</a>
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



<div class="about-area" style="margin-top:40px">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="about-container">
                    <h3>WHY NANASKA ?</h3>
                    <h5>Our Mission</h5>
                    <p>To be the preferred online tuition provider, with personalized service and value for money.</p>

                    <h5>What we strive for ?</h5>
                    <p>To develop a student who enjoys studying, we enjoy teaching, CIMA enjoys passing, companies enjoy working with.						</p>
                    <?php echo CHtml::link('Discover More', array('Site/viewAboutus'), array('class' => 'button-default')); ?>
<!--                    <a class="button-default" href="about.html">Discover More</a>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Course Area Start-->
<div class="course-area section-padding bg-white" > 
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-wrapper">
                    <div class="section-title">
                  <div class="hidden-for-desktopView"><br><br></div>
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
                        <p style="text-align:justify;text-justify:inner-word">This is the  final hurdle of CIMA students. We offer a range of products with individual attention & complete 24/7 service support  to pass this level with flying colours. Click below for more details. <br> <br></p>
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
                        <p style="text-align:justify;text-justify:inner-word">Our MCS Course once produced World's No 1 and we make you pass. Click below to learn more about our range of products which consits of 10 steps & key is 6 mock exams based on current pre seen in the real exam engine.	 </p>

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
                        <h4><a href="#">OPERATIONAL LEVEL</a></h4>
                        <div class="single-item-text-info">

                            <span>Date: <span><?php echo $operationalCommencement; ?></span></span>
                        </div>
                        <p style="text-align:justify;text-justify:inner-word">With the full emphasis of E1, P1 and F1 where we revise all key theory aspects and with a detailed past paper analysis, we are offering a course for OCS. Click below for learn more. <br> <br>  </p>

                    </div>
                    <div class="button-bottom">
                        <?php echo CHtml::link('Learn Now', array('Site/viewOurProduct'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 text-center">
                <?php echo CHtml::link('DISCOVER ALL PRODUCTS', array('Site/viewOurProduct'), array('class' => 'button-default button-large','style'=>'margin-top:20px!important')); ?>

            </div>
        </div>
    </div>
</div>
<!--End of Course Area-->

<div id="testimonial-area"></div>
<!--Testimonial Area Start-->
<div class="row" >
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
<div class="testimonial-area" style="height: 50% !important;" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-0 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2" >
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
                <div class="testimonial-text-slider"  style="width: 100%" >
                    <?php
                    if (!empty($data)) {

                         foreach ($data as $item)
                         {
                             echo '<div class="sin-testiText" >
                            <h2 class="text-center">'.$item['testimonials_name'].'</h2>
                            <p style="text-align:justify!important; text-justify:inner-word!important;">'.$item['testimonials_description'].'</p>
                        </div>';
                         }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="hidden-for-desktopView"><br><br></div>
<!--End of Testimonial Area-->
<!--Latest News Area Start-->
<div class="latest-area section-padding bg-white" >
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
                        <a ><img src="themes/bootstrap/img/latest/Lead Lecturer home page .jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >LEAD LECTURER</a></h3>

                        <p style="margin-bottom: -30px"> Mr. Channa leads a panel  of 23 lectures <br> <br> <br><br></p>

                        <?php echo CHtml::link('READ MORE', array('Site/leadLecture'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/Our Specialty.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >OUR SPECIALTY</a></h3>

                        <p style="margin-bottom: -30px">Our commitments for your success.<br> <br> <br><br>  </p>

                        <?php echo CHtml::link('READ MORE', array('Site/ourSpecialty'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/Our Forum.jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >OUR FORUM</a></h3>
                        <p style="margin-bottom: -7px"> Virtual space to access all study materials, videos & clarify doubts. <br> <br> <br>  </p>
                        <a href="http://learncima.co.uk/nanaska/" class="button-default" target="_blank">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="single-latest-item">
                    <div class="single-latest-image">
                        <a ><img src="themes/bootstrap/img/latest/Syllabus home page .jpg" alt=""></a>
                    </div>
                    <div class="single-latest-text">
                        <h3><a >SYLLABUS</a></h3>
                        <p style="margin-bottom:-7px">CIMA Syllabus 2020	<br> <br> <br> <br></p>
                        <?php echo CHtml::link('READ MORE', array('Site/syllabus'), array('class' => 'button-default')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Latest News Area-->
<div class="hidden-for-desktopView"><br><br></div>

<div class="event-area section-padding usa"style="background-Color:#2d3e50;">
    <div class="container"style="background-color:#2d3e50">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text "style="color:white !important;">
                    <div class="breadcrumb-text"style=",color:White;font-weight:bold;text-align:center;padding-bottom: 10px;">
                        <h3 style="padding-top: 20px">OUR LATEST NEWS</h3>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media (min-width: 1024px) {
            .new {
                margin-top:100px;
                padding-top:150px;
                margin-left:150px !important
            }
            .usa{
                min-height: 400px
            }
            button.{
                margin-left:80px !important
            }

        }

        @media (max-width:629px) {
             .new {
                margin-top:250px;
                padding-top:250px;
                margin-left:50px !important
            }
            .usa{
                min-height: 650px
            }
            button.{
                margin-left:50px!important
            }
        }
    </style>
    <div class="row">
        <section id="carousel">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-offset">

                        <div class="carousel slide" style="color:white;" id="fade-quote-carousel" data-ride="carousel" data-interval="3000" data-pause="true">
                            <!-- Carousel indicators -->
                            <ol class="carousel-indicators text-center new" style="">
                                <?php
                                $msgs = News::model()->getBroadcastNews();
                                $counter = 0;
                                foreach ($msgs as $msg) {

                                    if ($counter == 0) {
                                        echo '<li class="active text-center  button" data-target="#fade-quote-carousel"  data-slide-to="' . $counter . '" ></li>';
                                    } else {
                                        echo '<li data-target="#fade-quote-carousel" style="margin-left:10px" data-slide-to="' . $counter . '"class="text-center"></li>';
                                    }
                                    ++$counter;
                                }
                                ?>
                            </ol>

                            <style>
                                @media (min-width: 1024px) {
                                    .button {
                                      margin-left:40px !important 
                                    }

                                }

                                @media (max-width:629px) {
                                    .button {
                                        margin-left:0px !important 
                                    }
                                    
                                }
                            </style>
                            <!-- Carousel items -->
                            <div class="carousel-inner"style="Color:white;">
                              <?php
                                $msgs = News::model()->getBroadcastNews();
                                $counter = 0;
                                $count = 0;
                                foreach ($msgs as $msg)
                                {
                                    if ($count==0)
                                    {
                                        echo '
                                       <div class="active item" style="padding-left: 50px">
                                         <blockquote>
                                           <div class="row">';
                                            foreach ($msg as $item) {
                                               echo '<div class="col col-lg-6 col-sm-6" style="margin-bottom:10px;height:80px;margin-top:40px"><i class="zmdi-hc-li zmdi zmdi-dot-circle-alt"></i>'. $item['message'] .'</div>';
                                            }
                                        echo ' </div>
                                         </blockquote>
                                       </div>';
                                    }else
                                        {
                                            echo '
                                       <div class="item" style="padding-left: 50px">
                                         <blockquote>
                                           <div class="row">';
                                            foreach ($msg as $item) {
                                                echo '<div class="col col-lg-6 col-sm-6" style="margin-bottom:10px;height:80px;margin-top:40px"><i class="zmdi-hc-li zmdi zmdi-dot-circle-alt"></i>'. $item['message'] .'</div>';
                                            }
                                            echo ' </div>
                                         </blockquote>
                                       </div>';

                                        }
                                  ++$count;
                                }
                                 ?>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<br>
<br>
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




