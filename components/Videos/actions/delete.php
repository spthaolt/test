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
 $guid = input('guid');
 $video = ossn_get_video($guid);
 if(!$video){
	 ossn_trigger_message(ossn_print('video:com:invalid'), 'error');
	 redirect(REF);	 
 }
 
 $user = ossn_loggedin_user();
 if($video->owner_guid == $user->guid || $user->canModerate()){
	 $entity = ossn_get_entities(array(
			'type' => 'object',
			'owner_guid' => $video->guid,
			'subtype' => 'file:video',
  	 ));

	 if(class_exists("OssnLikes")){
	 	$likes = new OssnLikes;
	 	$likes->deleteLikes($entity[0]->guid, 'entity');
	 }
	 if(class_exists("OssnComments")){
		 $comments = new OssnComments;
		 $comments->commentsDeleteAll($entity[0]->guid, 'comments:entity');	 
	 }
	 
	 $video->deleteWallPost($video->guid);
	 if($video->deleteObject()){
	 	ossn_trigger_message(ossn_print('video:com:deleted'));
	 	redirect('video/all');			 
	 } 
 } 
 ossn_trigger_message(ossn_print('video:com:delete:fail'), 'error');
 redirect(REF);	 
