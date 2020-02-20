<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/slick.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.0.0/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/advancedticker.css" />

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.easy-ticker.js"></script>

<?php $this->pageTitle = Yii::app()->name; ?>
<div class="container footer-stable">
    <div class="row"> 
        <div class="span8 slide-left-margin">
            <div id="myCarousel" class="carousel slide slide-height" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                    <li data-target="#myCarousel" data-slide-to="5"></li>
                </ol>
                <div class="carousel-inner slide-height">
                    <div class="item active">
                        <img src="assets/img/flash_0.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/img/flash_1.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/img/flash_2.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/img/flash_3.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
<!--                    <div class="item">
                        <img src="assets/img/flash_4.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>-->
                    <div class="item">
                        <img src="assets/img/flash_5.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/img/flash_6.jpg" alt="First slide">
                        <div class="container">
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div><!-- /.carousel -->
        </div>
        <div class="span4">
            <?php
            $msgs = News::model()->getBroadcastNews();
            if (empty($msgs)) {
                echo '<div class="well">';
                echo '<center><b>News not available</b></center>';
                echo '</div>';
            } else {
                ?>
                <!--                <div style="text-align: center;">
                                    <i class="icon-arrow-up" id="nt-example1-prev"></i>
                                </div>-->
                <div id="nt-example1-container">

                    <ul id="nt-example1">
                        <?php
                        foreach ($msgs as $msg) {
                            ?>
                            <li class="news-row"><?php echo $msg['message']; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <!--                <div style="text-align: center;">
                                    <i class="icon-arrow-down" id="nt-example1-next"></i>
                                </div>-->
                <?php
            }
            ?>
        </div>
    </div>


    <div class="row">
        <div class="span8">
            <div class="span3 text-align-center" id="syllabus_logo"><img id="syllabus_img" name="syllabus_img" src="assets/img/syllabus.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"><h4>2015 Syllabus</h4> </div>
            <div class="span3 text-align-center" id="lecturer_logo"><img id="lecturer_img" name="lecturer_img" src="assets/img/lead_lecture.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"> <h4>Lead Lecturer</h4></div>
            <div class="span3 text-align-center" id="speciality_logo"><img id="speciality_img" name="speciality_img" src="assets/img/our_strengths.jpg" class="img-responsive circle-border" alt="Responsive image" onclick="renderRest(this)"><h4>Our Specialty</h4></div>
            <div class="span3 text-align-center" id="forum_logo"> <a href="http://forum.learncima.com/forum" target="_blank"><img src="assets/img/forum.jpg" class="img-responsive circle-border" alt="Responsive image"></a><h4>Our Forum</h4> </div>

        </div>
        <div class="span4 videoWrapper" id="youtubevid">
            <iframe width="380" height="240" src="//www.youtube.com/embed/ku3Wo0Ul4-0" frameborder="0" allowfullscreen></iframe>

        </div>

    </div>
    <div id="lead_lecturer_info" style="display: none">
        <h2>Lead Lecturer</h2>
        <br />
        <div class="row">
            <div class="span1"></div>

            <div class="span3">
                <div id="pic-channa">                        
                    <img src="<?php echo Yii::app()->baseUrl; ?>/assets/img/mrchanna3.jpg" />
                </div>
            </div>

            <div class="span5">
                <ul id="ul-qualifications1">
                    <br /><br />
                    <li>Fellow Member of CIMA.</li>
                    <li>Fellow Member of the Institute of Chartered Accountants of Sri Lanka.</li>
                    <li>MBA from University of Southern Queensland, Australia.</li>
                    <li>First Class Degree from University of Sri Jayewardenepura, Sri Lanka.</li>                        
                </ul>
            </div>                
        </div>
        <br />

        <div class="row">
            <div class="span11">
                <div class="span7">
                    <ul id="ul-qualifications2">
                        <li>Over 17 years of lecturing experience.</li>
                        <li>The lecturer for P3 (Performance Strategy), E3 (Enterprise Strategy) and T4 at one of the largest CIMA Institutes in the world.</li>
                        <li>Conducted revision programmes in Malaysia, Singapore, India, Hong Kong & Indonesia for P3 and for T4 as invited by CIMA Malaysia & CIMA Singapore.</li>
                        <li>Ex-Part Time Lecturer for MBA at Post Graduate Institute of Management, University of Sri Jayewardenepura.</li>
                    </ul>

                </div>

                <div class="span5">
                    <h4 align="justify" id="heading-prfessionalexp">Professional Experiences</h4>
                    <ul id="ul-qualifications1">
                        <br />
                        <li>Country Manager for Ernst and Young, Maldives. (2000 to 2002)</li>
                        <li>CFO for a multinational manufacturing entity. (2003 to up to date)</li>
                        <li>With his experiences and knowledge, a great mixture of theory and application for CIMA is assured.</li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
    <div id="syllabus_info" style="display: none">
        <h2>2015 Syllabus</h2><br/>
        <img src="assets/img/syllabus_pic.jpg" class="img-responsive" alt="Responsive image"> 
    </div>
    <div id="specialty_info" style="display: none">
        <h2>Our Specialty</h2>
        <div class="span5">
            <ul id="ul-qualifications1">
                <br /><br />
                <li>Personalized attention</li>
                <li>1-2-1 coaching</li>
                <li>Practice exams</li>
                <li>Live classrooms</li>
                <li>Best technology</li>
                <li>Speedy response</li>
            </ul>
        </div>
    </div>


</div>

<!--    /container -->

<div class="bottom_container_newsletter">
    <div class="container"> <h2> For Free Materials  </h2> <p> by submitting your email address we will be able to send you free materials </p> 
        <form class="form-search">
            <div class="span5"></div>
            <div class="span3" style="margin-left: 0px;">
                <input id="news_text_box" type="email" class="input-medium search-query" placeholder="Your Email Address" required>
                <!--                            <button type="submit" class="button button-signin">Submit</button>-->
                <?php
                echo CHtml::ajaxButton('Submit', array('User/sendMaterialMail'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'data' => array('mail' => 'js:news_text_box.value'),
                    'beforeSend' => 'function(){                
                $("#loading").addClass("loading_front");}',
                    'complete' => 'function(){                
                 $("#loading").removeClass("loading_front");}',
                    'success' => 'js:function(data){
                                    var google_conversion_id = 962159633;
                                    var google_conversion_language = "en";
                                    var google_conversion_format = "3";
                                    var google_conversion_color = "ffffff";
                                    var google_conversion_label = "4OI5CIPOhVkQkcjlygM";
                                    var google_remarketing_only = false;
                                    
                                    $.getScript( "http://www.googleadservices.com/pagead/conversion.js" );                                    
                                    
                                    bootbox.alert(data.msg);
                                    document.getElementById("news_text_box").value="";
                                }'
                        ), array(
                    'class' => 'button button-signin',
                    'id' => 'material_submit' . rand(0, 99),
                ));
                ?>
            </div>
            <div class="span1" style="margin-left: -10px;">
                <div id="loading" style="width: 32px; height: 32px;"></div>
            </div>            
        </form>

    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/slick.min.js"></script> 
<script>
                //	$(document).ready(function(){
                //		$('.slider').slick({
                //		  slidesToShow: 5,
                //		  slidesToScroll: 1,
                //		  autoplay: true,
                //		  autoplaySpeed: 2000,		
                //		  vertical:true
                //		});
                //	});
</script>

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




<script type="text/javascript">

    function renderRest(element) {
        //alert(element.name);
        var options = {};
        if (element.name == "syllabus_img") {
            $('#lead_lecturer_info').hide();
            $('#specialty_info').hide();
            $('#syllabus_info').slideDown(1000);
            //if(document.getElementById('syllabus_info').style.visibility == "hidden"){
            $('html, body').animate({
                scrollTop: $('#syllabus_info').offset().top
            }, 1200);
            //}

        } else if (element.name == "lecturer_img") {
            $('#syllabus_info').hide();
            $('#specialty_info').hide();
            $('#lead_lecturer_info').slideDown(1000);
            $('html, body').animate({
                scrollTop: $('#lead_lecturer_info').offset().top
            }, 1000);

        } else if (element.name == "speciality_img") {
            $('#syllabus_info').hide();
            $('#lead_lecturer_info').hide();
            $('#specialty_info').slideDown(1000);
            $('html, body').animate({
                scrollTop: $('#specialty_info').offset().top
            }, 1000);

        }
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {

        var dd = $('#nt-example1-container').easyTicker({
            direction: 'up',
            easing: 'easeInExpo',
            speed: 'slow',
            interval: 3000,
            height: 350,
            visible: 4,
            mousePause: 1,
            controls: {
                up: '#nt-example1-prev',
                down: '#nt-example1-next'
            }
        });
    });
</script>
