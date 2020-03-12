<div class="container">
  
    <?php
        $this->renderpartial('_level_news_sidemenu');
    ?>
    
    <div class="span8">
        <div class="widget stacked">
					
                <div class="widget-header">
                        <i class="icon-user"></i>
                        <h3>Personal Details</h3>
                </div> <!-- /widget-header -->
				
                    <div class="widget-content">

                        <div class="shortcuts">
                                <?php echo CHtml::link('<i class="icon-zoom-in text-large"></i><span class="shortcut-label">View Account Details</span>',array('view','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
<!--                                <a href="javascript:;" class="shortcut">
                                        <i class="icon-list-alt"></i>
                                        <span class="shortcut-label">View Account Details</span>
                                </a>-->
                                <?php echo CHtml::link('<i class="icon-pencil"></i><span class="shortcut-label">Update Account Details</span>',array('update','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
                                
                                <?php echo CHtml::link('<i class=" icon-random"></i><span class="shortcut-label">Change<br/>Password</span>',array('updatepass','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
                               
                        </div> <!-- /shortcuts -->	

                    </div> <!-- /widget-content -->
				
	</div>
        
        <div class="widget stacked">
					
                <div class="widget-header">
                        <i class="icon-bookmark"></i>
                        <h3>Exam Details</h3>
                </div> <!-- /widget-header -->
				
                    <div class="widget-content">

                        <div class="shortcuts">
                                
                    <?php 
                        $user_ID        = Yii::app()->user->getId(); 
                        $student_type   = Student::model()->getStudentTypeByUserId($user_ID);

                        if($student_type == 'FULL_TIME')
                        {?>
                                <?php echo CHtml::link('<i class="icon-calendar"></i><span class="shortcut-label">Scheduled<br/>Exams</span>',array('viewScheduledExams','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
                                 
                                <?php echo CHtml::link('<i class="icon-list-alt"></i><span class="shortcut-label">Past Exams Details</span>',array('viewPastExams','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
                                <?php echo CHtml::link('<i class="icon-plus"></i><span class="shortcut-label">Buy<br/>Exams</span>',array('exam/viewexam'),array('class'=>'shortcut')); ?>
                         <?php
                         }
                         else
                         { ?>
                                <?php echo CHtml::link('<i class="icon-calendar"></i><span class="shortcut-label">Scheduled<br/>Exams</span>',array('viewScheduledExams','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
<!--                                <a href="javascript:;" class="shortcut">
                                        <i class="icon-list-alt"></i>
                                        <span class="shortcut-label">Scheduled Exams</span>
                                </a>-->
                                <?php echo CHtml::link('<i class="icon-list-alt"></i><span class="shortcut-label">Past Exams Details</span>',array('viewPastExams','id'=>Yii::app()->user->id),array('class'=>'shortcut')); ?>
                                
<!--                                <a href="javascript:;" class="shortcut">
                                        <i class="icon-signal"></i>
                                        <span class="shortcut-label">Pay For Your Exams</span>	
                                </a>-->
                                <?php echo CHtml::link('<i class="icon-plus"></i><span class="shortcut-label">Buy<br/>Exams</span>',array('exam/viewexam'),array('class'=>'shortcut')); ?>
                         <?php
                          }
                         ?>
                             
                        </div> <!-- /shortcuts -->	

                    </div> <!-- /widget-content -->
				
	</div>
    </div>
</div>
<br><br><br>
