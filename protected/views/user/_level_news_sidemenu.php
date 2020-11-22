<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/advancedticker.css" />

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.easy-ticker.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
<br>
<br>
<br>
<div class="span3">
    <div class="master_heading"><center> Level News </center></div>

    <div id="wrapperforSlider">

        <?php
        $user_id = Yii::app()->user->getID();
        $msgs = News::model()->getLevelNews($user_id);
        $levelid = News::model()->getLevelforNews($user_id);

        if (empty($msgs['msg'])) {
            echo '<div class="well">';
            echo '<center><b>No level News</b></center>';
            echo '</div>';
        } else {
            ?>    

            <div id="nt-example1-container">
                <ul id="nt-example1">
                    <?php
                    foreach ($msgs['msg'] as $msg => $val) {
                        ?>
                        <li class="news-row" style="font-size: 13px; line-height: 25px"><?php echo $val['message']; ?></li>
                            <?php
                        }
                        ?>
                </ul>
            </div>               

            <?php
        }
        ?>

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        var dd = $('#nt-example1-container').easyTicker({
            direction: 'up',
            easing: 'easeInExpo',
            speed: 'slow',
            interval: 3000,
            height: 350,
            visible: 4,
            mousePause: 1,
            controls: {
                up: '#nt-example1-prev',
                down: '#nt-example1-next'
            }
        });
    });
</script>