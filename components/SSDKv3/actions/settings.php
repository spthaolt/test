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
 $component = new OssnComponents;
 $secret = input('secret');
 $apikey = input('apikey');
 $username = input('username');
 
 if(empty($secret) || empty($apikey) || !empty($user)){
		ossn_trigger_message(ossn_print('ssdkv3:save:error'), 'error');
		redirect(REF);		 
 }
 $args = array(
			   'apikey' => $apikey,
			   'secret' => $secret,
			   'username' => $username,
			   );
 if($component->setSettings('SSDKv3', $args)){
		ossn_trigger_message(ossn_print('ssdkv3:saved'));
		redirect(REF);
 } else {
		ossn_trigger_message(ossn_print('ssdkv3:save:error'), 'error');
		redirect(REF);	 
 }