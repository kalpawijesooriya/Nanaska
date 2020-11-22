<?php
/* @var $this TestimonialsController */
/* @var $model Testimonials */

$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Testimonials', 'url'=>array('index')),
	array('label'=>'Manage Testimonials', 'url'=>array('admin')),
);
?>

<h1>Create Testimonials</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>