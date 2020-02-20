<div class="control-group"> 
    <?php
    echo 'Essay Type <span class="asterix">*</span>';
    echo '<br>';
    echo CHtml::dropDownList('essay_type', '', array(
        '' => 'Select Essay question Type',
        'NORMAL_TYPE' => 'Normal Essay Question',
        'EMAIL_TYPE' => 'Email Essay Question'
            ), array(
        'options' => array('' => array('selected' => true), '' => array('disabled' => true)),
        'class' => 'form-control',
        'ajax' => array(
            'type' => 'POST', //request type
            'data' => array('essay_type' => 'js:this.value'),
            'url' => CController::createUrl('Question/getEssayType'),
            'update' => '#essay-type-row',
        )
    ));
    ?>   </div>

<br />
