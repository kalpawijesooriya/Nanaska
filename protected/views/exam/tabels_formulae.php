

<?php
//echo $examID;
$tables_and_formulae = Exam::model()->getExamTablesAndFormulaeByExamId($examID);


echo '<h4 class="light_heading">Tables & Formulae</h4><br/>';
?>
<div class="well">
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

                    $tab_title = Exam::model()->getExamTablesAndFormulaeTabTitleByExamTablesAndFormulaeId($item['exam_tables_and_formulae_id']);

                    if ($count == 0) {
                        ?>
                        <li class="active"><a data-toggle="tab" href="#<?php echo $item['tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a data-toggle="tab" href="#<?php echo $item['tab_position']; ?>"><?php echo $tab_title['tab_title']; ?></a></li>
                        <?php
                    }
                    $count++;
                }
                ?>
            </ul>
            <div class="tab-content" style="overflow-y: hidden">

                <?php
                $count2 = 0;

                foreach ($tables_and_formulae as $item) {
                    if ($count2 == 0) {
                        ?>
                        <div id="<?php echo $item['tab_position']; ?>" class="tab-pane fade in active">
                            <?php
                            if ($item['tables_and_formulae_text'] != NULL) {
                                echo $item['tables_and_formulae_text'];
                            } else {
                                echo CHtml::image(Yii::app()->request->baseUrl . '/images/table_formulae/' . $examID . '/' . $item['table_formulae_image'], "");
                            }
                            ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div id="<?php echo $item['tab_position']; ?>" class="tab-pane fade">
                            <?php
                            if ($item['tables_and_formulae_text'] != NULL) {
                                echo $item['tables_and_formulae_text'];
                            } else {
                                echo CHtml::image(Yii::app()->request->baseUrl . '/images/table_formulae/' . $examID . '/' . $item['table_formulae_image'], "");
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

