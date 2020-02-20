<!--<div class="span3"> 
	<ul id="stack_tab" class="nav nav-tabs nav-stacked">
              <li class="active"><a href="#">Personal Details</a>
                  <ul id="stack_tab" class="nav nav-tabs nav-stacked"><li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;Edit Account</a></li>
                      <li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;Change Password</a></li>
                  
              </li>
              <li><a href="#">Scheduled Exams</a></li>
              <li><a href="#">Past Exams</a></li>
              
            </ul>
</div>-->
<div class="span3">
<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    
    'items'=>array(
        array('label'=>'PERSONAL DETAILS'),
        array('label'=>''),
        array('label'=>'View Account', 'icon'=>'book', 'url'=>array('view','id'=>Yii::app()->user->id)),
        array('label'=>'Update Account', 'icon'=>'pencil', 'url'=>array('update','id'=>Yii::app()->user->id)),
        array('label'=>'Change Password', 'icon'=>'edit', 'url'=>array('updatepass','id'=>Yii::app()->user->id)),
        array('label'=>''),
        array('label'=>'EXAM DETAILS'),
        array('label'=>''),
        array('label'=>'Scheduled Exams', 'icon'=>'calendar', 'url'=>array('viewScheduledExams','id'=>Yii::app()->user->id)),
        array('label'=>'Past Exams', 'icon'=>'file', 'url'=>array('viewPastExams','id'=>Yii::app()->user->id)),
       
    ),
)); ?>
</div>