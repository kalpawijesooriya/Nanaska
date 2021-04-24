<div id="reference-dialog">
    <?php
    $reference_materials = QuestionReferenceMaterials::model()->findAllByAttributes(array('question_id' => $questionID));
    ?>
    <?php
    if ($reference_materials == null) {
        echo 'No Reference Materials';
    } else {
        ?>
        <div class="bs-example">
            <ul class="nav nav-tabs">
                <?php
                $count = 0;
                foreach ($reference_materials as $item) {
                    $tab_title = QuestionReferenceMaterialTabs::model()->findByAttributes(array('question_reference_material_id' => $item->question_reference_material_id));
                    if ($count == 0) {
                        ?>
                        <li class="active"><a data-toggle="tab" href="#tabPdf<?php echo $item['reference_tab_position']; ?>"><?php echo $tab_title['reference_tab_title']; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a data-toggle="tab" href="#tabPdf<?php echo $item['reference_tab_position']; ?>"><?php echo $tab_title['reference_tab_title']; ?></a></li>
                        <?php
                    }
                    $count++;
                }
                ?>
            </ul>
            <div class="tab-content">
                <?php
                $count2 = 0;
                foreach ($reference_materials as $item) {
                    if (!empty($item->reference_material_text)) {
                        if ($count2 == 0) {
                            ?>
                            <div id="tabPdf<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade in active">
                                <?php
                                echo $item['reference_material_text'];
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="tabPdf<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade">
                                <?php
                                echo $item['reference_material_text'];
                                ?>
                            </div>
                            <?php
                        }
                    } else if (!empty($item->reference_file)) {
                        if ($count2 == 0) {
                            ?>
                            <div id="tabPdf<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade in active" style="position:relative;height:relative;overflow:scroll;">
                                <?php
                                $location = Yii::app()->baseUrl . '/images/reference_material/' . $questionID . '/' . $item['reference_tab_position'].'/'.$item['reference_file'];
                                echo '<img src="' . $location . '" style="width:relative;height:relative">';
                                ?>

                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="tabPdf<?php echo $item['reference_tab_position']; ?>" class="tab-pane fade" style="position:relative;height:relative;overflow:scroll;">
                                <?php
                                $location = Yii::app()->baseUrl . '/images/reference_material/' . $questionID . '/' . $item['reference_tab_position'].'/'.$item['reference_file'];
                                echo '<img src="' . $location . '" style="width:relative;height:relative">';
                                ?>

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

