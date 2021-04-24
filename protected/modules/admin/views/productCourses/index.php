<?php
$this->breadcrumbs = array(
    'Product Courses',
);

$this->menu = array(
    array('label' => 'Create ProductCourses', 'url' => array('create')),
    array('label' => 'Manage ProductCourses', 'url' => array('admin')),
);
?>

<h1>Product Courses</h1>

<div class="well_dashboard">
    <div class="row">
        <div class="span9">


            <?php
            foreach ($dataProvider as $data) {

                echo '<div class="span4">
                            <div class="sub_well-settings">
                        
                        <div class="dashbord-sub-menu">';
                
                echo CHtml::link(CHtml::encode($data['product_course_name']), array('', 'id' => $data['id']));

                echo '</div> 
                        
                    </div>
            </div>';
            }
            ?>


        </div>
    </div>
</div>

