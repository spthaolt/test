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
function phone_numbers_init(){
	ossn_add_hook('wall', 'templates:item', 'ossn_phone_in_posts');
	ossn_add_hook('comment:view', 'template:params', 'ossn_phone_in_comments');	
}
/**
 * Replace the phone numbers in string
 * 
 * @param string $string A string containing phone number
 *
 * @return string|boolean
 */
function ossn_phone_replace($string = ''){
	if(!empty($string)){
		return preg_replace("/(\+?[\d-\(\)\s]{8,20}[0-9]?\d)/", '<a href="tel:$1">$1</a>', $string);
	}
	return false;
}
/**
 * Replace the phone numbers in posts
 *
 * @note Please don't call this function directly in your code.
 * 
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array  $return A comment item
 * @params array $params Option values
 *
 * @return array
 * @access private
 */
function ossn_phone_in_posts($hook, $type, $return, $params){
	$params['text'] = ossn_phone_replace($return['text']);
	return $params;	
}
/**
 * Replace the phone numbers in comments
 *
 * @note Please don't call this function directly in your code.
 * 
 * @param string $hook Name of hook
 * @param string $type Hook type
 * @param array  $return A comment item
 * @params array $params Option values
 *
 * @return array
 * @access private
 */
function ossn_phone_in_comments($hook, $type, $return, $params){
	if(isset($return['comment']['comments:post'])){
		$return['comment']['comments:post'] = ossn_phone_replace($return['comment']['comments:post']);
	}elseif(isset($return['comment']['comments:entity'])){
		$return['comment']['comments:post'] = ossn_phone_replace($return['comment']['comments:entity']);
	}
	return $return;		
}
ossn_register_callback('ossn', 'init', 'phone_numbers_init');
