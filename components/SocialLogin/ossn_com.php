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
define('SOCIAL_LOGIN', ossn_route()->com . 'SocialLogin/');

require_once(SOCIAL_LOGIN . 'classes/Login.php');
/**
 * Social Login Init
 * 
 * @return void
 */
function social_login_init() {
		ossn_register_page('social_login', 'social_login_handler');
		ossn_register_com_panel('SocialLogin', 'settings');
		
		ossn_extend_view('css/ossn.default', 'css/social/login');
		ossn_extend_view('css/ossn.admin.default', 'css/social/adminform');
		ossn_extend_view('forms/login2/before/submit', 'social/login');
		
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('social_login/settings', SOCIAL_LOGIN . 'actions/settings.php');
		}
		if(!ossn_isLoggedin()) {
				ossn_register_action('social/login/facebook', SOCIAL_LOGIN . 'actions/login/facebook.php');
		}
		
		ossn_add_hook('page', 'load', 'social_login_user_details_check');
}
/**
 * Social Login user details check
 * 
 * @return void
 */
function social_login_user_details_check($hook, $type, $return, $params) {
		if(ossn_isLoggedin()) {
				$user    = ossn_loggedin_user();
				$context = ossn_get_context();
				$allowed = array(
						'css',
						'js',
						'u'
				);
				if((!isset($user->gender) || !isset($user->birthdate)) && !in_array($params['handler'], $allowed)) {
						ossn_trigger_message(ossn_print('social:login:fill:profile'), 'error');
						redirect("u/{$user->username}/edit");
				}
		}
}
/**
 * Social Login Details
 * 
 * @return object
 */
function social_login_cred() {
		$component = new OssnComponents;
		$settings  = $component->getSettings('SocialLogin');
		
		$oauth           = new stdClass;
		$oauth->facebook = new stdClass;
		
		$oauth->facebook->consumer_key    = $settings->fb_consumer_key;
		$oauth->facebook->consumer_secret = $settings->fb_consumer_secret;
		
		return $oauth;
}
/**
 * Social login pages 
 *  
 * @param array $pages A list of handlers
 * 
 * @return void
 */
function social_login_handler($pages) {
		$page = $pages[0];
		switch($page) {
				case 'facebook':
						$login       = new Login;
						$helper      = $login->initFb()->getRedirectLoginHelper();
						$accessToken = $helper->getAccessToken();
						$user        = $login->initFb()->get('/me?fields=id,first_name,last_name,email', (string) $accessToken)->getGraphUser();
						//$image       = $login->initFb()->get('/me/picture?redirect=false&type=large', (string) $accessToken)->getGraphUser();
						$ossnuser    = ossn_user_by_email($user['email']);
						if(!$ossnuser) {
								$username = preg_replace('/\s+/', '', $user['first_name']);
								if(strlen($username) <= 4){
										$username = $username . substr(uniqid(), 5);
								}
								$i        = 1;
								while(ossn_user_by_username($username)) {
										$username = $username . '' . $i;
										$i++;
								}
								$password = substr(md5(time()), 0, 7);
								
								$add             = new OssnUser;
								$add->username   = $username;
								$add->first_name = $user['first_name'];
								$add->last_name  = $user['last_name'];
								$add->email      = $user['email'];
								$add->password   = $password;
								$add->validated  = true;
								if($add->addUser()) {
										if($add->Login()) {
												redirect("home");
										}
								} else {
										ossn_trigger_message(ossn_print('social:login:account:create:error'), 'error');
										redirect(REF);
								}
						} else {
								OssnSession::assign('OSSN_USER', $ossnuser);
								redirect("home");
						}
						break;
		}
}
ossn_register_callback('ossn', 'init', 'social_login_init');