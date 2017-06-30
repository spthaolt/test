<?php
	$user = ossn_user_by_guid($params->message_from);
?>
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
            <div class="time-created" data_id="<?php echo $params->id ?>" last_time="<?php echo $params->time; ?>"><?php echo ossn_user_friendly_time($params->time);?></div>    
            </div>
    </div>
    <div class="col-md-2">
        <img  class="user-icon" src="<?php echo $user->iconURL()->small;?>" />
    </div>                                
</div>