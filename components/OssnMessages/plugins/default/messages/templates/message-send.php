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
// $user = $params['user'];
// $data = new OssnMessages;
// $data->message_from = $user->guid;
// $data->message = $params['message'];
// $data->time = $params['last_time'];

if($params->message_from == ossn_loggedin_user()->guid){    
	
    echo ossn_plugin_view('messages/pages/view/sender', $params);
} else {
    echo ossn_plugin_view('messages/pages/view/recipient', $params);
}
?>

<script type="text/javascript">
	$('.group_message_last_id').val(<?php echo $params->id ?>);
</script>
