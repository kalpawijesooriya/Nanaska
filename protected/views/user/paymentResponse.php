<div class="row-fluid">
    <div class="container">
        <div class="span8">
        <h3 class="master_heading">Payment Status</h3>
        <?php echo '<div class="well">'. $status . '!</div>'; ?><br/>
        <?php echo ($refNo != '') ? "<div>Your Transaction refNo : $refNo<br/></div>" : '';  ?>
        </div>
        <br /><br /><br />
    </div>
</div>