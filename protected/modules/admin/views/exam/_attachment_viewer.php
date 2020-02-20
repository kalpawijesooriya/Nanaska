<div class="well">
    <?php
    if ($attachment == null) {
        echo '<strong>No Exam Attachment</strong>';
    } else {
        ?>
        <div class="bs-example">
            
            <div class="tab-content">

                <div>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/essay_exam_attachment/' . $attachment, "", array('width' => '800px', 'height' => 'auto')); ?>
                </div>

                
            </div>
        </div>

        <?php
    }
    ?>


</div>
