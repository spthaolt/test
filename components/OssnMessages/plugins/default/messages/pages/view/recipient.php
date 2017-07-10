<?php
	$user = ossn_user_by_guid($params->message_from);
?>
<div class="row">
    <input type="hidden" class="sqmessage message_from" value="<?php echo $params->message_from ?>" >
    <input type="hidden" class="sqmessage message_to" value="<?php echo $params->message_to ?>" >
    <input type="hidden" class="sqmessage message_id" value="<?php echo $params->id ?>" >
    <div class="col-md-2" style="text-align: right">
        <img  class="user-icon" src="<?php echo $user->iconURL()->small;?>" />
    </div>                                
    <div class="col-md-10">
            <div class="message-box-recieved text">
                <?php
                     if (function_exists('smilify')) {
                            echo smilify(ossn_message_print($params->message));
                       } else {
                            echo ossn_message_print($params->message);
                        }
                ?>
            <div class="time-created" data_id="<?php echo $params->id; ?>" last_time="<?php echo $params->time; ?>"><?php echo ossn_user_friendly_time($params->time);?></div>                                                
            </div>
    </div>
</div> 