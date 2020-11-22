<h3 class="light_heading">Set Privilege Levels</h3>
<br/>
<?php
//    echo $model->lecturer_id;
?>
<table>
    <tr>
        <td width="150">
            <strong>Lecturer ID</strong>
        </td>
        <td>
            <?php
            echo $model->lecturer_id;
            ?>
        </td>
    </tr>
    <tr>
        <td width="100">
            <strong>Lecturer Name</strong>
        </td>
        <td>
            <?php
            $user_id = Lecturer::model()->getUserIdByLecturerId($model->lecturer_id);
            $user = User::model()->getUserInfoById($user_id);
            echo $user['first_name'] . " " . $user['last_name'];
            ?>
        </td>
    </tr>
</table>

<br/>

<table>
    <tr>
        <td width="200">
            Course Management
        </td>
        <td>
            <input id="cm" type="hidden" value="0"/>
            <div id ="set_div_cm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'cm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_cm").style.display  = "block";

                document.getElementById("set_div_cm").style.display  = "none";
                document.getElementById("set_cm_status").style.display  = "block";
                document.getElementById("unset_cm_status").style.display  = "none";
                document.getElementById("cm").value  = "1";
            }
                                    }'
                        ), array(
                    'id' => 'set_cm',
                    'name' => 'set_cm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_cm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'cm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_cm").style.display  = "block";
                document.getElementById("unset_div_cm").style.display  = "none";
                document.getElementById("set_cm_status").style.display  = "none";
                document.getElementById("unset_cm_status").style.display  = "block";
                                document.getElementById("cm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_cm',
                    'name' => 'unset_cm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>

            <div class="span3" id="unset_cm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_cm_status" style="display: none">
                <b>Allowed</b>
            </div>


        </td>
    </tr>
    <tr>
        <td width="200">
            Level Management
        </td>
        <td>
            <input id="lm" type="hidden" value="0"/>

            <div id ="set_div_lm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'lm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_lm").style.display  = "block";

                document.getElementById("set_div_lm").style.display  = "none";
                document.getElementById("set_lm_status").style.display  = "block";
                document.getElementById("unset_lm_status").style.display  = "none";
                                document.getElementById("lm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_lm',
                    'name' => 'set_lm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_lm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'lm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_lm").style.display  = "block";
                document.getElementById("unset_div_lm").style.display  = "none";
                document.getElementById("set_lm_status").style.display  = "none";
                document.getElementById("unset_lm_status").style.display  = "block";
                                document.getElementById("lm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_lm',
                    'name' => 'unset_lm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_lm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_lm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Subject Management
        </td>
        <td>
            <input id="sm" type="hidden" value="0"/>

            <div id ="set_div_sm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_sm").style.display  = "block";

                document.getElementById("set_div_sm").style.display  = "none";
                document.getElementById("set_sm_status").style.display  = "block";
                document.getElementById("unset_sm_status").style.display  = "none";
                                document.getElementById("sm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_sm',
                    'name' => 'set_sm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_sm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_sm").style.display  = "block";
                document.getElementById("unset_div_sm").style.display  = "none";
                document.getElementById("set_sm_status").style.display  = "none";
                document.getElementById("unset_sm_status").style.display  = "block";
                                document.getElementById("sm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_sm',
                    'name' => 'unset_sm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_sm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_sm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Subject Area Management
        </td>
        <td>
            <input id="sam" type="hidden" value="0"/>

            <div id ="set_div_sam" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sam'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_sam").style.display  = "block";

                document.getElementById("set_div_sam").style.display  = "none";
                document.getElementById("set_sam_status").style.display  = "block";
                document.getElementById("unset_sam_status").style.display  = "none";
                                                document.getElementById("sam").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_sam',
                    'name' => 'set_sam',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_sam" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sam'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_sam").style.display  = "block";
                document.getElementById("unset_div_sam").style.display  = "none";
                document.getElementById("set_sam_status").style.display  = "none";
                document.getElementById("unset_sam_status").style.display  = "block";
                                                                document.getElementById("sam").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_sam',
                    'name' => 'unset_sam',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_sam_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_sam_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Sitting Management
        </td>
        <td>
            <input id="sim" type="hidden" value="0"/>

            <div id ="set_div_sim" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sim'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_sim").style.display  = "block";

                document.getElementById("set_div_sim").style.display  = "none";
                document.getElementById("set_sim_status").style.display  = "block";
                document.getElementById("unset_sim_status").style.display  = "none";
                                                document.getElementById("sim").value  = "1";
            }
                                    }'
                        ), array(
                    'id' => 'set_sim',
                    'name' => 'set_sim',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_sim" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'sim'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_sim").style.display  = "block";
                document.getElementById("unset_div_sim").style.display  = "none";
                document.getElementById("set_sim_status").style.display  = "none";
                document.getElementById("unset_sim_status").style.display  = "block";
                                                                document.getElementById("sim").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_sim',
                    'name' => 'unset_sim',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_sim_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_sim_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            News Management
        </td>
        <td>
            <input id="nm" type="hidden" value="0"/>

            <div id ="set_div_nm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'nm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_nm").style.display  = "block";

                document.getElementById("set_div_nm").style.display  = "none";
                document.getElementById("set_nm_status").style.display  = "block";
                document.getElementById("unset_nm_status").style.display  = "none";
                                                                document.getElementById("nm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_nm',
                    'name' => 'set_nm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_nm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'nm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_nm").style.display  = "block";
                document.getElementById("unset_div_nm").style.display  = "none";
                document.getElementById("set_nm_status").style.display  = "none";
                document.getElementById("unset_nm_status").style.display  = "block";
                                                                                document.getElementById("nm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_nm',
                    'name' => 'unset_nm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_nm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_nm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Country Management
        </td>
        <td>
            <input id="com" type="hidden" value="0"/>

            <div id ="set_div_com" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'com'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_com").style.display  = "block";

                document.getElementById("set_div_com").style.display  = "none";
                document.getElementById("set_com_status").style.display  = "block";
                document.getElementById("unset_com_status").style.display  = "none";
                 document.getElementById("com").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_com',
                    'name' => 'set_com',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_com" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'com'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_com").style.display  = "block";
                document.getElementById("unset_div_com").style.display  = "none";
                document.getElementById("set_com_status").style.display  = "none";
                document.getElementById("unset_com_status").style.display  = "block";
                                 document.getElementById("com").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_com',
                    'name' => 'unset_com',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_com_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_com_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td>
            <br/>
        </td>
        <td>
            <br/>
        </td>
    </tr>
    <tr>
        <td width="200">
            Student Management
        </td>
        <td>
            <input id="stm" type="hidden" value="0"/>

            <div id ="set_div_stm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'stm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_stm").style.display  = "block";

                document.getElementById("set_div_stm").style.display  = "none";
                document.getElementById("set_stm_status").style.display  = "block";
                document.getElementById("unset_stm_status").style.display  = "none";
                                 document.getElementById("stm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_stm',
                    'name' => 'set_stm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_stm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'stm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_stm").style.display  = "block";
                document.getElementById("unset_div_stm").style.display  = "none";
                document.getElementById("set_stm_status").style.display  = "none";
                document.getElementById("unset_stm_status").style.display  = "block";
                                                 document.getElementById("stm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_stm',
                    'name' => 'unset_stm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_stm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_stm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Lecturer Management
        </td>
        <td>
            <input id="lem" type="hidden" value="0"/>

            <div id ="set_div_lem" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'lem'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_lem").style.display  = "block";

                document.getElementById("set_div_lem").style.display  = "none";
                document.getElementById("set_lem_status").style.display  = "block";
                document.getElementById("unset_lem_status").style.display  = "none";
                                                 document.getElementById("lem").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_lem',
                    'name' => 'set_lem',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_lem" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'lem'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_lem").style.display  = "block";
                document.getElementById("unset_div_lem").style.display  = "none";
                document.getElementById("set_lem_status").style.display  = "none";
                document.getElementById("unset_lem_status").style.display  = "block";
                                                                 document.getElementById("lem").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_lem',
                    'name' => 'unset_lem',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_lem_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_lem_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Temporary Users
        </td>
        <td>
            <input id="tm" type="hidden" value="0"/>

            <div id ="set_div_tm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'tm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_tm").style.display  = "block";

                document.getElementById("set_div_tm").style.display  = "none";
                document.getElementById("set_tm_status").style.display  = "block";
                document.getElementById("unset_tm_status").style.display  = "none";
                                                                 document.getElementById("tm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_tm',
                    'name' => 'set_tm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_tm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'tm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_tm").style.display  = "block";
                document.getElementById("unset_div_tm").style.display  = "none";
                document.getElementById("set_tm_status").style.display  = "none";
                document.getElementById("unset_tm_status").style.display  = "block";
                                                                                 document.getElementById("tm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_tm',
                    'name' => 'unset_tm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_tm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_tm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Exam Management
        </td>
        <td>
            <input id="em" type="hidden" value="0"/>

            <div id ="set_div_em" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'em'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_em").style.display  = "block";

                document.getElementById("set_div_em").style.display  = "none";
                document.getElementById("set_em_status").style.display  = "block";
                document.getElementById("unset_em_status").style.display  = "none";
                document.getElementById("em").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_em',
                    'name' => 'set_em',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_em" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'em'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_em").style.display  = "block";
                document.getElementById("unset_div_em").style.display  = "none";
                document.getElementById("set_em_status").style.display  = "none";
                document.getElementById("unset_em_status").style.display  = "block";
                                document.getElementById("em").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_em',
                    'name' => 'unset_em',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_em_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_em_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Question Management
        </td>
        <td>
            <input id="qm" type="hidden" value="0"/>

            <div id ="set_div_qm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'qm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_qm").style.display  = "block";

                document.getElementById("set_div_qm").style.display  = "none";
                document.getElementById("set_qm_status").style.display  = "block";
                document.getElementById("unset_qm_status").style.display  = "none";
                                document.getElementById("qm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_qm',
                    'name' => 'set_qm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_qm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'qm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_qm").style.display  = "block";
                document.getElementById("unset_div_qm").style.display  = "none";
                document.getElementById("set_qm_status").style.display  = "none";
                document.getElementById("unset_qm_status").style.display  = "block";
                                                document.getElementById("qm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_qm',
                    'name' => 'unset_qm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_qm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_qm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>
    <tr>
        <td width="200">
            Result Management
        </td>
        <td>
            <input id="rm" type="hidden" value="0"/>

            <div id ="set_div_rm" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'rm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_rm").style.display  = "block";

                document.getElementById("set_div_rm").style.display  = "none";
                document.getElementById("set_rm_status").style.display  = "block";
                document.getElementById("unset_rm_status").style.display  = "none";
                                                document.getElementById("rm").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_rm',
                    'name' => 'set_rm',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_rm" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'rm'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_rm").style.display  = "block";
                document.getElementById("unset_div_rm").style.display  = "none";
                document.getElementById("set_rm_status").style.display  = "none";
                document.getElementById("unset_rm_status").style.display  = "block";
                                                                document.getElementById("rm").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_rm',
                    'name' => 'unset_rm',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_rm_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_rm_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>

    <tr>
        <td width="200">
            Essay Answer Management
        </td>
        <td>
            <input id="eam" type="hidden" value="0"/>

            <div id ="set_div_eam" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'eam'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_eam").style.display  = "block";

                document.getElementById("set_div_eam").style.display  = "none";
                document.getElementById("set_eam_status").style.display  = "block";
                document.getElementById("unset_eam_status").style.display  = "none";
                document.getElementById("eam").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_eam',
                    'name' => 'set_eam',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_eam" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'eam'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_eam").style.display  = "block";
                document.getElementById("unset_div_eam").style.display  = "none";
                document.getElementById("set_eam_status").style.display  = "none";
                document.getElementById("unset_eam_status").style.display  = "block";
                document.getElementById("eam").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_eam',
                    'name' => 'unset_eam',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_eam_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_eam_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>

    <tr>
        <td width="200">
            Activity Logs
        </td>
        <td>
            <input id="al" type="hidden" value="0"/>

            <div id ="set_div_al" style="display: block">
                <?php
                echo CHtml::ajaxButton('Allow', CController::createUrl('Lecturer/setPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'al'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                            document.getElementById("unset_div_al").style.display  = "block";

                document.getElementById("set_div_al").style.display  = "none";
                document.getElementById("set_al_status").style.display  = "block";
                document.getElementById("unset_al_status").style.display  = "none";
                document.getElementById("al").value  = "1";

            }
                                    }'
                        ), array(
                    'id' => 'set_al',
                    'name' => 'set_al',
                    'class' => 'bluebtnsmall',
                        )
                );
                ?>
            </div>
            <div id ="unset_div_al" style="display: none">
                <?php
                echo CHtml::ajaxButton('Deny', CController::createUrl('Lecturer/unsetPrivilegeLevel'), array(
                    'type' => 'POST', //request type
                    'dataType' => 'json',
                    'data' => array(
                        'section' => 'al'
                    ),
                    'success' => 'function(data){ 
            if(data.status=="success"){
                document.getElementById("set_div_al").style.display  = "block";
                document.getElementById("unset_div_al").style.display  = "none";
                document.getElementById("set_al_status").style.display  = "none";
                document.getElementById("unset_al_status").style.display  = "block";
                document.getElementById("al").value  = "0";

            }
                                    }'
                        ), array(
                    'id' => 'unset_al',
                    'name' => 'unset_al',
                    'class' => 'greybtnsmall',
                        )
                );
                ?>
            </div>
        </td>
        <td>
            <div class="span3" id="unset_al_status" style="display: block">
                <b>Denied</b>
            </div>

            <div class="span3" id="set_al_status" style="display: none">
                <b>Allowed</b>
            </div>

        </td>
    </tr>



</table>

<br/><br/>
<?php
echo CHtml::ajaxButton('Save', CController::createUrl('Lecturer/savePrivilegeLevels'), array(
    'type' => 'POST', //request type
    'dataType' => 'json',
    'data' => array(
        'lecturer_id' => $model->lecturer_id,
        'cm' => 'js:cm.value',
        'lm' => 'js:lm.value',
        'sm' => 'js:sm.value',
        'sam' => 'js:sam.value',
        'sim' => 'js:sim.value',
        'nm' => 'js:nm.value',
        'com' => 'js:com.value',
        'stm' => 'js:stm.value',
        'lem' => 'js:lem.value',
        'tm' => 'js:tm.value',
        'em' => 'js:em.value',
        'qm' => 'js:qm.value',
        'rm' => 'js:rm.value',
        'eam' => 'js:eam.value',
        'al' => 'js:al.value',
    ),
    'success' => 'function(data){ 
            if(data.status=="success"){
               document.location.href = data.redirect_url; 
            }
                                    }'
        ), array(
    'id' => 'save',
    'name' => 'save',
    'class' => 'bluebtn',
        )
);
?>