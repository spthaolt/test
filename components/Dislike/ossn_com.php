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

define('__DISLIKE__', ossn_route()->com . 'Dislike/');
require_once(__DISLIKE__ . 'classes/Dislike.php');
function disklike_init(){
		ossn_register_action('post/dislike', __DISLIKE__. 'actions/post/dislike.php');
        ossn_register_action('post/undislike', __DISLIKE__ . 'actions/post/undislike.php');
		
		ossn_register_callback('wall', 'load:item', 'ossn_wall_dislike_menu');
		ossn_register_callback('entity', 'load:comment:share:like', 'ossn_entity_dislike_link');
		ossn_register_callback('post', 'delete', 'ossn_post_dislike_delete');
		ossn_register_callback('delete', 'entity', 'ossn_entity_dislike_delete');
		
		ossn_extend_view('js/opensource.socialnetwork', 'js/dislike');
		ossn_extend_view('css/ossn.default', 'css/dislikes');
		
		ossn_extend_view('likes/post/likes', 'dislike/post/dislikes');
		ossn_extend_view('likes/post/likes_entity', 'dislike/post/dislikes_entity');
		
		ossn_register_page('dislikes', 'ossn_dislikesview_page_handler');	
}
function ossn_wall_dislike_menu($callback, $type, $params){
	$guid = $params["post"]->guid;
	
	ossn_unregister_menu("dislike", "postextra"); 
	ossn_unregister_menu("undislike", "postextra"); 
	
	if(!empty($guid)){
		$dislike = new Dislike;
		if(!$dislike->isDisliked($guid, ossn_loggedin_user()->guid)){
			ossn_register_menu_item("postextra", array(
					"name" => "dislike", 
					"href" => "javascript:;",
					"id" => "ossn-dislike-".$guid,
					"data-guid" => $guid,
					"data-type" => "post",
					"text" => ossn_print("ossn:dislike"),
			));
		} else {
			ossn_register_menu_item("postextra", array(
					"name" => "undislike", 
					"href" => "javascript:;",
					"id" => "ossn-dislike-".$guid,
					"data-guid" => $guid,		
					"data-type" => "post",
					"text" => ossn_print("ossn:undislike"),
			));			
		}
	}
}

function ossn_entity_dislike_link($callback, $type, $params){
	$guid = $params["entity"]->guid;
	
	ossn_unregister_menu("dislike", "entityextra"); 
	
	if(!empty($guid)){
		$dislikes = new Dislike;
		if(!$dislikes->isDisliked($guid, ossn_loggedin_user()->guid, "entity")){
			ossn_register_menu_item("entityextra", array(
					"name" => "dislike", 
					"href" => "javascript:;",
					"id" => "ossn-dislike-".$guid,
					"data-type" => "entity",
					"data-guid" => $guid,	
					"text" => ossn_print("ossn:dislike"),
			));
		} else {
			ossn_register_menu_item("entityextra", array(
					"name" => "undislike", 
					"href" => "javascript:;",
					"id" => "ossn-dislike-".$guid,					
					"data-type" => "entity",
					"data-guid" => $guid,	
					"text" => ossn_print("ossn:undislike"),
			));			
		}
	}
}

function ossn_dislikesview_page_handler() {
    echo ossn_plugin_view("output/ossnbox", array(
        "title" => ossn_print("people:dislike:this"),
        "contents" => ossn_plugin_view("dislike/pages/view"),
        "control" => false,
    ));
}

function ossn_post_dislike_delete($name, $type, $params) {
    $delete = new Dislike;
    $delete->deleteDislikes($params);
}

function ossn_entity_dislike_delete($name, $type, $params){
    $delete = new Dislike;
    $delete->deleteDislikes($params["entity"], "entity");	
}
ossn_register_callback('ossn', 'init', 'disklike_init');