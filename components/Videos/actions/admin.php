<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
 $component = new OssnComponents;
 
 $path = input('ffmpeg');
 if(empty($path)){
	 ossn_trigger_message(ossn_print('video:ffmpeg:input:empty'), 'error');
	 redirect(REF);
 }
 $vars = array(
	'ffmpeg_path' => $path,
  );
 if($component->setSettings('Videos', $vars)){
	 ossn_trigger_message(ossn_print('video:ffmpeg:path:saved'));
	 redirect(REF);
 } else {
	 ossn_trigger_message(ossn_print('video:ffmpeg:path:save:error'), 'error');
	 redirect(REF);	 
 }