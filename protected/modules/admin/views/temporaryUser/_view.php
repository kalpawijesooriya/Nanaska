<div class="well">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php
  
    echo CHtml::encode($data->id);
    ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
<?php echo CHtml::encode($data->first_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
<?php echo CHtml::encode($data->last_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('phone_number')); ?>:</b>
<?php echo CHtml::encode($data->phone_number); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
<?php echo CHtml::encode($data->address); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
<?php echo CHtml::encode(TemporaryUser::model()->getCountruByID($data->country_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
<?php echo CHtml::encode($data->email); ?>
    <br />
    <br />

    <?php echo CHtml::link(CHtml::encode("View In Detail"), array('view', 'id' => $data->id)); ?>

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
      <?php echo CHtml::encode($data->course_id); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('level_id')); ?>:</b>
      <?php echo CHtml::encode($data->level_id); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('sitting_id')); ?>:</b>
      <?php echo CHtml::encode($data->sitting_id); ?>
      <br />

     */ ?>

</div>