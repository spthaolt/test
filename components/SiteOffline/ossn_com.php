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
define('SITEOFFLINE', ossn_route()->com . 'SiteOffline/'); 
function siteoffline_init() {
		ossn_register_com_panel('SiteOffline', 'settings');
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('site/offline/save', SITEOFFLINE . 'actions/save.php');
		}
		$component = new OssnComponents;
		$settings  = $component->getSettings('SiteOffline');
		
		if(isset($settings->offline) && $settings->offline == 'offline') {
				ossn_register_page('index', 'ossn_siteoffline_page');
		}
		
		ossn_extend_view('css/ossn.admin.default', 'css/admin/siteoffline');
		ossn_extend_view('css/ossn.default', 'css/siteoffline');
}
/**
 * Site offline page handler
 *
 * @param null
 * @return mixed
 */
function ossn_siteoffline_page() {
		$title   = ossn_print('siteoffline');
		$content = ossn_set_page_layout('startup', array(
				'content' => ossn_plugin_view('siteoffline/index')
		));
		echo ossn_view_page($title, $content);
}
/**
 * Check if user loggedin is not admin then logout
 *
 * @param null
 * @return mixed
 */

function siteoffline_login_check() {
		if(ossn_isLoggedin()) {
				$user      = ossn_loggedin_user();
				$component = new OssnComponents;
				$settings  = $component->getSettings('SiteOffline');
				
				if(isset($settings->offline) && $settings->offline == 'offline') {
						if(!$user->isAdmin()) {
								ossn_logout();
								redirect();
						}
				}
		}
}
ossn_register_callback('ossn', 'init', 'siteoffline_login_check');
ossn_register_callback('ossn', 'init', 'siteoffline_init');
