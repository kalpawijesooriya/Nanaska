<?php
$examAttachment = ExamAttachment::model()->getDetailsExamAttachment($examID);

echo '<h4 class="light_heading">Tables & Formulae</h4><br/>';
?>

<div class="well">
    <?php
    if ($examAttachment == null) {
        echo '<strong>No Exam Attachment</strong>';
    } else {
        ?>
        <div class="bs-example">
            <ul class="nav nav-tabs">
                <?php
                $count = 0;
                foreach ($examAttachment as $key => $item) {

                    $tab_title = "Attachment" . ($key + 1);

                    if ($count == 0) {
                        ?>
                        <li class="active"><a data-toggle="tab" href="#<?php echo $item['exam_attachment_id']; ?>"><?php echo $tab_title; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a data-toggle="tab" href="#<?php echo $item['exam_attachment_id']; ?>"><?php echo $tab_title; ?></a></li>
                        <?php
                    }
                    $count++;
                }
                ?>

            </ul>
            <div class="tab-content">

                <?php
                $count2 = 0;

                foreach ($examAttachment as $key => $item) {
                    if ($count2 == 0) {
                        ?>
                        <div id="<?php echo $item['exam_attachment_id']; ?>" class="tab-pane fade in active">
                            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/essay_exam_attachment/' . $item['attachment'], "", array('width' => '800px', 'height' => 'auto')); ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div id="<?php echo $item['exam_attachment_id']; ?>" class="tab-pane fade">
                            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/essay_exam_attachment/' . $item['attachment'], "", array('width' => '800px', 'height' => 'auto')); ?>
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