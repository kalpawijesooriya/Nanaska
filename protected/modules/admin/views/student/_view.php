<div class="view">
    <div class="well">

        <b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
        <?php echo CHtml::encode($data->student_id); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('Student Name')); ?>:</b>
        <?php echo CHtml::encode($data->user->first_name." ".$data->user->last_name); ?></td>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('Level')); ?>:</b>
        <?php echo CHtml::encode(Level::model()->getLevelName($data->level_id)); ?></td>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('Session')); ?>:</b>
        <?php echo CHtml::encode(Sitting::model()->getSittingByID($data->sitting_id)); ?></td>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
        <?php
        
        if ($data->status == 1) {
            echo 'Active';
        } else if ($data->status == 0) {
            echo 'In-Active';
        }
        ?></td>
        <br />
        <br />
        <?php echo CHtml::link(CHtml::encode("View In Detail"), array('view', 'id' => $data->student_id)); ?>

    </div>
</div>