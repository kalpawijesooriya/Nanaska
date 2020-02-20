<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="container">

<h2>Error <?php echo $code; ?></h2>

<div class="well">
    <p style="color: red"><b><?php echo CHtml::encode($message); ?></b></p>
</div>


<br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>