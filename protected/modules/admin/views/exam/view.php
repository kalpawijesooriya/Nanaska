<?php
if (Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("exam_management") == 1) {

    $this->breadcrumbs = array(
        'Exams' => array('index'),
        $model->exam_id,
    );

    $this->menu = array(
        array('label' => 'List Exam', 'url' => array('index')),
        array('label' => 'Create Exam', 'url' => array('create')),
        array('label' => 'Update Exam', 'url' => array('update', 'id' => $model->exam_id)),
        //array('label' => 'Set Image', 'url' => array('setExamImage', 'id' => $model->exam_id)),
        array('label' => 'Set Attachments', 'url' => array('setAttachments', 'id' => $model->exam_id)),
//        array('label' => 'Set Instructions', 'url' => array('setExamInstruction', 'id' => $model->exam_id)),
//        array('label' => 'Update Instructions', 'url' => array('editExamInstruction', 'id' => $model->exam_id)),
        //    array('label' => 'Delete Exam', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->exam_id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Manage Exams', 'url' => array('admin')),
        array('label' => 'Export To PDF', 'url' => array('exportToExcel', 'id' => $model->exam_id)),
    );
    ?>

    <h2 class="light_heading">View Exam <?php echo $model->exam_id; ?></h2><br/>

    <?php
    if ($model->exam_type == "ESSAY") {
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'exam_id',
                array('name' => 'Course', 'value' => Course::model()->getCourseName(Subject::model()->getCourseOfSubject($model->subject_id))),
                array('name' => 'Level', 'value' => Level::model()->getLevelName(Subject::model()->getLevelOfSubject($model->subject_id))),
                array('name' => 'Subject', 'value' => Subject::model()->getSubjectName($model->subject_id)),
                'exam_name',
                'exam_description',
                'number_of_questions',
                'exam_type',
                'time',
                array('name' => 'Calculator Allowed', 'value' => Exam::model()->getBooleanText($model->calculator_allowed)),
                'exam_price',
//            'marks_per_question',
//            array('name' => 'Allow Custom Marks', 'value' => Exam::model()->getBooleanText($model->allow_custom_marks)),
//            array('name' => 'Allow Minus Marks', 'value' => Exam::model()->getBooleanText($model->allow_minus_marks)),
                'pass_mark',
                'expiry_duration',
//            array('name' => 'Allow View Marked Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_marked_questions)),
//            array('name' => 'Allow Go To Question', 'value' => Exam::model()->getBooleanText($model->allow_goto_question)),
//            array('name' => 'Allow View Un-answered Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_unanswered_questions)),
//                array('name' => 'Allow View Marked Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_marked_questions)),
                array('name' => 'Allow Go To Question', 'value' => Exam::model()->getBooleanText($model->allow_goto_question)),
                array('name' => 'Allow View Un-answered Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_unanswered_questions)),
            ),
        ));
    } else {
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'exam_id',
                array('name' => 'Course', 'value' => Course::model()->getCourseName(Subject::model()->getCourseOfSubject($model->subject_id))),
                array('name' => 'Level', 'value' => Level::model()->getLevelName(Subject::model()->getLevelOfSubject($model->subject_id))),
                array('name' => 'Subject', 'value' => Subject::model()->getSubjectName($model->subject_id)),
                'exam_name',
                'exam_description',
                'number_of_questions',
                'exam_type',
                'time',
                array('name' => 'Calculator Allowed', 'value' => Exam::model()->getBooleanText($model->calculator_allowed)),
                'exam_price',
                'marks_per_question',
                array('name' => 'Allow Custom Marks', 'value' => Exam::model()->getBooleanText($model->allow_custom_marks)),
                array('name' => 'Allow Minus Marks', 'value' => Exam::model()->getBooleanText($model->allow_minus_marks)),
                'pass_mark',
                'expiry_duration',
                array('name' => 'Allow View Marked Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_marked_questions)),
                array('name' => 'Allow Go To Question', 'value' => Exam::model()->getBooleanText($model->allow_goto_question)),
                array('name' => 'Allow View Un-answered Questions', 'value' => Exam::model()->getBooleanText($model->allow_view_unanswered_questions)),
            ),
        ));
    }

    echo '<h3 class="light_heading">Exam Image</h3><br/>';

//echo $model->exam_image;

    if ($model->exam_image != null) {

        echo CHtml::image(Yii::app()->request->baseUrl . '/images/exam_images/' . $model->exam_image, "", array("width" => "200px", "height" => "72px"));
    } else {
        if (Yii::app()->user->hasFlash(Consts::STATUS_IMAGE_NOT_SET)) {
            ?><div class="info">
            <?php echo Yii::app()->user->getFlash(Consts::STATUS_IMAGE_NOT_SET); ?>
            </div>
            <?php
        } else {
            ?><div>
                <?php echo Consts::ERROR_IMAGE_NOT_SET; ?>
            </div>
            <?php
        }
    }

    echo '<br />';
    echo '<h3 class="light_heading">Exam Instructions</h3><br/>';

    $extension = substr($model->exam_instruction, strrpos($model->exam_instruction, '.') + 1);
    $extension = strtolower($extension);

    if ($extension == "jpg" || $extension == "png" || $extension == "tif" || $extension == "gif") {
        echo CHtml::image(Yii::app()->request->baseUrl . '/images/exam_instructions/' . $model->exam_id . '/' . $model->exam_instruction, "", array("width" => "200px", "height" => "auto"));
    } else {
        echo $model->exam_instruction;
    }

//    if ($model->exam_type == "PRESET" || $model->exam_type == "DYNAMIC") {
//        //display exam exhibit image
//        echo '<br />';
//        echo '<h3 class="light_heading">Exam Exhibits</h3><br/>';
//        echo '<div id ="exhibit" class="well">';
//        if (isset($model->exam_exhibit)) {
//            $extension = substr($model->exam_exhibit, strrpos($model->exam_exhibit, '.') + 1);
//            $extension = strtolower($extension);
//
//            if ($extension == "jpg" || $extension == "png" || $extension == "tif" || $extension == "gif") {
//                echo CHtml::image(Yii::app()->request->baseUrl . '/images/exam_exhibit/' . $model->exam_id . '/' . $model->exam_exhibit, "", array("width" => "200px", "height" => "auto"));
//            } else {
//                echo $model->exam_exhibit;
//            }
//        } else {
//            echo '<strong>No Exhibit</strong>';
//        }
//        echo '</div>';
//    }
    //if ($model->exam_type != "ESSAY") {
    echo '<br/><br/>';
    $tables_and_formulae = ExamTablesAndFormulae::model()->getExamTablesAndFormulaeByExamId($model->exam_id);
    echo '<h3 class="light_heading">Tables & Formulae</h3><br/>';
    ?>
    <div id ="table_and_formula" class="well">
        <?php
        if ($tables_and_formulae == null) {
            echo '<strong>No Tables & Formulae</strong>';
        } else {
            ?>
            <div class="bs-example">
                <ul class="nav nav-tabs">
                    <?php
                    $count = 0;
//                if (sizeof($tables_and_formulae) == 3) {
                    foreach ($tables_and_formulae as $item) {
                        $tab_title = ExamTablesAndFormulaeTabTitle::model()->getExamTablesAndFormulaeTabTitleByExamTablesAndFormulaeId($item['exam_tables_and_formulae_id']);
                        if ($count == 0) {
                            ?>
                            <li class="active"><a data-toggle="tab" href="#table<?php echo $item['tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li><a data-toggle="tab" href="#table<?php echo $item['tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                            <?php
                        }
                        $count++;
                    }
                    ?>
                    <?php
                    ?>
                </ul>

                <div class="tab-content">
                    <?php
                    $count2 = 0;
                    foreach ($tables_and_formulae as $item) {
                        if ($count2 == 0) {
                            ?>
                            <div id="table<?php echo $item['tab_position']; ?>" class="tab-pane fade in active">
                                <?php
                                if ($item['tables_and_formulae_text'] != NULL) {
                                    echo $item['tables_and_formulae_text'];
                                } else {
                                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/table_formulae/' . $model->exam_id . '/' . $item['table_formulae_image'], "", array("width" => "200px", "height" => "auto"));
                                }
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="table<?php echo $item['tab_position']; ?>" class="tab-pane fade">
                                <?php
                                if ($item['tables_and_formulae_text'] != NULL) {
                                    echo $item['tables_and_formulae_text'];
                                } else {
                                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/table_formulae/' . $model->exam_id . '/' . $item['table_formulae_image'], "", array("width" => "200px", "height" => "auto"));
                                }
                                ?>
                            </div>
                            <?php
                        }
                        $count2++;
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    //} else {
    if ($model->exam_type == "ESSAY") {
        echo '<br/><br/>';
        $exam_preseen_material = ExamPreseenMaterials::model()->findAllByAttributes(array('exam_id' => ($model->exam_id)));
        echo '<h3 class="light_heading">Pre-Seen Materials</h3><br/>';
        ?>

        <div id ="preseen" class="well" >
            <?php
            if ($exam_preseen_material == null) {
                echo '<strong>No Pre-Seen Materials</strong>';
            } else {
                ?>
                <div class="bs-example">
                    <ul class="nav nav-tabs">
                        <?php
                        $count = 0;
                        foreach ($exam_preseen_material as $item) {
                            $tab_title = ExamPreseenMaterialTabs::model()->findByAttributes(array('exam_preseen_material_id' => $item->exam_preseen_material_id));
                            if ($count == 0) {
                                ?>
                                <li class="active"><a data-toggle="tab" href="#tabText"><?php echo $tab_title['tab_title']; ?></a></li>
                                <?php
                            } else {
                                ?>
                                <li><a data-toggle="tab" href="#<?php echo $item['preseen_tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </ul>
                    <div class="tab-content" style="height: 400px">
                        <?php
                        $count2 = 0;
                        foreach ($exam_preseen_material as $item) {
                            if (isset($item->preseen_text)) {
                                if ($count2 == 0) {
                                    ?>
                                    <div id="tabText" class="tab-pane fade in active">
                                        <?php
                                        echo $item['preseen_text'];
                                        ?>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div id="<?php echo $item['preseen_tab_position']; ?>" class="tab-pane fade">
                                        <?php
                                        echo $item['preseen_text'];
                                        ?>
                                    </div>
                                    <?php
                                }
                            } else if (isset($item->preseen_pdf)) {
                                if ($count2 == 0) {
                                    ?>
                                    <div id="tabText" class="tab-pane fade in active" style="height: 400px">
                                        <?php
                                        echo CHtml::link(CHtml::encode($item['preseen_pdf']), Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $model->exam_id . '/' . $item['preseen_pdf']);
                                        $location = Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $model->exam_id . '/' . $item['preseen_pdf'];
                                        ?>
                                        <br><br>
                                        <iframe id="cru-frame-RefNew"src="<?php echo $location; ?>"width="100%" height="100%" frameBorder="0" scrolling="yes" ></iframe>

                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div id="<?php echo $item['preseen_tab_position']; ?>" class="tab-pane" style="height: 400px">
                                        <?php
                                        echo CHtml::link(CHtml::encode($item['preseen_pdf']), Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $model->exam_id . '/' . $item['preseen_pdf']);
                                        $location = Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $model->exam_id . '/' . $item['preseen_pdf'];
                                        ?>
                                        <br><br>

                                        <iframe id="cru-frame-RefNew"src="<?php echo $location; ?>"width="100%" height="100%" frameBorder="0" scrolling="yes" ></iframe>

                                    </div>
                                    <?php
                                }
                            }

                            $count2++;
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
    }
    ?>
    <br/><br/>


    <div>

    </div>

    <?php
    $examData = Exam::getExamInfoById($model->exam_id);
    ?>


    <?php
    if ($examData->exam_type == "DYNAMIC") {
        $subjectAreaData = ExamSubjectArea::getSubjectAreasOfExamById($model->exam_id);
        echo '<br/>';
        ?>

        <table border="1">
            <tr>
                <td width="300">
            <center><strong>Subject</strong></center>
        </td>
        <td width="300">
        <center><strong>Subject Area</strong></center>
        </td>
        <td width="300">
        <center><strong>Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Single Answer Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Multiple Answer Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Short Written Answer Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Drag & Drop Answer Type A Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Drag & Drop Answer Type B Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Drag & Drop Answer Type C Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Drag & Drop Answer Type D Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Drag & Drop Answer Type E Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Multiple Choice Answer Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>True Or False Answer Weightage</strong></center>
        </td>
        <td width="300">
        <center><strong>Hot-Spot Answer Weightage</strong></center>
        </td>
        <!--            <td width="300">
        <center><strong>Subject Area Weightage</strong></center>
        </td>-->

        </tr>

        <?php
        foreach ($subjectAreaData as $subjectAreaItem) {
            echo '<tr>';

            echo '<td width="300">';
            echo '<center>';
            echo Subject::model()->getSubjectName($subjectAreaItem['subject_area_details']['subject_id']);
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['subject_area_details']['subject_area_name'];
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['single_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['multiple_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['short_written_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['drag_drop_typea_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['drag_drop_typeb_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['drag_drop_typec_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['drag_drop_typed_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['drag_drop_typee_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['multiple_choice_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['true_or_false_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '<td width="300">';
            echo '<center>';
            echo $subjectAreaItem['exam_subject_area_details']['hotspot_answer_weightage'] . " %";
            echo '</center>';
            echo '</td>';

            echo '</tr>';
        }
        ?>
        </table>
        <?php
    } elseif ($examData->exam_type == "ESSAY") {
        //$examQuestions = Exam::getQuestionsOfExamById($model->exam_id);
        $examSections = Exam::getSectionsOfExamById($model->exam_id);
        //var_dump($examSections);die;
        echo '<h3 class="light_heading">Exam Sections</h3>';
        foreach ($examSections as $examSection) {
            echo '<h4>Section ' . $examSection['section_number'] . '</h4>';
            echo '<h5>Section time: ' . $examSection['section_time'] . '</h5>';
            //echo $examSection['section_time'].'<br/>';
            $sectionQuestions = Exam::getQuestionsOfExamByIdSectionNo($model->exam_id, $examSection['section_number']);
            ?>

            <table border="1">
                <tr>
                    <td width="300">
                <center><strong>Question ID</strong></center>
            </td>
            <td width="300">
            <center><strong>Subject Area</strong></center>
            </td>
            <td width="300">
            <center><strong>Question Type</strong></center>
            </td>
            <td width="300">
            <center><strong>Date Created</strong></center>
            </td>
            <td width="300">
            <center><strong></strong></center>
            </td>
            </tr>

            <?php
            foreach ($sectionQuestions as $sectionQuestion) {
                $questionData = Question::model()->getQuestion($sectionQuestion['question_id']);
                echo '<tr>';

                echo '<td width="300">';
                echo '<center>';
                echo $sectionQuestion['question_id'];
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo Question::model()->getSubjectAreaOfQuestion($sectionQuestion['question_id']);
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo Question::model()->getQuestionTypeLabel($questionData['question_type']);
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo $questionData['date_created'];
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo CHtml::link(CHtml::encode("View In Detail"), array('question/view', 'id' => $sectionQuestion['question_id']));

                echo '</center>';
                echo '</td>';

                echo '</tr>';
            }

            echo '</table>';
            echo '<br/><br/>';
        }
    } else {
//        echo $model->exam_id;
        $examQuestions = Exam::getQuestionsOfExamById($model->exam_id);
        ?>

        <h4 class="light_heading">Questions</h4><br/>
        <table border="1">
            <tr>
                <td width="300">
            <center><strong>Question ID</strong></center>
            </td>
            <td width="300">
            <center><strong>Subject Area</strong></center>
            </td>
            <td width="300">
            <center><strong>Question Type</strong></center>
            </td>
            <td width="300">
            <center><strong>Date Created</strong></center>
            </td>
            <td width="300">
            <center><strong></strong></center>
            </td>
            </tr>    
            <?php
            foreach ($examQuestions as $examQuestion) {
                $questionData = Question::model()->getQuestion($examQuestion['question_id']);
                echo '<tr>';

                echo '<td width="300">';
                echo '<center>';
                echo $examQuestion['question_id'];
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo Question::model()->getSubjectAreaOfQuestion($examQuestion['question_id']);
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo Question::model()->getQuestionTypeLabel($questionData['question_type']);
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo $questionData['date_created'];
                echo '</center>';
                echo '</td>';

                echo '<td width="300">';
                echo '<center>';
                echo CHtml::link(CHtml::encode("View In Detail"), array('question/view', 'id' => $examQuestion['question_id']));

                echo '</center>';
                echo '</td>';

                echo '</tr>';
            }
//        print_r($examQuestions);
        }
        ?>
    </table>

    <br/>
    <!--</div>-->      
    <b>Status: </b>
    <?php
    if ($model->status == 1) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'Active<br/><br/>'; ?>
        </p>
        <?php
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Exam/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('exam_id' => $model->exam_id),
            'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:block')
        );
        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Exam/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('exam_id' => $model->exam_id),
            'success' => 'function(data){    

                               document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";         
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:none')
        );
    } else if ($model->status == 0) {
        ?>
        <p id="status" style="display:inline">
            <?php echo 'In-Active<br/><br/>'; ?>
        </p>
        <?php
        echo CHtml::ajaxSubmitButton('Re-Activate', CController::createUrl('Exam/reactivate'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('exam_id' => $model->exam_id),
            'success' => 'function(){                                       
                                      document.getElementById("status").innerHTML = "Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "block";
                            document.getElementById("reactivateButton").style.display = "none";      
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'reactivateButton', 'style' => 'display:block')
        );
        echo CHtml::ajaxSubmitButton('Suspend', CController::createUrl('Exam/suspend'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'data' => array('exam_id' => $model->exam_id),
            'success' => 'function(){                                       
                           document.getElementById("status").innerHTML = "In-Active<br/><br/>";
                            document.getElementById("suspendButton").style.display = "none";
                            document.getElementById("reactivateButton").style.display = "block";
                            
                           
                                    }'
                ), array('class' => 'btn btn-checkout', 'id' => 'suspendButton', 'style' => 'display:none')
        );
    }
} else {
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
?>
<br />
<script type="text/javascript">
    function openTable() {
        //var $j = jQuery.noConflict(true);
        $("#mydialog_pdf").dialog("open");
        return false;
    }
</script>
<!--</div>-->      