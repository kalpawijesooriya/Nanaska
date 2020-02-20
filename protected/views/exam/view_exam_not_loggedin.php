
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/tabs.css" />

<script type="text/javascript">  
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

        <ul class="nav nav-tabs hidden-for-phone">
            <?php
            foreach ($courses as $key => $course) {
                if ($key === 0) {
                    echo '<li class="active" ><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt">' . $course->course_name . '</a></li>';
                } else {
                    echo '<li><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt">' . $course->course_name . '</a></li>';
                }
            }
            ?>
        </ul>

        <div class="tab-content hidden-for-phone">
            <?php
            foreach ($courses as $key => $course) {

                if ($key === 0) {
                    echo '<div class="tab-pane active" id="' . $course->course_id . '">';
                    // echo $course->course_id;
                } else {
                    echo '<div class="tab-pane" id="' . $course->course_id . '">';
                    //echo $course->course_id;
                }
                echo '<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">';
                echo '<div class="level-names style="style="float:left; height: auto;">';
                //echo '<ul class="nav" style="margin-top: 40px ">';

                echo '<ul class="levels-nav level-ul">';
                foreach ($levels as $course_id => $courseLevels) {
                    if ($course->course_id == $course_id) {
                        foreach ($courseLevels as $courseLevel) {
                            //echo '<li><a href="#' . $courseLevel->level_id . '">' . $courseLevel->level_name . '</a></li> <br />';
                            echo CHtml::ajaxLink('<li>' . $courseLevel->level_name . '</li>', Yii::app()->createUrl('Exam/viewDetailsForNotLoggedin'), array(
                                'type' => 'POST',
                                //'dataType' => 'json',
                                'data' => array('levelId' => $courseLevel->level_id),
                                'update' => '.req_res',
//                                 'success' => 'function(data){
//                                     if(data[0].status=="success"){
//                                     document.getElementById("subject_heading").innerHtml("Hello");
//                                    }
//                                     }',
                                    ), array('class' => 'link-background ')
                            );
                        }
                    }
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>


            <div class="req_res">
                <?php
                if (!empty($courses)) {
                    ?>
                    <div class='span1'></div><div class='span4'><br /><br /><div class='master_heading'>Instructions</div><p>Please select a level to try a sample exam.</p><p>Please <?php echo CHtml::link('create an account', array('user/create')); ?>  or <?php echo CHtml::link('login', array('site/login')); ?> to buy exams.</p></div> </div>
                <?php
            } else {
                ?>
                <div class='span1'></div><div class='span4'><br /><br /><p>Sorry, this content is not currently available.</p><p>Please <?php echo CHtml::link('create an account', array('user/create')); ?>  or <?php echo CHtml::link('login', array('site/login')); ?> to buy exams.</p></div> </div>
            <?php
        }
        ?>


    </div>

</div>

<div class="hidden-for-desktop">
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
            'url' => Yii::app()->createUrl('exam/viewDetailsForNotLoggedin'), //or $this->createUrl('loadcities') if '$this' extends CController
            'update' => '.req_res', //or 'success' => 'function(data){...handle the data in the way you want...}',
            'data' => array('levelId' => 'js:this.value'),
            )));
    ?>

    <div class="req_res">

    </div>
</div>

</div>

<?php
if (isset($courseLevels)) {
    if (count($courseLevels) == 0) {
        echo ' <br/><br/><br/><br/><br/><br/><br/><br/><br /><br />';
    } else {
        echo ' <br/><br/><br/><br/><br/><br/><br/><br/>';
    }
}
?>

<script type="text/javascript">
    $('.level-ul li').click(function () {
        $('.highlight').removeClass('highlight');
        $(this).addClass('highlight');

    });
</script>


<script type="text/javascript">
    $('#level-link').on('click', function(e){       
        e.preventDefault();
        $(this).toggleClass('myClickState');
    });
</script>