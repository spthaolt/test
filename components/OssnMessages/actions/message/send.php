<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$send = new OssnMessages;
$message = input('message');
$type = input('type');
if (!$type) $type = "individual";
$to = input('to');
$user_login = ossn_loggedin_user();
$time = time();
if ($send->send($user_login->guid, $to, $message, $time, $type)) {
	$message = ossn_restore_new_lines($message);
    $params['message'] = $message;
    $params['message_from'] = $user_login->guid;
    $params['last_time'] = $time;
	$params['user'] = $user_login;	
    if ($type == "group") {
    	$params['page'] = "group";
    	$params['group'] = ossn_get_group_by_guid($to);
    }
    
    echo ossn_plugin_view('messages/templates/message-send', $params);

} else {
    echo 0;
}
//messages only at some points #470
// don't mess with system ajax requests
exit;