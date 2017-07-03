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
define('__OSSN_MESSAGES__', ossn_route()->com . 'OssnMessages/');
require_once(__OSSN_MESSAGES__ . 'classes/OssnMessages.php');

/**
 * Ossn messages
 * Get object into function
 *
 * @return object
 */
function OssnMessages() {
		$OssnMessages = new OssnMessages;
		return $OssnMessages;
}
/**
 * Initilize the the component
 *
 * @return void
 */
function ossn_messages() {

		ossn_extend_view('css/ossn.default', 'css/message');
		ossn_register_page('messages', 'ossn_messages_page');
		ossn_extend_view('js/opensource.socialnetwork', 'js/OssnMessages');
		ossn_uregister_plugin_view('theme/page/elements/footer');
		if(ossn_isLoggedin()) {
			// ossn_remove_extend_view('ossn/page/footer');
				ossn_register_action('message/send', __OSSN_MESSAGES__ . 'actions/message/send.php');
				
				$user_loggedin = ossn_loggedin_user();
				$icon          = ossn_site_url('components/OssnMessages/images/messages.png');
				ossn_register_sections_menu('newsfeed', array(
						'name' => 'messages',
						'text' => ossn_print('user:messages'),
						'url' => ossn_site_url('messages/all'),
						'parent' => 'links',
						'icon' => $icon
				));
				
		}
		//callbacks
		ossn_register_callback('user', 'delete', 'ossn_user_messages_delete');
}
/**
 * Ossn messages page handler
 *
 * @param array $pages Pages
 *
 * @return mixed data
 */
function ossn_messages_page($pages) {
	if(!ossn_isLoggedin()) {
		ossn_error_page();
	}
	$OssnMessages = new OssnMessages;
	$page         = $pages[0];
	if(empty($page)) {
		$page = 'messages';
	}
	$user_login = ossn_loggedin_user();
	$params['page'] = $page;
	
	switch($page) {
		case 'group':
			ossn_remove_view_extend('ossn/page/footer', 'chat/chatbar');
			ossn_unload_js('ossn.chat');
			$params['to_guid'] = $pages[1];
			if (!empty($params['to_guid'])) {
				if (!ossn_get_group_by_guid($params['to_guid'])->isMember($params['to_guid'], $user_login->guid)) ossn_error_page();
				$groups = ossn_get_user_groups($user_login);
				$params['groups_list'] = "";
				$title = ossn_print('sq:message:all:friends');
				$icon = "https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png";
				$params['groups_list'] .= <<<TEXT
<a href="/messages/all" class="list-group-item" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$title</p>
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
    			if ($groups) {
    				foreach ($groups as $key => $group) {
    					if ($group->guid == $params['to_guid']) {
    						$group->is_active = "active";
    					}
    					$params['groups_list'] .= ossn_plugin_view('messages/templates/group-item', $group);
    				}
    			}
    			$friends = ossn_get_group_by_guid($params['to_guid'])->getMembers();
    			$params['friends_list'] = "";
    			if ($friends) {
    				foreach ($friends as $key => $friend) {
    					if ($friend->guid != $user_login->guid) {
    						if (OssnChat::getChatUserStatus($friend->guid) == 'online') {
    						    $friend->status = 'ossn-message-icon-online';
    						    $friend->status_title = "online";
    						} else {
    						    $friend->status = 'ossn-message-icon-offline';
    						    $friend->status_title = "offline";
    						}
    						$params['friends_list'] .= ossn_plugin_view('messages/templates/friend-item', $friend);
    					}
    				}
    			}

    			$params['messages_content'] = "";
    			$messages = $OssnMessages->getMessagesGroup($params['to_guid']);
    			if ($messages) {
    				$messages =  (array) $messages;
    				krsort($messages);
    				foreach ($messages as $message) {
    					$params['messages_content'] .= ossn_plugin_view('messages/templates/message-send', $message);
    				}
    			}
    			$params['script'] = ossn_plugin_view('messages/templates/script', $params);
    			$params['messages_body'] = ossn_plugin_view('messages/templates/messages-content', $params);
    			$contents         = array(
    					'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params),
    			);
    			$content          = ossn_set_page_layout('message', $contents);
    			echo ossn_view_page(ossn_print('sq:message:title'), $content, "message");
    		} else {
    			ossn_error_page();
    		}
    		break;
    	case 'all':
    		ossn_remove_view_extend('ossn/page/footer', 'chat/chatbar');
    		ossn_unload_js('ossn.chat');
    		$groups = ossn_get_user_groups($user_login);
    		$params['groups_list'] = "";
    		$title = ossn_print('sq:message:all:friends');
    		$icon = "https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png";
    		$params['groups_list'] .= <<<TEXT
<a href="/messages/all" class="list-group-item active" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$title</p>
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
    			if ($groups) {
    				foreach ($groups as $key => $group) {
    					$params['groups_list'] .= ossn_plugin_view('messages/templates/group-item', $group);
    				}
    			}
    			$friends = $user_login->getFriends();
    			$params['to_guid'] = $friends[0]->guid;

    			$params['friends_list'] = "";
    			if ($friends) {
    				foreach ($friends as $key => $friend) {
    					if (OssnChat::getChatUserStatus($friend->guid) == 'online') {
    					    $friend->status = 'ossn-message-icon-online';
    					    $friend->status_title = "online";
    					} else {
    					    $friend->status = 'ossn-message-icon-offline';
    					    $friend->status_title = "offline";
    					}

    					if ($friend->guid == $params['to_guid']) {
    						$friend->is_active = "active";
    					}
    					$params['friends_list'] .= ossn_plugin_view('messages/templates/friend-item', $friend);
    				}
    			}

    			$params['messages_content'] = "";
    			$messages = $OssnMessages->get($user_login->guid, $params['to_guid']);
    			if ($messages) {
    				$messages =  (array) $messages;
    				krsort($messages);
    				foreach ($messages as $message) {
    					$params['messages_content'] .= ossn_plugin_view('messages/templates/message-send', $message);
    				}
    			}
    			$params['script'] = ossn_plugin_view('messages/templates/script', $params);
    			$params['messages_body'] = ossn_plugin_view('messages/templates/messages-content', $params);
    			$contents = array(
					'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params),
    			);
    			$content = ossn_set_page_layout('message', $contents);
    			echo ossn_view_page(ossn_print('sq:message:title'), $content, "message");
    			break;
    	case 'individual':
			ossn_remove_view_extend('ossn/page/footer', 'chat/chatbar');
			ossn_unload_js('ossn.chat');
			$groups = ossn_get_user_groups($user_login);
			$params['groups_list'] = "";
			$title = ossn_print('sq:message:all:friends');
			$icon = "https://cdn2.iconfinder.com/data/icons/people-groups/512/Group_Woman_2-512.png";
			$params['groups_list'] .= <<<TEXT
<a href="/messages/all" class="list-group-item active" style="border-right: 0px">
	<div class="col-sm-3">
		<img width="48px" height="48px" src="$icon" />		
	</div>
	<div class="col-sm-9" style="padding: 0px">
		<p style="margin:0px">$title</p>
	</div>
	<div class="clearfix"></div>
</a>
TEXT;
			if ($groups) {
				foreach ($groups as $key => $group) {
					$params['groups_list'] .= ossn_plugin_view('messages/templates/group-item', $group);
				}
			}
			$friends = $user_login->getFriends();
			$params['to_guid'] = ossn_user_by_username($pages[1])->guid;
			$params['friends_list'] = "";
			if ($friends) {
				foreach ($friends as $key => $friend) {
					if (OssnChat::getChatUserStatus($friend->guid) == 'online') {
					    $friend->status = 'ossn-message-icon-online';
					    $friend->status_title = "online";
					} else {
					    $friend->status = 'ossn-message-icon-offline';
					    $friend->status_title = "offline";
					}

					if ($friend->guid == $params['to_guid']) {
						$friend->is_active = "active";
					}
					$params['friends_list'] .= ossn_plugin_view('messages/templates/friend-item', $friend);
				}
			}

			$params['messages_content'] = "";
			$messages = $OssnMessages->get($user_login->guid, $params['to_guid']);
			if ($messages) {
				$messages =  (array) $messages;
				krsort($messages);
				foreach ($messages as $message) {
					$params['messages_content'] .= ossn_plugin_view('messages/templates/message-send', $message);
				}
			}
			$params['script'] = ossn_plugin_view('messages/templates/script', $params);
			$params['messages_body'] = ossn_plugin_view('messages/templates/messages-content', $params);
			$contents = array(
				'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params),
			);
			$content = ossn_set_page_layout('message', $contents);
			echo ossn_view_page(ossn_print('sq:message:title'), $content, "message");
			break;
		case 'getnew':
			$from_guid = $user_login->guid;
			$to_guid = $pages[1];
			$message_last_id = $pages[2];
			$message_type = $pages[3];
			$messages = $OssnMessages->getNew($from_guid, $to_guid, $message_last_id, $message_type);
			if($messages) {
				foreach($messages as $message) {
					echo ossn_plugin_view('messages/templates/message-send', $message);
				}
				$OssnMessages->markViewed($to_guid, $from_guid);
				echo '<script>Ossn.playSound();</script>';
			}
			break;
		case 'getnewgroup':
			$group_guid = $pages[1];
			$last_time = $pages[2];
			// $guid     = ossn_get_group_by_guid($username)->guid;
			$messages = $OssnMessages->getNewGroup($group_guid, $last_time);
			if($messages) {
				foreach($messages as $message) {
					$user              = ossn_user_by_guid($message->message_from);
					$params['page']	   = "group";
					$params['user']    = $user;
					$params['message'] = $message->message;
					$params['last_time'] = $message->time;
					echo ossn_plugin_view('messages/templates/message-send', $params);
				}
				$OssnMessages->markViewedGroup($guid);
				echo '<script>Ossn.playSound();</script>';
			}
			break;
		case 'getrecent':
			$params['recent'] = $OssnMessages->recentChat(ossn_loggedin_user()->guid);
			echo ossn_plugin_view('messages/templates/message-with', $params);
			break;
		case 'getold':
			$from_guid = $user_login->guid;
			$to_guid = $pages[1];
			$message_first_id = $pages[2];
			$message_type = $pages[3];
			$messages = $OssnMessages->getOld($from_guid, $to_guid, $message_first_id, $message_type);
			if($messages) {
				$messages =  (array) $messages;
				krsort($messages);
				foreach($messages as $message) {
					echo ossn_plugin_view('messages/templates/message-send', $message);
				}
			}
			break;
		case 'getstatusfriends':
			if ($pages[2] == "group") {
				$params['to_guid'] = $pages[1];
				$friends = ossn_get_group_by_guid($params['to_guid'])->getMembers();
			} else {
				$friends = $user_login->getFriends();
			}
			$params['friends_list'] = "";
			if ($friends) {
				foreach ($friends as $key => $friend) {
					if ($friend->guid != $user_login->guid) {
						if (OssnChat::getChatUserStatus($friend->guid) == 'online') {
						    $friend->status = 'ossn-message-icon-online';
						    $friend->status_title = "online";
						} else {
						    $friend->status = 'ossn-message-icon-offline';
						    $friend->status_title = "offline";
						}
						$params['friends_list'] .= ossn_plugin_view('messages/templates/friend-item', $friend);
					}
				}
			}
			echo $params['friends_list'];
			break;
		default:
			ossn_error_page();
			break;
	}
}
/**
 * Print user messages
 * This will translate unix new lines to html line break
 *
 * @param string $message Message
 *
 * @return string
 */
function ossn_message_print($message) {
		return nl2br($message);
}
/**
 * Delete user messages
 *
 * @param string $callback Name of callback
 * @param string $type Callback type
 * @param array $params Arrays or Objects
 *
 * @return void
 * @access private
 */
function ossn_user_messages_delete($callback, $type, $params) {
		$messages = new OssnMessages;
		if(isset($params['entity']->guid)) {
				$messages->deleteUser($params['entity']->guid);
		}
}

function check_group_exist_userlogin($group_guid)
{
	$user = ossn_loggedin_user();
	$groups = ossn_get_user_groups($user);
	$group = ossn_get_group_by_guid($group_guid);

	return in_array($group, $groups);
}
ossn_register_callback('ossn', 'init', 'ossn_messages');
