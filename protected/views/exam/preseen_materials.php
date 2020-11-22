<?php
$exam_preseen_material = ExamPreseenMaterials::model()->findAllByAttributes(array('exam_id' => $examID));
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
                        <li class="active"><a data-toggle="tab" href="#tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a data-toggle="tab" href="#tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                        <?php
                    }
                    $count++;
                }
                ?>
            </ul>
            <div class="tab-content" style="height: 600px">
                <?php
                $count2 = 0;
                foreach ($exam_preseen_material as $item) {
                    if (!empty($item->preseen_text)) {
                        if ($count2 == 0) {
                            ?>
                            <div id="tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>" class="tab-pane fade in active">
                                <?php
                                echo $item['preseen_text'];
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>" class="tab-pane fade">
                                <?php
                                echo $item['preseen_text'];
                                ?>
                            </div>
                            <?php
                        }
                    } else if (isset($item->preseen_pdf)) {
                            if ($count2 == 0) {
                                    ?>
                                    <div id="tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>" class="tab-pane fade in active" style="position:relative;height:100%;overflow:scroll;">
                                        <?php
                                        echo CHtml::link(CHtml::encode($item['preseen_pdf']), Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $examID . '/' . $item['preseen_pdf']);
                                        $location = Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $examID . '/' . $item['preseen_pdf'];
                                        ?>
                                        <br><br>
                                        <iframe id="cru-frame-RefNew"src="<?php echo $location; ?>"width="100%" height="100%" frameBorder="0" scrolling="yes" ></iframe>

                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div id="tabPdfPreseen<?php echo $item['preseen_tab_position']; ?>" class="tab-pane fade" style="position:relative;height:100% !important;overflow:scroll;">
                                        <?php
                                        echo CHtml::link(CHtml::encode($item['preseen_pdf']), Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $examID . '/' . $item['preseen_pdf']);
                                        $location = Yii::app()->baseUrl . '/images/essay_exam_preseen/' . $examID . '/' . $item['preseen_pdf'];
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
<script type="text/javascript">
    //pdf dialog open
    function openPDF() {
        $("#mydialog_pdf").dialog("open");
        return false;
    }
</script>
