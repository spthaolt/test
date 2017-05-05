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
 set_time_limit(0);
 session_write_close();	
 
 $title = input('title');
 $description = input('description');
 
 if(empty($title) || empty($description) || empty($description)){
	 ossn_trigger_message(ossn_print('video:com:fields:requred'), 'error');
	 redirect(REF);
 }
 $allowed = array('video/mp4', 'video/mpeg', 'video/3gpp', 'video/x-ms-wmv', 'video/x-msvideo', 'video/quicktime');
 if(isset($_FILES['video']) && !in_array($_FILES['video']['type'], $allowed)){
	 ossn_trigger_message(ossn_print('video:com:mp4:files'), 'error');	
	 redirect(REF);		 
 }
 
 $file = new OssnFile;
 $extension = $file->getFileExtension($_FILES['video']['name']);
 $tmp_path = $_FILES['video']['tmp_name'];
 
 $video = new Videos;
 $extensions = array('3gp', 'mov', 'avi', 'wmv', 'flv');
 if(in_array($extension, $extensions)){
	 
	 $hash = md5($_FILES['video']['tmp_name'] . time() . rand());
	 $newfile_name = $hash . '.mp4';
	 $dir = ossn_get_userdata("tmp/videos/");
	 $newfile = $dir . $newfile_name;
	 
	 if(!is_dir($dir)){
		mkdir($dir, 0755, true); 
	 }
	 $vtk = input('vtk');
	 $progress_file = $dir . $vtk . '.progress.txt';
	 if($video->convert($_FILES['video']['tmp_name'], $newfile, $progress_file)){
		 $_FILES['video']['tmp_name'] = $newfile;
		 $_FILES['video']['type'] = 'video/mp4';
		 $_FILES['video']['name'] = $newfile_name;
		 $_FILES['video']['size'] = filesize($newfile);
	 } else {
	 	ossn_trigger_message(ossn_print('video:com:upload:conversion:failed'), 'error');
		redirect(REF);		 
	 }
 }
 
 if($video->addVideo($title, $description)){
	 $guid = $video->getObjectId();
	 $title = OssnTranslit::urlize($title);
	 $url = "video/view/{$guid}/{$title}";
	 
	 ossn_set_ajax_data(array(
				'url' => $url
	 ));	 
	 
	 if(isset($newfile)){
		 unlink($newfile);
		 unlink($progress_file);		 
	 }
	 
	 ossn_trigger_message(ossn_print('video:com:uploaded'));	
	 redirect($url);
 } else {
	 
	 if(isset($newfile)){
		 unlink($newfile);
		 unlink($progress_file);
	 }
	 
	 
	 ossn_trigger_message(ossn_print('video:com:upload:failed'), 'error');
	 redirect(REF);
 }