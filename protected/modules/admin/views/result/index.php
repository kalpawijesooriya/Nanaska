<?php
if(Yii::app()->user->loadUser()->user_type == "SUPERADMIN" || Yii::app()->user->isUserAllowed("result_management") == 1)
{
    
$this->breadcrumbs = array(
    'Results',
);

$this->menu = array(
//    array('label' => 'Create Course', 'url' => array('create')),
//    array('label' => 'Manage Course', 'url' => array('admin')),
);
?>

<h2 class="light_heading">Results</h2>

<br/>

<div class="well_dashboard">
    <div class="row">
        <div class="span9">
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/viewResultPerStudent">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> View Results Per Student </div>  </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/viewResultPerExam">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> View Results Per Exam </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/viewResultPerSubject">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> View Results Per Subject </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/viewResultPerSubjectArea">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> View Results Per Subject Area </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/viewResultPerBatch">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> View Results Per Batch </div> </div>
                </a> </div>
            <div class="span4"> <a class="user_text" href="index.php?r=admin/result/ExportToExcel">
                    <div class="sub_well-settings">
                        <div class="dashbord-sub-menu"> Export Results to Excel </div> </div>
                </a> </div>
        </div>
    </div>       

</div>

<?php
}

else
{
    $this->redirect(array('/admin/custom/customError', Consts::STR_MESSAGE => 'You\'re not authorized to perform this action!'));
}
//$this->widget('bootstrap.widgets.TbListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//));
?>
