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
define('CATEGORIES', ossn_route()->com . 'Categories/');
require_once(CATEGORIES . 'classes/Categories.php'); 
/**
 * User category init
 *
 * @return void
 */
function categories_init() {
		ossn_add_hook('user', 'default:fields', 'ossn_categories_fields');
		ossn_register_com_panel('Categories', 'settings');
		
		ossn_register_page('users', 'ossn_users_page');
		
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('category/add', CATEGORIES . 'actions/add.php');
				ossn_register_action('category/delete', CATEGORIES . 'actions/delete.php');
		}
		ossn_extend_view('css/ossn.default', 'css/categories');
}
/**
 * User categories page handler
 *
 * @return mixdata
 */
function ossn_users_page($pages) {
		$type = $pages[0];
		if(empty($type)) {
				ossn_error_page();
		}
		$object = ossn_get_object($type);
		if(!$object || $object->subtype !== 'user:category') {
				ossn_error_page();
		}
		$type     = $object->title;
		$title    = ossn_print('categories:users', array(
				$type
		));
		$contents = array(
				'content' => ossn_plugin_view('categories/users', array(
						'object' => $object
				))
		);
		$content  = ossn_set_page_layout('newsfeed', $contents);
		echo ossn_view_page($title, $content);
}
/**
 * Add categories menu to sidebar
 *
 * @return void
 */
function categories_menu_sidebar() {
		$categories = new Categories;
		$categories = $categories->getAll();
		if($categories) {
				foreach($categories as $item) {
						$translit = OssnTranslit::urlize($item->title);
						ossn_register_sections_menu('newsfeed', array(
								'text' => $item->title,
								'url' => ossn_site_url("users/{$item->guid}/{$translit}"),
								'section' => 'categories',
								'icon' => true
						));
				}
		}
}
/**
 * Extend the user fields
 *
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array $return A option values
 *
 * @return array
 */
function ossn_categories_fields($hook, $type, $return) {
		if(!isset($return['required']['dropdown'])) {
				$return['required']['dropdown'] = array();
		}
		$categories = new Categories;
		$categories = $categories->getAll();
		if($categories) {
				$cats     = array();
				$cats[''] = ossn_print('categories:select');
				foreach($categories as $item) {
						$prepare        = Categories::prepare($item->title);
						$cats[$prepare] = $item->title;
				}
				$return['required']['dropdown'][] = array(
						'name' => 'category',
						'options' => $cats
				);
		}
		return $return;
}
ossn_register_callback('ossn', 'init', 'categories_menu_sidebar');
ossn_register_callback('ossn', 'init', 'categories_init');
