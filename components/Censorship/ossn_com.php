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
define('CENSORSHIP', ossn_route()->com . 'Censorship/');
define('CENSORSHIP', ossn_route()->com . 'Censorship/');
/**
 * Initilize the component
 *
 * @param null
 * @return void
 */
function censorship_init() {
		ossn_register_com_panel('Censorship', 'settings');
		
		ossn_register_callback('wall', 'post:created', 'censorship_wallpost_add', 1000);
		ossn_register_callback('wall', 'post:edited', 'censorship_wallpost_add', 1000);
		ossn_register_callback('comment', 'created', 'censorship_comment_add', 1000);
		ossn_register_callback('comment', 'edited', 'censorship_comment_add', 1000);
		
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('admin/censorship/settings', CENSORSHIP . 'actions/settings.php');
				
		}
}
/**
 * Censorship process
 *
 * @param string $string A string
 * @return string|boolean
 */
function censorship_process($string = '') {
		$component = new OssnComponents;
		$settings  = $component->getSettings('Censorship');
		if($settings) {
				if(!empty($settings->words) && !empty($settings->stringval)) {
						$word = explode(',', $settings->words);
						foreach($word as $item) {
								if(!empty($item)) {
										$preg    = strtolower(trim($item));
										$words[] = "/($preg)/i";
								}
						}
						$string = preg_replace($words, $settings->stringval, $string);
				}
				return $string;
		}
		return $string;
}
/** 
 * Censor wallposts
 *
 * @param string $callback A callback type.
 * @param string $type A type of callback
 * @param array  $params Option values
 *
 * @return void
 */
function censorship_wallpost_add($callback, $type, $params) {
		if(isset($params['object_guid']) && !empty($params['object_guid'])) {
				$object = ossn_get_object($params['object_guid']);
		} elseif(isset($params['object']) && $params['object'] instanceof OssnObject) {
				$object = $params['object'];
		}
		if($object) {
				$json = html_entity_decode($object->description);
				
				$data = json_decode($json, true);
				$text = censorship_process($data['post']);
				$text = ossn_input_escape($text);
				
				$data['post'] = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
				$rejson       = json_encode($data, JSON_UNESCAPED_UNICODE);
				
				$object->description = "{$rejson}";
				$object->save();
		}
}
/** 
 * Censor comments
 *
 * @param string $callback A callback type.
 * @param string $type A type of callback
 * @param array  $params Option values
 *
 * @return void
 */
function censorship_comment_add($callback, $type, $params) {
		if(isset($params['id']) && !empty($params['id'])) {
				$comment = ossn_get_annotation($params['id']);
		} elseif($params['annotation']) {
				$comment = ossn_get_annotation($params['annotation']->id);
		}
		if($comment) {
				if($comment->type == 'comments:entity') {
						$text                               = $comment->getParam('comments:entity');
						$comment->data->{'comments:entity'} = censorship_process($text);
				} elseif($comment->type == 'comments:post') {
						$text                             = $comment->getParam('comments:post');
						$comment->data->{'comments:post'} = censorship_process($text);
				}
				$comment->save();
		}
}
ossn_register_callback('ossn', 'init', 'censorship_init');