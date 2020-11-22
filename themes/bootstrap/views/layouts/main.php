
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="themes/bootstrap/img/logo/logo.png">

    <!-- Google Fonts
    ============================================ -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Bootstrap CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css"/>

    <!-- Fontawsome CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css"/>

    <!-- Owl Carousel CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/owl.carousel.css"/>

    <!-- jquery-ui CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery-ui.css"/>

    <!-- Meanmenu CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/meanmenu.min.css"/>

    <!-- Animate CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animate.css"/>

    <!-- Animated Headlines CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animated-headlines.css"/>

    <!-- Nivo slider CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/new-site-lib/nivo-slider/css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/new-site-lib/nivo-slider/css/preview.css" type="text/css" media="screen" />

    <!-- Metarial Iconic Font CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/material-design-iconic-font.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/material-design-iconic-font.min.css"/>

    <!-- Slick CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/slick.css"/>

    <!-- Video CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.mb.YTPlayer.css"/>

    <!-- Style CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css"/>

    <!-- Color CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/color.css"/>

    <!-- Responsive CSS
    ============================================ -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/montserrat-font.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style2.css"/>


    <!-- Modernizr JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/65ed7007/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/65ed7007/jquery.yii.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.easing.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.easing.min.js"></script>
    <?php Yii::app()->bootstrap->register(); ?>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-57238628-1', 'auto');
        ga('send', 'pageview');

    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 962159633;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;

        /* ]]> */
        $(document).ready(function(){
            $( "#subscribeForm" ).submit(function( event ) {

                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('User/sendMaterialMail'); ?>',
                    dataType:'json',
                    data : {'mail' : $('#news_text_box').val()},
                    beforeSend:function(){
                    $("#loading").removeClass("loading_front");},
                    complete:function(){
                        $("#loading").removeClass("loading_front");},
                    success:function(data){
                        var google_conversion_id = 962159633;
                        var google_conversion_language = "en";
                        var google_conversion_format = "3";
                        var google_conversion_color = "ffffff";
                        var google_conversion_label = "4OI5CIPOhVkQkcjlygM";
                        var google_remarketing_only = false;

                        $.getScript( "http://www.googleadservices.com/pagead/conversion.js" );

                         alert(data.msg);
                        document.getElementById("news_text_box").value="";

                        console.log($.parseJSON(data));
                    },
                    error: function(data) {

                        console.log("Error occured.please try again")
                    },


                });
            });
        });



    </script>

    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/962159633/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
<style>

.hedderLogo{
    max-width: 175% !important;
    min-width: 175%!important;
    min-height:175%!important;
    max-height:175%!important;
 
}

    .notification .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }
body {
    overflow-x: hidden; /* Hide scrollbars */
}



</style>

    <style>
        #news_text_box{
            border-radius: 0px;
        }
    </style>
    <style>
        @media (min-width: 1024px) {
            .hidden-for-desktopView {
                display: none;
            }
            .products{
                display: none;
            }
            .logo{
                margin-left: -20%;
                margin-top:-8%!important;
                width:140% !important;
          
            }
            .slide1{
                font-size:40px
            }
            .slide2{
                font-size:30px
            }
           
        }

        @media (max-width:629px) {
            .hidden-for-mobileView {
                display: none;
            }

            .mobile{
                margin-top:100px
            }

            .safe{
                font-size:30px
            }

            .safe2{
                font-size:40px
            }
            .o{
                font-size:60px
            }
            .logo{
                width:100% !important;
                margin-top:-35px
            }
            .slide1{
                font-size:20px
            }
            .slide2{
                font-size:10px
            }
           
        }
    </style>

</head>


<body>
    <div class="as-mainwrapper">
        <!--Bg White Start-->
        <div class="bg-white">
        <!-- Fixed navbar -->
            <header>
                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 col-sm-5 hidden-xs">
                                <span>Have any question? <a href = "mailto: info@nanaska.com">info@nanaska.com</a></span>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
                                <div class="header-top-right" style="width: 120%;margin-right: 20px">
                                    <div class="content"><a href="http://learncima.co.uk/nanaska/"><i class="zmdi zmdi-globe"></i> Our Forum</a></div>
                                    <?php
                                      if (Yii::app()->user->isGuest) {
                                          echo '<div class="content"><a href="#"><i class="zmdi zmdi-account"></i>Online Exams</a>
                                                  <ul class="account-dropdown">
                                                   <li>'.CHtml::link("Login", array("site/login")).'</li>
                                                   <li>'.CHtml::link("Register", array("user/create")).'</a></li>
                                                  </ul>
                                                </div>';
                                      }else {
                                         if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {

                                             echo '<div class="content"><a href="?r=admin"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a></div>';
                                         }
                                         else if (Yii::app()->user->loadUser()->user_type == "LECTURER") {
                                             echo '<div class="content"><a href="?r=admin"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a></div>';
                                             echo '<div class="content"><a href="?r=user/detailLecturer"><i class="zmdi zmdi-account-o"></i> My Profile</a></div>';

                                         }else {
                                             if (isset(Yii::app()->user->loadUser()->user_id)) {
                                                 $status = Student::model()->getStudentStatusTypeByUserId(Yii::app()->user->loadUser()->user_id);

                                                 if ($status == 1) {
                                                     echo '<div class="content"><a href="?r=user/detail"><i class="zmdi zmdi-account-o"></i> My Profile</a></div>';
                                                 }
                                             } else {
                                                 echo '<div class="content"><a href="?r=user/detail"><i class="zmdi zmdi-account-o"></i> My Profile</a></div>';
                                             }

                                         }
                                          echo '<div class="content"><a href="?r=site/logout"><i class="icon-lock icon-white"></i> Log Out</a></div>';
                                      }

                                      ?>


                                    <div class="content"><a href="?r=shoppingcart/viewcart" class="notification"><i class="zmdi zmdi-shopping-basket"></i> Checkout<span class="badge" id="quantityWidget">
                                            <?php

                                            $totalProductQty = Util::getShoppingCartQuantity();
                                            if ($totalProductQty==0)
                                            {
                                                echo '<script>
                                              document.getElementById("quantityWidget").style.visibility = "hidden";
                                                 
                                                  </script>';

                                            }else{
                                                echo '<script>
                                               document.getElementById("quantityWidget").style.visibility = "visible";
                                         
                                                  </script>';
                                                echo $totalProductQty;
                                            }

                                            ?>
                                        </span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-logo-menu sticker">
                    <div class="container" >
                        <div class="row"  style="max-height:96px!important" >
                            <div class="col-md-3 col-sm-12" style="max-height:96px!important">
                                <div  style="max-height:96px!important">
                                    <a href="/nanaska-backend/index.php"><img  src="themes/bootstrap/img/logo/logoHedder.png" alt="EDUCAT" class="logo logo2"></a>

                                </div>
                               
                            </div>
                            <div class="col-md-9"  style="max-height:96px!important">
                                <div class="mainmenu-area pull-right"  style="max-height:96px!important">
                                    <div class="mainmenu hidden-sm hidden-xs">
                                        <nav>
                                            <?php
                                            $route = '';
                                            $route = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
                                            ?>
                                            <ul id="nav">
                                                <li <?php echo ($route == 'site/index') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Home', Yii::app()->homeUrl) ?>
                                                </li>
                                                <li <?php echo ($route == 'site/viewAboutus') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('About Us', array('site/viewAboutus')) ?>
                                                </li>
                                                <li <?php echo ($route == 'site/viewOurProduct') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Our Products', array('site/viewOurProduct')) ?>
                                                </li>
                                                <li <?php echo ($route == 'site/testimonials') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Testimonials', array('site/testimonials')) ?>
                                                </li>
                                                <li <?php echo ($route == 'user/create') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Registration', array('user/create')) ?>
                                                </li>
                                                <li <?php echo ($route == 'user/payment') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Payments', array('user/payment')) ?>
                                                </li>
                                                <li <?php echo ($route == 'site/contact') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Contact Us', array('site/contact')) ?>
                                                </li>
                                                <?php if (Yii::app()->user->getId() == NULL) { ?>
                                                    <li <?php echo ($route == 'exam/notLoggedinViewExam') ? 'class="active"' : '' ?>>
                                                        <?php echo CHtml::link('Exams', array('exam/notLoggedinViewExam')) ?>
                                                    </li>

                                                <?php } else { ?>
                                                    <li <?php echo ($route == 'exam/viewexam') ? 'class="active"' : '' ?>>
                                                        <?php echo CHtml::link('Exams', array('exam/viewexam')) ?>
                                                    </li>

                                                <?php } ?>


                                        </nav>
                                    </div>

                                    <!--Search Form-->
                                    <div class="search">
                                        <div class="search-form">
                                            <form id="search-form" action="#">
                                                <input type="search" placeholder="Search here..." name="search" id="" />
                                                <button type="submit" id="subscribe">
                                                    <span><i class="fa fa-search"></i></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!--End of Search Form-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Area start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="mobile-menu">
                                    <nav id="dropdown">
                                        <?php
                                        $route = '';
                                        $route = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
                                        ?>
                                        <ul>
                                            <li class="current" <?php echo ($route == 'site/index') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Home', Yii::app()->homeUrl) ?>
                                            </li>
                                            <li class="current" <?php echo ($route == 'site/viewAboutus') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('About Us', array('site/viewAboutus')) ?>
                                            </li>
                                            <li class="current" <?php echo ($route == 'site/viewOurProduct') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Our Products', array('site/viewOurProduct')) ?>
                                            </li>
                                            <li class="current" <?php echo ($route == 'site/testimonials') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Testimonials', array('site/testimonials')) ?>
                                            </li>
                                            <li class="current" <?php echo ($route == 'user/create') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Registration', array('user/create')) ?>
                                            </li>

                                            <li class="current" <?php echo ($route == 'user/payment') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Payments', array('user/payment')) ?>
                                            </li>
                                            <?php if (Yii::app()->user->getId() == NULL) { ?>
                                                <li class="current" <?php echo ($route == 'exam/notLoggedinViewExam') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Exams', array('exam/notLoggedinViewExam')) ?>
                                                </li>

                                            <?php } else { ?>
                                                <li class="current" <?php echo ($route == 'exam/viewexam') ? 'class="active"' : '' ?>>
                                                    <?php echo CHtml::link('Exams', array('exam/viewexam')) ?>
                                                </li>

                                            <?php } ?>

                                            <li class="current" <?php echo ($route == 'site/contact') ? 'class="active"' : '' ?>>
                                                <?php echo CHtml::link('Contact Us', array('site/contact')) ?>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Area end -->
            </header>


              <?php echo $content; ?>
            <br>  <br>  <br>
            <!--Newsletter Area Start-->
            <div class="newsletter-area" >
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-5" >
                            <div class="newsletter-content">
                                <h3>SUBSCRIBE</h3>
                                <h4>TO GET OUR FREE MATERIALS</h4>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 mobile">
                            <div class="newsletter-form angle">
                                <form  class="footer-newsletter fix" id="subscribeForm">
                                    <div class="subscribe-form">
                                        <input type="email" name="email" placeholder="Enter your email address..." id="news_text_box">
                                        <button type="submit" id="submitButton" >SUBSCRIBE</button>
                                    </div>
                                  </form>
                                <div class="span1" style="margin-left: -10px;">
                                    <div id="loading" style="width: 32px; height: 32px;"></div>
                                </div>
                                <!-- mailchimp-alerts Start -->
                                <div class="mailchimp-alerts text-centre fix pull-right">
                                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                    <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                    <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                                </div>
                                <!-- mailchimp-alerts end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End of Newsletter Area-->

            <div class="footer-widget-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">

                                <div class="footer-logo">
                                    <a href="/nanaska-backend/index.php"><img src="themes/bootstrap/img/logo/footer.png" alt=""></a>
                                </div>
                        </div>
                                <div class="col-md-3 col-sm-4">
                                    <div class="single-footer-widget">
                                        <h3>GET IN TOUCH</h3>
                                        <a href="tel:555-555-1212"><i class="fa fa-phone"></i>+94 - 777 - 39 - 8996</a>
                                        <span><i class="fa fa-envelope"></i><a href = "mailto: info@nanaska.com">info@nanaska.com</a></span>

                                    </div>
                                </div>
                                <div class="col-md-3 hidden-sm">
                                    <div class="single-footer-widget">
                                        <h3>LEARN MORE</h3>
                                        <ul class="footer-list">

                                            <li><?php echo CHtml::link('Online Exams', array('exam/viewexam')); ?></li>
                                            <li><a href="#">Course Structure</a></li>

                                            <li><a href="#">Levels & Categories</a></li>
                                            <dd>
                                                <?php echo CHtml::link('Terms and Conditions', array('site/termsofservice')); ?>
                                            </dd>

                                            <dd>
                                                <?php echo CHtml::link('Privacy Policy', array('site/viewPrivacy')); ?>
                                            </dd>
                                        </ul>
                                    </div>
                                </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="single-footer-widget">


                                <div class="social-icons">
                                    <a href="https://www.facebook.com/LearnCIMA" target="_blank"><i class="zmdi zmdi-facebook"></i></a>
                                    <a href="https://lk.linkedin.com/in/nanaska-learncima-92b430120" target="_blank"><i class="zmdi zmdi-linkedin"></i></a>
                                    <a href="https://twitter.com/learn_cima" target="_blank"><i class="zmdi zmdi-twitter"></i></a>
                                    <a href="https://www.instagram.com/nanaska__/" target="_blank"><i class="zmdi zmdi-instagram"></i></a>
                                </div>
                              </div>
                            </div>
                    </div>
                </div>
            </div>
            <!--End of Footer Widget Area-->
            <!--End of Footer Widget Area-->
            <!--Footer Area Start-->
            <footer class="footer-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-7">
                              <span>Copyright &copy; NANASKA .All right reserved.
                        </div>
                        <div class="col-md-6 col-sm-5">
                            <div class="column-right">

                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!--End of Footer Area-->
        </div>
        <!--End of Bg White-->
    </div>
    <!--End of Main Wrapper Area-->
    <!-- jquery
        ============================================ -->


<!--    <script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>-->

    <!-- bootstrap JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/bootstrap.min.js"></script>

    <!-- nivo slider js
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/new-site-lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/new-site-lib/nivo-slider/home.js" type="text/javascript"></script>

    <!-- meanmenu JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.meanmenu.js"></script>

    <!-- wow JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/wow.min.js"></script>

    <!-- owl.carousel JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/owl.carousel.min.js"></script>

    <!-- scrollUp JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.scrollUp.min.js"></script>

    <!-- Waypoints JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/waypoints.min.js"></script>

    <!-- Counterup JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.counterup.min.js"></script>

    <!-- Slick JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/slick.min.js"></script>

    <!-- Animated Headlines JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/animated-headlines.js"></script>

    <!-- Textilate JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/textilate.js"></script>

    <!-- Lettering JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/lettering.js"></script>

    <!-- Video Player JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.mb.YTPlayer.js"></script>

    <!-- AJax Mail JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/ajax-mail.js"></script>

    <!-- plugins JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/plugins.js"></script>


    <!-- main JS
    ============================================ -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/main.js"></script>



    </body>
</html>

<script type="text/javascript">
    function redirect() {
        location.href = "index.php?r=user/create";
    }

</script>
