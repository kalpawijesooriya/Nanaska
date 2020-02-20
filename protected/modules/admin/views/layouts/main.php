<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/navbar-fixed-top.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/carousel.css" />

<!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl;                                          ?>/css/bootstrap-spinner.css" />-->
<!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->theme->baseUrl;                                          ?>/plugins/font-awesome/css/font-awesome.css" />-->

<!--        <script src="<?php //echo Yii::app()->theme->baseUrl;                                          ?>/js/jquery.spinner.min.js" type="text/javascript"></script>-->


<!--        <script src="<?php // Yii::app()->theme->baseUrl;                                         ?>/js/bootstrap-modal.js" type="text/javascript"></script>-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php Yii::app()->bootstrap->register(); ?>
    </head>

    <body>


        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'brand' => 'LearnCIMA Admin Dashboard',
            'brandUrl' => array('/admin'),
            'type' => 'inverse',
            'collapse' => true,
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        //array('label' => 'Home', 'url' => array('/admin')),
                        array('label' => 'Site', 'url' => Yii::app()->homeUrl),
//                array('label'=>'About', 'url'=>array('#')),
//                array('label'=>'Contact', 'url'=>array('#')),
//                
                        //  array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ),
            ),
        ));
        ?>



        <?php //if(isset($this->breadcrumbs)):?>
        <?php
        //$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        //'links'=>$this->breadcrumbs,
        //));
        ?><!-- breadcrumbs -->
        <?php //endif ?>
        <!--       <div class="row">
          <div class="span4"> <img src="assets/img/logo.png" class="img-responsive" alt="Responsive image"> </div>

        </div>--><p>&nbsp;</p>
        <p>&nbsp;</p>


        <?php
        $route = '';
        $route = Yii::app()->controller->id;
        $actionName = Yii::app()->controller->action->id;
//        echo $actionName;
//        die;

        if ($route != 'default') {
            if($actionName!='export'){
            ?>
            <div class="span3"><br/><br/><br/><br/>
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">


                        <!--                <li><a href="index.php?r=admin/course">Course Management</a></li>
                                            <li><a href="index.php?r=admin/level">Level Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/subject">Subject Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/subjectArea">Subject-Area Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/sitting">Sitting Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/news">News Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/country">Country Management</a></li>-->

                        <li <?php echo ($route == 'course') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Course Management', array('course/index')) ?>
                        </li>

                        <li <?php echo ($route == 'level') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Level Management', array('level/index')) ?>
                        </li>

                        <li <?php echo ($route == 'subject') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Subject Management', array('subject/index')) ?>
                        </li>

                        <li <?php echo ($route == 'subjectArea') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Subject-Area Management', array('subjectArea/index')) ?>
                        </li>

                        <li <?php echo ($route == 'sitting') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Session Management', array('sitting/index')) ?>
                        </li>

                        <li <?php echo ($route == 'news') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('News Management', array('news/index')) ?>
                        </li>

                        <li <?php echo ($route == 'country') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Country Management', array('country/index')) ?>
                        </li>

                        <li <?php echo ($route == 'frontendPayment') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Frontend Payment', array('frontendPayment/index')) ?>
                        </li>





                    </ul>
                </div><!--/.well -->
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">

                        <!--                    <li /*class="active"*/><a href="index.php?r=admin/student">Student Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/lecturer">Lecturer Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/temporaryUser">Temporary Users</a></li>                    -->
                        <!--                    <li><a href="index.php?r=admin/exam">Exam Management</a></li>-->
                        <!--                    <li><a href="index.php?r=admin/question">Question Management</a></li>-->

                        <!--                    <li><a href="index.php?r=admin/result">Result Management</a></li>-->

                        <?php if ($route != 'studentExam') { ?>

                            <li <?php echo ($route == 'student') ? 'class="active"' : '' ?>>
                                <?php echo CHtml::link('Student Management', array('student/index')) ?>
                            </li>

                        <?php } else { ?>
                            <li <?php echo ($route == 'studentExam') ? 'class="active"' : '' ?>>
                                <?php echo CHtml::link('Student Management', array('student/index')) ?>
                            </li>

                        <?php }
                        ?>

                        <?php
                        if ($route == 'question' && $actionName == 'approve') {
                            ?>
                            <li <?php echo ($route == 'question' && $actionName == 'approve') ? 'class="active"' : '' ?>>
                                <?php echo CHtml::link('Lecturer Management', array('lecturer/index')) ?>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li <?php echo ($route == 'lecturer') ? 'class="active"' : '' ?>>
                                <?php echo CHtml::link('Lecturer Management', array('lecturer/index')) ?>
                            </li>

                            <?php
                        }
                        ?>


                        <li <?php echo ($route == 'temporaryUser') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Temporary Users', array('temporaryUser/index')) ?>
                        </li>

                        <li <?php echo ($route == 'exam') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Exam Management', array('exam/index')) ?>
                        </li>

                        <li <?php echo ($route == 'question' && $actionName != 'approve') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Question Management', array('question/index')) ?>
                        </li>


                        <li <?php echo ($route == 'result') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Result Management', array('result/index')) ?>
                        </li>
                        <li <?php echo ($route == 'essayAnswer') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Essay Answer Management', array('essayAnswer/index')) ?>
                        </li>
                        <li <?php echo ($route == 'frontendPayment') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Testimonials', array('testimonials/index')) ?>
                        </li>

                    </ul>
                </div><!--/.well -->

                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <li <?php echo ($route == 'audit') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Activity Log', array('audit/index')) ?>
                        </li>

                        <li <?php echo ($route == 'loginAudit') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('User Log', array('loginAudit/index')) ?>
                        </li>

                        <li <?php echo ($route == 'examAudit') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Log Per 60 min', array('examAudit/viewLogPer60Mins')) ?>
                        </li>

                        <li <?php echo ($route == 'user') ? 'class="active"' : '' ?>>
                            <?php echo CHtml::link('Change Password', array('/admin/user/updatepass','id'=>Yii::app()->user->id)) ?>
                        </li>
                    </ul>
                </div>


            </div>
            <?php } } else { ?>

            <div class="span2"></div>


        <?php } ?>


        <!--/span-->

        <!--        <div class="container">-->


        <?php echo $content; ?>

        <div class="clear"></div>


        <!--	<div id="footer">
                        Copyright &copy; <?php //echo date('Y');                                                      ?> by My Company.<br/>
                        All Rights Reserved.<br/>
        <?php //echo Yii::powered();       ?>
                </div> footer -->

        <!--</div> page -->
        <p>&nbsp;</p>
        <div class="clear"></div>

        <footer>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

        </footer>

    </body>
</html>
