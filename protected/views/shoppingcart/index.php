
<div style="padding: 10%">
    
    
    <?php
    $shopping_cart_exams = Yii::app()->session['shopping_cart']['exams'];
    
    foreach ($shopping_cart_exams as $shopping_cart_exam){
        $this->renderPartial('_single_exam', array('shopping_cart_exam'=>$shopping_cart_exam));
    }
    
    ?>
</div>