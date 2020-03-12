<div class="container">
    <div class="span3">

    </div>

    <div class="span8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-user"></i>
                <h3>Personal Details</h3>
            </div> <!-- /widget-header -->

            <div class="widget-content">

                <div class="shortcuts">
                    <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">View Account Details</span>', array('viewLecturerDetails', 'id' => Yii::app()->user->id), array('class' => 'shortcut')); ?>
                    <!-- <a href="javascript:;" class="shortcut">
                                                            <i class="icon-list-alt"></i>
                                                            <span class="shortcut-label">View Account Details</span>
                                                    </a>-->
                    <?php //echo CHtml::link('<i class="icon-pencil"></i><span class="shortcut-label">Update Account Details</span>', array('update', 'id' => Yii::app()->user->id), array('class' => 'shortcut')); ?>

                    <?php echo CHtml::link('<i class=" icon-random"></i><span class="shortcut-label">Change<br/>Password</span>', array('viewChangeLecPass', 'id' => Yii::app()->user->id), array('class' => 'shortcut')); ?>

                </div> <!-- /shortcuts -->	

            </div> <!-- /widget-content -->

        </div>
    </div>

</div>

<br>
<br>
<br>