<div class="container">

    <?php
    $this->renderpartial('_level_news_sidemenu');
    $levelname = User::model()->getLevelByLevelId($levelid);
    $LevelNewsDetails = News::model()->getLevelNewsDetailsByNewsId($messageid['news_id']);
    // var_dump($LevelNewsDetails);die;
    ?>

    <div class="span8">
        <div class="master_heading"><?php echo $levelname[0]['level_name'] ?></div>

        <div class="well">               

            <b><?php echo CHtml::encode('Subject'); ?>:</b>
            <?php echo CHtml::encode($LevelNewsDetails[0]['subject']); ?>
            <br />

            <b><?php echo CHtml::encode('Message'); ?>:</b>
            <?php echo CHtml::encode($LevelNewsDetails[0]['message']); ?>
            <br />


            <b><?php echo CHtml::encode('Attachment'); ?>:</b>

            <?php
            if ($LevelNewsDetails[0]['attachment'] == null) {
                echo 'Attachment not set';
            } else {
                echo '<a href="' . Yii::app()->baseUrl . '/images/NewsImageAttachments/' . $LevelNewsDetails[0]['news_id'] . '/' . $LevelNewsDetails[0]['attachment'] . '" download>Download Attachment</a>';
            }
           
            ?>

        </div>

    </div>

</div>

