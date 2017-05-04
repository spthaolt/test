<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
define('SOFTLAB24_SDK_V3', ossn_route()->com . 'SSDKv3/');
require_once(SOFTLAB24_SDK_V3 . 'classes/SSDKv3.php');
/**
 * Initlize the SDKv3
 *
 * @param null
 * 
 * @return void
 */
function softlab24_sdk_v3_init() {
		ossn_register_page('softlab24_sdk_v3', 'softlab24_sdk_v3_handler');
		ossn_register_com_panel('SSDKv3', 'settings');
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('ossn/mobile/settings', SOFTLAB24_SDK_V3 . 'actions/settings.php');
		}
		$component = new OssnComponents;
		$settings  = $component->getSettings("SSDKv3");
		
		if(isset($settings->apikey)) {
				ossn_register_callback('message', 'created', 'ossn_message_created');
				ossn_extend_view('ossn/page/footer/contents', 'ssdkv3/mobile');
				ossn_register_page('mobileapp', 'ossn_mobileapp_page');
		}
}
/**
 * Show a page to user from where they can download app
 *
 * @param null
 * 
 * @return void
 */
function ossn_mobileapp_page() {
		$title               = ossn_print('ssdk:mobileapp');
		$contents['content'] = ossn_plugin_view('ssdkv3/mobile_page');
		$content             = ossn_set_page_layout('newsfeed', $contents);
		echo ossn_view_page($title, $content);
}
/**
 * Notify the SDK if some message is created.
 *
 * @param string $callback The name of callback
 * @param string $type The callback type
 * @param array $params Option values
 * 
 * @return void
 */
function ossn_message_created($callback, $type, $params) {
		SDKv3::messageCreated($params);
}
/**
 * SSDK main init
 *
 * @return void
 */
function softlab24_sdk_v3_handler() {
		$access = new SDKv3;
		$access->response();
}
ossn_register_callback('ossn', 'init', 'softlab24_sdk_v3_init');