<?php
	$user = ossn_user_by_guid($params->message_from);
?>
<!-- <div class="row msg_container base_sent">
    <div class="col-md-10 col-xs-10 sqMScontent">
        <div class="messages msg_sent">
            <?php echo $params->message ?>
            <time datetime="<?php echo $params->time ?>"><?php echo ossn_user_friendly_time($params->time) ?></time>
        </div>
    </div>
    <div class="col-md-1 col-xs-2 avatar">
        <img src="<?php echo $user->iconURL()->smaller; ?>" class=" img-responsive ">
    </div>
</div>
 -->
<div class="row">
    <div class="col-md-10">
            <div class="message-box-sent text">
                <?php
                     if (function_exists('smilify')) {
                            echo smilify(ossn_message_print($params->message));
                       } else {
                            echo ossn_message_print($params->message);
                        }
                ?>
            <div class="time-created" last_time="<?php echo $params->time; ?>"><?php echo ossn_user_friendly_time($params->time);?></div>    
            </div>
    </div>
    <div class="col-md-2">
        <img  class="user-icon" src="<?php echo $user->iconURL()->small;?>" />
    </div>                                
</div>