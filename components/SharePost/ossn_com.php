<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team https://www.softlab24.com/contact
 * @copyright 2014-2016 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('SHAREPOST', ossn_route()->com . 'SharePost/');

function share_post_init(){
	if(ossn_isLoggedin()){
		ossn_register_callback('wall', 'load:item', 'share_post_menu');
		ossn_register_action('post/share', SHAREPOST . 'actions/share.php');
	}
	ossn_extend_view('css/ossn.default', 'postshare/css');
	ossn_add_hook('wall:template', 'post:share:post', 'ossn_post_share_item');	
}
/**
 * Template for event wall item
 *
 * @return mixed data;
 */
function ossn_post_share_item($hook, $type, $return, $params) {
		return ossn_plugin_view("postshare/wall/item", $params);
}
function share_post_menu($callback, $type, $params) {
		$guid = $params['post']->guid;
		
		ossn_unregister_menu('sharepost', 'postextra');
		ossn_register_menu_item('postextra', array(
				'name' => 'sharepost',
				'href' => ossn_site_url("action/post/share?guid={$guid}", true),
				'text' => ossn_print('post:share')
		));
}
function share_post($itemguid = ''){
		if(empty($itemguid)){
			return false;
		}
		if(empty($itemguid) || !class_exists("OssnWall")) {
						return false;
		}
		$wall = new OssnWall;
		$wall->item_type   = 'post:share:post';
		$wall->owner_guid  = ossn_loggedin_user()->guid;
		$wall->poster_guid = ossn_loggedin_user()->guid;
		$wall->item_guid   = $itemguid;
		if($wall->Post('null:data')) {
			return true;
		}
	return false;
}
ossn_register_callback('ossn', 'init', 'share_post_init');