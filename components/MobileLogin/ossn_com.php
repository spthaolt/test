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
define('__MOBILELOGIN__', ossn_route()->com . 'MobileLogin/');
/**
 * Mobile Login Initialize
 *
 * @param null
 * @return void
 */
function mobile_login_init() {
		ossn_add_hook('user', 'default:fields', 'ossn_mobile_login_field');
		
		ossn_unregister_action('user/login');
		ossn_register_action('user/login', __MOBILELOGIN__ . 'actions/login.php');
		
		if(ossn_isLoggedin()) {
				ossn_unregister_action('profile/edit');
				ossn_register_action('profile/edit', __MOBILELOGIN__ . 'actions/edit.php');
		} else {
				ossn_unregister_action('user/register');
				ossn_register_action('user/register', __MOBILELOGIN__ . 'actions/register.php');
		}
}
/**
 * Add new user mobilelogin field
 *
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array  $return Fields
 *
 * @return array
 */
function ossn_mobile_login_field($hook, $type, $return) {
		$return['required']['text'][] = array(
				'name' => 'mobilelogin',
				'params' => array(
						'class' => 'mobilelogin',
						'placeholder' => ossn_print('mobilelogin:num')
				)
		);
		return $return;
}
/**
 * Get user by mobile number
 *
 * @param string $mobile Mobile number
 *
 * @return object|boolean
 */
function ossn_user_by_mobile($mobile = '') {
		if(!empty($mobile)) {
				$user   = new OssnUser;
				$search = $user->searchUsers(array(
						'entities_pairs' => array(
								array(
										'name' => 'mobilelogin',
										'value' => $mobile
								)
						)
				));
				if($search) {
						return $search[0];
				}
		}
		return false;
}