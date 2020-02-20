<?php //echo $news_id;  
   $msg = News::model()->getAllTheBroadcastNews($news_id);
  // var_dump($msg);
?>

<div class="container">
    <div class="span4"></div>
    <div class="span5">
        <div class="master_heading">Broadcast News</div>
        
        <br />
        
        <div class="well">
            
<!--            <div class="span3"><h5 class="master_heading">Subject</h5></div><div class="span9"><?php //echo $msg[0]['subject'];?></div>
            -->
            <br />
            <?php echo $msg[0]['message'];?>
        </div>
    </div>
    
</div>