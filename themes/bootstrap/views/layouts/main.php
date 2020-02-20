
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>




            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/navbar-fixed-top.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/carousel.css" />

            <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/bootstrap-modal.js" type="text/javascript"></script>
            <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/styles-small.css', 'only screen and (max-width: 800px)'); ?>


            <title><?php echo CHtml::encode($this->pageTitle); ?></title>

            <?php Yii::app()->bootstrap->register(); ?>
            <!-- custom style sheet of the site -->    
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
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

            <!-- Google AdWords -->
            <script type="text/javascript">
                /* <![CDATA[ */
                var google_conversion_id = 962159633;
                var google_custom_params = window.google_tag_params;
                var google_remarketing_only = true;
                /* ]]> */
            </script> 
            <script type="text/javascript" 
                    src="//www.googleadservices.com/pagead/conversion.js">
            </script> 
            <noscript> 
                <div style="display:inline;"> 
                    <img height="1" width="1" style="border-style:none;" alt="" 
                         src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/962159633/?value=0&amp;guid=ON&amp;script=0"/> 
                </div> 
            </noscript> 


    </head>

    <body>

        <!-- Fixed navbar -->
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <?php
                            if (Yii::app()->user->isGuest) {
                                echo '<li class="dropdown">';
                                echo'<button class="button button-register" onclick="redirect()" type="button"><i class="icon-pencil icon-white"></i>Register or Send Contact</button>';
                                echo '<button class="button button-login" data-toggle="dropdown" type="button"><i class="icon-lock icon-white"></i>  Sign in</button> ';
                                echo '<ul class="dropdown-menu">';
                                //echo     '<li><a href="index.php?r=site/login">Action</a></li>';
                                //echo     '<li><label>Username</label><input type="text" name="LoginForm[username]"><br/></li>';
                                //echo     '<li><label>Password</label><input type="password" name="LoginForm[password]"></li><br/>';

                                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                    'action' => 'index.php?r=site/login',
                                    'id' => 'login-form',
                                    'enableAjaxValidation' => true,
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'form-horizontal form-control',
                                        'role' => 'form'
                                    )
                                ));

                                $model = new LoginForm;

                                echo '<br/>';
                                echo '<div class="control-group">';
                                echo $form->labelEx($model, 'username', array('label' => 'Email', 'style' => 'margin-left:5px;'));
                                echo $form->textField($model, 'username', array('placeholder' => 'Enter your email', 'style' => 'margin-left:5px;margin-right:15px;'));
                                echo $form->error($model, 'username', array('style' => 'margin-left:5px;'));
                                echo '</div>';

                                echo '<div class="control-group">';
                                echo $form->labelEx($model, 'password', array('label' => 'Password', 'style' => 'margin-left:5px;'));
                                echo $form->passwordField($model, 'password', array('placeholder' => 'Enter Password', 'style' => 'margin-left:5px;margin-right:15px;'));
                                echo $form->error($model, 'password', array('style' => 'margin-left:5px;'));
                                echo '</div>';

                                echo '<div class="checkbox" style="margin-left:5px;">';
                                echo $form->checkBox($model, 'rememberMe');
                                echo $form->label($model, 'rememberMe');
                                echo '</div>';

                                echo '<a href=' . $this->createUrl('user/forgotpassword') . ' style="margin-left:5px;">Forgot password?</a><br/><br/>';

                                echo CHtml::submitButton('Sign in', array('class' => 'button button-news', 'style' => 'margin-left:5px;', 'id' => 'holddropdown'));
                                $this->endWidget();


                                echo '</li>';
                            } else {
                                ?>
                                <li ><a href="?r=shoppingcart/viewcart" class="link-shopping-cart"><i class="icon-shopping-cart icon-white"></i> Shopping Cart <span  id = "quantityWidget" rel='popover' class="badge2">
                                            <?php
                                            $totalProductQty = Util::getShoppingCartQuantity();
                                            echo $totalProductQty;
                                            ?>
                                        </span></a></li>
                                <?php
                                //echo '<li><a href="?r=user/view&id=' . Yii::app()->user->getId() . '"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-pencil icon-white"></i> My Profile</button></a></li>';
                                if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN") {
                                    echo '<li><a href="?r=admin"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-pencil icon-white"></i> Dashboard</button></a></li>';
                                } else if (Yii::app()->user->loadUser()->user_type == "LECTURER") {
                                    echo '<li><a href="?r=admin"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-pencil icon-white"></i> Dashboard</button></a></li>';
                                    echo '<li><a href="?r=user/detailLecturer"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-user icon-white"></i> My Profile</button></a></li>';
                                } else {
                                    if (isset(Yii::app()->user->loadUser()->user_id)) {
                                        $status = Student::model()->getStudentStatusTypeByUserId(Yii::app()->user->loadUser()->user_id);

                                        if ($status == 1) {
                                            echo '<li><a href="?r=user/detail"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-user icon-white"></i> My Profile</button></a></li>';
                                        }
                                    } else {
                                        echo '<li><a href="?r=user/detail"><button class="button button-register" style="margin-left: 20px;" type="button"><i class="icon-user icon-white"></i> My Profile</button></a></li>';
                                    }
                                }

                                echo '<li><a href="?r=site/logout"><button class="button button-login" type="button"><i class="icon-lock icon-white"></i> Log Out (' . Yii::app()->user->name . ')</button></a></li>';
                            }
                            ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <?php
//$this->widget('bootstrap.widgets.TbNavbar',array(
//        'items'=>array(
//        array(
//            'class'=>'bootstrap.widgets.TbMenu',
//            'items'=>array(
//                array('label'=>'Home', 'url'=>array('/site/index')),
//                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//                array('label'=>'Contact', 'url'=>array('/site/contact')),
//               
//                
//                
//                
//            ),
//        ),
//            array(
//            'class'=>'bootstrap.widgets.TbMenu',
//            'htmlOptions'=>array('class'=>'pull-right'),
//            'items'=>array(
//                array('label'=>'My Profile','icon'=>'user', 'url'=>array('/user/view','id'=>Yii::app()->user->getId()), 'visible'=>!Yii::app()->user->isGuest),
//                array('label'=>'Register','icon'=>'pencil', 'url'=>'index.php?r=user/create', 'visible'=>Yii::app()->user->isGuest),
//                array('label'=>'Login','icon'=>'lock', 'url'=>'index.php?r=site/login','visible'=>Yii::app()->user->isGuest),
//                array('label'=>'Logout ('.Yii::app()->user->name.')','icon'=>'off', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
//    ),
//)))); 
        ?>

        <?php
        //$this->widget('bootstrap.widgets.TbNavbar',array(
//        'items'=>array(
//        array(
//            'class'=>'bootstrap.widgets.TbMenu',
//            'items'=>array(
//                array('label'=>'Home', 'url'=>array('/site/index')),
//                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//                array('label'=>'Contact', 'url'=>array('/site/contact')),
//               
//                
//                
//                
//            ),
//        ),
//            array(
//            'class'=>'bootstrap.widgets.TbMenu',
//            'htmlOptions'=>array('class'=>'pull-right'),
//            'items'=>array(
//                array('label'=>'My Profile','icon'=>'user', 'url'=>array('/user/view','id'=>Yii::app()->user->getId()), 'visible'=>!Yii::app()->user->isGuest),
//                array('label'=>'Register','icon'=>'pencil', 'url'=>'index.php?r=user/create', 'visible'=>Yii::app()->user->isGuest),
//                array('label'=>'Login','icon'=>'lock', 'url'=>'index.php?r=site/login','visible'=>Yii::app()->user->isGuest),
//                array('label'=>'Logout ('.Yii::app()->user->name.')','icon'=>'off', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
//    ),
//)))); 
        ?>
        <?php //if(isset($this->breadcrumbs)): ?>
        <?php
//$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
//'links'=>$this->breadcrumbs,
//)); 
        ?><!-- breadcrumbs -->
        <?php //endif  ?>
        <div class="container">

            <div id="header-spacing" class="row">  
                <div class="span4" id="img_logo"> <img src="assets/img/logo.png" class="logo" alt="Responsive image"> </div>
                <div class="span8" id="header_main"> <h2 class="main_heading "> Case Study Specialist with World Class Technology</h2> </div>

                <div class="span8"> 
                    <div class="masthead clearfix">
                        <div class="inner">
                            <?php
                            $route = '';
                            $route = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
                            ?>
                            <ul class="nav masthead-nav" style="margin-top: 10px;">
                                <li <?php echo ($route == 'site/index') ? 'class="active"' : '' ?>>
                                    <?php echo CHtml::link('Home', Yii::app()->homeUrl) ?>
                                </li>

                                <li <?php echo ($route == 'site/viewAboutus') ? 'class="active"' : '' ?>>
                                    <?php echo CHtml::link('About Us', array('site/viewAboutus')) ?>
                                </li>
                                <li <?php echo ($route == 'site/viewOurProduct') ? 'class="active"' : '' ?>>
                                    <?php echo CHtml::link('Our Products', array('site/viewOurProduct')) ?>
                                </li>
                                <!--                                <li><a href="#">Testimonials</a></li>-->
                                <li <?php echo ($route == 'site/viewTestamonial') ? 'class="active"' : '' ?>>
                                    <?php echo CHtml::link('Testimonials', array('site/viewTestamonial')) ?>
                                </li>

                                <li <?php echo ($route == 'user/create') ? 'class="active"' : '' ?>>
                                    <?php echo CHtml::link('Registration', array('user/create')) ?>
                                </li>

                                <!--                                <li><a href="#">Payment</a></li>-->
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

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php echo $content; ?>

        <div class="clear"></div>
        <div id="footer_main"class="bottom_container_sub_footer"> 
            <div class="container">
                <footer>
                    <style>
                        dd img{
                            height: 25px;
                        }
                    </style>
                    <div class="span3"></div>
<!--                    <div class="span3" style="margin-top: 86px;"> <p class="footer-icon"> <?php /* ?><img src="assets/img/fb.png"> <img src="assets/img/tweeter.png"> <img src="assets/img/gplus.png"><?php */ ?>  <p>&copy; LearnCIMA <?php echo date('Y'); ?> &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p> </p> </div>-->

                    <div id="learn_more"class="span2"> <p> <dl> 
                                <!--<dt>LEARN MORE</dt>-->
                                <dd><b>LEARN MORE</b></dd>
                                <dd>Online Exam</dd>
                                <dd>Course Structure</dd>
                                <dd>Schemes</dd>
                                <dd>Levels & Categories</dd>
                            </dl> </p> </div>
                    <div class="span2"> <p> <dl> 
                                <dd><b>ABOUT</b></dd>
                                <!--                                <dd>
                                                                    //<?php // echo CHtml::link('Staff', array(''));             ?>
                                                                </dd>-->
                                <dd>
                                    <?php echo CHtml::link('About Us', array('site/viewAboutus')); ?>
                                </dd>
                                <dd>
                                    <?php echo CHtml::link('Terms and Conditions', array('site/termsofservice')); ?>
                                </dd>  
                                <dd>
                                    <?php echo CHtml::link('Privacy Policy', array('site/viewPrivacy')); ?>
                                </dd>  
                            </dl> </p> </div>
                    <div class="span3"> <p> <dl> 
                                <dd><b>CONTACT</b></dd>
                                <dd>Email: info@nanaska.com</dd>
                                <dd>Telephone: +94777398996</dd>
                                <dd style="padding-top: 5px"><a href="https://www.facebook.com/LearnCIMA" target="_blank"><img src="assets/img/fb.png"></a> <a href="https://twitter.com/learn_cima" target="_blank"><img src="assets/img/tweeter.png"></a> <a href="https://www.linkedin.com/in/learn-cima-92b430120?authType=NAME_SEARCH&authToken=4cu3&locale=en_US&trk=tyah&trkInfo=clickedVertical%3Amynetwork%2CclickedEntityId%3A502704179%2CauthType%3ANAME_SEARCH%2Cidx%3A1-1-1%2CtarId%3A1466066734498%2Ctas%3Alearn%20cima" target="_blank"><img src="assets/img/linkedin.png"></a></dd>
                            </dl> </p> </div>
                    <p class="pull-right" style="margin-top: 125px;"><a href="#">Back to top</a></p>

                </footer>
            </div>

        </div>
        <!--    <div id="footer">
                        Copyright &copy; <?php //echo date('Y');                      ?> by My Company.<br/>
                        All Rights Reserved.<br/>
        <?php //echo Yii::powered();        ?>
                </div> footer -->



    </body>
</html>
<script type="text/javascript">
    function redirect() {
        location.href = "index.php?r=user/create";
    }



</script>
