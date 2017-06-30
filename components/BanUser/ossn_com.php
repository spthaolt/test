<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */

define('BANUSER', ossn_route()->com . 'BanUser/');
/**
 * Ban user initilize
 *
 * @return void
 */
function ban_user_init() {
       ossn_register_callback('page', 'load:profile', 'ossn_user_ban_menu', 101);
	   ossn_extend_view('css/ossn.default', 'css/banuser');
	   
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('user/ban', BANUSER. 'actions/ban.php');
				ossn_register_action('user/unban', BANUSER. 'actions/unban.php');
		}
		ossn_add_hook('profile', 'load:content', 'ossn_ban_user_profile_notice');
	 	ossn_add_hook('profile', 'load:picture', 'ossn_block_profile_picture');
		
		ossn_register_callback('user', 'before:login', 'ossn_ban_login_ban');
		
}

/**
 * User profile ban menu
 *
 * @return void
 */
function ossn_user_ban_menu($hook, $type, $params){
	$guid = ossn_get_page_owner_guid();
	if(!empty($guid) && ossn_loggedin_user()->guid !== $guid){
			$user = ossn_user_by_guid($guid);
			if($user && ($user->is_banned == false || !isset($user->is_banned))){
				ossn_register_menu_item('profile_extramenu', array(
						'name' => 'banuser',
						'href' => ossn_site_url("action/user/ban?guid={$guid}", true),
						'text' => ossn_print('banuser'),
				));
			} elseif($user->is_banned == true){
				ossn_register_menu_item('profile_extramenu', array(
						'name' => 'banuser',
						'href' => ossn_site_url("action/user/unban?guid={$guid}", true),
						'text' => ossn_print('banuser:unban'),
				));				
			}
	}
}

/**
 * User ban profile notice
 * 
 * If admin is loggedin he will get ban message and users profile also
 * If user isn't admin then he'll only see ban message.
 *
 * @return mixed
 */
function ossn_ban_user_profile_notice($hook, $type, $contents, $params){
	$message = ossn_plugin_view('banuser/notice');
	if(ossn_isAdminLoggedin() && $params['user']->is_banned == true){
		return $message  . $contents;
	} elseif($params['user']->is_banned == true){
		return $message;
	}
	return $contents;
}

/**
 * Ban user from login
 *
 * @return void
 */
function ossn_ban_login_ban($callback, $type, $params){
	if($params['user']->is_banned == true){
		ossn_trigger_message(ossn_print('banuser:banned:login'), 'error');
		redirect(REF);
	}
}

/**
 * Change user profile picture to banned icon
 *
 * @return string
 */
function ossn_block_profile_picture($hook, $type, $return, $params){
	$size = $params['size'];
	if($params['user']->is_banned == true){
		return BANUSER . "images/users/{$size}.jpg";
	}
	return $return;
}

/**
 * Ban user validate
 * Check if user is loggedin and banned then log him out.
 *
 * @return void
 */
function ban_user_validate(){
	if(ossn_isLoggedin()){
		$user = ossn_loggedin_user();
		$user = ossn_user_by_guid($user->guid);
		
		if($user->is_banned == true){
			ossn_logout();
			redirect();	
		}
	}
}
ossn_register_callback('ossn', 'init', 'ban_user_validate');
ossn_register_callback('ossn', 'init', 'ban_user_init');
