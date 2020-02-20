<?php
/* @var $this TestimonialsController */
/* @var $model Testimonials */

$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	$model->testimonials_id,
);

$this->menu=array(
	array('label'=>'List Testimonials', 'url'=>array('index')),
	array('label'=>'Create Testimonials', 'url'=>array('create')),
	array('label'=>'Update Testimonials', 'url'=>array('update', 'id'=>$model->testimonials_id)),
	array('label'=>'Delete Testimonials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->testimonials_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Testimonials', 'url'=>array('admin')),
);
?>

<h1>View Testimonials #<?php echo $model->testimonials_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'testimonials_id',
		'testimonials_name',
		'testimonials_description',
		'image_url',
	),
)); ?>
