<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/tabs.css" />

<script type="text/javascript">
    function clearFunction() {        
        x=document.getElementsByClassName("req_res");  // Find the elements
        for(var i = 0; i < x.length; i++){
            x[i].innerHTML="<div id='course-description'><div class='span1'></div><div class='span4'><br /><br /><div class='master_heading'>Instructions</div><p>Please click on courses to see the relevant levels.</p><p>Select levels from the left hand side navigation to view exams relent to each level.</p><p>You have to purchase exams before taking them.</p> </div> </div>";    // Change the content
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

        <ul class="nav nav-tabs hidden-for-phone">
            <?php
            foreach ($courses as $key => $course) {
                if ($key === 0) {
                    echo '<li class="active" ><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt" onclick="clearFunction()">' . $course->course_name . '</a></li>';
                } else {
                    echo '<li class=""><a href="#' . $course->course_id . '"  data-toggle="tab" id="ttt" onclick="clearFunction()">' . $course->course_name . '</a></li>';
                }
            }
            ?>

        </ul>

        <div class="tab-content hidden-for-phone">
            <?php
            foreach ($courses as $key => $course) {

                if ($key === 0) {
                    echo '<div class="tab-pane active" id="' . $course->course_id . '">';
                } else {
                    echo '<div class="tab-pane" id="' . $course->course_id . '">';
                }
                echo '<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">';
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


            <div class="req_res">               

                

            <?php
            if (!empty($courses)) {
                ?>
                <div class='span1'></div><div class='span4'><br /><br /><div class='master_heading'>Instructions</div><p>Please click on courses to see the relevant levels.</p><p>Select levels from the left hand side navigation to view exams relent to each level.</p><p>You have to purchase exams before taking them.</p> </div> </div>
            <?php
        } else {
            ?>
            <div class='span1'></div><div class='span4'><br /><br /><p>Sorry, this content is not currently available.</p></div> </div>
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