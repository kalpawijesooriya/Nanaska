<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("question_management") == 1) {


    $this->breadcrumbs = array(
        'Questions' => array('index'),
        $model->question_id,
    );

    $type = Question::model()->getQuestionTypeLabel($model->question_type);

    if ($type == "Essay Answer") {
        $this->menu = array(
            array('label' => 'List Questions', 'url' => array('index')),
            array('label' => 'Create Question', 'url' => array('create')),
            array('label' => 'Update Question', 'url' => array('update', 'id' => $model->question_id)),
            //array('label' => 'Set Reference', 'url' => array('viewReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id')),
            //array('label' => 'Update Reference', 'url' => array('ViewUpdateReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id_update')),
            array('label' => 'Manage Questions', 'url' => array('admin')),
        );
    } else {
        $this->menu = array(
            array('label' => 'List Questions', 'url' => array('index')),
            array('label' => 'Create Question', 'url' => array('create')),
            array('label' => 'Update Question', 'url' => array('update', 'id' => $model->question_id)),
            //array('label' => 'Set Reference', 'url' => array('viewReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id')),
            //array('label' => 'Update Reference', 'url' => array('ViewUpdateReferenceMaterial', 'id' => $model->question_id), 'itemOptions' => array('id' => 'ref_id_update')),
            array('label' => 'Manage Questions', 'url' => array('admin')),
        );
    }
    ?>

    <?php
    $qid = $model->question_id;
    $attach = $model->exhibit_attachment;

    $subjectAreaDetails = SubjectArea::model()->getSubjectAreaDetails($model->subject_area_id);

    $subject = Subject::model()->getSubjectDetails($subjectAreaDetails['subject_id']);

    $level = Level::model()->getLevel($subject['level_id']);

    $course = Course::model()->getCourseDetails($level['course_id']);


    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            array('name' => 'Question ID', 'value' => $model->question_id),
            array('name' => 'Course', 'value' => $course['course_name']),
            array('name' => 'Level', 'value' => $level['level_name']),
            array('name' => 'Subject', 'value' => $subject['subject_name']),
            array('name' => 'Subject Area', 'value' => SubjectArea::model()->getSubjectAreaName($model->subject_area_id)),
            array('name' => 'Question Type', 'value' => Question::model()->getQuestionTypeLabel($model->question_type)),
            'number_of_marks',
            array('label' => 'Exhibit',
                'type' => 'raw',
                'value' => CHtml::link(CHtml::encode($model->exhibit_attachment), Yii::app()->baseUrl . '/images/exhibit_attachment/' . $model->question_id . '/' . $model->exhibit_attachment)),
            array('name' => 'Exclude From Dynamic', 'value' => Question::model()->getExcludeDynamicLabel($model->exclude_from_dynamic)),
            array('name' => 'Lecturer Code', 'value' => Lecturer::model()->getLecturerCodeByUserId($model->author_id)),
            array('name' => 'Lecturer Name', 'value' => User::model()->getName($model->author_id)),
        ),
    ));
    ?>

    <br/>
    <?php
    echo '<h4>Question Display</h4><hr>';
    echo '<div style="max-width:800px;word-wrap: break-word;">';
    echo html_entity_decode($model->question_text, HTML_ENTITIES, 'UTF-8');
    echo '</div>';
    echo '<br/>';
    ?>


    <!-- hotspot question function --->

    <script type="text/javascript">
        //    var ele = document.getElementById("question_types");
        //    if (ele.value == "HOT_SPOT_ANSWER") {
        //        showImage();
        //    }

        function showImage() {
            // myImage : ID of image on which to place new image
            var offX = 0;
            var offY = 0;
            var l = 0;
            var t = 0;
            var xCoordinates = new Array();
            var yCoordinates = new Array();

    <?php
    $image_coordinates = Hotspot::model()->getImageName($model->question_id);

    $coords = '';
    $pieces = '';
    $tok = Array();

    $coordX = Array();
    $coordY = Array();

    if (!empty($image_coordinates)) {

        foreach ($image_coordinates as $coordinate) {
            $coords = $coordinate->coordinates;
        }

        $pieces = explode("/", $coords);

        $temp1 = array();
        for ($k = 0; $k < sizeof($pieces); $k++) {
            $tempp = array();

            $tok[$k] = explode(",", $pieces[$k]);
            foreach ($tok[$k] as $key => $value) {
                //print_r("<<".$key."-".$value.">>");
                if ($value != '') {
                    $tempp[] = $value;
                }
            }
            $temp1[] = $tempp;
        }

        $numberofareas = 0;
//add "-" when a one area is finished
        foreach ($temp1 as $tm) {
            if ($numberofareas > 0) {
                $coordX[] = "-";
                $coordY[] = "-";
            }
            foreach ($tm as $key => $value) {
                if ($key % 2 == 0) {
                    $coordX[] = $value;
                } else {
                    $coordY[] = $value;
                }
            }
            $numberofareas++;
        }


        for ($i = 0; $i < sizeof($coordX); $i++) {
            ?>
                    xCoordinates.push('<?php echo $coordX[$i]; ?>');

                    yCoordinates.push('<?php echo $coordY[$i]; ?>');
            <?php
        }
        ?>

                var image = document.getElementById('myImage');
                var crossColorCount = 0;
                margin = 0;

                // Location inside the image

                for (ik = 0; ik < xCoordinates.length; ik++) {

                    l = (image.offsetLeft);
                    t = (image.offsetTop);
                    w = image.width;
                    h = image.height;

                    if (xCoordinates[ik] == "-" && yCoordinates[ik] == "-") {
                        crossColorCount++;
                    }

                    if (xCoordinates[ik] != "-") {
                        offX = parseInt(xCoordinates[ik]);
                    }
                    if (yCoordinates[ik] != "-") {
                        offY = parseInt(yCoordinates[ik]);
                    }

                    if (offX > margin)
                        offX -= margin;
                    if (offY > margin)
                        offY -= margin;

                    l += (offX);
                    t += (offY);

                    if (xCoordinates[ik] != "-") {
                        var newImage = document.createElement("img");
                        if (crossColorCount == 0) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png');
                        } else if (crossColorCount == 1) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/cross1.png');
                        } else if (crossColorCount == 2) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossblue.png');
                        } else if (crossColorCount == 3) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossbrown.png');
                        } else if (crossColorCount == 4) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgreen.png');
                        } else if (crossColorCount == 5) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgrey.png');
                        } else if (crossColorCount == 6) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crosspink.png');
                        } else if (crossColorCount == 7) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossrorange.png');
                        } else if (crossColorCount == 8) {
                            newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossyellow.png');
                        }

                        newImage.style.width = '12px';
                        newImage.style.height = '14px';
                        newImage.setAttribute('class', 'overlays');
                        newImage.style.left = l - 7 + "px";
                        newImage.style.top = t - 6 + "px";

                        $('#imge').append(newImage);
                    }
                }

    <?php } ?>

        }

        window.onload = showImage;

    </script>



    <?php
    if ($model->question_type == 'HOT_SPOT_ANSWER') {
        $uploaded_images = Hotspot::model()->getImageName($model->question_id);

        if (!empty($uploaded_images)) {

            foreach ($uploaded_images as $images) {
                if ($images->image_name != Null) {

                    echo '<style>
                        .overlays{
                         position: absolute;
                        } 
                        </style>';

                    echo '<div id="imge" style="max-width:600px; max-height:400px">';
                    echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $images->hotspot_id . '/' . $images->image_name . '" style="max-width:600px; max-height:400px" />';
                    echo '</div>';
                } else {
                    echo '<div id="imge" style="max-width:600px; max-height:400px">';
                    echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png" style="max-width:600px; max-height:400px" />';
                    echo '</div>';
                }
            }
        } else {
            echo '<div id="imge" style="width:auto;height:400px">';
            echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png" style="max-width:600px; max-height:400px" />';
            echo '</div>';
        }
    }
    ?> 


    <br/>
    <?php
    echo '<h4>Question Logic</h4><hr>';
    if ($model->question_logic == null) {
        echo '<h6>question logic not set</h6>';
    } else {
        echo html_entity_decode($model->question_logic, HTML_ENTITIES, 'UTF-8');
        //echo html_entity_decode($model->question_logic);
    }

    echo '<br/>';
    ?>



    <br/>
    <br/>


    <!--<button class="btn btn-mock" id="formula-btn" type="button" onclick="openPdf()">View Pdf</button>-->

    <br /><br />


    <b>Status: </b>
    <?php
    if ($model->status == 1) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'Active<br/><br/>'; ?>
        </p>


                                                                                        <!--        <p id="exam_question_message" style="color: red"></p>-->



        <?php
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Question/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){             
                           
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                           document.getElementById("suspendButton").style.display = "none";
                           document.getElementById("reactivateButton").style.display = "block";
                           document.getElementById("exam_question_message").style.color = "red";
                           document.getElementById("exam_question_message").innerHTML = data.message;                           
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:block')
        );



        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Question/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){   

                            document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";
                            document.getElementById("exam_question_message").style.color = "green";
                            document.getElementById("exam_question_message").innerHTML = data.message;  
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:none')
        );
        ?>
        <br />
        <p id="exam_question_message"></p>
        <?php
    } else if ($model->status == 0) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'In-Active<br/><br/>'; ?>
        </p>


        <?php
        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Question/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){                                       
                            document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";
                            document.getElementById("exam_question_message").style.color = "green";
                            document.getElementById("exam_question_message").innerHTML = data.message;  
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:block')
        );
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Question/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('question_id' => $model->question_id),
            'success' => 'js:function(data){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                           document.getElementById("suspendButton").style.display = "none";
                           document.getElementById("reactivateButton").style.display = "block";
                           document.getElementById("exam_question_message").style.color = "red";
                           document.getElementById("exam_question_message").innerHTML = data.message;                           
                        }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:none')
        );
        ?>
        <br />
        <p id="exam_question_message"></p>
        <?php
    }
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}