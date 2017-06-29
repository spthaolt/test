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
						$group_guid = $pages[1];
						if (!empty($group_guid)) {
								$groups = ossn_get_user_groups($user_login);
								$group = ossn_get_group_by_guid($group_guid);
								if (!$group->isMember($group_guid, ossn_loggedin_user()->guid)) ossn_error_page();
								$title = ossn_print('ossn:message:between', array(
										$group->title
								));
								$OssnMessages->markViewedGroup($group_guid);
								$params['friends'] = $group->getMembers();
								$params['groups'] = $groups;
								$params['to'] = $group_guid;
								$params['data']   = $OssnMessages->getMessagesGroup($group_guid);
								$params['data'] =  (array) $params['data'];
								krsort($params['data']);
								$params['last_message'] = $OssnMessages->getLastTime($group_guid);
								$params['message_content'] = ossn_plugin_view('messages/pages/view/message_content', $params);
								$contents = array(
										'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params)
								);
								$content          = ossn_set_page_layout('message', $contents);
								echo ossn_view_page($title, $content, "message");

						} else {
								ossn_error_page();
						}
						break;
				case 'message':
						$username = $pages[1];
						if(!empty($username)) {
								$user = ossn_user_by_username($username);
								if(empty($user->guid)) {
										ossn_error_page();
								}
								$title = ossn_print('ossn:message:between', array(
										$user->fullname
								));
								$OssnMessages->markViewed($user->guid, $user_login->guid);
								$params['data']   = $OssnMessages->get($user_login->guid, $user->guid);
								$params['user']   = $user;
								$params['recent'] = $OssnMessages->recentChat(ossn_loggedin_user()->guid);
								$contents         = array(
										'content' => ossn_plugin_view('messages/pages/view', $params)
								);
								$content          = ossn_set_page_layout('media', $contents);
								echo ossn_view_page($title, $content, "message");
								
						} else {
								ossn_error_page();
						}
						break;
				case 'all':
						$friends = $user_login->getFriends();
						$groups = ossn_get_user_groups($user_login);
						$params['friends'] = $friends;
						$params['groups'] = $groups;
						$params['to'] = $friends[0]->username;
						$params['data'] = $OssnMessages->get($user_login->guid, $friends[0]->guid);
						$params['message_content'] = ossn_plugin_view('messages/pages/view/message_content', $params);
						$title = ossn_print('sq:message:title');
						$contents         = array(
								'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params),
						);
						$content          = ossn_set_page_layout('message', $contents);
						echo ossn_view_page($title, $content, "message");
						break;
				case 'individual':
						$friends = $user_login->getFriends();
						$groups = ossn_get_user_groups($user_login);
						$params['friends'] = $friends;
						$params['groups'] = $groups;
						if ($user_login->isFriend($user_login->guid, ossn_user_by_username($pages[1])->guid)) {
							$params['to'] = $pages[1];
						} else {
							ossn_error_page();
						}
						$user = ossn_user_by_username($pages[1]);
						$params['data'] = $OssnMessages->get($user_login->guid, $user->guid);
						$params['data'] =  (array) $params['data'];
						krsort($params['data']);
						$params['message_content'] = ossn_plugin_view('messages/pages/view/message_content', $params);
						$title = ossn_print('sq:message:title');
						$contents         = array(
								'content' => ossn_plugin_view('messages/pages/view/layout/messages', $params),
						);
						$content          = ossn_set_page_layout('message', $contents);
						echo ossn_view_page($title, $content, "message");
						break;
				case 'friends':
						$params['recent'] = $OssnMessages->recentChat(ossn_loggedin_user()->guid);
						$active           = $params['recent'][0];
						if(isset($active->message_to) && $active->message_to == ossn_loggedin_user()->guid) {
								$getuser = $active->message_from;
						}
						if(isset($active->message_from) && $active->message_from == ossn_loggedin_user()->guid) {
								$getuser = $active->message_to;
						}
						if(isset($getuser)) {
								$user = ossn_user_by_guid($getuser);
								$OssnMessages->markViewed($getuser, ossn_loggedin_user()->guid);
								$params['data'] = $OssnMessages->get(ossn_loggedin_user()->guid, $getuser);
								
								$params['user'] = $user;
						}
						$contents = array(
								'content' => ossn_plugin_view('messages/pages/messages', $params)
						);
						if(!isset($getuser)) {
								$contents = array(
										'content' => ossn_plugin_view('messages/pages/messages-none')
								);
						}
						$title   = ossn_print('messages');
						$content = ossn_set_page_layout('media', $contents);
						echo ossn_view_page($title, $content, "message");
						break;
				case 'getnew':
						$username = $pages[1];
						$guid     = ossn_user_by_username($username)->guid;
						$messages = $OssnMessages->getNew($guid, $user_login->guid);
						if($messages) {
								foreach($messages as $message) {
										$user              = ossn_user_by_guid($message->message_from);
										$params['user']    = $user;
										$params['message'] = $message->message;
										$params['last_time'] = $message->time;
										echo ossn_plugin_view('messages/templates/message-send', $params);
								}
								$OssnMessages->markViewed($guid, ossn_loggedin_user()->guid);
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
						$to = $pages[1];
						$time = $pages[2];
						$type = $pages[3];
						// $guid     = ossn_get_group_by_guid($username)->guid;
						if ($type == "group") {
							$params['page']	   = "group";
						}
						$messages = $OssnMessages->getOld($user_login->guid, $to, $time, $type);
						$messages =  (array) $messages;
						krsort($messages);
						if($messages) {
								foreach($messages as $message) {
										$user              = ossn_user_by_guid($message->message_from);
										$params['user']    = $user;
										$params['message'] = $message->message;
										$params['last_time'] = $message->time;
										echo ossn_plugin_view('messages/templates/message-send', $params);
								}
								$OssnMessages->markViewedGroup($guid);
								echo '<script>Ossn.playSound();</script>';
						}
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
