<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$groups_list = "";
if ($params['page'] == "group") {
	$group = ossn_get_group_by_guid($params['to']);
	$params['group'] = $group;
	foreach ($params['last_message'] as $key => $value) {
		$last_time = $value->time;
	}
} else {
	$user = ossn_user_by_username($params['to']);
	$params['user'] = $user;
}

if ($params['page'] == "all") {
	$is_active = "active";
} else if ($params['page'] == "individual") {
	$is_active = "active";
}
	$title = ossn_print('sq:message:all:friends');
	$icon = $icon = "https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png";
	$groups_list .= <<<TEXT
<a href="/messages/all" class="list-group-item $is_active" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$title</p>
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
foreach ($params['groups'] as $key => $group) {
	$is_active = "";
	if ($params['page'] == "group") {
		if ($group->guid == $params['to']) {
			$is_active = "active";
		}
	}
	
	$group_guid = $group->guid;
	$icon = "https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png";
	$title = $group->title;
	$groups_list .= <<<TEXT
<a href="/messages/group/$group_guid" class="list-group-item $is_active" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$title</p>
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
}

$friends_list = "";

foreach ($params['friends'] as $key => $friend) {
	if ($friend->guid != ossn_loggedin_user()->guid) {
		$is_active = "";
		if ($friend->username == $params['to']) {
			$is_active = "active";	
		}

		$icon = $friend->iconURL()->smaller;
		$fullname = $friend->fullname;
		$username = $friend->username;
if (OssnChat::getChatUserStatus($friend->guid) == 'online') {
    $status = 'ossn-message-icon-online';
    $status_title = "online";
} else {
    $status = 'ossn-message-icon-offline';
    $status_title = "offline";
}
		$friends_list .= <<<TEXT
<a href="/messages/individual/$username" class="list-group-item $is_active" style="border-left: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$fullname</p>
		<div class="sqmessage $status" ></div>$status_title
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
	} 
}
?>
<div class="thumbnail sqmessage">
	<div class="caption">
        <h3><?php echo ossn_print('sq:message:title'); ?></h3>
    </div>
	<div class="col-sm-3 sqmessage">
		<div class="list-group sqmessage">
			<?php echo $groups_list ?>
		</div>
	</div>
	<div class="col-sm-6 sqmessage">
		<div class="message-inner sqmessage" >
			<div class="message-with">
			<?php if ($params['page'] == "group") { ?>
				<div class="message-inner" id="message-append-<?php echo $params['group']->guid ?>">
			<?php } else {	?>
				<div class="message-inner" id="message-append-<?php echo $params['user']->guid ?>">
			<?php } ?>
					<?php echo ossn_plugin_view('messages/pages/view/message_content', $params); ?>
				</div>
			</div>
		</div>
			<?php if ($params['page'] == "group") { 
				echo ossn_view_form('send', array(
						'component' => 'OssnMessages',
						'class' => 'message-form-form sqmessage',
						'id' => "message-send-{$params['group']->guid}",
						'params' => $params
				), false);
			} else { 
				echo ossn_view_form('send', array(
						'component' => 'OssnMessages',
						'class' => 'message-form-form sqmessage',
						'id' => "message-send-{$params['user']->guid}",
						'params' => $params
				), false);
			}  ?>
	</div>
	<div class="col-sm-3 sqmessage">
		<div class="list-group sqmessage">
			<?php echo $friends_list ?>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<audio id="ossn-chat-sound" src="<?php echo ossn_site_url("components/OssnMessages/sound/pling.mp3"); ?>" preload="auto"></audio>
<?php if ($params['page'] == "group") { ?>
<script>
    Ossn.SendMessage(<?php echo $params['group']->guid; ?>);
    $(document).ready(function () {

    	var check_time = $("#message-append-<?php echo $params['group']->guid ?> div.row:last").find('.time-created').attr('last_time');
        setInterval(function () {
        	var last_time = $("#message-append-<?php echo $params['group']->guid ?> div.row:last").find('.time-created').attr('last_time');
        	if (check_time != last_time) {
        		Ossn.message_scrollMove(<?php echo $params['group']->guid; ?>);
        		check_time = last_time;
        	}
            Ossn.getMessagesGroup('<?php echo $params['group']->guid; ?>',last_time);
            //Ossn.getRecent('<?php echo $params['user']->guid;?>');
       		
        }, 5000);
        Ossn.message_scrollMove(<?php echo $params['group']->guid; ?>);
  	});
</script>
<?php } else { ?>
<script>
    Ossn.SendMessage(<?php echo $params['user']->guid;?>);
            $(document).ready(function () {
                setInterval(function () {

                    Ossn.getMessages('<?php echo $params['user']->username;?>', '<?php echo $params['user']->guid;?>');
                    //Ossn.getRecent('<?php echo $params['user']->guid;?>');
                }, 5000);
               	Ossn.message_scrollMove(<?php echo $params['user']->guid;?>);
      });
</script>
<?php } ?>
<script type="text/javascript">
	
	$(document).on('keypress', '.input_message', function(e) {
		if (e.keyCode == 13 && e.altKey) {
			$('.ossn-form.message-form-form.sqmessage .btn.btn-primary').click();
	    }
	});
	var check_first_time = 0;
	$('.message-inner.sqmessage').scroll(function() {

		if ($(this).scrollTop() == 0) {

			var first_time = $("#message-append-<?php echo $params['user']->guid ?> div.row:first").find('.time-created').attr('last_time');
			if (check_first_time != first_time) {
				<?php if ($params['page'] == "group") { ?>
					var to_guid = <?php echo $params['group']->guid; ?>;
					Ossn.getOldMessages(to_guid, first_time, "group");
				<?php } else { ?> 
					var to_guid = <?php echo $params['user']->guid; ?>;
					Ossn.getOldMessages(to_guid, first_time, "individual");
				<?php } ?>

				check_first_time = first_time;
			}
		}
	});
</script>