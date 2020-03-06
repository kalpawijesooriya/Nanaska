

<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/vendor/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    function hideFunction(){
        $('.course-description').hide();
    }

</script>
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
<?php
$courses = $courseModel;
$levels = $courseLevelModel;
$list_data = array();
foreach ($courses as $course) {
    $list_data[$course->course_id] = $course->course_name;
}
?>
<div class="btn-group text-center">
    <button type="button" class="btn btn-default dropdown-toggle dr-breakout-btn text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Course <span class="caret text-center"></span>
    </button>
    <ul class="dropdown-menu dr-breakout text-center">
        <?php
        foreach ($courses as $key => $course)
        {
            echo ' <li class="button text-center"><a href="#" onclick="showFoo('.$course->course_id .')" >' . $course->course_name . '</a></li>';
            if ($key===0){
                echo '<script>
                       $(window).on(\'load\', function() {
                            showFoo('.$course->course_id .')
                        });
                      </script>';
            }
        }
        ?>
    </ul>
</div>

<div class="course-area section-padding bg-white" id="courses" style="margin: auto;">

</div>
<br><br><br>
<script type="text/javascript">

    function showFoo(id) {
        $.ajax({
            type: 'POST',
            async:false,
            url: '<?php echo Yii::app()->createUrl('exam/Ajax'); ?>',
            data:{data:id},
            success:function(data){

                appendCourses(data);
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");

            },


        });

    }

    function appendCourses(data) {
        $("#courses").html("");
        var datas = $.parseJSON(data);
        if(datas.length==0){
            $( "#courses" ).append( "<p class='text-center'>Sorry! No Levels available for this course </P>");
        }
        else
        datas.forEach(function(item){

           // console.log(item.level_name)
            $( "#courses" ).append( "<div class=\"container\">\n" +
                "                        <div class=\"row\">\n" +
                "                            <div class=\"col-md-12\">\n" +
                "                                <div class=\"section-title-wrapper\">\n" +
                "                                    <div class=\"section-title\">\n" +
                "                                      <h3>"+item.level_name+"</h3>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"row\" style=\"margin: auto;\">" );
                                             loadCourses(item.level_id)
            $( "#courses" ).append( "  </div>\n" +
                "                    </div>\n");
        });

    }
    function loadCourses(level_id) {
        $.ajax({
            type: 'POST',
            async:false,
            url: '<?php echo Yii::app()->createUrl('exam/GetCourses'); ?>',
            data:{data:level_id},
            success:function(data){
                $.parseJSON(data).forEach(function(item){

                    $( "#courses" ).append( " <div class=\"col-md-3 hidden-sm-4\">\n" +
                        "                                <div class=\"single-item\">\n" +
                        "                                    <div class=\"single-item-image overlay-effect\">\n" +
                        "                                        <br>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"single-item-text\">\n" +
                        "                                        <h5><a href=\"#\">"+item.subject_name+"</a></h5>\n" +
                        "                                     <br>                 \n" +
                        "                                     <div class=\"alert alert-info\" role=\"alert\">   \n" +
                        "                                        <p>No Exams for the subject </p>\n" +
                        "                                      </div>              \n" +
                        "                                    </div>\n" +
                        "\n" +
                        "                                </div>\n" +
                        "                            </div>");
                });


                console.log($.parseJSON(data));
            },
            error: function(data) {

                console.log("Error occured.please try again")
            },


        });

    }
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
        margin: 50px 20%;
    }
</style>