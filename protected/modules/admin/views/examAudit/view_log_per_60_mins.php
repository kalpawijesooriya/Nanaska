<h2 class="light_heading">Exam Taken Log</h2>

<?php $this->widget('bootstrap.widgets.TbGridView',array( 
    'id'=>'exam-taken-log-grid', 
    'dataProvider'=>$model->search(), 
    'filter'=>$model, 
    'columns'=>array( 
        'id',
        array('name' => 'exam_name', 'value' => '$data->exam->exam_name'),
        array('name' => 'user_name', 'value' => '($data->user) ? $data->user->email : "N/A"'),
        array('name' => 'exam_type', 'value' => '$data->exam->exam_type'),
        'timestamp'
    ),
    'pager' => array(
//        'cssFile'=>Yii::app()->theme->baseUrl."/css/pagination.css",
        'header' => '',
        'prevPageLabel' => 'Previous',
        'nextPageLabel' => 'Next',
        'firstPageLabel'=>'First',
        'lastPageLabel'=>'Last',
        //'footer'=>'End',//defalut empty
       // 'maxButtonCount'=>4 // defalut 10                   
        ),
));