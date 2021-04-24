<?php
$userDetails = User::model()->getUserDetailsByUserId($id);
$lecDetails = Lecturer::model()->getLecturerDetailsByUserId($id);
?>

<div class="span3">

</div>

<div class="span8">
    <h3 class="master_heading">Account Settings</h3>
    <div class="well well-no-background">
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Lecturer Code</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $lecDetails['lecturer_code']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">First Name</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $userDetails['first_name']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Last Name</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $userDetails['last_name']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $userDetails['email']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Phone Number</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $userDetails['phone_number']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Phone Number 2</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $lecDetails['extra_number']; ?>" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Address</label>
                <div class="controls">
                    <input class="span5" type="text" id="inputEmail" value="<?php echo $userDetails['address']; ?>" readonly/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="inputEmail"></label>
                <div class="controls"><p>Please contact <?php echo CHtml::link('here', array('site/contact')) ?> to change your details.</p></div>
            </div>

        </form>
    </div>
</div>

