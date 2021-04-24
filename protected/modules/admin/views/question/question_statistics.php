<div class="row-fluid">
    <div class="span12"><h2 class="light_heading">Question Statistics</h2></div>
    <div class="span12">
        <div class="span2">
            Course
        </div>
        <div class="span10">
            <?php
            $courseList = Course::model()->findAll();
            echo CHtml::dropDownList('course_id', '', CHtml::listData($courseList, 'course_id', 'course_name'), array(
                'empty' => 'Select Course',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('question/loadlevels'), //or $this->createUrl('loadcities') if '$this' extends CController
                    'update' => '#level_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
                    'data' => array('course_id' => 'js:this.value'),
                    'beforeSend' => 'function() {
                        if(level_id.value!=""){                
                             level_id.options.length = 1;                  
                        }
                        if(subject_id.value!=""){                
                             subject_id.options.length = 1;                  
                        }
                        if(subject_area_id.value!=""){                
                             subject_area_id.options.length = 1;                  
                        }
                        if(question_id.value!=""){                
                             question_id.options.length = 1;                  
                        }
                        $( "#question_and_answer" ).html("");
                        $( "#no_of_times_appeared" ).html("");
                        $( "#no_of_times_attempted" ).html("");
                        $( "#no_of_marked" ).html("");
                        $( "#average_time_for_question" ).html("");
                        $( "#minimum_time_for_question" ).html("");
                        $( "#maximum_time_for_question" ).html("");
                        $( "#no_of_correct_attempts" ).html("");
                        $( "#no_of_incorrect_attempts" ).html("");
                    }',
                    ))
            );
            ?>
        </div>
    </div>

    <div class="span12">
        <div class="span2">
            Level
        </div>
        <div class="span10">
            <?php
            echo CHtml::dropDownList('level_id', '', array(), array('empty' => 'Select Level',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('question/loadSubjects'), //or $this->createUrl('loadcities') if '$this' extends CController
                    'update' => '#subject_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
                    'data' => array('level_id' => 'js:this.value'),
                    'beforeSend' => 'function() {                    
                        if(subject_id.value!=""){                
                             subject_id.options.length = 1;                  
                        }
                        if(subject_area_id.value!=""){                
                             subject_area_id.options.length = 1;                  
                        }
                        if(question_id.value!=""){                
                             question_id.options.length = 1;                  
                        }
                        $( "#question_and_answer" ).html("");
                        $( "#no_of_times_appeared" ).html("");
                        $( "#no_of_times_attempted" ).html("");
                        $( "#no_of_marked" ).html("");
                        $( "#average_time_for_question" ).html("");
                        $( "#minimum_time_for_question" ).html("");
                        $( "#maximum_time_for_question" ).html("");
                        $( "#no_of_correct_attempts" ).html("");
                        $( "#no_of_incorrect_attempts" ).html("");
                    }',
                    ))
            );
            ?>
        </div>
    </div>

    <div class="span12">
        <div class="span2">
            Subject
        </div>
        <div class="span10">
            <?php
            echo CHtml::dropDownList('subject_id', '', array(), array('empty' => 'Select Subject',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('question/loadSubjectAreas'), //or $this->createUrl('loadcities') if '$this' extends CController
                    'update' => '#subject_area_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
                    'data' => array('subject_id' => 'js:this.value'),
                    'beforeSend' => 'function() {                    
                        if(subject_area_id.value!=""){                
                             subject_area_id.options.length = 1;                  
                        }
                        if(question_id.value!=""){                
                             question_id.options.length = 1;                  
                        }
                        $( "#question_and_answer" ).html("");
                        $( "#no_of_times_appeared" ).html("");
                        $( "#no_of_times_attempted" ).html("");
                        $( "#no_of_marked" ).html("");
                        $( "#average_time_for_question" ).html("");
                        $( "#minimum_time_for_question" ).html("");
                        $( "#maximum_time_for_question" ).html("");
                        $( "#no_of_correct_attempts" ).html("");
                        $( "#no_of_incorrect_attempts" ).html("");
                    }',
                    ))
            );
            ?>
        </div>
    </div>

    <div class="span12">
        <div class="span2">
            Subject Area
        </div>
        <div class="span10">
            <?php
            echo CHtml::dropDownList('subject_area_id', '', array(), array('empty' => 'Select Subject Area',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('question/loadQuestions'), //or $this->createUrl('loadcities') if '$this' extends CController
                    'update' => '#question_id', //or 'success' => 'function(data){...handle the data in the way you want...}',
                    'data' => array('subject_area_id' => 'js:this.value'),
                    'beforeSend' => 'function() {                    
                        if(question_id.value!=""){                
                             question_id.options.length = 1;                  
                        }
                        $( "#question_and_answer" ).html("");
                        $( "#no_of_times_appeared" ).html("");
                        $( "#no_of_times_attempted" ).html("");
                        $( "#no_of_marked" ).html("");
                        $( "#average_time_for_question" ).html("");
                        $( "#minimum_time_for_question" ).html("");
                        $( "#maximum_time_for_question" ).html("");
                        $( "#no_of_correct_attempts" ).html("");
                        $( "#no_of_incorrect_attempts" ).html("");
                    }',
                    ))
            );
            ?>
        </div>
    </div>

    <div class="span12">
        <div class="span2">
            Question
        </div>
        <div class="span10">
            <?php
            echo CHtml::dropDownList('question_id', '', array(), array('prompt' => 'Select Question',
                'class' => 'form-control',
                'ajax' => array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'url' => $this->createUrl('question/loadQuestionAndAnswer'), //or $this->createUrl('loadcities') if '$this' extends CController
                    //'update' => '#question_and_answer', //or 'success' => 'function(data){...handle the data in the way you want...}',
                    'data' => array('question_id' => 'js:this.value'),
                    'beforeSend' => 'function() {                    
                        $( "#question_and_answer" ).html("");
                        $( "#no_of_times_appeared" ).html("");
                        $( "#no_of_times_attempted" ).html("");
                        $( "#no_of_marked" ).html("");
                        $( "#average_time_for_question" ).html("");
                        $( "#minimum_time_for_question" ).html("");
                        $( "#maximum_time_for_question" ).html("");
                        $( "#no_of_correct_attempts" ).html("");
                        $( "#no_of_incorrect_attempts" ).html("");
                    }',
                    'success' => 'function(data){
                        $( "#question_and_answer" ).html(data.answer_html);
                        $( "#no_of_times_appeared" ).html(data.times_appeared);
                        $( "#no_of_times_attempted" ).html(data.times_attempted);
                        $( "#no_of_marked" ).html(data.no_of_marked);
                        $( "#average_time_for_question" ).html(data.average_time_for_question);
                        $( "#minimum_time_for_question" ).html(data.minimum_time_for_question);
                        $( "#maximum_time_for_question" ).html(data.maximum_time_for_question);
                        $( "#no_of_correct_attempts" ).html(data.no_of_correct_attempts);
                        $( "#no_of_incorrect_attempts" ).html(data.no_of_incorrect_attempts);
                    }',
                    ))
            );
            ?>
        </div>
    </div>


    <!-- display answer -->
    <div class="span12" id="question_and_answer">

    </div>

    <div class="span12">
        <div class="span4">
            No of times appeared :
        </div>
        <div class="span8">
            <span id="no_of_times_appeared"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            No of times attempted : 
        </div>
        <div class="span8">
            <span id="no_of_times_attempted"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            No of times marked by student :
        </div>
        <div class="span8">
            <span id="no_of_marked"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            Average Time Taken for Question(minutes) :
        </div>
        <div class="span8">
            <span id="average_time_for_question"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            Minimum Time Taken for Question(minutes) : 
        </div>
        <div class="span8">
            <span id="minimum_time_for_question"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            Maximum Time Taken for Question(minutes) : 
        </div>
        <div class="span8">
            <span id="maximum_time_for_question"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            No of correct attempts : 
        </div>
        <div class="span8">
            <span id="no_of_correct_attempts"></span>
        </div>
    </div>

    <div class="span12">
        <div class="span4">
            No of incorrect attempts :
        </div>
        <div class="span8">
            <span id="no_of_incorrect_attempts"></span>
        </div>
    </div>
</div>