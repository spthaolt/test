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
if (!$message) {
    exit;
}
if ($send->send($user_login->guid, $to, $message, $time, $type)) {
    // $params['id'] = 

    if ($type == "group") {
        $from_guid = $user_login->guid;
        $to_guid = $to;
        $message_last_id = input('last_id');
        $message_type = $type;
        $messages = $send->getNew($from_guid, $to_guid, $message_last_id, $message_type);
        if($messages) {
                foreach($messages as $message) {
                        echo ossn_plugin_view('messages/templates/message-send', $message);
                }
        }
    } else {
        $send->id = $send->last_id;
        $send->message_from = $user_login->guid;
        $send->message_to = $to;
        $send->message = ossn_restore_new_lines($message);
        $send->time = $time;
        echo ossn_plugin_view('messages/templates/message-send', $send);
    }

}
//messages only at some points #470
// don't mess with system ajax requests
exit;