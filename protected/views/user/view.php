<div class="container">
    <?php
//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	$model->user_id,
//);
    $this->renderpartial('_level_news_sidemenu');
//$this->menu=array(
//	array('label'=>'View Account','url'=>array('view','id'=>$model->user_id)),
//	array('label'=>'Edit Account','url'=>array('update','id'=>$model->user_id)),
//	array('label'=>'Change Password','url'=>array('updatepass','id'=>$model->user_id)),
    //array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
    //array('label'=>'Manage User','url'=>array('admin')),
//);
    ?>


    <div class="span8"> 
        <h3 class="master_heading">Account Settings</h3>
        <div class="well well-no-background">
        
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">First Name</label>
                    <div class="controls">
                        <input class="span5" type="text" id="inputEmail" value="<?php echo $model->first_name ?>" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Last Name</label>
                    <div class="controls">
                        <input class="span5" type="text" id="inputEmail" value="<?php echo $model->last_name ?>" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input class="span5" type="text" id="inputEmail" value="<?php echo $model->email ?>" readonly/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputEmail">Phone Number</label>
                    <div class="controls">
                        <input class="span5" type="text" id="inputEmail" value="<?php echo $model->phone_number ?>" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Address</label>
                    <div class="controls">
                        <input class="span5" type="text" id="inputEmail" value="<?php echo $model->address ?>" readonly/>
                    </div>
                </div>

                <!--  <div class="control-group">
                  <button type="submit" class="btn btn-edit pull-right">Edit</button>
                </div>-->
            </form>	
        </div>
    </div>

    <?php
    //$this->widget('bootstrap.widgets.TbDetailView',array(
//	'data'=>$model,
//	'attributes'=>array(
//		'user_id',
//		'first_name',
//		'last_name',
//		'email',
//		'phone_number',
//		'address',
//		//'country.country_name',
//		'user_type',
//	),
//)); 
    ?>

</div>
