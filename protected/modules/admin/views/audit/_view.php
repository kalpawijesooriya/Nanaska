<div class="well">

    <b><?php echo CHtml::encode("Log number"); ?>:</b>
    <?php echo CHtml::encode($data->audit_id); //echo CHtml::link(CHtml::encode($data->audit_id), array('view', 'id'=>$data->audit_id)); ?>
    <br />

    <?php
    $userDetails = User::model()->getUserName($data->user_id);

    if ($userDetails['user_type'] != "SUPERADMIN") {
        ?>
        <b><?php echo CHtml::encode("User id"); ?>:</b>
        <?php
        if ($data->user_id == "") {
            echo CHtml::encode("-");
        } else {
            echo CHtml::encode($data->user_id);
        }
        ?>
        <br />

        <?php
    }
    ?>

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php
    if ($userDetails['user_type'] == "SUPERADMIN") {
        $fullName = "Admin";
    } else if ($userDetails['first_name'] == "") {
        $fullName = "-";
    } else {
        $fullName = $userDetails['first_name'] . " " . $userDetails['last_name'];
    }
    ?>


    <?php echo CHtml::encode($fullName); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('action_name')); ?>:</b>
    <?php echo CHtml::encode(Audit::model()->getActionNameBylabel($data->action_name)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('action_id')); ?>:</b>
    <?php echo CHtml::encode($data->action_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
    <?php echo CHtml::encode($data->action); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
    <?php echo CHtml::encode($data->time); ?>
    <br />

    <br/>
    <?php echo CHtml::link(CHtml::encode("View In Detail"), array('view', 'id' => $data->audit_id)); ?>

</div>