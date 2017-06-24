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

define('__VIDEOS__', ossn_route()->com . 'Videos/');
require_once(__VIDEOS__ . 'classes/Videos.php');
require_once(__VIDEOS__ . 'classes/VideoThumb.php');

/**
 * Init the component
 *
 * @return void
 */
function videos_init() {
		ossn_extend_view('css/ossn.default', 'css/videos');
		ossn_new_js('videos.init', 'js/videos');
		
		ossn_register_com_panel('Videos', 'settings');
		
		if(ossn_isLoggedin()) {
				ossn_register_action('video/add', __VIDEOS__ . 'actions/add.php');
				ossn_register_action('video/delete', __VIDEOS__ . 'actions/delete.php');
				ossn_register_action('video/edit', __VIDEOS__ . 'actions/edit.php');
		}
		if(ossn_isAdminLoggedin()){
				ossn_register_action('video/admin/settings', __VIDEOS__ . 'actions/admin.php');
		}
		ossn_register_page('video', 'ossn_video_page_handler');
		
		ossn_add_hook('wall:template', 'video', 'ossn_wall_video');
		
		ossn_new_external_js('videoplayer.js', 'components/Videos/vendors/player/mediaelement-and-player.min.js');
		ossn_new_external_css('videoplayer.css', 'components/Videos/vendors/player/mediaelementplayer.min.css');
		
		ossn_register_callback('page', 'load:profile', 'ossn_profile_videos_menu');
		ossn_register_sections_menu('newsfeed', array(
						'name' => 'videos_all',
						'text' => ossn_print('video:com:all'),
						'url' => ossn_site_url('video/all'),
						'section' => 'videos',
						'icon' => true,
		));	
		$user = ossn_loggedin_user();
		ossn_register_sections_menu('newsfeed', array(
						'name' => 'videos_my',
						'text' => ossn_print('video:com:mine'),
						'url' => ossn_site_url('video/all/'). $user->guid,
						'section' => 'videos',
						'icon' => true,
		));	
		ossn_register_sections_menu('newsfeed', array(
						'name' => 'videos_add',
						'text' => ossn_print('video:com:add'),
						'url' => ossn_site_url('video/add'),
						'section' => 'videos',
						'icon' => true,
		));			
}
/**
 * Video component pages
 *
 * @return mixdata
 */
function ossn_video_page_handler($pages) {
		$page = $pages[0];
		switch($page) {
				case 'add':
						ossn_load_js('videos.init');
						ossn_load_external_js('videoplayer.js');
						
						$title               = ossn_print('video:com:add');
						$contents['content'] = ossn_plugin_view('videos/add');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'all':
						$title               = ossn_print('video:com:all');				
						if(!empty($pages[1])){
							ossn_set_input('owner_guid', $pages[1]);
							$user = ossn_user_by_guid($pages[1]);
							$title  = ossn_print('video:com:users:videos', array($user->fullname));
						}
						$contents['content'] = ossn_plugin_view('videos/list');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;						
				case 'view':
						$video = ossn_get_video($pages[1]);
						if(!$video) {
								ossn_error_page();
						}
						
						ossn_load_js('videos.init');
						ossn_load_external_js('videoplayer.js');
						ossn_load_external_css('videoplayer.css');
						
						$title               = $video->title;
						$contents['content'] = ossn_plugin_view('videos/view', array(
								'video' => $video
						));
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'edit':
						$video = ossn_get_video($pages[1]);
						if(!$video) {
								ossn_error_page();
						}
						$user = ossn_loggedin_user();
						if($video->owner_guid == $user->guid || $user->canModerate()) {
								$title               = $video->title;
								$contents['content'] = ossn_plugin_view('videos/edit', array(
										'video' => $video
								));
								$content             = ossn_set_page_layout('newsfeed', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				case 'cover':
						$video = ossn_get_video($pages[1]);
						if(!$video) {
								ossn_error_page();
						}
						$getfile = $video->getParam('file:cover');
						$etag    = md5($video->guid);
						
						if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
								header("HTTP/1.1 304 Not Modified");
								exit;
						}
						$file = ossn_get_userdata("object/{$video->guid}/{$getfile}");
						if(is_file($file)) {
								$filesize = filesize($file);
								header("Content-type: image/jpeg");
								header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
								header("Pragma: public");
								header("Cache-Control: public");
								header("Content-Length: $filesize");
								header("ETag: \"$etag\"");
								readfile($file);
								return true;
						} else {
								ossn_error_page();
						}
						break;
				case 'file':
						$video = ossn_get_video($pages[1]);
						if(!$video) {
								ossn_error_page();
						}
						$getfile = $video->getParam('file:video');
						$file    = ossn_get_userdata("object/{$video->guid}/{$getfile}");
						ossn_video_output($file);
						break;
				case 'progress':
					if(isset($pages[1])){
						session_write_close();	
						
						$dir = ossn_get_userdata("tmp/videos/");
						$file = $dir . $pages[1] . '.progress.txt';
						if(is_file($file)){
							echo Videos::progress($file);
							exit;
						}
						echo 1;
					}
				break;
				default:
					ossn_error_page();
		}
}
/**
 * Get a video
 *
 * @param integer $guid A video guid
 *
 * @return object|boolean
 */
function ossn_get_video($guid) {
		if(!empty($guid)) {
				$object = ossn_get_object($guid);
				$object = (array) $object;
				return arrayObject($object, 'Videos');
		}
		return false;
}
/**
 * Get a video as output buffer
 *
 * @param string $filename A file path
 *
 * @return mixdata
 */
function ossn_video_output($filename) {
		if(is_file($filename)) {
				
				$file = $filename;
				$fp   = @fopen($file, 'rb');
				
				$size   = filesize($file);
				$length = $size;
				$start  = 0;
				$end    = $size - 1;
				
				header('Content-type: video/mp4');
				header("Accept-Ranges: 0-$length");
				if(isset($_SERVER['HTTP_RANGE'])) {
						$c_start = $start;
						$c_end   = $end;
						
						list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
						if(strpos($range, ',') !== false) {
								header('HTTP/1.1 416 Requested Range Not Satisfiable');
								header("Content-Range: bytes $start-$end/$size");
								exit;
						}
						if($range == '-') {
								$c_start = $size - substr($range, 1);
						} else {
								$range   = explode('-', $range);
								$c_start = $range[0];
								$c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
						}
						$c_end = ($c_end > $end) ? $end : $c_end;
						if($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
								header('HTTP/1.1 416 Requested Range Not Satisfiable');
								header("Content-Range: bytes $start-$end/$size");
								exit;
						}
						$start  = $c_start;
						$end    = $c_end;
						$length = $end - $start + 1;
						fseek($fp, $start);
						header('HTTP/1.1 206 Partial Content');
				}
				header("Content-Range: bytes $start-$end/$size");
				header("Content-Length: " . $length);
				
				
				$buffer = 1024 * 8;
				while(!feof($fp) && ($p = ftell($fp)) <= $end) {
						if($p + $buffer > $end) {
								$buffer = $end - $p + 1;
						}
						set_time_limit(0);
						echo fread($fp, $buffer);
						flush();
				}
				
				fclose($fp);
				exit();
		}
}
/**
 * Template for profile cover photo created by ossnwall
 *
 * @return mixed data;
 */
function ossn_wall_video($hook, $type, $return, $params) {
		ossn_load_js('videos.init');
		ossn_load_external_js('videoplayer.js');
		ossn_load_external_css('videoplayer.css');	
		
		return ossn_plugin_view("videos/wall/video", $params);
}
/**
 * Add photos link to user timeline
 *
 * @return void;
 * @access private;
 */
function ossn_profile_videos_menu($event, $type, $params) {
		$guid = ossn_get_page_owner_guid();
		$url   = ossn_site_url();
		ossn_register_menu_item('user_timeline', array(
				'name' => 'videos',
				'href' => ossn_site_url("video/all/{$guid}"),
				'text' => ossn_print('video:com'),
		));
}
/**
 * Max upload size
 *
 * @return string
 */
function ossn_video_max_size(){
   $max_upload    = (int)(ini_get('upload_max_filesize'));
   $max_post      = (int)(ini_get('post_max_size'));
   $memory_limit  = (int)(ini_get('memory_limit'));
   return min($max_upload, $max_post, $memory_limit);      
} 
/**
 * FFMPEG Path
 *
 * @return string|void
 */
function ossn_video_ffmpeg_dir(){
	$com = new OssnComponents;
	$params = $com->getSettings('Videos');
	if(!empty($params->ffmpeg_path)){
		return $params->ffmpeg_path;
	}
	return false;
}
/**
 * IS FFMPEG Exists 
 *
 * NOTE This is a raw check, it simply check if exe binary exists or not.
 *
 * @return string
 */
function ossn_video_is_ffmpeg_exists(){
	$path = ossn_video_ffmpeg_dir();
	if(!empty($path)){
			if(strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
						if(is_file($path . 'ffmpeg.exe')){
							return ossn_print("video:com:ffmpeg:found", array($path . 'ffmpeg.exe'));
						}
			}	else {
						if(is_file($path . 'ffmpeg')){
							return ossn_print("video:com:ffmpeg:found", array($path . 'ffmpeg'));
						}				
			}
	}	
	return ossn_print("video:com:ffmpeg:notfound");
}
/**
* Find percentage
 *
* @param string $val1 Result
* @param string $val2 Total
* @param string $precision Number of decimals
*
* @return integer
*/		
function percentage($val1, $val2, $precision) {
	$division = $val1 / $val2;
	$res = $division * 100;
	$res = round($res, $precision);
	return $res;
}
ossn_register_callback('ossn', 'init', 'videos_init');
