<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('KERNEL', ossn_route()->com . 'Kernel/');
/**
 * Kernel check if connection is valid
 *
 * @return boolean
 */
function ossn_kernal_is_established() {
	return true;
	// $kernel    = new OssnKernel;
	// $establish = $kernel->sendRequest('auth', array());
	// if(base64_decode($establish->data) !== 'established') {
	// 		return false;
	// }
	// return true;
}
/**
 * Kernel Initialize
 *
 * @return void
 */
function ossn_kernal_init() {
		ossn_add_hook('ossn', 'kernel:cred', 'ossn_kernal_auth');
}
/**
 * Set kernal creds
 *
 * @return object|boolean
 */
function ossn_kernal_creds() {
		global $license;
		if(!is_file(KERNEL . 'license.php')){
				return false;
		}
		include_once(KERNEL . 'license.php');
		if(isset($license['api_key'])) {
				return (object) $license;
		}
		return false;
}
/**
 * Setup a sdk for kernel
 *
 * @return void
 */
if(!OssnKernel::isCacheLoaded()){ 
	define('KERNEL_STATUS', ossn_kernal_is_established());
} else {
	define('KERNEL_STATUS', true);		
}
function ossn_register_system_sdk($type, $handler, $pcit = 4001) {
	if(KERNEL_STATUS === true) {
		OssnKernel::setINIT($type, $handler, $pcit);
	}
}
ossn_register_callback('ossn', 'init', 'ossn_kernal_init');